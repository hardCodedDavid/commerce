@extends('layouts.user')

@section('title', 'Checkout')

@section('content')

<main class="no-main">
    <section class="section--checkout">
        <div class="container">
            <h2 class="page__title">Checkout</h2>
            <div class="checkout__content">
                <div class="checkout__header">
                    <div class="row">
                        <div class="col-12">
                            <div class="checkout__header__box">
                                <p><i class="icon-user"></i>Returning customer? <a href="/login">Click here to login</a></p><i class="icon-chevron-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <h3 class="checkout__title">Billing Details</h3>
                        <div class="checkout__form">
                            <form>
                                <div class="form-row">
                                    <div class="col-12 col-lg-6 form-group--block">
                                        <label>First name: <span>*</span></label>
                                        <input class="form-control" type="text" required>
                                    </div>
                                    <div class="col-12 col-lg-6 form-group--block">
                                        <label>Last name<span>*</span></label>
                                        <input class="form-control" type="text" required>
                                        {{-- <div class="invalid-feedback">Please enter last name!</div> --}}
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Company name (optional)</label>
                                        <input class="form-control" type="text">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Country: <span>*</span></label>
                                        <select class="single-select2" name="state">
                                            <option value="uk">United Kingdom</option>
                                            <option value="vn">Viet Nam</option>
                                        </select>
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Street address: <span>*</span></label>
                                        <input class="form-control" type="text" placeholder="House number and street name">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Postcode/ ZIP (optional)</label>
                                        <input class="form-control" type="text">
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Town/ City: <span>*</span></label>
                                        <input class="form-control" type="text" required>
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Phone: <span>*</span></label>
                                        <input class="form-control" type="text" required>
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Email address: <span>*</span></label>
                                        <input class="form-control" type="email" required>
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="label-checkbox">Create an account?</label>
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="label-checkbox"><b>Ship to a different address?</b></label>
                                    </div>
                                    <div class="col-12 form-group--block">
                                        <label>Order notes (optional)</label>
                                        <textarea class="form-control" placeholder="Note about your orders, e.g special notes for delivery."></textarea>
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
                                <div class="checkout__product__item">
                                    <div class="checkout-product">
                                        <div class="product__name">Extreme Budweiser Light Can<span>(x1)</span></div>
                                        <div class="product__unit">500g</div>
                                    </div>
                                    <div class="checkout-price">$3.90</div>
                                </div>
                                <div class="checkout__product__item">
                                    <div class="checkout-product">
                                        <div class="product__name">Honest Organic Still Lemonade<span>(x1)</span></div>
                                        <div class="product__unit">100g</div>
                                    </div>
                                    <div class="checkout-price">$5.99</div>
                                </div>
                                <div class="checkout__product__item">
                                    <div class="checkout-product">
                                        <div class="product__name">Matures Own 100% Wheat<span>(x1)</span></div>
                                        <div class="product__unit">1.5L</div>
                                    </div>
                                    <div class="checkout-price">$12.90</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="checkout__label">Subtotal</div>
                                </div>
                                <div class="col-4 text-right">
                                    <div class="checkout__label">$22.79</div>
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
                                    <div class="checkout__money">$22.79</div>
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