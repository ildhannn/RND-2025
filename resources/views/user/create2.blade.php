@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tambah User')

{{-- @section('page-style')
    <style>
        .tabCreateUser {
            display: none;
        }

        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: 2px dotted # border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }
    </style>
@endsection --}}

@section('content')

    <div class="container">
        <div class="row justify-content-end mb-4">
            <div class="col-md-1">
                <a href="/user" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Tambah Pengguna Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('post-create-user') }}" method="POST" enctype="multipart/form-data" id="regForm">
                    @csrf
                    <div class="tabCreateUser">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-merge mb-4">
                                    <span id="basic-icon-default-username" class="input-group-text"><i
                                            class="mdi mdi-account-outline"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control" id="basic-icon-default-username"
                                            aria-describedby="basic-icon-default-username" name="username" />
                                        <label for="basic-icon-default-username">Username</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                        <div class="form-floating form-floating-outline">
                                            <input type="email" id="basic-icon-default-email" class="form-control"
                                                aria-describedby="basic-icon-default-email2" name="email" />
                                            <label for="basic-icon-default-email">Email</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="mdi mdi-map-marker-outline"></i></span>
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" id="basic-icon-default-alamat" class="form-control"
                                                aria-describedby="basic-icon-default-alamat" name="alamat" />
                                            <label for="basic-icon-default-alamat">Alamat</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" id="basic-icon-default-password" class="form-control"
                                                aria-describedby="basic-icon-default-password" name="password" />
                                            <label for="basic-icon-default-password">Password</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="mdi mdi-image-area"></i></span>
                                        <div class="form-floating form-floating-outline">
                                            <input type="file" class="form-control" name="foto" accept="image/*" />
                                            <label for="basic-icon-default-foto">Foto</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="tabCreateUser">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="text-center">Registrasi Face Recognition - IDLE</h1>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="camera"></div>
                                        <br />
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onClick="take_snapshot()">Ambil
                                            Foto</button>
                                        <input type="hidden" name="images" class="image-tag">
                                    </div>
                                    <div class="col-md-6">
                                        <div id="results">Foto akan Tampil disini</div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <br />
                                        <button type="button" class="btn btn-primary btn-sm"
                                            onClick="registerFace()">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Buat</button>
                    {{-- <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" class="brutal-btn bg-menu-theme" id="prevBtn"
                                onclick="nextPrev(-1)">Kembali</button>
                            <button type="button" class="brutal-btn bg-menu-theme" id="nextBtn"
                                onclick="nextPrev(1)">Lanjut</button>
                        </div>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>

@endsection

@section('page-createUser-script')
    <script>
        let currentTab = 0;
        showTab(currentTab);

        function showTab(n) {
            let x = document.getElementsByClassName("tabCreateUser");
            x[n].style.display = "block";
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Buat";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            let x = document.getElementsByClassName("tabCreateUser");
            // if (n == 1 && !validateForm()) return false;
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
                document.getElementById("regForm").submit();
                return false;
            }
            showTab(currentTab);
        }

        // function validateForm() {
        //     var x, y, i, valid = true;
        //     x = document.getElementsByClassName("tab");
        //     y = x[currentTab].getElementsByTagName("input");
        //     for (i = 0; i < y.length; i++) {
        //         if (y[i].value == "") {
        //             y[i].className += " invalid";
        //             valid = false;
        //         }
        //     }
        //     if (valid) {
        //         document.getElementsByClassName("step")[currentTab].className += " finish";
        //     }
        //     return valid;
        // }

        function fixStepIndicator(n) {
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            x[n].className += " active";
        }
    </script>
@endsection

{{-- @section('page-regisfr-script')
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
                            text: 'Registrasi wajah berhasil klik ok dan klik tombol untuk buat',
                            icon: 'success',
                        });
                        // window.location.href = "/face_recognition";
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

@endsection --}}
