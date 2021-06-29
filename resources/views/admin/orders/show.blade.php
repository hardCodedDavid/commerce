@extends('layouts.admin')

@section('title', 'Order Details')

@section('style')

@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Order Details</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.orders') }}">Orders</a></li>
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
                <div class="col-lg-12">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h5 class="card-title mb-0">Order No : #02101</h5>
                                </div>
                                <div class="col-5 text-right">
                                    <span class="badge badge-success-inverse">Completed</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Order Placed</h6>
                                    <p class="mb-0">01/04/2020 at 03:35 PM</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Name</h6>
                                    <p class="mb-0">Michelle Johnson</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Email ID</h6>
                                    <p class="mb-0">demo@example.com</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Contact No</h6>
                                    <p class="mb-0">+1 9876543210</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-xl-6 ">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Delivery Address <a href="#" class="badge badge-primary-inverse">Edit</a></h6>
                                    <p>417 Redbud Drive, Manhattan Building,<br/> Whitestone, NY.<br/> New York-11357</p>
                                    <p class="mb-0">+1 123 123 4567</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-6 ">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Billing Address <a href="#" class="badge badge-primary-inverse">Edit</a></h6>
                                    <p>417 Redbud Drive, Manhattan Building,<br/> Whitestone, NY.<br/> New York-11357</p>
                                    <p class="mb-0">+1 123 123 4567</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">Order Items</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Action</th>
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
                                            <td><a href="#" class="text-success mr-2"><i class="ri-pencil-line"></i></a><a href="#" class="text-danger"><i class="ri-delete-bin-3-line"></i></a></td>
                                            <td><img src="assets/images/ecommerce/product_01.svg" class="img-fluid" width="35" alt="product"></td>
                                            <td>Apple MacBook Pro</td>
                                            <td>1</td>
                                            <td>$10</td>
                                            <td class="text-right">$500</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td><a href="#" class="text-success mr-2"><i class="ri-pencil-line"></i></a><a href="#" class="text-danger"><i class="ri-delete-bin-3-line"></i></a></td>
                                            <td><img src="assets/images/ecommerce/product_02.svg" class="img-fluid" width="35" alt="product"></td>
                                            <td>Dell Alienware</td>
                                            <td>2</td>
                                            <td>$20</td>
                                            <td class="text-right">$200</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td><a href="#" class="text-success mr-2"><i class="ri-pencil-line"></i></a><a href="#" class="text-danger"><i class="ri-delete-bin-3-line"></i></a></td>
                                            <td><img src="assets/images/ecommerce/product_03.svg" class="img-fluid" width="35" alt="product"></td>
                                            <td>Acer Predator Helios</td>
                                            <td>3</td>
                                            <td>$30</td>
                                            <td class="text-right">$300</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row border-top pt-3">
                                <div class="col-md-12 order-2 order-lg-1 col-lg-4 col-xl-6">
                                    <div class="order-note">
                                        <p class="mb-5"><span class="badge badge-secondary-inverse">Free Shipping Order</span></p>
                                        <h6>Note :</h6>
                                        <p>Please, Pack with product air bag and handle with care.</p>
                                    </div>
                                </div>
                                <div class="col-md-12 order-1 order-lg-2 col-lg-8 col-xl-6">
                                    <div class="order-total table-responsive ">
                                        <table class="table table-borderless text-right">
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total :</td>
                                                    <td>$1000.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping :</td>
                                                    <td>$0.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Tax(18%) :</td>
                                                    <td>$180.00</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-black f-w-7 font-18">Amount :</td>
                                                    <td class="text-black f-w-7 font-18">$1180.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-warning-rgba my-1">Mark Pending</button>
                            <button type="button" class="btn btn-primary-rgba my-1">Mark Processing</button>
                            <button type="button" class="btn btn-success-rgba my-1">Mark Delivered</button>
                            <button type="button" class="btn btn-danger-rgba my-1">Mark Cancelled</button>
                        </div>
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