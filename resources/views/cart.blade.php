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
                                    <div class="shopping-cart-row">
                                        <div class="cart-product">
                                            <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{ asset('assets/img/products/01-Fresh/01_18a.jpg') }}" alt="alt" /></a>
                                                <div class="ps-product__content">
                                                    <h5><a class="ps-product__name" href="#">Extreme Budweiser Light Can</a></h5>
                                                    <p class="ps-product__unit">500g</p>
                                                    <p class="ps-product__soldby">Sold by <span>Farmart</span></p>
                                                    <p class="ps-product__meta">Price: <span class="ps-product__price">$3.90</span></p>
                                                    <div class="def-number-input number-input safari_only">
                                                        <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                        <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                        <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                                    </div><span class="ps-product__total">Total: <span>$3.90 </span></span>
                                                </div>
                                                <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                            </div>
                                        </div>
                                        <div class="cart-price"><span class="ps-product__price">$3.90</span>
                                        </div>
                                        <div class="cart-quantity">
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="cart-total"> <span class="ps-product__total">$3.90 </span>
                                        </div>
                                        <div class="cart-action"> <i class="icon-trash2"></i></div>
                                    </div>
                                    <div class="shopping-cart-row">
                                        <div class="cart-product">
                                            <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{ asset('assets/img/products/01-Fresh/01_31a.jpg') }}" alt="alt" /></a>
                                                <div class="ps-product__content">
                                                    <h5><a class="ps-product__name" href="#">Honest Organic Still Lemonade</a></h5>
                                                    <p class="ps-product__unit">100g</p>
                                                    <p class="ps-product__soldby">Sold by <span>JohnDoe</span></p>
                                                    <p class="ps-product__meta">Price: <span class="ps-product__price-sale">$5.99</span><span class="ps-product__is-sale">$8.99</span></p>
                                                    <div class="def-number-input number-input safari_only">
                                                        <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                        <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                        <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                                    </div><span class="ps-product__total">Total: <span>$5.99  </span></span>
                                                </div>
                                                <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                            </div>
                                        </div>
                                        <div class="cart-price"><span class="ps-product__price-sale">$5.99</span><span class="ps-product__is-sale">$8.99</span>
                                        </div>
                                        <div class="cart-quantity">
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="cart-total"> <span class="ps-product__total">$5.99  </span>
                                        </div>
                                        <div class="cart-action"> <i class="icon-trash2"></i></div>
                                    </div>
                                    <div class="shopping-cart-row">
                                        <div class="cart-product">
                                            <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="{{ asset('assets/img/products/01-Fresh/01_16a.jpg') }}" alt="alt" /></a>
                                                <div class="ps-product__content">
                                                    <h5><a class="ps-product__name" href="#">Matures Own 100% Wheat</a></h5>
                                                    <p class="ps-product__unit">1.5L</p>
                                                    <p class="ps-product__soldby">Sold by <span>HomeShopping</span></p>
                                                    <p class="ps-product__meta">Price: <span class="ps-product__price">$12.90</span></p>
                                                    <div class="def-number-input number-input safari_only">
                                                        <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                        <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                        <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                                    </div><span class="ps-product__total">Total: <span>$12.90 </span></span>
                                                </div>
                                                <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                            </div>
                                        </div>
                                        <div class="cart-price"><span class="ps-product__price">$12.90</span>
                                        </div>
                                        <div class="cart-quantity">
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div>
                                        </div>
                                        <div class="cart-total"> <span class="ps-product__total">$12.90 </span>
                                        </div>
                                        <div class="cart-action"> <i class="icon-trash2"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="shopping-cart__step"><a class="clear-item" href="javascript:void(0);">Clear all items</a><a class="button right" href="javascript:void(0);"><i class="icon-sync"> </i>Update Cart</a><a class="button left" href="/shop"><i class="icon-arrow-left"></i>Continue Shopping</a></div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="shopping-cart__right">
                            <div class="shopping-cart__total">
                                <p class="shopping-cart__subtotal"><span>Subtotal</span><span class="price">$22.79</span></p>
                                <p class="shopping-cart__subtotal"><span><b>TOTAL</b></span><span class="price-total">$22.79</span></p>
                            </div><a class="btn shopping-cart__checkout" href="/checkout">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
