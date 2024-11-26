@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tambah User')

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
                <form action="{{ route('post-create-user') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </div>
@endsection
