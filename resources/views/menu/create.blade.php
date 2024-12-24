@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tambah Menu')

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
                <h5 class="mb-0">Tambah Menu Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('post-create-menu') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="kewenangan_id[]" hidden />
                    <div class="row mb-4">
                        <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-format-list-group"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select form-select-md" name="kategori">
                                        <option selected disabled>Pilih kategori</option>
                                        <option value="dashboard">Dashboard</option>
                                        <option value="user">Management User</option>
                                        <option value="menu">Management Menu</option>
                                        <option value="log">Log Aktifitas</option>
                                        <option value="pengaturan">Pengaturan</option>
                                    </select>
                                    <label for="basic-icon-default-route">Kategori</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-list-status"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select form-select-md" name="parent_id">
                                        <option selected disabled>Pilih Parent Menu</option>
                                        @foreach ($parentMenu as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <label for="basic-icon-default-route">Sub Menu</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-menu"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="basic-icon-default-nama"
                                        aria-describedby="basic-icon-default-nama" name="nama" />
                                    <label for="basic-icon-default-nama">Nama Menu</label>
                                </div>
                            </div>
                            <div class="form-text">*huruf kecil semua</div>
                        </div>
                        <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="mdi mdi-router-network"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="basic-icon-default-url" class="form-control"
                                        aria-describedby="basic-icon-default-url" name="url" />
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
                                        aria-describedby="basic-icon-default-slug" name="slug" />
                                    <label for="basic-icon-default-slug">Slug</label>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-6 mt-4">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-nama" class="input-group-text"><i
                                        class="mdi mdi-format-list-group"></i></span>
                                <div class="form-floating form-floating-outline">
                                    <select class="form-select form-select-md" name="icon" id="icons">
                                        <option selected disabled>Pilih Icon</option>
                                    </select>
                                    <label for="basic-icon-default-route">Icon</label>
                                </div>
                            </div>
                        </div> --}}


                        {{-- new input icon --}}
                        {{-- <div class="col-md mt-4">
                            <div class="card card-action mb-4">
                                <div class="card-header">
                                    <div class="card-action-title">Pilih Icon</div>
                                    <div class="card-action-element">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" class="card-collapsible"><i
                                                        class="tf-icons mdi mdi-chevron-up"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="collapse show" style="height: 50px;">
                                    <div class="card-body">
                                        <div class="row" id="icons-container">
                                            <div class="col-md-1" id="icons">
                                                <div class="card">
                                                    <div class="card-body">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('page-createMenu-script')
    <script src="{{ asset('assets/js/cards-actions.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ asset('assets/json/icons.json') }}')
                .then(response => response.json())
                .then(data => {
                    const iconsContainer = document.getElementById(
                        'icons-container');

                    iconsContainer.innerHTML = '';
                    data.forEach(item => {
                        const col = document.createElement('div');
                        col.classList.add('col-md-1', 'mb-4');

                        const card = document.createElement('div');
                        card.classList.add('card');

                        const cardBody = document.createElement('div');
                        cardBody.classList.add('card-body', 'text-center');

                        const iconElement = document.createElement('span');
                        iconElement.classList.add('mdi', `mdi-${item.name}`);
                        iconElement.style.fontSize = '24px';
                        iconElement.title = item.name;

                        cardBody.appendChild(iconElement);
                        card.appendChild(cardBody);
                        col.appendChild(card);
                        iconsContainer.appendChild(col);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
@endsection
