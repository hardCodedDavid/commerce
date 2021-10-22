@extends('layouts.user')

@section('title', 'Order Tracking')

@section('styles')
    <style>
        ul.timeline {
            list-style-type: none;
            position: relative;
        }
        ul.timeline:before {
            content: ' ';
            background: #d4d9df;
            display: inline-block;
            position: absolute;
            left: 29px;
            width: 2px;
            height: 100%;
            z-index: 400;
        }
        ul.timeline > li {
            margin: 20px 0;
            padding-left: 20px;
        }
        ul.timeline > li:before {
            content: ' ';
            background: white;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #22c0e8;
            left: 20px;
            width: 20px;
            height: 20px;
            z-index: 400;
        }
    </style>
@endsection

@section('content')
    <main class="no-main">
        <section class="section--order-tracking">
            <div class="container mt-5 mb-5">
                <h2 class="page__title">Order Tracking</h2>
                <div class="row order-tracking__content">
                    <div class="order-tracking__form col-md-6 offset-md-3">
                        <h4>Order #{{ $order['code'] }}</h4>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <h5>General Information</h5>
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">Code:</strong>{{ $order['code'] }}</div>
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">Name:</strong>{{ $order['name'] }}</div>
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">Email:</strong>{{ $order['email'] }}</div>
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">Phone:</strong>{{ $order['phone'] }}</div>
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
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">Date:</strong>{{ $order['created_at']->format('M d, Y') }}</div>
                            </div>
                            <div class="col-lg-6">
                                <h5>Shipping Information</h5>
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">Country:</strong>{{ $order['country'] }}</div>
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">State:</strong>{{ $order['state'] }}</div>
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">City:</strong>{{ $order['city'] }}</div>
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">Address:</strong>{{ $order['address'] }}</div>
{{--                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">PostCode:</strong>{{ $order['postcode'] ?? 'N/A' }}</div>--}}
                                <div style="font-size: 13px" class="my-2"><strong class="mr-2">Note:</strong>{{ $order['note'] ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <ul class="timeline">
                            @foreach ($order->activities as $activity)
                            <li>
                                <strong>{{ $activity['type'] }}</strong>
                                <strong class="float-right">{{ $activity['created_at']->format('M d, Y') }}</strong>
                                <p>{{ $activity['message'] }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
