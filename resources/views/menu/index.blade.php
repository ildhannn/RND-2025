@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Managemen Menu')

@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 mb-4 mb-xl-0">
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="card-title">List Menu Yang Tersedia</h3>
                                <div class="row justify-content-end mb-4">
                                    <div class="col-md-2">
                                        <a href="{{ route('create-menu') }}" class="btn btn-sm btn-primary d-flex"><i
                                                class="mdi mdi-plus"></i>
                                            Tambah Menu</a>
                                    </div>
                                </div>
                                <div class="nav-align-top mb-4">
                                    {{-- nav --}}
                                    <div class="card">
                                        <div class="card-body">
                                            <ul class="nav nav-pills nav-fill" role="tablist">
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link active" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#dashboard"
                                                        aria-controls="dashboard" aria-selected="true"><i
                                                            class="tf-icons mdi mdi-home-outline me-1"></i>
                                                        Dashboard
                                                        {{-- <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-danger ms-1">3</span> --}}
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#user" aria-controls="user"
                                                        aria-selected="false"><i
                                                            class="tf-icons mdi mdi-account-outline me-1"></i> Managemen
                                                        User
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#menu" aria-controls="menu"
                                                        aria-selected="false"><i class="tf-icons mdi mdi-menu me-1"></i>
                                                        Managemen Menu
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#log" aria-controls="log"
                                                        aria-selected="false"><i class="tf-icons mdi mdi-math-log me-1"></i>
                                                        Log Aktifitas
                                                    </button>
                                                </li>
                                                <li class="nav-item">
                                                    <button type="button" class="nav-link" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#pengaturan"
                                                        aria-controls="pengaturan" aria-selected="false"><i
                                                            class="tf-icons mdi mdi-cog me-1"></i>
                                                        Pengaturan
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    {{-- table --}}
                                    <div class="card mt-4">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table" id="dashboardTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Menu</th>
                                                                    <th>URL</th>
                                                                    <th>Slug</th>
                                                                    <th>Icon</th>
                                                                    <th>Kewenangan</th>
                                                                    <th>Status</th>
                                                                    <th>Kategori</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($menu['dashboard'] as $item)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $item->nama }}</td>
                                                                        <td>{{ $item->url }}</td>
                                                                        <td>{{ $item->slug }}</td>
                                                                        <td>{{ $item->icon ?? '-' }}</td>
                                                                        <td>
                                                                            <span
                                                                                class="text-truncate d-flex align-items-center">
                                                                                @php
                                                                                    $kewenanganIds = is_array(
                                                                                        $item->kewenangan_id,
                                                                                    )
                                                                                        ? $item->kewenangan_id
                                                                                        : json_decode(
                                                                                            $item->kewenangan_id,
                                                                                            true,
                                                                                        );

                                                                                    $kewenanganIds = $kewenanganIds ?? [
                                                                                        $item->kewenangan_id,
                                                                                    ];
                                                                                @endphp

                                                                                @foreach ($kewenanganIds as $kewenangan)
                                                                                    <span data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="{{ $kewenangan == 1 ? 'Superadmin' : ($kewenangan == 2 ? 'Admin' : 'User') }}">
                                                                                        <i
                                                                                            class="mdi {{ $kewenangan == 1 ? 'mdi-laptop text-primary' : ($kewenangan == 2 ? 'mdi-shield-account text-success' : 'mdi-account text-info') }}
                                                                              mdi-20px me-2"></i>
                                                                                    </span>
                                                                                @endforeach
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge rounded-pill {{ $item->status == 1 ? 'bg-label-success' : 'bg-label-danger' }} me-1">{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                                        </td>
                                                                        <td>{{ $item->kategori }}</td>
                                                                        <td>
                                                                            <a href="/edit_menu/{{ $item->id }}"
                                                                                class="btn btn-sm btn-primary">Edit</a>
                                                                            <form
                                                                                action="/menu_hapus-post/{{ $item->id }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger"
                                                                                    id="hapus_user">Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="user" role="tabpanel">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table" id="userTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Menu</th>
                                                                    <th>URL</th>
                                                                    <th>Slug</th>
                                                                    <th>Icon</th>
                                                                    <th>Kewenangan</th>
                                                                    <th>Status</th>
                                                                    <th>Kategori</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($menu['users'] as $item)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $item->nama }}</td>
                                                                        <td>{{ $item->url }}</td>
                                                                        <td>{{ $item->slug }}</td>
                                                                        <td>{{ $item->icon ?? '-' }}</td>
                                                                        <td>
                                                                            <span
                                                                                class="text-truncate d-flex align-items-center">
                                                                                @php
                                                                                    $kewenanganIds = is_array(
                                                                                        $item->kewenangan_id,
                                                                                    )
                                                                                        ? $item->kewenangan_id
                                                                                        : json_decode(
                                                                                            $item->kewenangan_id,
                                                                                            true,
                                                                                        );

                                                                                    $kewenanganIds = $kewenanganIds ?? [
                                                                                        $item->kewenangan_id,
                                                                                    ];
                                                                                @endphp

                                                                                @foreach ($kewenanganIds as $kewenangan)
                                                                                    <span data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="{{ $kewenangan == 1 ? 'Superadmin' : ($kewenangan == 2 ? 'Admin' : 'User') }}">
                                                                                        <i
                                                                                            class="mdi {{ $kewenangan == 1 ? 'mdi-laptop text-primary' : ($kewenangan == 2 ? 'mdi-shield-account text-success' : 'mdi-account text-info') }}
                                                                      mdi-20px me-2"></i>
                                                                                    </span>
                                                                                @endforeach
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge rounded-pill {{ $item->status == 1 ? 'bg-label-success' : 'bg-label-danger' }} me-1">{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                                        </td>
                                                                        <td>{{ $item->kategori }}</td>
                                                                        <td>
                                                                            <a href="/edit_menu/{{ $item->id }}"
                                                                                class="btn btn-sm btn-primary">Edit</a>
                                                                            <form
                                                                                action="/menu_hapus-post/{{ $item->id }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger"
                                                                                    id="hapus_user">Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="menu" role="tabpanel">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table" id="menuTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Menu</th>
                                                                    <th>URL</th>
                                                                    <th>Slug</th>
                                                                    <th>Icon</th>
                                                                    <th>Kewenangan</th>
                                                                    <th>Status</th>
                                                                    <th>Kategori</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($menu['menus'] as $item)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $item->nama }}</td>
                                                                        <td>{{ $item->url }}</td>
                                                                        <td>{{ $item->slug }}</td>
                                                                        <td>{{ $item->icon ?? '-' }}</td>
                                                                        <td>
                                                                            <span
                                                                                class="text-truncate d-flex align-items-center">
                                                                                @php
                                                                                    $kewenanganIds = is_array(
                                                                                        $item->kewenangan_id,
                                                                                    )
                                                                                        ? $item->kewenangan_id
                                                                                        : json_decode(
                                                                                            $item->kewenangan_id,
                                                                                            true,
                                                                                        );

                                                                                    $kewenanganIds = $kewenanganIds ?? [
                                                                                        $item->kewenangan_id,
                                                                                    ];
                                                                                @endphp

                                                                                @foreach ($kewenanganIds as $kewenangan)
                                                                                    <span data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="{{ $kewenangan == 1 ? 'Superadmin' : ($kewenangan == 2 ? 'Admin' : 'User') }}">
                                                                                        <i
                                                                                            class="mdi {{ $kewenangan == 1 ? 'mdi-laptop text-primary' : ($kewenangan == 2 ? 'mdi-shield-account text-success' : 'mdi-account text-info') }}
                                                                      mdi-20px me-2"></i>
                                                                                    </span>
                                                                                @endforeach
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge rounded-pill {{ $item->status == 1 ? 'bg-label-success' : 'bg-label-danger' }} me-1">{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                                        </td>
                                                                        <td>{{ $item->kategori }}</td>
                                                                        <td>
                                                                            <a href="/edit_menu/{{ $item->id }}"
                                                                                class="btn btn-sm btn-primary">Edit</a>
                                                                            <form
                                                                                action="/menu_hapus-post/{{ $item->id }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger"
                                                                                    id="hapus_user">Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="log" role="tabpanel">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table" id="logTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Menu</th>
                                                                    <th>URL</th>
                                                                    <th>Slug</th>
                                                                    <th>Icon</th>
                                                                    <th>Kewenangan</th>
                                                                    <th>Status</th>
                                                                    <th>Kategori</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($menu['log'] as $item)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $item->nama }}</td>
                                                                        <td>{{ $item->url }}</td>
                                                                        <td>{{ $item->slug }}</td>
                                                                        <td>{{ $item->icon ?? '-' }}</td>
                                                                        <td>
                                                                            <span
                                                                                class="text-truncate d-flex align-items-center">
                                                                                @php
                                                                                    $kewenanganIds = is_array(
                                                                                        $item->kewenangan_id,
                                                                                    )
                                                                                        ? $item->kewenangan_id
                                                                                        : json_decode(
                                                                                            $item->kewenangan_id,
                                                                                            true,
                                                                                        );

                                                                                    $kewenanganIds = $kewenanganIds ?? [
                                                                                        $item->kewenangan_id,
                                                                                    ];
                                                                                @endphp

                                                                                @foreach ($kewenanganIds as $kewenangan)
                                                                                    <span data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="{{ $kewenangan == 1 ? 'Superadmin' : ($kewenangan == 2 ? 'Admin' : 'User') }}">
                                                                                        <i
                                                                                            class="mdi {{ $kewenangan == 1 ? 'mdi-laptop text-primary' : ($kewenangan == 2 ? 'mdi-shield-account text-success' : 'mdi-account text-info') }}
                                                                    mdi-20px me-2"></i>
                                                                                    </span>
                                                                                @endforeach
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge rounded-pill {{ $item->status == 1 ? 'bg-label-success' : 'bg-label-danger' }} me-1">{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                                        </td>
                                                                        <td>{{ $item->kategori }}</td>
                                                                        <td>
                                                                            <a href="/edit_menu/{{ $item->id }}"
                                                                                class="btn btn-sm btn-primary">Edit</a>
                                                                            <form
                                                                                action="/menu_hapus-post/{{ $item->id }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger"
                                                                                    id="hapus_user">Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="pengaturan" role="tabpanel">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table" id="pengaturanTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Menu</th>
                                                                    <th>URL</th>
                                                                    <th>Slug</th>
                                                                    <th>Icon</th>
                                                                    <th>Kewenangan</th>
                                                                    <th>Status</th>
                                                                    <th>Kategori</th>
                                                                    <th>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($menu['pengaturan'] as $item)
                                                                    @if ($item->parent_id == null)
                                                                        kosong
                                                                    @endif
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>{{ $item->nama }}</td>
                                                                        <td>{{ $item->url }}</td>
                                                                        <td>{{ $item->slug }}</td>
                                                                        <td>{{ $item->icon ?? '-' }}</td>
                                                                        <td>
                                                                            <span
                                                                                class="text-truncate d-flex align-items-center">
                                                                                @php
                                                                                    $kewenanganIds = is_array(
                                                                                        $item->kewenangan_id,
                                                                                    )
                                                                                        ? $item->kewenangan_id
                                                                                        : json_decode(
                                                                                            $item->kewenangan_id,
                                                                                            true,
                                                                                        );

                                                                                    $kewenanganIds = $kewenanganIds ?? [
                                                                                        $item->kewenangan_id,
                                                                                    ];
                                                                                @endphp

                                                                                @foreach ($kewenanganIds as $kewenangan)
                                                                                    <span data-bs-toggle="tooltip"
                                                                                        data-bs-placement="bottom"
                                                                                        title="{{ $kewenangan == 1 ? 'Superadmin' : ($kewenangan == 2 ? 'Admin' : 'User') }}">
                                                                                        <i
                                                                                            class="mdi {{ $kewenangan == 1 ? 'mdi-laptop text-primary' : ($kewenangan == 2 ? 'mdi-shield-account text-success' : 'mdi-account text-info') }} mdi-20px me-2"></i>
                                                                                    </span>
                                                                                @endforeach
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge rounded-pill {{ $item->status == 1 ? 'bg-label-success' : 'bg-label-danger' }} me-1">{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                                                        </td>
                                                                        <td>{{ $item->kategori }}</td>
                                                                        <td>
                                                                            <a href="/edit_menu/{{ $item->id }}"
                                                                                class="btn btn-sm btn-primary">Edit</a>
                                                                            <form
                                                                                action="/menu_hapus-post/{{ $item->id }}"
                                                                                method="POST" class="d-inline">
                                                                                @csrf
                                                                                <button type="submit"
                                                                                    class="btn btn-sm btn-danger"
                                                                                    id="hapus_user">Hapus</button>
                                                                            </form>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-table-script')

    <script type="text/javascript">
        $(document).ready(function() {
            let t = $('#dashboardTable').DataTable({
                lengthMenu: [10, 20, 30, 40, 50],
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

    <script type="text/javascript">
        $(document).ready(function() {
            let t = $('#userTable').DataTable({
                lengthMenu: [10, 20, 30, 40, 50],
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

    <script type="text/javascript">
        $(document).ready(function() {
            let t = $('#menuTable').DataTable({
                lengthMenu: [10, 20, 30, 40, 50],
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

    <script type="text/javascript">
        $(document).ready(function() {
            let t = $('#logTable').DataTable({
                lengthMenu: [10, 20, 30, 40, 50],
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

    <script type="text/javascript">
        $(document).ready(function() {
            let t = $('#pengaturanTable').DataTable({
                lengthMenu: [10, 20, 30, 40, 50],
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
