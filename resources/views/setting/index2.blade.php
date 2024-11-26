@extends('layouts/layoutMaster')

@section('title', 'Pengaturan')

@section('head')
    <div class="brutal-header">
        <p class="text-light">PENGATURAN</p>
    </div>
@endsection

@section('content')

    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Pengaturan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('post-edit-pengaturan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group input-group-merge mb-4">
                                <span id="basic-icon-default-nama_apk" class="input-group-text"><i
                                        class="mdi mdi-apps"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="basic-icon-default-nama_apk"
                                        aria-describedby="basic-icon-default-nama_apk" name="nama_apk"
                                        value="{{ $res->nama_apk }}" />
                                    <label for="basic-icon-default-nama_apk">Nama Aplikasi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-page-layout-footer"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="texts" id="basic-icon-default-footer" class="form-control"
                                            aria-describedby="basic-icon-default-footer" name="footer"
                                            value="{{ $res->footer }}" />
                                        <label for="basic-icon-default-footer">Footer</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-page-layout-header"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" id="basic-icon-default-logo_header" class="form-control"
                                            aria-describedby="basic-icon-default-logo_header" name="logo_header" />
                                        <label for="basic-icon-default-logo_header">Logo Header</label>
                                    </div>
                                </div>
                            </div>
                            <img src="{{ $res->url_logo_header }}" alt="logo_header" width="100" height="auto">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="mdi mdi-star-box"></i></span>
                                    <div class="form-floating form-floating-outline">
                                        <input type="file" id="basic-icon-default-favico" class="form-control"
                                            aria-describedby="basic-icon-default-favico" name="favico" />
                                        <label for="basic-icon-default-favico">Favico</label>
                                    </div>
                                </div>
                            </div>
                            <img src="{{ $res->url_favico }}" alt="favico" width="100" height="auto">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </div>

@endsection
