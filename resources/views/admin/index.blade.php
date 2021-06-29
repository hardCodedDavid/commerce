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
                    <button class="btn btn-primary"><i class="ri-refresh-line mr-2"></i>Refresh</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
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
                            <h4 class="card-title mb-0">5%</h4>
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
                            <h4 class="card-title mb-0">198</h4>
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
                            <p class="font-15">Employees</p>
                            <h4 class="card-title mb-0">15,986</h4>
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
                            <h5 class="card-title mb-0">Lead Compare</h5>
                        </div>
                        <div class="col-6 col-lg-3">
                            <select class="form-control font-12">
                                <option value="class1" selected>Last Week</option>
                                <option value="class2">Last Month</option>
                                <option value="class3">Last Year</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="apex-bar-chart"></div>
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
                            <h5 class="card-title mb-0">Lead Compare</h5>
                        </div>
                        <div class="col-6 col-lg-3">
                            <select class="form-control font-12">
                                <option value="class1" selected>Last Week</option>
                                <option value="class2">Last Month</option>
                                <option value="class3">Last Year</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="apex-mixed-line-chart"></div>
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
                                    <h4 class="card-title mb-0">250</h4>
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
                                    <p class="font-15">Comission</p>
                                    <h4 class="card-title mb-0">10%</h4>
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
                                    <p class="font-15">Sales</p>
                                    <h4 class="card-title mb-0">25%</h4>
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
                                    <h4 class="card-title mb-0">7%</h4>
                                </div>
                                <div class="col-6 text-right">
                                    <span class="piety-bar-4">5,3,9,6,5</span>
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
                                    <p class="font-15">Returns</p>
                                    <h4 class="card-title mb-0">21%</h4>
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
                                    <p class="font-15">Refunds</p>
                                    <h4 class="card-title mb-0">18%</h4>
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
                            <h5 class="card-title mb-0">Average Monthly Revenue</h5>
                        </div>
                        <div class="col-6 col-lg-3">
                            <select class="form-control font-12">
                                <option value="class1" selected>Last Week</option>
                                <option value="class2">Last Month</option>
                                <option value="class3">Last Year</option>
                            </select>
                        </div>
                    </div>
                    <h2>$9,86,587</h2>
                </div>
                <div class="card-body p-0">
                    <div id="apex-area-chart"></div>
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
                            <h5 class="card-title mb-0">Payment Breakdown</h5>
                        </div>
                        <div class="col-6 col-lg-3">
                            <select class="form-control font-12">
                                <option value="class1" selected>Last Week</option>
                                <option value="class2">Last Month</option>
                                <option value="class3">Last Year</option>
                            </select>
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
                        <div class="col-6 col-lg-3">
                            <select class="form-control font-12">
                                <option value="class1" selected>Last Week</option>
                                <option value="class2">Last Month</option>
                                <option value="class3">Last Year</option>
                            </select>
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
                            <h5 class="card-title mb-0">Top Selling Products</h5>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-outline-light text-muted btn-sm float-right font-12">View</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Progress</th>
                                    <th class="text-right">%</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Healthcare</td>
                                    <td>
                                        <div class="progress" style="height: 4px;">
                                          <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">75%</td>
                                </tr>
                                <tr>
                                    <td>Banking Finance</td>
                                    <td>
                                        <div class="progress" style="height: 4px;">
                                          <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">40%</td>
                                </tr>
                                <tr>
                                    <td>FMCG</td>
                                    <td>
                                        <div class="progress" style="height: 4px;">
                                          <div class="progress-bar bg-danger" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">60%</td>
                                </tr>
                                <tr>
                                    <td>Agriculture</td>
                                    <td>
                                        <div class="progress" style="height: 4px;">
                                          <div class="progress-bar bg-warning" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">50%</td>
                                </tr>
                                <tr>
                                    <td>Automobile</td>
                                    <td>
                                        <div class="progress" style="height: 4px;">
                                          <div class="progress-bar bg-info" role="progressbar" style="width: 87%;" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td class="text-right">87%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
        <!-- Start col -->
        <div class="col-lg-12 col-xl-6">
            <div class="card m-b-30">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <h5 class="card-title mb-0">Activity</h5>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-outline-light text-muted btn-sm float-right font-12">View</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="media mb-4">
                            <span class="iconbar iconbar-md bg-primary text-white rounded align-self-center mr-3"><i class="ri-folder-5-line align-unset"></i></span>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1 font-16">Project 01 timeline approved</h5>
                                <p class="mb-0">2 hours ago</p>
                            </div>
                        </li>
                        <li class="media mb-4">
                            <span class="iconbar iconbar-md bg-success text-white rounded align-self-center mr-3"><i class="ri-user-3-line align-unset"></i></span>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1 font-16">Ronnie applied for leave</h5>
                                <p class="mb-0">10 hours ago</p>
                            </div>
                        </li>
                        <li class="media mb-4">
                            <span class="iconbar iconbar-md bg-warning text-white rounded align-self-center mr-3"><i class="ri-calendar-event-line align-unset"></i></span>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1 font-16">Meeting Schedule with WIPRO</h5>
                                <p class="mb-0">27 May, 2020</p>
                            </div>
                        </li>
                        <li class="media mb-4">
                            <span class="iconbar iconbar-md bg-danger text-white rounded align-self-center mr-3"><i class="ri-eye-2-line align-unset"></i></span>
                            <div class="media-body">
                                <h5 class="mt-0 mb-1 font-16">Presentation for final tapeout</h5>
                                <p class="mb-0">15 Mar, 2020</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
@endsection

@section('script')
    <!-- Piety Chart js -->
    <script src="{{ asset('admin/assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- Dashboard js -->
    <script src="{{ asset('admin/assets/js/custom/custom-dashboard-ecommerce.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/peity/jquery.peity.min.js') }}"></script>
    <!-- Apex js -->
    <script src="{{ asset('admin/assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/apexcharts/irregular-data-series.js') }}"></script>
    <!-- Custom Dashboard js -->
    <script src="{{ asset('admin/assets/js/custom/custom-dashboard.js') }}"></script>
@endsection