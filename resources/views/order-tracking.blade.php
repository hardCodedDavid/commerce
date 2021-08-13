@extends('layouts.user')

@section('title', 'Order Tracking')

@section('content')
    <main class="no-main">
        <section class="section--order-tracking">
            <div class="container">
                <h2 class="page__title">Order Tracking</h2>
                <div class="order-tracking__content">
                    <div class="order-tracking__form">
                        <form action="{{ route('trackOrder') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="col-12">
                                    <p>To track your order please anter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have receied.</p>
                                </div>
                                <div class="col-12 form-group--block">
                                    <label>Order Id: </label>
                                    <input class="form-control" value="{{ old('order_id') }}" name="order_id" type="text" placeholder="Found in your order confirmation email">
                                    @error('order_id')
                                        <div class="p-0">
                                            <strong style="color: #dc3545; font-size: 11px">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 form-group--block">
                                    <label>Billing Email: </label>
                                    <input class="form-control" value="{{ old('email') }}" name="email" type="email" placeholder="Email you used during checkout">
                                    @error('email')
                                        <div class="p-0">
                                            <strong style="color: #dc3545; font-size: 11px">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 form-group--block">
                                    <button class="btn ps-button">Track Order</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
