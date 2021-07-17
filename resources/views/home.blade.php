@extends('layouts.user')

@section('title', 'Home')

@section('content')

@php
    $banners = \App\Models\Banner::inRandomOrder()->get();
    $categories = \App\Models\Category::inRandomOrder()->get();
    $discountedDeals =  \App\Models\Product::where('is_listed', 1)
                            ->where('discount', '>', 0)
                            ->with(['categories', 'media'])
                            ->inRandomOrder()
                            ->get();
    $topSelling = \App\Models\Product::where('is_listed', 1)
                            ->with(['categories', 'media'])
                            ->get();

    $newArrivals = \App\Models\Product::where('is_listed', 1)
                            ->latest()
                            ->with(['categories', 'media'])
                            ->get();
@endphp

<main class="no-main">
    <div class="section-slide--default">
        <div class="owl-carousel" data-owl-auto="false" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
            @foreach ($banners->where('position', 'top')->take(3) as $banner)
                <div class="ps-banner">
                    <img class="mobile-only" src="{{ asset($banner['url']) }}" alt="alt" />
                    <img class="desktop-only" src="{{ asset($banner['url']) }}" alt="alt" />
                </div>
            @endforeach
        </div>
    </div>
    <section class="section-featured--default ps-home--block">
        <div class="container">
            <div class="ps-block__header">
                <h3 class="ps-block__title">Featured Categories</h3>
            </div>
            <div class="featured--content">
                <div class="featured__group">
                    <div class="row m-0">
                        @foreach($categories->take(8) as $category)
                            <div class="col-3 p-0">
                                <div class="ps-product--vertical"><a href="#"><img class="ps-product__thumbnail" src="/assets/img/products/05-ReadyMeals/05_2a.jpg" alt="alt" /></a>
                                    <div class="ps-product__content"><a class="ps-product__name" href="#">{{ $category['name'] }}</a>
                                        <p class="ps-product__quantity">{{ $category->products()->count() }} item(s)</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="featured--content-mobile">
                <div class="owl-carousel" data-owl-auto="true" data-owl-loop="true" data-owl-speed="10000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on">
                    <div class="product-slide">
                        @foreach($categories->take(8) as $category)
                            <a class="ps-product--vertical" href="#"><img class="ps-product__thumbnail" src="/assets/img/products/02-FoodCupboard/02_19a.jpg" alt="alt" />
                                <div class="ps-product__content">
                                    <h5 class="ps-product__name">{{ $category['name'] }}</h5>
                                    <p class="ps-product__quantity">{{ $category->products()->count() }} items</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-flashdeal--default ps-home--block">
        <div class="container">
            <div class="ps-block__header">
                <h3 class="ps-block__title"><i class="icon-power"></i>Top Discounted Deals</h3>
            </div>
            <div class="flashdeal--content">
                <div class="owl-carousel" data-owl-auto="false" data-owl-loop="false" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="6" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="6" data-owl-duration="1000" data-owl-mousedrag="on">
                    @foreach ($discountedDeals->take(10) as $deal)
                    <div class="ps-product--standard"><a href="{{ route('product.detail', $deal['code']) }}"><img class="ps-product__thumbnail" src="{{ asset($deal->media->first()['url']) }}" alt="{{ $deal['name'] }}" /></a>
                        <div class="ps-product__content">
                            <p class="ps-product-price-block"><span class="ps-product__sale">₦{{ $deal->getFormattedDiscountedPrice() }}</span><span class="ps-product__price">₦{{ $deal->getFormattedActualPrice() }}</span><span class="ps-product__off" style="font-size: 11px">{{ $deal->getDiscountedPercent() }}% Off</span></p>
                            <p class="ps-product__type"></p><a href="{{ route('product.detail', $deal['code']) }}">
                                <h5 class="ps-product__name">{{ $deal['name'] }}</h5>
                            </a>
                            <p class="ps-product__unit">
                                @foreach ($deal->categories->take(2) as $category)
                                    <div class="badge badge-light mx-1">{{ $category['name'] }}</div>
                                @endforeach
                            </p>
                            <p class="ps-product__sold">Sold: 0</p>
                        </div>
                        <div class="ps-product__footer">
                            <div class="def-number-input number-input safari_only">
                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                            </div>
                            <button class="mt-4 ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button>
                            <div class="ps-product__box">
                                <a class="ps-product__wishlist" href="wishlist.html">Wishlist</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="section-categories--default">
        <div class="container">
            <div class="categories--block">
                <h3><a class="categories__title" id="freshFoodBlock">Top Selling Products</a></h3>
                <div class="categories__content">
                    <div class="categories__products">
                        <div class="row m-0">
                            @foreach ($topSelling->take(16) as $product)
                            <div class="col-6 col-md-4 col-lg-3 p-0">
                                <div class="ps-product--standard">
                                    <a href="{{ route('product.detail', $product['code']) }}">
                                        <img class="ps-product__thumbnail" src="{{ asset($product->media->first()['url']) }}" alt="{{ $product['name'] }}" />
                                    </a>
                                    @if ($product->isNew())
                                        <span class="ps-badge ps-product__new">New </span>
                                    @endif
                                    @if ($product->isDiscounted())
                                        <span class="ps-badge ps-product__offbadge">{{ $product->getDiscountedPercent() }}% Off </span>
                                    @endif
                                    <div class="ps-product__content">
                                        <h5><a class="ps-product__name" href="{{ route('product.detail', $product['code']) }}">{{ $product['name'] }}</a></h5>
                                        @if ($product->isDiscounted())
                                        <p class="ps-product-price-block"><span class="ps-product__sale">₦{{ $product->getFormattedDiscountedPrice() }}</span><span class="ps-product__price">₦{{ $product->getFormattedActualPrice() }}</span><span class="ps-product__off" style="font-size: 11px">{{ $product->getDiscountedPercent() }}% Off</span></p>
                                        @else
                                            <p class="ps-product-price-block"><span class="ps-product__price-default">₦{{ $product->getFormattedDiscountedPrice() }}</span>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="ps-product__footer">
                                        <div class="def-number-input number-input safari_only">
                                            <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                            <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                            <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                        </div>
                                        <button class="mt-5 ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button>
                                        <div class="ps-product__box">
                                            <a class="ps-product__wishlist" href="wishlist.html">Wishlist</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="categories--block">
                <h3><a class="categories__title" id="freshFoodBlock">New Arrivals</a></h3>
                <div class="categories__content">
                    <div class="categories__products">
                        <div class="row m-0">
                            @foreach ($newArrivals->take(16) as $product)
                            <div class="col-6 col-md-4 col-lg-3 p-0">
                                <div class="ps-product--standard">
                                    <a href="{{ route('product.detail', $product['code']) }}">
                                        <img class="ps-product__thumbnail" src="{{ asset($product->media->first()['url']) }}" alt="{{ $product['name'] }}" />
                                    </a>
                                    @if ($product->isNew())
                                        <span class="ps-badge ps-product__new">New </span>
                                    @endif
                                    @if ($product->isDiscounted())
                                        <span class="ps-badge ps-product__offbadge">{{ $product->getDiscountedPercent() }}% Off </span>
                                    @endif
                                    <div class="ps-product__content">
                                        <h5><a class="ps-product__name" href="{{ route('product.detail', $product['code']) }}">{{ $product['name'] }}</a></h5>
                                        @if ($product->isDiscounted())
                                        <p class="ps-product-price-block"><span class="ps-product__sale">₦{{ $product->getFormattedDiscountedPrice() }}</span><span class="ps-product__price">₦{{ $product->getFormattedActualPrice() }}</span><span class="ps-product__off" style="font-size: 11px">{{ $product->getDiscountedPercent() }}% Off</span></p>
                                        @else
                                            <p class="ps-product-price-block"><span class="ps-product__price-default">₦{{ $product->getFormattedDiscountedPrice() }}</span>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="ps-product__footer">
                                        <div class="def-number-input number-input safari_only">
                                            <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                            <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                            <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                        </div>
                                        <button class="mt-3 ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button>
                                        <div class="ps-product__box">
                                            <a class="ps-product__wishlist" href="wishlist.html">Wishlist</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
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
                                    <div class="quickview-carousel"><img class="carousel__thumbnail" src="/assets/img/products/01-Fresh/01_1a.jpg" alt="alt" /></div>
                                    <div class="quickview-carousel"><img class="carousel__thumbnail" src="/assets/img/products/01-Fresh/01_2a.jpg" alt="alt" /></div>
                                    <div class="quickview-carousel"><img class="carousel__thumbnail" src="/assets/img/products/01-Fresh/01_4a.jpg" alt="alt" /></div>
                                    <div class="quickview-carousel"><img class="carousel__thumbnail" src="/assets/img/products/01-Fresh/01_9a.jpg" alt="alt" /></div>
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
                                    <div class="ps-product--standard"><a href="{{ route('product.detail', $product['code']) }}"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_35a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>Farmart</p><a href="{{ route('product.detail', $product['code']) }}">
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
                                    <div class="ps-product--standard"><a href="{{ route('product.detail', $product['code']) }}"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_16a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>Karery Store</p><a href="{{ route('product.detail', $product['code']) }}">
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
                                    <div class="ps-product--standard"><a href="{{ route('product.detail', $product['code']) }}"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_12a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>John Farm</p><a href="{{ route('product.detail', $product['code']) }}">
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
                                    <div class="ps-product--standard"><a href="{{ route('product.detail', $product['code']) }}"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_15a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>Farmart</p><a href="{{ route('product.detail', $product['code']) }}">
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
                                    <div class="ps-product--standard"><a href="{{ route('product.detail', $product['code']) }}"><img class="ps-product__thumbnail" src="/assets/img/products/06-SoftDrinks-TeaCoffee/06_3a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content">
                                            <p class="ps-product__type"><i class="icon-store"></i>Sun Farm</p><a href="{{ route('product.detail', $product['code']) }}">
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
