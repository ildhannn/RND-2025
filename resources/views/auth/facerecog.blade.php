@extends('layouts/blankLayout')

@section('title', 'Face Recognition')

@section('content')

    <div class="card" style="margin-top: 80px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Face Recognition - IDLE</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="camera"></div>
                            <br />
                            <button type="button" class="btn btn-primary btn-sm" onClick="take_snapshot()">Ambil
                                Foto</button>
                            <input type="hidden" name="image" class="image-tag">
                        </div>
                        <div class="col-md-6">
                            <div id="results">Foto akan Tampil disini</div>
                        </div>
                        <div class="col-md-12 text-center">
                            <br />
                            <button class="btn btn-success" onClick="recognizeFace()">Cek</button>
                            <div id="loading" style="display: none">Process...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-fr-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/face-api.min.js"></script>
    <script>
        Webcam.set({
            width: 490,
            height: 390,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#camera');

        async function loadModels() {
            const MODEL_URL = '/models';
            await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);
            console.log("Models OK");
        }

        window.onload = loadModels;

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                document.querySelector(".image-tag").value = data_uri;
                document.getElementById('results').innerHTML = '<img id="capturedImage" src="' + data_uri + '"/>';
            });
        };


        async function loadKnownFaceDescriptors() {
            const id = "{{ Session::get('id') }}";
            const user = "{{ Session::get('username') }}";
            const url = "{{ url('/get-fr') }}" + "/" + id;

            const response = await fetch(url);
            const res = await response.json();

            const data = res.data;

            return data.map(faceData => {
                let descriptorsString = faceData.descriptors;

                if (descriptorsString.startsWith('"') && descriptorsString.endsWith('"')) {
                    descriptorsString = descriptorsString.slice(1, -1);
                }

                let parsedDescriptors;
                try {
                    parsedDescriptors = JSON.parse(descriptorsString);
                } catch (error) {
                    console.error("gagal parse descriptors", error);
                    return null;
                }

                if (Array.isArray(parsedDescriptors) && Array.isArray(parsedDescriptors[0])) {
                    const descriptorArray = parsedDescriptors.map(d => new Float32Array(d));
                    return new faceapi.LabeledFaceDescriptors(
                        String(faceData.id_user),
                        descriptorArray
                    );
                } else {
                    console.error("format descriptors bukan harus array");
                    return null;
                }

            }).filter(Boolean);
        }


        async function recognizeFace() {
            const imgElement = document.getElementById('results').querySelector('img');

            if (!imgElement) {
                Swal.fire({
                    title: 'Opss!',
                    text: 'Tidak ada gambar yang ditangkap. Silahkan ambil gambar terlebih dahulu',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const dataUri = imgElement.src;
            const response = await fetch(dataUri);
            const blob = await response.blob();
            const inputImg = await faceapi.bufferToImage(blob);

            const knownFaceDescriptors = await loadKnownFaceDescriptors();

            if (knownFaceDescriptors.length === 0) {
                Swal.fire({
                    title: 'Opss!',
                    text: 'Tidak ada descriptors wajah',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            } else {
                document.getElementById('loading').style.display = 'block';
            }

            const inputResults = await faceapi.detectAllFaces(inputImg, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks().withFaceDescriptors();

            if (inputResults.length === 0) {
                Swal.fire({
                    title: 'Opss!',
                    text: 'Tidak ada wajah yang terdeteksi',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                document.getElementById('loading').style.display = 'none';
                return;
            }
            const inputDescriptor = inputResults[0].descriptor;

            const faceMatcher = new faceapi.FaceMatcher(knownFaceDescriptors);

            const bestMatch = faceMatcher.findBestMatch(inputDescriptor);

            console.log(`Best match: ${bestMatch.toString()}`);

            if (bestMatch.label !== 'unknown') {
                window.location.href = "{{ url('/') }}"
                Swal.fire({
                    title: `${bestMatch.label}`,
                    text: 'Selamat Datang',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Opss!',
                    text: 'Wajah tidak terdaftar',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                window.location.href = "{{ url('/face_recognition') }}"
            }
        }
    </script>

@endsection
