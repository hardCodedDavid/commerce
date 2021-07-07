@extends('layouts.admin')

@section('title', 'Sale Invoice')

@section('style')

@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Sale Invoice</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.sales') }}">Sale</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Invoice</li>
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
                                            <p class="mb-1">No : <b>#{{ $sale['code'] }}</b></p>
                                            <p class="mb-0">{{ $sale['date']->format('d M, Y') }}</p>
                                            <h4 class="text-success mb-0 mt-3">₦{{ number_format($sale->getTotal()) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-billing">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <div class="invoice-address">
                                            <h6 class="mb-3">Cust Details</h6>
                                            <h6 class="text-muted">{{ $sale['customer_name'] }}</h6>
                                            <ul class="list-unstyled">
                                                <li>{{ $sale['customer_address'] }}</li>
                                                <li>{{ $sale['customer_phone'] }}</li>
                                                <li>{{ $sale['customer_email'] }}</li>
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
                                                <th scope="col">Product</th>
                                                <th scope="col">Brand</th>
                                                @foreach ($variations as $variation)
                                                    <th scope="col">{{ ucfirst($variation['name']) }}</th>
                                                @endforeach
                                                <th scope="col">Qty</th>
                                                <th scope="col">Unit Price</th>
                                                <th scope="col">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sale->items()->get() as $key=>$item)
                                                <tr>
                                                    <th scope="row">{{ $key + 1 }}</th>
                                                    <td>{{ $item->product['name'] }}</td>
                                                    <td>{{ $item->brand['name'] ?? 'N/A' }}</td>
                                                    @foreach ($variations as $variation)
                                                        @php $value = null; @endphp
                                                        @foreach ($item->product->variationItems()->get() as $currentVariationItem)
                                                            @if ($currentVariationItem['variation_id'] == $variation['id'])
                                                                @php $value = $currentVariationItem['name'] @endphp
                                                            @endif
                                                        @endforeach
                                                        <td>{{ $value ?? 'N/A' }}</td>
                                                    @endforeach
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>₦{{ number_format($item['price']) }}</td>
                                                    <td>₦{{ number_format($item['price'] * $item['quantity']) }}</td>
                                                </tr>
                                            @endforeach
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
                                                        <td>₦{{ number_format($sale->getSubTotal()) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Shipping Fee :</td>
                                                        <td>₦{{ $sale['shipping_fee'] ?? 0 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Additional Fee :</td>
                                                        <td>₦{{ $sale['additional_fee'] ?? 0 }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="f-w-7 font-18"><h5>Total :</h5></td>
                                                        <td class="f-w-7 font-18"><h5>₦{{ number_format($sale->getTotal()) }}</h5></td>
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