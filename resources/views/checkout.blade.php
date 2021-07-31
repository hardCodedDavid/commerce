@extends('layouts.user')

@section('title', 'Checkout')

@php
    $cart = \App\Http\Controllers\CartController::getUserCartAsArray();
    $user = auth()->user();
    $name = $user['name'] ?? null;
    $country = $user['country'] ?? null;
    $state = $user['state'] ?? null;
    $address = $user['address'] ?? null;
    $postcode = $user['postcode'] ?? null;
    $city = $user['city'] ?? null;
    $phone = $user['phone'] ?? null;
    $email = $user['email'] ?? null;
@endphp

@section('content')

<main class="no-main">
    <section class="section--checkout">
        <div class="container">
            <h2 class="page__title">Checkout</h2>
            <div class="checkout__content">
                @guest
                    <div class="checkout__header">
                        <div class="row">
                            <div class="col-12">
                                <div class="checkout__header__box">
                                    <p><i class="icon-user"></i>Returning customer? <a href="/login">Click here to login</a></p><i class="icon-chevron-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endguest
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <h3 class="checkout__title">Billing Details</h3>
                        <div class="checkout__form">
                            <form>
                                <div class="form-row">
                                    <div class="col-12 col-12 form-group--block">
                                        <label>Full Name: <span>*</span></label>
                                        <input class="form-control" value="{{ old('name') ?? $name }}" type="text" placeholder="Full Name">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Country: <span>*</span></label>
                                        <input class="form-control" value="{{ old('country') ?? $country }}" type="text" placeholder="Country">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>State: <span>*</span></label>
                                        <input class="form-control" value="{{ old('state') ?? $state }}" type="text" placeholder="State">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Address: <span>*</span></label>
                                        <input class="form-control" value="{{ old('address') ?? $address }}" type="text" placeholder="Address">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Postcode/ ZIP (optional)</label>
                                        <input class="form-control" value="{{ old('postcode') ?? $postcode }}" type="text">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Town/ City: <span>*</span></label>
                                        <input class="form-control" value="{{ old('city') ?? $city }}" type="text" required>
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Phone: <span>*</span></label>
                                        <input class="form-control" value="{{ old('phone') ?? $phone }}" type="text" required>
                                    </div>
                                    @auth
                                        <div class="col-12 form-group--block">
                                            <label>Email address: <span>*</span></label>
                                            <input class="form-control" value="{{ $email }}" type="email" disabled required>
                                        </div>
                                    @else
                                        <div class="col-12 form-group--block">
                                            <label>Email address: <span>*</span></label>
                                            <input class="form-control" value="{{ old('email') ?? $email }}" type="email" required>
                                        </div>
                                    @endauth
                                    @guest
                                        <div class="col-12 form-group--block">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="label-checkbox">Create an account?</label>
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Password: </label>
                                            <input class="form-control" type="password">
                                        </div>
                                    @endguest
                                    @auth
                                        <div class="col-12 form-group--block">
                                            <input class="form-check-input" type="checkbox">
                                            <label class="label-checkbox"><b>Ship to a different address?</b></label>
                                        </div>
                                    @endauth
                                    <div class="col-12 form-group--block">
                                        <label>Order notes (optional)</label>
                                        <textarea class="form-control" placeholder="Note about your orders, e.g special notes for delivery.">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5">
                        <h3 class="checkout__title">Your Order</h3>
                        <div class="checkout__products">
                            <div class="row">
                                <div class="col-8">
                                    <div class="checkout__label">PRODUCT</div>
                                </div>
                                <div class="col-4 text-right">
                                    <div class="checkout__label">TOTAL</div>
                                </div>
                            </div>
                            <div class="checkout__list">
                                @foreach ($cart['items'] as $item)
                                    <div class="checkout__product__item">
                                        <div class="checkout-product">
                                            <div class="product__name">{{ $item['product']['name'] }}<span>(x1)</span></div>
                                            <div class="product__unit">{{ $item['product']['weight'] }}Kg</div>
                                        </div>
                                        <div class="checkout-price">₦{{ number_format($item['product']->getDiscountedPrice()) }}</div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="checkout__label">Subtotal</div>
                                </div>
                                <div class="col-4 text-right">
                                    <div class="checkout__label">₦{{ number_format($cart['total']) }}</div>
                                </div>
                            </div>
                            <hr>
                            <div class="checkout__label">Shipping</div>
                            <p>Free shipping</p>
                            <div class="row">
                                <div class="col-8">
                                    <div class="checkout__total">Total</div>
                                </div>
                                <div class="col-4 text-right">
                                    <div class="checkout__money">₦{{ number_format($cart['total']) }}</div>
                                </div>
                            </div>
                        </div>
                        <a class="checkout__order" href="order-tracking.html">Place an order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
