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
                            <div class="ps-form__content table-responsive">
                                <table class="table">
                                    <tr>
                                        <th><strong>#</strong></th>
                                        <th><strong>Order ID</strong></th>
                                        <th><strong>Amount</strong></th>
                                        <th><strong>Status</strong></th>
                                        <th><strong>Date</strong></th>
                                        <th><strong>Action</strong></th>
                                    </tr>
                                    @php
                                       $orders = auth()->user()->orders()->latest()->get();
                                    @endphp
                                    @if (count($orders))
                                        @foreach ($orders as $key=>$order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a class="text-underline" href="/orders/{{ $order['code'] }}/details">{{ $order['code'] }}</a>
                                            </td>
                                            <td>₦{{ number_format($order['total'], 2) }}</td>
                                            <td>
                                                @if ($order['status'] == 'pending')
                                                    <span class="badge badge-warning">pending</span>
                                                @elseif ($order['status'] == 'processing')
                                                    <span class="badge badge-primary">processing</span>
                                                @elseif ($order['status'] == 'delivered')
                                                    <span class="badge badge-success">delivered</span>
                                                @elseif ($order['status'] == 'cancelled')
                                                    <span class="badge badge-danger">cancelled</span>
                                                @endif
                                            </td>
                                            <td>{{ $order['created_at']->format('M d, Y') }}</td>
                                            <td class="text-center">
                                                <a style="font-size: 13px" href='/orders/{{ $order['code'] }}/details' class="btn py-2 px-3 my-3 btn-success">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="6">No order(s)</td>
                                        </tr>
                                    @endif
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