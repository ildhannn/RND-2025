@extends('layouts/blankLayout')

@section('title', 'Face Recognition')

@section('content')

    <div class="card" style="margin-top: 80px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Face Recognition - IDLE</h1>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-md-5 col-sm-1">
                                        <div id="camera"></div>
                                        <div id="results" style="display: none">Foto akan Tampil disini</div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <button type="button" class="btn btn-primary btn-sm" onClick="take_snapshot()">Ambil
                                Foto</button>
                            <input type="file" id="getfr" accept="image/*" style="display: none;">
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
    <script>
        Webcam.set({
            width: 500,
            height: 390,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#camera');

        function take_snapshot() {
            Webcam.snap(function(foto) {
                // hasil capture
                document.getElementById('results').innerHTML = '<img id="capturedImage" src="' + foto + '"/>';
                document.getElementById('results').style.display = 'block'
                document.getElementById('camera').style.display = 'none'

                // store ke id=getfr
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = 490;
                canvas.height = 390;
                const img = new Image();
                img.onload = function() {
                    context.drawImage(img, 0, 0);

                    canvas.toBlob(function(blob) {
                        const file = new File([blob], "{{ Session::get('username') }}" +
                            '.jpg', {
                                type: 'image/jpeg'
                            });

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);

                        const fileInput = document.getElementById('getfr');
                        fileInput.files = dataTransfer.files;

                        console.log('File ready for upload:', fileInput.files[0].name);
                    }, 'image/jpeg');
                };
                img.src = foto;
            });
        };

        function recognizeFace() {
            const apiKey = 'eef6c78b-c094-4413-b3da-9a911f4726ee';
            const file = document.getElementById("getfr");

            if (file.files.length === 0) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Foto terlebih dahulu',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const photo = file.files[0]

            let formData = new FormData();
            formData.append("file", photo);

            const limit = 10;
            const predictionCount = 5;
            const detectionProbabilityThreshold = 0.6;

            const baseUrl = 'http://localhost:8002/api/v1/recognition/recognize';
            const url = `${baseUrl}?limit=${limit}&prediction_count=${predictionCount}&det_prob_threshold=${detectionProbabilityThreshold}`;
            fetch(url, {
                    method: "POST",
                    headers: {
                        "x-api-key": apiKey
                    },
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    const treshold = 0.99;
                    const loggedInUser = "{{ Session::get('username') }}";

                    let recognizedRoles = [];

                    if (data.result && data.result.length > 0) {
                        data.result.forEach(result => {
                            if (result.subjects && result.subjects.length > 0) {
                                result.subjects.forEach(subject => {
                                    if (subject.similarity >= treshold) {
                                        recognizedRoles.push(subject.subject);
                                    }
                                });
                            }
                        });

                        if (recognizedRoles.includes(loggedInUser)) {
                            Swal.fire({
                                title: 'Success!',
                                text: `Selamat datang, ${loggedInUser }!`,
                                icon: 'success',
                            });
                            setTimeout(() => {
                                window.location.href = "{{ url('/') }}";
                            }, 1000);
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Wajah tidak cocok.',
                                icon: 'error',
                            });
                        }
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Wajah tidak terdeteksi.',
                            icon: 'error',
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Terjadi kesalahan dalam proses verifikasi wajah.',
                        icon: 'error',
                    });
                    console.error('Error:', error);
                });
        }
    </script>

@endsection
