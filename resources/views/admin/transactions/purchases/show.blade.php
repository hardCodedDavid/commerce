@extends('layouts.admin')

@section('title', 'Purchase Details')

@section('style')

@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Purchase Details</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.purchases') }}">Purchases</a></li>
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
        <!-- End row -->
        <div class="row justify-content-center">
            <!-- Start col -->
            <div class="col-md-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="invoice">
                            <div class="invoice-head">
                                <div class="row">
                                    <div class="col-12 col-md-7 col-lg-7">
                                        <div class="invoice-logo">
                                            <img src="{{ asset('admin/assets/images/logo.svg') }}" class="img-fluid" alt="invoice-logo">
                                        </div>
                                        <h4>Olian Design Inc.</h4>
                                        <p>The Complete Web Solutions Partner</p>
                                        <p class="mb-0">21st Street, Titanium Tower, Times Square, Nevada Campus, New Jersey - 55986 USA.</p>
                                    </div>
                                    <div class="col-12 col-md-5 col-lg-5">
                                        <div class="invoice-name">
                                            <p class="mb-1">No : #INV001</p>
                                            <p class="mb-0">01 April, 2020</p>
                                            <h4 class="text-success mb-0 mt-3">$1180</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-billing">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <div class="invoice-address">
                                            <h6 class="mb-3">Supplier Details</h6>
                                            <h6 class="text-muted">Amy Adams</h6>
                                            <ul class="list-unstyled">
                                                <li>417 Redbud Drive, Manhattan Building, Whitestone, NY, New York-11357</li>
                                                <li>+1-9876543210</li>
                                                <li>amyadams@email.com</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-summary">
                                <div class="table-responsive ">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
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
                                                <td><img src="{{ asset('admin/assets/images/ecommerc') }}e/product_01.svg" class="img-fluid" width="35" alt="product"></td>
                                                <td>Apple Watch</td>
                                                <td>1</td>
                                                <td>$10</td>
                                                <td class="text-right">$500</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td><img src="{{ asset('admin/assets/images/ecommerc') }}e/product_02.svg" class="img-fluid" width="35" alt="product"></td>
                                                <td>Apple iPhone</td>
                                                <td>2</td>
                                                <td>$20</td>
                                                <td class="text-right">$200</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td><img src="{{ asset('admin/assets/images/ecommerc') }}e/product_03.svg" class="img-fluid" width="35" alt="product"></td>
                                                <td>Apple iPad</td>
                                                <td>3</td>
                                                <td>$30</td>
                                                <td class="text-right">$300</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="invoice-summary-total">
                                <div class="row">
                                    <div class="offset-md-6 col-md-6">
                                        <div class="order-total table-responsive ">
                                            <table class="table table-borderless text-right">
                                                <tbody>
                                                    <tr>
                                                        <td>Sub Total :</td>
                                                        <td>$1000.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping Charges :</td>
                                                        <td>$0.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tax (18%) :</td>
                                                        <td>$180.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="f-w-7 font-18"><h5>Amount Payable :</h5></td>
                                                        <td class="f-w-7 font-18"><h5>$1180.00</h5></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-footer">
                                <div class="row align-items-center">
                                    <div class="offset-md-6 col-md-6">
                                        <div class="invoice-footer-btn">
                                            <a href="javascript:window.print()" class="btn btn-primary py-1 font-16"><i class="ri-printer-line mr-2"></i>Print</a>
                                        </div>
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
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')

@endsection