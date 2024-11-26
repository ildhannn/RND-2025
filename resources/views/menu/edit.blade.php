@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Edit Menu')

@section('content')
    <div class="container">
        <div class="row justify-content-end mb-4">
            <div class="col-md-1">
                <a href="/menu" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Edit Menu</h5>
            </div>
            <div class="card-body">
                <form action="/menu_edit-post/{{ $res->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-format-list-group"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select form-select-md" name="kategori">
                                        <option selected disabled>Pilih kategori</option>
                                        <option value="dashboard" {{ $res->kategori == 'dashboard' ? 'selected' : '' }}>
                                            Dashboard</option>
                                        <option value="user" {{ $res->kategori == 'user' ? 'selected' : '' }}>Management
                                            Pengguna</option>
                                        <option value="log" {{ $res->kategori == 'log' ? 'selected' : '' }}>Log Aktifitas
                                        </option>
                                    </select>
                                    <label for="basic-icon-default-route">Kategori</label>
                                </div>
                            </div>
                        </div>

                        {{-- Kewenagan old --}}
                        {{-- <div class="col-md-6">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-format-list-group"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select form-select-sm" name="kewenangan_id">
                                        <option disabled selected>Pilih Kewenangan</option>
                                        @foreach ($kewenangan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $res->kewenangan_id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="basic-icon-default-route">Kewenangan</label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-menu"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="basic-icon-default-nama"
                                        aria-describedby="basic-icon-default-nama" name="nama"
                                        value="{{ $res->nama }}" />
                                    <label for="basic-icon-default-nama">Nama Menu</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="mdi mdi-router-network"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="basic-icon-default-url" class="form-control"
                                        aria-describedby="basic-icon-default-url" name="url"
                                        value="{{ $res->url }}" />
                                    <label for="basic-icon-default-url">URL</label>
                                </div>
                            </div>
                            <div class="form-text">*awali dengan simbol (/)</div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="mdi mdi-router-network"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="basic-icon-default-slug" class="form-control"
                                        aria-describedby="basic-icon-default-slug" name="slug"
                                        value="{{ $res->slug }}" />
                                    <label for="basic-icon-default-slug">Slug</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-format-list-group"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select form-select-sm" name="icon">
                                        <option disabled selected>Pilih Icon</option>
                                    </select>
                                    <label for="basic-icon-default-route">Icon</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-list-status"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select form-select-md" name="status" value="{{ $res->status }}">
                                        <option selected disabled>Pilih Kewenangan</option>
                                        <option value="1" {{ $res->status == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $res->status == 0 ? 'selected' : '' }}>Tidak Aktif
                                        </option>
                                    </select>
                                    <label for="basic-icon-default-route">Status</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- New Kewenangan --}}
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-6">
                                <div class="card">
                                    <h5 class="card-header">Kewenangan</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md mb-md-0 mb-2">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content" for="superadmin">
                                                        <span class="custom-option-body">
                                                            <i class="mdi mdi-laptop"></i>
                                                            <span class="custom-option-title"> Superadmin </span>
                                                        </span>
                                                        <input class="form-check-input" type="checkbox" value="1"
                                                            id="superadmin" name="kewenangan_id[]"
                                                            {{ in_array(1, json_decode($res->kewenangan_id)) ? 'checked' : '' }} />
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md mb-md-0 mb-2">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content" for="admin">
                                                        <span class="custom-option-body">
                                                            <i class="mdi mdi-shield-account"></i>
                                                            <span class="custom-option-title"> Admin </span>
                                                        </span>
                                                        <input class="form-check-input" type="checkbox" value="2"
                                                            id="admin" name="kewenangan_id[]"
                                                            {{ in_array(2, json_decode($res->kewenangan_id)) ? 'checked' : '' }} />
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md mb-md-0 mb-2">
                                                <div class="form-check custom-option custom-option-icon">
                                                    <label class="form-check-label custom-option-content" for="user">
                                                        <span class="custom-option-body">
                                                            <i class="mdi mdi-account"></i>
                                                            <span class="custom-option-title"> User </span>
                                                        </span>
                                                        <input class="form-check-input" type="checkbox" value="3"
                                                            id="user" name="kewenangan_id[]"
                                                            {{ in_array(3, json_decode($res->kewenangan_id)) ? 'checked' : '' }} />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </div>
@endsection
