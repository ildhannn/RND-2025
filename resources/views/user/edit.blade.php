@extends('layouts/layoutMaster')

@section('title', 'Edit User')

@section('content')

    <div class="container">
        <div class="row justify-content-end mb-4">
            <div class="col-md-1">
                <a href="/user" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom-dashed">
            <div class="row">
                <div class="col-md">
                    <div>
                        <h5 class="card-title mb-0">Edit Pengguna</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <form action="/edit_user_post/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h6>1. Detail Akun</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" class="form-control" value="{{ $user->username }}"
                                name="username" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <input type="text" id="email" class="form-control" value="{{ $user->email }}"
                                name="email" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="alamat">Alamat</label>
                            <input type="text" id="alamat" class="form-control" value="{{ $user->alamat }}"
                                name="alamat" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="kewenangan">Kewenangan</label>
                            <select class="form-select form-select-sm" name="kewenangan_id">
                                <option disabled selected>Pilih Kewenangan</option>
                                @foreach ($kewenangan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $item->id == $user->kewenangan_id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select form-select-sm" name="status" value="{{ $user->status }}">
                                <option selected disabled>Pilih Kewenangan</option>
                                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>
                        {{-- <div class="col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" {{ $user->status == 1 ? 'checked' : '' }} type="checkbox" role="switch" id="status" name="status">
                                <label id="cek" class="form-check-label" for="status"></label>
                            </div>
                        </div> --}}
                    </div>

                    <hr class="my-4 mx-n4" />

                    <h6>2. Upload Gambar</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="foto" accept="image/*" />
                        </div>
                        <div class="col-md-6">
                          <img src="{{ $user->url_foto }}" alt="foto_user" width="100" height="100">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Simpan</button>
                        <button type="reset" class="btn btn-label-secondary">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- @section('page-script')
    <script>
        const checkbox = document.getElementById('status');
        const label = document.getElementById('cek');

        checkbox.addEventListener('change', function() {

            if (this.checked) {
                label.textContent = 'Aktif';
            } else {
                label.textContent = 'Tidak Aktif';
            }
        });

        if (checkbox.checked) {
            label.textContent = 'Aktif';
        } else {
            label.textContent = 'Tidak Aktif';
        }
    </script>
@endsection --}}
