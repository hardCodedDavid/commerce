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
                        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                            <h3 class="checkout__title">Delivery Method</h3>
                            <div class="form-group--block">
                                <input class="form-check-input" type="checkbox" value="pickup" @if(old('delivery_method') == 'pickup') checked @endif name="delivery_method" id="delivery_method1">
                                <label class="label-checkbox" for="delivery_method1"><b class="text-heading">Pick up</b></label>
                            </div>
                            <div class="form-group--block">
                                <input class="form-check-input" type="checkbox" id="delivery_method2" @if(old('delivery_method') == 'ship') checked @endif name="delivery_method" value="ship">
                                <label class="label-checkbox" for="delivery_method2"><b class="text-heading">Ship to address</b></label>
                            </div>
                            @error('delivery_method')
                            <div class="small">
                                <strong style="color: red">{{ $message }}</strong>
                            </div>
                            @enderror
                            <div id="pickup" style="display: @if(old('delivery_method') == 'pickup') block @else none @endif">
                                <h3 class="checkout__title">Billing Details</h3>
                                <div class="checkout__form">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-12 col-12 form-group--block">
                                            <label>Full Name: <span>*</span></label>
                                            <input class="form-control @error('name') is-invalid @enderror" @auth readonly @endauth name="name" value="{{ old('name') ?? $name }}" type="text" placeholder="Full Name">
                                            @error('name')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        @auth
                                            <div class="col-12 form-group--block">
                                                <label>Email address: <span>*</span></label>
                                                <input class="form-control" value="{{ $email }}" type="email" disabled required>
                                            </div>
                                        @else
                                            <div class="col-12 form-group--block">
                                                <label>Email address: <span>*</span></label>
                                                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email" required>
                                                @error('email')
                                                <div class="small">
                                                    <strong style="color: red">{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        @endauth
                                        <div class="col-12 form-group--block">
                                            <label>Phone: <span>*</span></label>
                                            <input class="form-control @error('phone') is-invalid @enderror" @auth readonly @endauth name="phone" value="{{ old('phone') ?? $phone }}" type="text" required>
                                            @error('phone')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-3">
                                            @php $locations = json_decode(\App\Models\Setting::first()->pickup_locations, true) ?? []; $location = App\Models\Setting::first()->address @endphp
                                            <h5>Pickup Location</h5>
                                            @if(count($locations) < 1)
                                                <div class="form-group">
                                                    <input class="form-check-inline" type="radio" id="pickup" name="pickup_location" value="{!! $location !!}" checked>
                                                    <label for="pickup" class="form-check-label">{!! $location !!}</label>
                                                </div>
                                            @else
                                                @foreach($locations as $key => $loc)
                                                    <div class="form-group">
                                                        <input class="form-check-inline" type="radio" id="pickup-{{ $key }}" name="pickup_location" value="{{ $loc }}" @if(old('pickup_location') == $loc) checked @endif>
                                                        <label for="pickup-{{ $key }}" class="form-check-label">{{ $loc }}</label>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @error('pickup_location')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        @guest
                                            <div class="col-12 form-group--block">
                                                <input onchange="$('.create-account-section').toggle(500)" @if (old('create_account') && old('create_account') == 'yes') checked @endif id="create-account" name="create_account" value="yes" class="form-check-input" type="checkbox">
                                                <label for="create-account" class="label-checkbox">Create an account?</label>
                                            </div>
                                            <div @if (old('create_account') && old('create_account') == 'yes') style="display: block" @else style="display: none" @endif class="col-12 create-account-section">
                                                <div class="form-row">
                                                    <div class="col-12 form-group--block">
                                                        <label>Password: </label>
                                                        <input class="form-control @error('password') is-invalid @enderror" name="password" type="password">
                                                        @error('password')
                                                        <div class="small">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 form-group--block">
                                                        <label>Confirm Password: </label>
                                                        <input class="form-control" name="password_confirmation" type="password">
                                                    </div>
                                                </div>
                                            </div>
                                        @endguest
                                    </div>
                                </div>
                            </div>
                            <div id="ship" style="display: @if(old('delivery_method') == 'ship') block @else none @endif">
                                <h3 class="checkout__title">Billing Details</h3>
                                <div class="checkout__form">
                                    <div class="form-row">
                                        <div class="col-12 col-12 form-group--block">
                                            <label>Full Name: <span>*</span></label>
                                            <input class="form-control @error('name') is-invalid @enderror" @auth readonly @endauth name="name" value="{{ old('name') ?? $name }}" type="text" placeholder="Full Name">
                                            @error('name')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Country: <span>*</span></label>
                                            <input class="form-control @error('country') is-invalid @enderror" @auth readonly @endauth name="country" value="{{ old('country') ?? $country }}" type="text" placeholder="Country">
                                            @error('country')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>State: <span>*</span></label>
                                            <input class="form-control @error('state') is-invalid @enderror" name="state" @auth readonly @endauth value="{{ old('state') ?? $state }}" type="text" placeholder="State">
                                            @error('state')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Address: <span>*</span></label>
                                            <input class="form-control @error('address') is-invalid @enderror" @auth readonly @endauth name="address" value="{{ old('address') ?? $address }}" type="text" placeholder="Address">
                                            @error('address')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Postcode/ ZIP (optional)</label>
                                            <input class="form-control @error('postcode') is-invalid @enderror" @auth readonly @endauth name="postcode" value="{{ old('postcode') ?? $postcode }}" type="text">
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Town/ City: <span>*</span></label>
                                            <input class="form-control @error('city') is-invalid @enderror" @auth readonly @endauth name="city" value="{{ old('city') ?? $city }}" type="text" required>
                                            @error('city')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 form-group--block">
                                            <label>Phone: <span>*</span></label>
                                            <input class="form-control @error('phone') is-invalid @enderror" @auth readonly @endauth name="phone" value="{{ old('phone') ?? $phone }}" type="text" required>
                                            @error('phone')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        @auth
                                            <div class="col-12 form-group--block">
                                                <label>Email address: <span>*</span></label>
                                                <input class="form-control" value="{{ $email }}" type="email" disabled required>
                                            </div>
                                        @else
                                            <div class="col-12 form-group--block">
                                                <label>Email address: <span>*</span></label>
                                                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email" required>
                                                @error('email')
                                                <div class="small">
                                                    <strong style="color: red">{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        @endauth
                                        @guest
                                            <div class="col-12 form-group--block">
                                                <input onchange="$('.create-account-section').toggle(500)" @if (old('create_account') && old('create_account') == 'yes') checked @endif id="create-account" name="create_account" value="yes" class="form-check-input" type="checkbox">
                                                <label for="create-account" class="label-checkbox">Create an account?</label>
                                            </div>
                                            <div @if (old('create_account') && old('create_account') == 'yes') style="display: block" @else style="display: none" @endif class="col-12 create-account-section">
                                                <div class="form-row">
                                                    <div class="col-12 form-group--block">
                                                        <label>Password: </label>
                                                        <input class="form-control @error('password') is-invalid @enderror" name="password" type="password">
                                                        @error('password')
                                                        <div class="small">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 form-group--block">
                                                        <label>Confirm Password: </label>
                                                        <input class="form-control" name="password_confirmation" type="password">
                                                    </div>
                                                </div>
                                            </div>
                                        @endguest
                                        @auth
                                            <div class="col-12 form-group--block">
                                                <input class="form-check-input" @if (old('ship_to_new_address') && old('ship_to_new_address') == 'yes') checked @endif onchange="$('.shipping-details').toggle(500)" name="ship_to_new_address" value="yes" id="ship-to-new-address" type="checkbox">
                                                <label for="ship-to-new-address" class="label-checkbox"><b>Ship to a different address?</b></label>
                                            </div>
                                            <div @if (old('ship_to_new_address') && old('ship_to_new_address') == 'yes') style="display: block" @else style="display: none"  @endif  class="col-12 shipping-details">
                                                <h3 class="my-0 checkout__title">Shipping Details</h3>
                                                <div class="form-row">
                                                    <div class="col-12 form-group--block">
                                                        <label>Country: <span>*</span></label>
                                                        <input class="form-control @error('shipping_country') is-invalid @enderror" name="shipping_country" value="{{ old('shipping_country') }}" type="text" placeholder="Country">
                                                        @error('shipping_country')
                                                        <div class="small">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 form-group--block">
                                                        <label>State: <span>*</span></label>
                                                        <input class="form-control @error('shipping_state') is-invalid @enderror" name="shipping_state" value="{{ old('shipping_state') }}" type="text" placeholder="State">
                                                        @error('shipping_state')
                                                        <div class="small">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 form-group--block">
                                                        <label>Address: <span>*</span></label>
                                                        <input class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" value="{{ old('shipping_address') }}" type="text" placeholder="Address">
                                                        @error('shipping_address')
                                                        <div class="small">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12 form-group--block">
                                                        <label>Postcode/ ZIP (optional)</label>
                                                        <input class="form-control @error('shipping_postcode') is-invalid @enderror" name="shipping_postcode" value="{{ old('shipping_postcode') }}" type="text">
                                                    </div>
                                                    <div class="col-12 form-group--block">
                                                        <label>Town/ City: <span>*</span></label>
                                                        <input class="form-control @error('shipping_city') is-invalid @enderror" name="shipping_city" value="{{ old('shipping_city') }}" type="text" required>
                                                        @error('shipping_city')
                                                        <div class="small">
                                                            <strong style="color: red">{{ $message }}</strong>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        @endauth
                                        <div class="col-12 form-group--block">
                                            <label>Order notes (optional)</label>
                                            <textarea class="form-control" name="note" placeholder="Note about your orders, e.g special notes for delivery.">{{ old('note') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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
                        <a class="checkout__order" onclick="$('#checkoutForm').submit()" href="javascript:void(0);">Place an order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
    <script>
        const del1 = $('#delivery_method1')
        const del2 = $('#delivery_method2')
        del1.on('change', () => {
            if ($(del2).is(':checked') === true)
                $(del2).prop('checked', false)

            $('#pickup').toggle(500)
            $('#ship').hide(500)
        })

        del2.on('change', () => {
            if ($(del1).is(':checked') === true)
                $(del1).prop('checked', false)
            $('#ship').toggle(500)
            $('#pickup').hide(500)
        })
    </script>
@endsection
