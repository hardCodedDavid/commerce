@extends('layouts.admin')

@section('title', 'User Details')

@section('style')

@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">User Details</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
     <!-- Start Contentbar -->
     <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-5 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title mb-0">My Account</h5>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link mb-2 active" id="v-pills-dashboard-tab" data-toggle="pill" href="#v-pills-dashboard" role="tab" aria-controls="v-pills-dashboard" aria-selected="true"><i class="ri-dashboard-line mr-2"></i>Dashboard</a>
                            <a class="nav-link mb-2" id="v-pills-order-tab" data-toggle="pill" href="#v-pills-order" role="tab" aria-controls="v-pills-order" aria-selected="false"><i class="ri-dropbox-line mr-2"></i>Orders</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
            <!-- Start col -->
            <div class="col-lg-7 col-xl-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <!-- Dashboard Start -->
                    <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel" aria-labelledby="v-pills-dashboard-tab">
                        <!-- Start row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <form>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control" id="username">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="useremail">Email</label>
                                                    <input type="email" class="form-control" id="useremail">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="usermobile">Mobile Number</label>
                                                    <input type="text" class="form-control" id="usermobile">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="userbirthdate">Date of Birth</label>
                                                    <input type="date" class="form-control" id="userbirthdate">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="userpassword">Password</label>
                                                    <input type="password" class="form-control" id="userpassword">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="userconfirmedpassword">Confirmed Password</label>
                                                    <input type="password" class="form-control" id="userconfirmedpassword">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="usermale" name="usergender" class="custom-control-input" checked>
                                                    <label class="custom-control-label" for="usermale">Male</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="userfemale" name="usergender" class="custom-control-input">
                                                    <label class="custom-control-label" for="userfemale">Female</label>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                    </div>
                    <!-- Dashboard End -->
                    <!-- My Orders Start -->
                    <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title mb-0">My Orders</h5>
                            </div>
                            <div class="card-body">
                                <div class="order-box">
                                    <div class="card border m-b-30">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col-sm-6">
                                                    <h5>ID : #O2101</h5>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6 class="mb-0">Total : <strong>$500</strong></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Photo</th>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Qty</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col" class="text-right">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">1</th>
                                                            <td><img src="{{ asset('admin/assets/images/ecommerce/product_01.svg') }}" class="img-fluid" width="35" alt="product"></td>
                                                            <td>Apple Watch</td>
                                                            <td>1</td>
                                                            <td>$100</td>
                                                            <td class="text-right">$100</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">2</th>
                                                            <td><img src="{{ asset('admin/assets/images/ecommerce/product_02.svg') }}" class="img-fluid" width="35" alt="product"></td>
                                                            <td>Apple iPhone</td>
                                                            <td>2</td>
                                                            <td>$200</td>
                                                            <td class="text-right">$400</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row align-items-center">
                                                <div class="col-sm-6">
                                                    <h5>Status : <span class="badge badge-info-inverse font-14">Shipped</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-box">
                                    <div class="card border m-b-30">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col-sm-6">
                                                    <h5>ID : #O2102</h5>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6 class="mb-0">Total : <strong>$100</strong></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Photo</th>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Qty</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col" class="text-right">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">1</th>
                                                            <td><img src="{{ asset('admin/assets/images/ecommerce/product_01.svg') }}" class="img-fluid" width="35" alt="product"></td>
                                                            <td>Apple iPad</td>
                                                            <td>1</td>
                                                            <td>$100</td>
                                                            <td class="text-right">$100</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row align-items-center">
                                                <div class="col-sm-6">
                                                    <h5>Status : <span class="badge badge-primary-inverse font-14">Delivered</span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- My Orders End -->
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')

@endsection