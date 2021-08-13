@extends('layouts.user')

@section('title', 'Order Successful')

@section('content')
    <main class="no-main">
        <section class="section--order-tracking">
            <div class="container mt-5 mb-5">
                <h2 class="page__title">Order was successful</h2>
                <div class="row order-tracking__content">
                    <div class="col-md-6 offset-md-3 p-5" style="background: #f7f7f7; border-radius: 5px">
                        <div class="text-center">
                            <img class="mx-auto" width="200px" src="/assets/img/success.svg" alt=""/>
                        </div>
                        <div class="text-center">
                            <p class="my-3">Your order of <strong>₦{{ number_format($order['total'], 2) }}</strong> was successful, your order ID is <strong>{{ $order['code'] }}</strong>
                            <br>
                            @guest
                                <a style="font-size: 15px" href="/order-tracking" class="btn py-2 px-3 my-3 btn-success">Track Order</a>
                            @else
                                <a style="font-size: 15px" href='/orders' class="btn py-2 px-3 my-3 btn-success">My Orders</a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
