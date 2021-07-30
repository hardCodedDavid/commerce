@extends('layouts.user')

@section('title', 'Cart')

@section('content')

<main class="no-main">
    <section class="section--shopping-cart">
        <div class="container shopping-container">
            <h2 class="page__title">Shopping Cart</h2>
            <div class="shopping-cart__content">
                <div class="row m-0">
                    <div class="col-12 col-lg-8">
                        <div class="shopping-cart__products">
                            <div class="shopping-cart__table">
                                <div class="shopping-cart-light">
                                    <div class="shopping-cart-row">
                                        <div class="cart-product">Product</div>
                                        <div class="cart-price">Price</div>
                                        <div class="cart-quantity">Quantity</div>
                                        <div class="cart-total">Total</div>
                                        <div class="cart-action"> </div>
                                    </div>
                                </div>
                                <div class="shopping-cart-body">
                                </div>
                            </div>
                            <div class="shopping-cart__step">
                                <a onclick="clearCart()" class="button right" href="javascript:void(0);"><i class="icon-sync"></i>Clear Cart</a>
                                <a class="button left" href="/shop"><i class="icon-arrow-left"></i>Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="shopping-cart__right">
                            <div class="shopping-cart__total">
                                <p class="shopping-cart__subtotal"><span>Subtotal</span><span class="price cart-total-amount"></span></p>
                                <p class="shopping-cart__subtotal"><span><b>TOTAL</b></span><span class="price-total cart-total-amount"></span></p>
                            </div><a class="btn shopping-cart__checkout" href="/checkout">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
