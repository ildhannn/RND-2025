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
    <div class="col-md-6 col-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <p class="card-subtitle text-muted mb-1">Aktifitas Terakhir</p>
                </div>
                <div class="dropdown">
                    <button type="button" class="btn dropdown-toggle px-0" data-bs-toggle="dropdown" aria-expanded="false"><i
                            class="mdi mdi-calendar-month-outline"></i></button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Hari ini</a></li>
                        <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Kemarin</a></li>
                        <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">1 Minggu
                                Terakhir</a>
                        </li>
                        <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">1 Bulan
                                Terakhir</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">Bulan Sekarang</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div id="dahsboard"></div>
            </div>
        </div>
    </div>
@endsection

@section('page-dashboard-script')
    <script>
        let dataLogin = @json($res).login.length;
        let dataUpdatePengguna = @json($res).update_pengguna.length;
        let dataUpdateMenu = @json($res).update_menu.length;

        const horizontalBarChartEl = document.querySelector('#dahsboard'),
            horizontalBarChartConfig = {
                chart: {
                    height: 400,
                    fontFamily: 'Inter',
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '30%',
                        startingShape: 'rounded',
                        borderRadius: 8
                    }
                },
                grid: {
                    borderColor: config.colors.borderColor,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    padding: {
                        top: -20,
                        bottom: -12
                    }
                },
                colors: '#c8102e',
                dataLabels: {
                    enabled: false
                },
                series: [{
                    data: [
                      dataLogin,
                      dataUpdatePengguna,
                      dataUpdateMenu
                    ]
                }],
                xaxis: {
                    categories: ['Login', 'Update Pengguna', 'Update Menu'],
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: config.colors.textMuted,
                            fontSize: '11px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: config.colors.textMuted,
                            fontSize: '11px'
                        }
                    }
                }
            };
        if (typeof horizontalBarChartEl !== undefined && horizontalBarChartEl !== null) {
            const horizontalBarChart = new ApexCharts(horizontalBarChartEl, horizontalBarChartConfig);
            horizontalBarChart.render();
        }
    </script>
@endsection
