@extends('layouts.user')

@section('title', 'Orders')

@section('styles')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@section('content')
<main class="ps-page--my-account">
    <section class="ps-section--account">
        <div class="container">
            <div class="row mt-lg-0 mt-5">
                @include('account-sidebar', ['active' => 'orders'])
                <div class="col-lg-8">
                    <div class="ps-section__right">
                        <div class="ps-form--account-setting">
                            <div class="ps-form__header">
                                <h3> Orders</h3>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4>Shipping Information</h4>
                                    <div style="font-size: 13px" class="my-2"><strong class="mr-2">Country:</strong>{{ $order['country'] }}</div>
                                    <div style="font-size: 13px" class="my-2"><strong class="mr-2">State:</strong>{{ $order['state'] }}</div>
                                    <div style="font-size: 13px" class="my-2"><strong class="mr-2">City:</strong>{{ $order['city'] }}</div>
                                    <div style="font-size: 13px" class="my-2"><strong class="mr-2">Address:</strong>{{ $order['address'] }}</div>
                                    <div style="font-size: 13px" class="my-2"><strong class="mr-2">PostCode:</strong>{{ $order['postcode'] ?? 'N/A' }}</div>
                                    <div style="font-size: 13px" class="my-2"><strong class="mr-2">Note:</strong>{{ $order['note'] ?? 'N/A' }}</div>
                                    <div style="font-size: 13px" class="my-2"><strong class="mr-2">Status:</strong>
                                        @if ($order['status'] == 'pending')
                                            <span class="badge badge-warning">pending</span>
                                        @elseif ($order['status'] == 'processing')
                                            <span class="badge badge-primary">processing</span>
                                        @elseif ($order['status'] == 'delivered')
                                            <span class="badge badge-success">delivered</span>
                                        @elseif ($order['status'] == 'cancelled')
                                            <span class="badge badge-danger">cancelled</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ps-form__content table-responsive">
                                <table class="table">
                                    <tr>
                                        <th><strong>#</strong></th>
                                        <th><strong>Product</strong></th>
                                        <th><strong>Price</strong></th>
                                        <th><strong>Quantity</strong></th>
                                        <th><strong>SubTotal</strong></th>
                                    </tr>
                                        @foreach ($order->items()->get() as $key=>$item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a href="{{ route('product.detail', $item['product']['code']) }}">
                                                    <img width="50px" src="{{ asset($item['product']['media'][0]['url']) }}"/>
                                                    <p class="my-1">{{ $item['product']['name'] }}</p>
                                                </a>
                                            </td>
                                            <td>₦{{ number_format($item['price'], 2) }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>₦{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="2"><strong>Total</strong></td>
                                            <td colspan="3" class="text-right"><strong>₦{{ number_format($order['total'], 2) }}</strong></td>
                                        </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection