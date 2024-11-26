@php
    $configData = Helper::appClasses();
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Login - RND 2025')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth2.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
@endsection

@section('content')
    <div class="position-relative">

        <div class="row" style="background-color: black">
            <div class="col-md-12">
                <div class="brutal-header">
                    <p class="text-light">RND - 2025</p>
                </div>
            </div>
        </div>

        <div class="container mt-5" style="max-width: 700px;">
            <div class="row justify-content-center">
                <div class="col-md-6 mb-4">
                    <div class="brutal-card">
                        <div class="head text-center mt-3">
                            <h4>KEJAKSAAN AGUNG INDONESIA</h4>
                        </div>
                        <hr style="border: 1px dotted #636578">
                        <div class="text-center">
                            <h4 class="mb-2">Selamat datang di {{ config('variables.templateName') }}! </h4>
                            <p class="mb-4">Silahkan lakukan otentikasi</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="brutal-card p-2">
                        <form id="formAuthentication" class="mb-3" action="{{ route('post-login') }}" method="POST">
                            @csrf
                            <div class="form-floating form-floating-outline mb-3">
                                <input type="text" class="brutal-input" id="username" name="username" value="superadmin"
                                    placeholder="Masukan Username" autofocus>
                                {{-- <label for="username">Username</label> --}}
                            </div>
                            <div class="mb-3">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" id="password" class="brutal-input" name="password"
                                                value="123456"
                                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                aria-describedby="password" />
                                            {{-- <label for="password">Password</label> --}}
                                        </div>
                                        <span class="input-group-text cursor-pointer" style="border: 2px dotted #a2a2a2; background-color: #efefef"><i class="mdi mdi-eye-off-outline"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="brutal-btn d-grid w-100 bg-menu-theme" type="submit">Masuk</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
