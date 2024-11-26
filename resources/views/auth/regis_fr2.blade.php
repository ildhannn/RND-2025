@extends('layouts/layoutMaster')

@section('title', 'Registrasi Face Recognition')

@section('content')

    <div class="card" style="margin-top: 80px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Registrasi Face Recognition - IDLE</h1>
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
                            <input type="file" id="postfr" accept="image/*" style="display: none;">
                        </div>
                        <div class="col-md-12 text-center">
                            <br />
                            <button type="button" class="btn btn-primary btn-sm" onClick="registerFace()">Simpan</button>
                            <a href="/user" class="btn btn-warning btn-sm">Kembali</a>
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

                // store to id=postfr
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = 490;
                canvas.height = 390;
                const img = new Image();
                img.onload = function() {
                    context.drawImage(img, 0, 0);

                    canvas.toBlob(function(blob) {
                        const file = new File([blob], "{{ Session::get('username') }}.jpg", {
                            type: 'image/jpeg'
                        });

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);

                        const fileInput = document.getElementById('postfr');
                        fileInput.files = dataTransfer.files;

                        console.log('File ready for upload:', fileInput.files[0].name);
                    }, 'image/jpeg');
                };
                img.src = foto;
            });
        };

        // regist fr
        function registerFace() {
            const fileInput = document.getElementById("postfr");
            const apiKey = 'eef6c78b-c094-4413-b3da-9a911f4726ee';

            if (fileInput.files.length === 0) {
                Swal.fire({
                    title: 'Oops!',
                    text: 'Foto terlebih dahulu',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            const photo = fileInput.files[0];

            const formData = new FormData();
            formData.append("file", photo);

            const subject = "{{ Session::get('username') }}";

            // Send the request
            fetch('http://localhost:8002/api/v1/recognition/faces/?subject=' + encodeURIComponent(subject), {
                    method: "POST",
                    headers: {
                        "x-api-key": apiKey
                    },
                    body: formData
                })
                .then(r => {
                    if (!r.ok) {
                        throw new Error('Terjadi kesalahan' + r.statusText);
                    }
                    return r.json();
                })
                .then(function(data) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Registrasi wajah berhasil',
                        icon: 'success',
                    });
                    setTimeout(function() {
                        window.location.href = "/user";
                    }, 1000);
                })
                .catch(function(error) {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Wajah tidak terdeteksi.',
                        icon: 'error',
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                });
        }
    </script>

@endsection
