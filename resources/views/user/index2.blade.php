@extends('layouts/layoutMaster')

@section('title', 'List Pengguna')

@section('head')
    <div class="brutal-header">
        <p class="text-light">LIST PENGGUNA</p>
    </div>
@endsection

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-md-2 col-xl-1 col-sm-2 col-xs-2">
            <div class="brutal-circle-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Pengguna">
                <p class="mb-2">{{ $user['total'] }}</p>
            </div>
        </div>
        <div class="col-md-2 col-xl-1 col-sm-2 col-xs-2 ">
            <div class="brutal-circle-card" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Pengguna Aktif">
                <p class="mb-2">{{ $user['aktif'] }}</p>
            </div>
        </div>
        <div class="col-md-2 col-xl-1 col-sm-2 col-xs-2 ">
            <div class="brutal-circle-card" data-bs-toggle="tooltip" data-bs-placement="top"
                title="Total Pengguna Tidak Aktif">
                <p class="mb-2">{{ $user['tidak_aktif'] }}</p>
            </div>
        </div>
        <div class="brutal-card-main">
            <div class="card-body">
                @if (Session::get('username') === 'superadmin')
                    <div class="row justify-content-end">
                        <div class="col-md-1">
                            <a href="{{ route('create-user') }}" class="bg-menu-theme btn-brutal-primary d-flex"><i
                                    class="mdi mdi-plus"></i>
                                Tambah</a>
                        </div>
                    </div>
                @endif
                <div class="table-responsive text-nowrap">
                    <table class="table" id="usersTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Kewenangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($user['users'] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="avatar avatar-md me-2">
                                                    <img src="{{ $item->url_foto == '' ? asset('assets/img/avatars/5.png') : $item->url_foto }}"
                                                        alt="Avatar" class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                {{ $item->username }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>
                                        <span
                                            class="brutal-badge rounded-pill {{ $item->status == 1 ? 'brutal-label-success ' : 'brutal-label-danger' }} me-1">{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                    </td>
                                    <td>
                                        <span class='text-truncate d-flex align-items-center'>
                                            <i
                                                class="mdi {{ $item->kewenangan_id == 1 ? 'mdi-laptop' : ($item->kewenangan_id == 2 ? 'mdi-shield-account' : 'mdi-account') }} mdi-20px me-2"></i>
                                            {{ $item->kewenangan_id == 1 ? 'Superadmin' : ($item->kewenangan_id == 2 ? 'Admin' : 'User') }}
                                        </span>
                                    </td>
                                    <td width="10%">
                                        {{-- @if ($user['face'] !== Session::get('username'))
                                        <a href="/registrasi_fr/{{ $item->id }}"
                                            class="bg-menu-theme btn-brutal-primary"><i
                                                class="mdi mdi-face-recognition"></i>&nbsp;Registrasi FR</a>
                                    @endif --}}
                                        <a href="/edit_user/{{ $item->id }}"
                                            class="bg-menu-theme btn-brutal-secondary"><i
                                                class="mdi mdi-account-edit"></i>&nbsp;Edit</a>
                                        <form action="/hapus_user/{{ $item->id }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="bg-menu-theme btn-brutal-danger"
                                                id="hapus_user"><i
                                                    class="mdi mdi-delete-circle-outline"></i>&nbsp;Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @section('page-user-script')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            const hapusUser = document.querySelector('#hapus_user');
            hapusUser.onclick = function() {
                Swal.fire({
                    title: 'Hapus User ini ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus',
                    customClass: {
                        confirmButton: 'btn btn-primary me-1 waves-effect waves-light',
                        cancelButton: 'btn btn-outline-secondary waves-effect'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil di hapus',
                            customClass: {
                                confirmButton: 'btn btn-success waves-effect'
                            }
                        });
                    }
                });
            }
        </script>
    @endsection

    @section('page-table-script')
        <script type="text/javascript">
            $(document).ready(function() {
                let t = $('#usersTable').DataTable({
                    lengthMenu: [5, 10, 20, 30, 40, 50],
                    responsive: true,
                    Paginate: true,
                    searching: true,
                    info: true,
                    // language: {
                    //     url: '//cdn.datatables.net/plug-ins/2.1.7/i18n/id.json',
                    // },
                    columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: 0,
                    }, ],
                    order: [
                        [1, 'asc']
                    ],

                });

                t.on('order.dt search.dt', function() {
                    let i = 1;

                    t.cells(null, 0, {
                        search: 'applied',
                        order: 'applied'
                    }).every(function(cell) {
                        this.data(i++);
                    });

                }).draw();
            });
        </script>
    @endsection
