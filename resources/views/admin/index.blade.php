@extends('layouts.admin')

@section('title', 'Dashboard')

@section('style')
    <!-- Apex css -->
    <link href="{{ asset('admin/assets/plugins/apexcharts/apexcharts.css') }}" rel="stylesheet">
@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Dashboard</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary"><i class="ri-refresh-line mr-2"></i>Refresh</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
@can ('View Dashboard')
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12 col-xl-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col-8">
                            <p class="font-15">Total Revenue</p>
                            <h5 class="card-title mb-0">₦{{ number_format($sales) }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-arrow-right-up-line align-unset"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col-8">
                            <p class="font-15">Products</p>
                            <h5 class="card-title mb-0">{{ $products }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-money-dollar-circle-line align-unset"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col-8">
                            <p class="font-15">Users</p>
                            <h5 class="card-title mb-0">{{ $users }}</h5>
                        </div>
                        <div class="col-4 text-right">
                            <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-user-3-line align-unset"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
        <!-- Start col -->
        <div class="col-lg-12 col-xl-9">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6 col-lg-9">
                            <h5 class="card-title mb-0">This Year Transactions</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="transactionMonthlyChart"></div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
    <!-- Start row -->
    <div class="row">
         <!-- Start col -->
         <div class="col-lg-12 col-xl-6">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6 col-lg-9">
                            <h5 class="card-title mb-0">This Month Transactions</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="transactionDailyBreakdown"></div>
                </div>
            </div>
        </div>
        <!-- End col -->
        <!-- Start col -->
        <div class="col-lg-12 col-xl-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col-6">
                                    <p class="font-15">Orders</p>
                                    <h5 class="card-title mb-0">{{ $orders }}</h5>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="piety-bar-1">5,3,9,6,5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col-6">
                                    <p class="font-15">Sales</p>
                                    <h5 class="card-title mb-0">₦{{ number_format($sales) }}</h5>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="piety-bar-2">5,3,9,6,5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col-6">
                                    <p class="font-15">Purchases</p>
                                    <h5 class="card-title mb-0">₦{{ number_format($purchases) }}</h5>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="piety-bar-3">5,3,9,6,5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col-6">
                                    <p class="font-15">Profit</p>
                                    <h5 class="card-title mb-0">₦{{ number_format($profit) }}</h5>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="piety-bar-4">1,3,9,6,5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col-6">
                                    <p class="font-15">Suppliers</p>
                                    <h5 class="card-title mb-0">{{ $suppliers }}</h5>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="piety-bar-5">5,3,9,6,5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-b-30">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col-6">
                                    <p class="font-15">Listed Products</p>
                                    <h5 class="card-title mb-0">{{ $listed_products }}</h5>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="piety-bar-6">5,3,9,6,5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12 col-xl-7">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6 col-lg-9">
                            <h5 class="card-title mb-0">Average Monthly Profit</h5>
                        </div>
                    </div>
                    <h2>₦ {{ number_format(array_sum($chart_data['year_transactions']['profit']) / 12) }}</h2>
                </div>
                <div class="card-body p-0">
                    <div id="profitChart"></div>
                </div>
            </div>
        </div>
        <!-- End col -->
        <!-- Start col -->
        <div class="col-lg-12 col-xl-5">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6 col-lg-9">
                            <h5 class="card-title mb-0">Transaction Breakdown</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0">
                    <div id="apex-donut-chart"></div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
     <!-- Start row -->
     <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6 col-lg-9">
                            <h5 class="card-title mb-0">Sales</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="apex-column-chart"></div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12 col-xl-6">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h5 class="card-title mb-0">Top 5 Selling Products</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th class="text-right">Qty sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($top_selling as $product)
                                    <tr>
                                        <td>{{ $product['name'] }}</td>
                                        <td>
                                            {{ $product['sell_price'] }}
                                        </td>
                                        <td class="text-right">{{ $product->saleItems->count() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
@else
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-4">
                            <div class="thankyou-content text-center my-5">
                                <img src="/admin/assets/images/ecommerce/home.svg" class="img-fluid mb-5" alt="thankyou">
                                <p class="my-4">You don't have permission to view this page</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
@endcan
@endsection

@section('script')
    <!-- Piety Chart js -->
    <script src="{{ asset('admin/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- Dashboard js -->
    {{-- <script src="{{ asset('admin/assets/js/custom/custom-dashboard-ecommerce.js') }}"></script> --}}
    <script src="{{ asset('admin/assets/plugins/peity/jquery.peity.min.js') }}"></script>
    <!-- Apex js -->
    <script src="{{ asset('admin/assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/apexcharts/irregular-data-series.js') }}"></script>
    <!-- Custom Dashboard js -->
    {{-- <script src="{{ asset('admin/assets/js/custom/custom-dashboard.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            var options = {
                chart: {
                    height: 270,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '25%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                colors: ['#190D3F', '#c4ec19'],
                series: [{
                    name: 'Purchases',
                    data: {!! json_encode($chart_data['year_transactions']['purchases']) !!}
                }, {
                    name: 'Sales',
                    data: {!! json_encode($chart_data['year_transactions']['sales']) !!}
                }],
                legend: {
                    show: false,
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    axisBorder: {
                        show: true,
                        color: 'rgba(0,0,0,0.05)'
                    },
                    axisTicks: {
                        show: true,
                        color: 'rgba(0,0,0,0.05)'
                    }
                },
                grid: {
                    row: {
                        colors: ['transparent', 'transparent'], opacity: .2
                    },
                    borderColor: 'rgba(0,0,0,0.05)'
                },
                fill: {
                    opacity: 1,
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "₦ " + val + " thousands"
                        }
                    }
                }
            }
            var chart = new ApexCharts(
                document.querySelector("#transactionMonthlyChart"),
                options
            );
            chart.render();

            var options = {
            chart: {
            height: 270,
            type: 'line',
            toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            colors: ['#190D3F','#c4ec19'],
            series: [{
                name: "Purchases",
                data: {!! json_encode($chart_data['month_transactions']['purchases']) !!}
            },
            {
                name: 'Sales',
                data: {!! json_encode($chart_data['month_transactions']['sales']) !!}
            }
            ],
            dataLabels: {
                enabled: false
            },
            stroke: {
            width: [3, 3],
            curve: 'straight',
            },
            grid: {
                row: {
                    colors: ['transparent', 'transparent'], opacity: .2
                },
                borderColor: 'rgba(0,0,0,0.05)'
            },
            legend: {
            tooltipHoverFormatter: function(val, opts) {
                return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
            }
            },
            markers: {
            size: 0,
            hover: {
                sizeOffset: 6
            }
            }
        };
        var chart = new ApexCharts(document.querySelector("#transactionDailyBreakdown"), options);
        chart.render();

        })

        var options = {
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: false
                },
                zoom: {
                type: 'x',
                enabled: false,
                autoScaleYaxis: true
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
            },
            colors: ['#190D3F'],
            series: [{
                name: 'Profit',
                data: {!! json_encode($chart_data['year_transactions']['profit']) !!}
            }],
            legend: {
                show: false,
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                axisBorder: {
                    show: true,
                    color: 'rgba(0,0,0,0.05)'
                },
                axisTicks: {
                    show: true,
                    color: 'rgba(0,0,0,0.05)'
                }
            },
            grid: {
                row: {
                    colors: ['transparent', 'transparent'], opacity: .2
                },
                borderColor: 'rgba(0,0,0,0.05)'
            },
            tooltip: {
                x: {
                    format: 'dd/MM/yy HH:mm'
                },
            }
        }
        var chart = new ApexCharts(
            document.querySelector("#profitChart"),
            options
        );
        chart.render();

        var options = {
            chart: {
            type: 'donut',
            width: 300,
            },
            colors: ['#190D3F', '#c4ec19'],
            series: [{!! json_encode($purchases) !!}, {!! json_encode($sales) !!}],
            labels: ['Purchases', 'Sales'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                width: 250
                }
            }
            }]
        };
        var chart = new ApexCharts(document.querySelector("#apex-donut-chart"), options);
        chart.render();

        var options = {
            series: [{
            name: 'Sales',
            data: {!! json_encode($chart_data['year_transactions']['sales']) !!}
            }],
            annotations: {
            points: [{
                seriesIndex: 0,
                label: {
                borderColor: '#190D3F',
                offsetY: 0,
                style: {
                    color: '#fff',
                    background: '#190D3F',
                }
                }
            }]
            },
            chart: {
            height: 300,
            type: 'bar',
            toolbar: {
                show: false
            }
            },
            plotOptions: {
            bar: {
                columnWidth: '25%',
                endingShape: 'rounded'
            }
            },
            colors: ['#190D3F'],
            dataLabels: {
            enabled: false
            },
            stroke: {
            width: 2
            },
            grid: {
            row: {
                colors: ['#fff', '#fff']
            }
            },
            xaxis: {
            labels: {
                rotate: -45
            },
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            tickPlacement: 'on'
            },
            yaxis: {
            title: {
                text: 'Sales',
            },
            },
            fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 0.85,
                opacityTo: 0.85,
                stops: [50, 0, 100]
            },
            }
            };
            var chart = new ApexCharts(document.querySelector("#apex-column-chart"), options);
            chart.render();

            $(".piety-bar-1").peity("bar", {
                width: 55,
                height: 55,
                padding: 0.2,
                fill: ["#190D3F"],
            });

                /* -- Piety - Bar Chart 2 -- */
            $(".piety-bar-2").peity("bar", {
                width: 55,
                height: 55,
                padding: 0.2,
                fill: ["#acacb4"]
            });

                /* -- Piety - Bar Chart 3 -- */
            $(".piety-bar-3").peity("bar", {
                width: 55,
                height: 55,
                padding: 0.2,
                fill: ["#c4ec19"]
            });

                /* -- Piety - Bar Chart 4  -- */
            $(".piety-bar-4").peity("bar", {
                width: 55,
                height: 55,
                padding: 0.2,
                fill: ["#fcbc04"]
            });

                /* -- Piety - Bar Chart 5 -- */
            $(".piety-bar-5").peity("bar", {
                width: 55,
                height: 55,
                padding: 0.2,
                fill: ["#25bef6"]
            });

                /* -- Piety - Bar Chart 6  -- */
            $(".piety-bar-6").peity("bar", {
                width: 55,
                height: 55,
                padding: 0.2,
                fill: ["#f62525"]
            });
    </script>
@endsection
