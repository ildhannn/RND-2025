@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Log Aktifitas')

@section('head')
    <div class="brutal-header">
        <p class="text-light">LOG AKTIFITAS</p>
    </div>
@endsection

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
                            <th>IP</th>
                            {{-- <th>Browser</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($res as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user }}</td>
                                <td>{{ $item->nama_aktifitas }}</td>
                                <td>{{ $item->ip }}</td>
                                {{-- <td>{{ $item->browser }}</td> --}}
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
