@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Log Aktifitas')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table" id="logTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pengguna</th>
                            <th>Aktifitas</th>
                            <th>IP Private</th>
                            <th>IP Public</th>
                            <th>Host</th>
                            <th>Info Lebih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($res as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user }}</td>
                                <td>{{ $item->nama_aktifitas }}</td>
                                <td>{{ $item->ip_private }}</td>
                                <td>{{ $item->ip_public }}</td>
                                <td>{{ $item->host }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailLain">
                                        Detail Lainnya
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="detailLain" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="detailLain">WAKTU AKSES : {{ \Carbon\Carbon::parse($item->created_at)->format('d-M-Y / H:i:s A') }}</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table>
                                                        <tr>
                                                          <div class="col">
                                                            <th>User Agent</th>
                                                            <th>: </th>
                                                            <td>{{ $item->user_agent }}</td>
                                                          </div>
                                                        </tr>
                                                        <tr>
                                                          <div class="col">
                                                            <th>Browser</th>
                                                            <th>: </th>
                                                            <td>{{ $item->browser }}</td>
                                                          </div>
                                                        </tr>
                                                        <tr>
                                                          <div class="col">
                                                            <th>Perangkat</th>
                                                            <th>: </th>
                                                            <td>{{ $item->bot }}</td>
                                                          </div>
                                                        </tr>
                                                        <tr>
                                                          <div class="col">
                                                            <th>Akses lewat web/mobile</th>
                                                            <th>: </th>
                                                            <td>{{ $item->inapp === false ? 'TIDAL' : 'YA' }}</td>
                                                          </div>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-table-script')
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
@endsection
