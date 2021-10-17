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
    $lat = $user['latitude'] ?? null;
    $lng = $user['longitude'] ?? null;
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
                                            <input class="form-control @error('pickup_name') is-invalid @enderror" @auth readonly @endauth name="pickup_name" value="{{ old('pickup_name') ?? $name }}" type="text" placeholder="Full Name">
                                            @error('pickup_name')
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
                                                <input class="form-control @error('pickup_email') is-invalid @enderror" name="pickup_email" value="{{ old('pickup_email') }}" type="email" required>
                                                @error('pickup_email')
                                                <div class="small">
                                                    <strong style="color: red">{{ $message }}</strong>
                                                </div>
                                                @enderror
                                            </div>
                                        @endauth
                                        <div class="col-12 form-group--block">
                                            <label>Phone: <span>*</span></label>
                                            <input class="form-control @error('pickup_phone') is-invalid @enderror" @auth readonly @endauth name="pickup_phone" value="{{ old('pickup_phone') ?? $phone }}" type="text" required>
                                            @error('pickup_phone')
                                            <div class="small">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 mt-3">
                                            @php $locations = json_decode(App\Models\Setting::first()->pickup_locations, true) ?? []; $location = App\Models\Setting::first()->address @endphp
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
                                            <input class="form-control @error('address') is-invalid @enderror" @auth readonly @endauth name="address" value="{{ old('address') ?? $address }}" type="text" onblur="setTimeout(() => estimateDelivery(), 1500);" placeholder="Address" id="searchTextField" autocomplete="on" runat="server" />
                                            <input type="hidden" id="cityLat" name="cityLat" value="{{ old('cityLat') ?? $lat }}" />
                                            <input type="hidden" id="cityLng" name="cityLng" value="{{ old('cityLng') ?? $lng }}" />
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
                                                        <input class="form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" value="{{ old('shipping_address') }}" type="text" onblur="setTimeout(() => estimateDelivery(true), 1500);" placeholder="Address" id="searchTextField1" autocomplete="on" runat="server" />
                                                        <input type="hidden" id="cityLat1" name="shippingCityLat" value="{{ old('shippingCityLat') }}" />
                                                        <input type="hidden" id="cityLng1" name="shippingCityLng" value="{{ old('shippingCityLng') }}" />
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

                            <input type="hidden" name="delivery_fee" value="{{ old('delivery_fee') ?? $delivery_fee }}" id="delivery_fee">
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
                                            <div class="product__name">{{ $item['product']['name'] }}<span>(x{{ $item['quantity'] }})</span></div>
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
                            <div style="display: @if(old('delivery_method') == 'ship') block @else none @endif" id="delivery_fee_container">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="checkout__label">Delivery Fee</div>
                                    </div>
                                    <div class="col-4 text-right">
                                        <div class="checkout__label" id="delivery_val">{!! old('delivery_fee') ? '₦'.old('delivery_fee') : (($lat && $lng) ? '₦'.number_format($delivery_fee) : '<i>enter valid address</i>') !!}</div>
                                    </div>
                                </div>
                                <hr>
                            </div>
{{--                            <div class="checkout__label">Shipping</div>--}}
{{--                            <p>Free shipping</p>--}}
                            <div class="row">
                                <div class="col-8">
                                    <div class="checkout__total">Total</div>
                                </div>
                                <div class="col-4 text-right">
                                    <div class="checkout__money" id="checkout-total">₦{{ old('delivery_fee') ? number_format($cart['total'] + old('delivery_fee')) : number_format($cart['total']) }}</div>
                                </div>
                            </div>
                        </div>
                        <a class="checkout__order" onclick="$('#checkoutForm').submit()" id="checkout-btn" href="javascript:void(0);">Place an order</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBN_UW11I0wCCLflmY5Eu1FLc2-UYXrOmw&libraries=places" type="text/javascript"></script>
    <script type="text/javascript">
        getStates();
        const del1 = $('#delivery_method1')
        const del2 = $('#delivery_method2')
        const delFeeCont = $('#delivery_fee_container')

        del1.on('change', () => {
            if ($(del2).is(':checked') === true)
                $(del2).prop('checked', false)

            $('#pickup').toggle(500)
            $('#ship').hide(500)
            delFeeCont.hide(500)
            calcTotal();
        })

        del2.on('change', () => {
            if ($(del1).is(':checked') === true)
                $(del1).prop('checked', false)
            $('#ship').toggle(500)
            $('#pickup').hide(500)
            delFeeCont.toggle(500)
            calcTotal();
        })

        function initialize() {
            var input = document.getElementById('searchTextField');
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                // document.getElementById('city2').value = place.name;
                document.getElementById('cityLat').value = place.geometry.location.lat();
                document.getElementById('cityLng').value = place.geometry.location.lng();
            });

            var input1 = document.getElementById('searchTextField1');
            var autocomplete1 = new google.maps.places.Autocomplete(input1);
            google.maps.event.addListener(autocomplete1, 'place_changed', function () {
                var place = autocomplete1.getPlace();
                // document.getElementById('city3').value = place.name;
                document.getElementById('cityLat1').value = place.geometry.location.lat();
                document.getElementById('cityLng1').value = place.geometry.location.lng();
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);


        function getStates() {
            $.ajax({
                url: "/d",
                type: "GET",
                headers: {"Authorization" : "Bearer {{ env('CNS_ACCESS_TOKEN') }}", "X-CSRF-TOKEN": "{{ csrf_token() }}"},
                success: function (res) {
                    console.log(res)
                },
                error: function (err) {
                    console.log(err)
                }
            });
        }

        function estimateDelivery(diff = false) {
            let loc, lat, lng;
            if (diff) {
                loc = $('input[name="shipping_address"]').val();
                lat = $('input[name="shippingCityLat"]').val();
                lng = $('input[name="shippingCityLng"]').val();
            } else {
                loc = $('input[name="address"]').val();
                lat = $('input[name="cityLat"]').val();
                lng = $('input[name="cityLng"]').val();
            }
            const fee = parseFloat($('#delivery_fee').val())
            const btn = $('#checkout-btn')

            if (loc && lat && lng) {
                $.ajax({
                    url: "{{ route('estimateDelivery') }}",
                    data: {loc, lat, lng},
                    type: "GET",
                    beforeSend: function (xhr) {
                        btn.attr('disabled', true)
                    },
                    success: function (res) {
                        $('#delivery_val').html('₦' + numberFormat(parseFloat('2500')))
                        $('#delivery_fee').val(parseFloat('2500'))
                        calcTotal('2500')
                        // if (res) {
                        //     res = JSON.parse(res)
                        //     console.log(res.fare)
                        //     if (res.fare) {
                        //         $('#delivery_val').html('₦' + numberFormat(parseFloat(res.fare)))
                        //         $('#delivery_fee').val(parseFloat(res.fare))
                        //         calcTotal(res.fare)
                        //     } else {
                        //         $('#delivery_val').html('enter valid address')
                        //         $('#delivery_fee').val(fee)
                        //         calcTotal('0')
                        //     }
                        // } else {
                        //     $('#delivery_val').html('enter valid address')
                        //     $('#delivery_fee').val(fee)
                        //     calcTotal('0')
                        // }
                        btn.attr('disabled', false)
                    },
                    error: function (err) {
                        $('#delivery_val').html('enter valid address')
                        calcTotal('0')
                        btn.attr('disabled', false)
                    }
                });
            } else {
                $('#delivery_val').html('enter valid address')
                calcTotal('0')
                $.notify('Address could not be validated', 'error');
            }
        }

        function calcTotal(fee = null) {
            const deliveryFee = fee ?? $('#delivery_fee').val()
            const total = $('#checkout-total')
            if (del2.is(':checked'))
                total.html('₦' + numberFormat(parseFloat('{{ $cart['total'] }}') + parseFloat(deliveryFee)))
            else
                total.html('₦' + numberFormat(parseFloat('{{ $cart['total'] }}')))
        }
    </script>
@endsection
