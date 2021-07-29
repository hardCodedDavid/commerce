@extends('layouts.user')

@section('title', 'Deals')

@php
    $categories = \App\Models\Category::with('subCategories')->whereHas('products', function ($q) {
        $q->where('discount', '>', 0);
    })->get();
@endphp

@section('content')
<main class="no-main">
    <section class="section--flashSale">
        <div class="flashSale__header">
            <div class="container">
                <h3 class="flashSale__title">Flash Sale<span class="ps-countdown"><span class="ps-countdown-end">Ends in : </span><span class="ps-countdown"><b class="hours">00</b> hours : <b class="minutes">12</b> mins : <b class="seconds">45</b> secs</span><span class="ps-countdown mobile"><b class="hours">00</b> h : <b class="minutes">12</b> m : <b class="seconds">45</b> s</span></span></h3>
            </div>
        </div>
        <div class="container">
            <div class="flashSale__category">
                <ul>
                    <li class="@if(is_null($category)) active @endif">
                        <a href="{{ route('deals') }}">All</a>
                    </li>
                    @foreach ($categories as $curCategory)
                        <li class="@if($curCategory['name'] == $category) active @endif"><a href="{{ route('deals', $curCategory['name']) }}">{{ $curCategory['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="flashSale__product">
                <div class="row m-0">
                    @foreach ($products as $product)
                        @include('single-product', ['product' => $product])
                    @endforeach
                </div>
            </div>
            <div class="flashSale__loading">
                <div class="ps-pagination blog--pagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="popupQuickview" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl ps-quickview">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid quickview-body">
                        <div class="row">
                            <div class="col-12 col-lg-5">
                                <div class="owl-carousel" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-item-xl="1" data-owl-duration="1000" data-owl-mousedrag="on">
                                    <div class="quickview-carousel"><img class="carousel__thumbnail" src="img/products/01-Fresh/01_1a.jpg" alt="alt" /></div>
                                    <div class="quickview-carousel"><img class="carousel__thumbnail" src="img/products/01-Fresh/01_2a.jpg" alt="alt" /></div>
                                    <div class="quickview-carousel"><img class="carousel__thumbnail" src="img/products/01-Fresh/01_4a.jpg" alt="alt" /></div>
                                    <div class="quickview-carousel"><img class="carousel__thumbnail" src="img/products/01-Fresh/01_9a.jpg" alt="alt" /></div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-7">
                                <div class="quickview__product">
                                    <div class="product__header">
                                        <div class="product__title">Hovis Farmhouse Soft White Bread</div>
                                        <div class="product__meta">
                                            <div class="product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4" selected="selected">4</option>
                                                    <option value="5">5</option>
                                                </select><span>4 customer reviews</span>
                                            </div>
                                            <div class="product__code"><span>SKU: </span>#VEG20938</div>
                                        </div>
                                    </div>
                                    <div class="product__content">
                                        <div class="product__price"><span class="sale">$5.49</span><span class="price">$6.90</span><span class="off">25% Off</span></div>
                                        <p class="product__unit">300g</p>
                                        <div class="alert__success">Availability: <span>34 in stock</span></div>
                                        <ul>
                                            <li>Type: Organic</li>
                                            <li>MFG: Jun 4, 2020</li>
                                            <li>LIFE: 30 days</li>
                                        </ul>
                                    </div>
                                    <div class="product__action">
                                        <label>Quantity: </label>
                                        <div class="def-number-input number-input safari_only">
                                            <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                            <input class="quantity" min="0" name="quantity" value="1" type="number">
                                            <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                        </div>
                                        <button class="btn product__addcart"> <i class="icon-cart"></i>Add to cart</button>
                                        <button class="btn button-icon icon-md"><i class="icon-repeat"></i></button>
                                        <button class="btn button-icon icon-md"><i class="icon-heart"></i></button>
                                    </div>
                                    <div class="product__footer">
                                        <div class="ps-social--share"><a class="ps-social__icon facebook" href="#"><i class="fa fa-thumbs-up"></i><span>Like</span><span class="ps-social__number">0</span></a><a class="ps-social__icon facebook" href="#"><i class="fa fa-facebook-square"></i><span>Like</span><span class="ps-social__number">0</span></a><a class="ps-social__icon twitter" href="#"><i class="fa fa-twitter"></i><span>Like</span></a><a class="ps-social__icon" href="#"><i class="fa fa-plus-square"></i><span>Like</span></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="popupAddToCart" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl ps-addcart">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="alert__success"><i class="icon-checkmark-circle"></i> "Morrisons The Best Beef Topside" successfully added to you cart. <a href="shopping-cart.html">View cart(3)</a></div>
                        <hr>
                        <h3 class="cart__title">CUSTOMERS WHO BOUGHT THIS ALSO BOUGHT:</h3>
                        <div class="cart__content">
                            <div class="owl-carousel" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="4" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="2" data-owl-item-lg="4" data-owl-item-xl="4" data-owl-duration="1000" data-owl-mousedrag="on">
                                <div class="cart-item">
                                    <div class="ps-product--standard"><a href="product-default.html"><img class="ps-product__thumbnail" src="img/products/01-Fresh/01_35a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>Farmart</p><a href="product-default.html">
                                                <h5 class="ps-product__name">Extreme Budweiser Light Can</h5>
                                            </a>
                                            <p class="ps-product__unit">500g</p>
                                            <div class="ps-product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4" selected="selected">4</option>
                                                    <option value="5">5</option>
                                                </select><span>(4)</span>
                                            </div>
                                            <p class="ps-product-price-block"><span class="ps-product__sale">$8.90</span><span class="ps-product__price">$9.90</span><span class="ps-product__off">15% Off</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-item">
                                    <div class="ps-product--standard"><a href="product-default.html"><img class="ps-product__thumbnail" src="img/products/01-Fresh/01_16a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>Karery Store</p><a href="product-default.html">
                                                <h5 class="ps-product__name">Honest Organic Still Lemonade</h5>
                                            </a>
                                            <p class="ps-product__unit">100g</p>
                                            <div class="ps-product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5" selected="selected">5</option>
                                                </select><span>(14)</span>
                                            </div>
                                            <p class="ps-product-price-block"><span class="ps-product__price-default">$1.99</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-item">
                                    <div class="ps-product--standard"><a href="product-default.html"><img class="ps-product__thumbnail" src="img/products/01-Fresh/01_12a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>John Farm</p><a href="product-default.html">
                                                <h5 class="ps-product__name">Natures Own 100% Wheat</h5>
                                            </a>
                                            <p class="ps-product__unit">100g</p>
                                            <div class="ps-product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select><span>(0)</span>
                                            </div>
                                            <p class="ps-product-price-block"><span class="ps-product__price-default">$4.49</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-item">
                                    <div class="ps-product--standard"><a href="product-default.html"><img class="ps-product__thumbnail" src="img/products/01-Fresh/01_15a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>Farmart</p><a href="product-default.html">
                                                <h5 class="ps-product__name">Avocado, Hass Large</h5>
                                            </a>
                                            <p class="ps-product__unit">300g</p>
                                            <div class="ps-product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3" selected="selected">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select><span>(6)</span>
                                            </div>
                                            <p class="ps-product-price-block"><span class="ps-product__sale">$6.99</span><span class="ps-product__price">$9.90</span><span class="ps-product__off">25% Off</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="cart-item">
                                    <div class="ps-product--standard"><a href="product-default.html"><img class="ps-product__thumbnail" src="img/products/06-SoftDrinks-TeaCoffee/06_3a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>Sun Farm</p><a href="product-default.html">
                                                <h5 class="ps-product__name">Kevita Kom Ginger</h5>
                                            </a>
                                            <p class="ps-product__unit">200g</p>
                                            <div class="ps-product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4" selected="selected">4</option>
                                                    <option value="5">5</option>
                                                </select><span>(6)</span>
                                            </div>
                                            <p class="ps-product-price-block"><span class="ps-product__sale">$4.90</span><span class="ps-product__price">$3.99</span><span class="ps-product__off">15% Off</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
