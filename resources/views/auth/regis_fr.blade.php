@extends('layouts/blankLayout')

@section('title', 'Registrasi Face Recognition')

@section('content')

    <div class="card" style="margin-top: 80px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Registrasi Face Recognition - IDLE</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="camera"></div>
                            <br />
                            <button type="button" class="btn btn-primary btn-sm" onClick="take_snapshot()">Ambil
                                Foto</button>
                            <input type="hidden" name="images" class="image-tag">
                        </div>
                        <div class="col-md-6">
                            <div id="results">Foto akan Tampil disini</div>
                        </div>
                        <div class="col-md-12 text-center">
                            <br />
                            <button type="button" class="btn btn-primary btn-sm" onClick="registerFace()">Simpan</button>
                            <a href="/face_recognition" class="btn btn-warning btn-sm">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-regisfr-script')
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
            Webcam.snap(function(foto) {
                document.querySelector(".image-tag").value = foto;
                document.getElementById('results').innerHTML = '<img id="capturedImage" src="' + foto + '"/>';
            });
        };

        function dataURItoBlob(dataURI) {
            if (dataURI == null) {
                alert('Foto tidak boleh kosong');
            } else {
                let byteString = atob(dataURI.split(',')[1]);

                let arrayBuffer = new ArrayBuffer(byteString.length);
                let uint8Array = new Uint8Array(arrayBuffer);
                for (let i = 0; i < byteString.length; i++) {
                    uint8Array[i] = byteString.charCodeAt(i);
                }

                return new Blob([uint8Array], {
                    type: 'image/jpeg'
                });
            }

        }

        // Belum optimal, masih keneh kajegal promise, tapi data asup
        async function registerFace() {
            let id = "{{ Session::get('id') }}";
            let url = "{{ url('/registrasi_fr') }}" + "/" + id;

            let foto = document.querySelector(".image-tag").value;
            let imageBlob = dataURItoBlob(foto);

            let inputImg = await faceapi.bufferToImage(imageBlob);
            let results = await faceapi.detectAllFaces(inputImg, new faceapi.TinyFaceDetectorOptions())
                .withFaceLandmarks().withFaceDescriptors();

            if (results.length > 0) {
                let descriptor = results[0].descriptor;
                let formattedDescriptors = [Array.from(descriptor)];

                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer {{ Session::get('token') }}'
                    },
                    body: JSON.stringify({
                        id_user: id,
                        descriptors: formattedDescriptors
                    }),
                }).then(res => {
                    if (res.ok) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Registrasi wajah berhasil',
                            icon: 'success',
                        });
                        window.location.href = "/face_recognition";
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal registrasi wajah ' + errorText,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Wajah tidak terdeteksi.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    </script>

@endsection
