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
                                    <h5 class="card-title mb-0">Order No : #{{ $order['code'] }}</h5>
                                </div>
                                <div class="col-5 text-right">
                                    @if ($order['status'] == 'pending')
                                        <span class="badge badge-warning-inverse">pending</span>
                                    @elseif ($order['status'] == 'processing')
                                        <span class="badge badge-primary-inverse">processing</span>
                                    @elseif ($order['status'] == 'delivered')
                                        <span class="badge badge-success-inverse">delivered</span>
                                    @elseif ($order['status'] == 'cancelled')
                                        <span class="badge badge-danger-inverse">cancelled</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-5">
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Order Placed</h6>
                                    <p class="mb-0">{{ $order['created_at']->format('d/m/Y \a\t h:m A') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Name</h6>
                                    <p class="mb-0">{{ $order['name'] }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Email ID</h6>
                                    <p class="mb-0">{{ $order['email'] }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-3">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Contact No</h6>
                                    <p class="mb-0">{{ $order['phone'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-xl-6 ">
                                    <div class="order-primary-detail mb-4">
                                    <h6>Delivery Information </h6>
                                    <p><i>Address</i>: {{ $order['address'] }}</p>
                                    <p><i>Country</i>: {{ $order['country'] }}</p>
                                    <p><i>State</i>: {{ $order['state'] }}</p>
                                    <p><i>City</i>: {{ $order['city'] }}</p>
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
                                        @foreach ($order->items()->get() as $key=>$item)
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
                            <div class="row border-top pt-3">
                                <div class="col-md-12 order-2 order-lg-1 col-lg-4 col-xl-6">
                                    <div class="order-note">
                                        <h6>Note :</h6>
                                        <p>{{ $order['note'] }}</p>
                                    </div>
                                </div>
                                <div class="col-md-12 order-1 order-lg-2 col-lg-8 col-xl-6">
                                    <div class="order-total table-responsive ">
                                        <table class="table table-borderless text-right">
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total :</td>
                                                    <td>₦{{ number_format($order->getSubTotal()) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Fee :</td>
                                                    <td>₦{{ $order['shipping'] ?? 0 }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="f-w-7 font-18"><h5>Total :</h5></td>
                                                    <td class="f-w-7 font-18"><h5>₦{{ number_format($order->getTotal()) }}</h5></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            @if ($order['status'] != 'pending')
                                <button type="button" onclick="confirmSubmission('markPendingForm')" class="btn btn-warning-rgba my-1">Mark Pending</button>
                            @endif

                            @if ($order['status'] != 'processing')
                                <button type="button" onclick="confirmSubmission('markProcessingForm')" class="btn btn-primary-rgba my-1">Mark Processing</button>
                            @endif

                            @if ($order['status'] != 'delivered')
                                <button type="button" onclick="confirmSubmission('markDeliveredForm')" class="btn btn-success-rgba my-1">Mark Delivered</button>
                            @endif

                            @if ($order['status'] != 'cancelled')
                                <button type="button" onclick="confirmSubmission('markCancelledForm')" class="btn btn-danger-rgba my-1">Mark Cancelled</button>
                            @endif

                            @if ($order['status'] != 'pending')
                                <form method="POST" id="markPendingForm" action="{{ route('admin.orders.state.change', $order) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="state" value="pending" />
                                </form>
                            @endif

                            @if ($order['status'] != 'processing')
                                <form method="POST" id="markProcessingForm" action="{{ route('admin.orders.state.change', $order) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="state" value="processing"/>
                                </form>
                            @endif

                            @if ($order['status'] != 'delivered')
                                <form method="POST" id="markDeliveredForm" action="{{ route('admin.orders.state.change', $order) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="state" value="delivered" />
                                </form>
                            @endif

                            @if ($order['status'] != 'cancelled')
                                <form method="POST" id="markCancelledForm" action="{{ route('admin.orders.state.change', $order) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="state" value="cancelled" />
                                </form>
                            @endif
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