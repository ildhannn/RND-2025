@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Dashboard')

@section('head')
    <div class="brutal-header">
        <p class="text-light">DASHBOARD</p>
    </div>
@endsection


@section('content')
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Balance</h5>
                    <small class="text-muted">Commercial networks & enterprises</small>
                </div>
                <div class="d-sm-flex d-none align-items-center">
                    <h5 class="mb-0 me-3">$ 100,000</h5>
                    <span class="badge bg-label-secondary rounded-pill">
                        <i class='mdi mdi-arrow-down mdi-14px text-danger'></i>
                        <span class="align-middle">20%</span>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div id="lineChart"></div>
            </div>
        </div>
    </div>
@endsection


@section('page-dashboard-script')
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/charts-apex.js') }}"></script>
@endsection
