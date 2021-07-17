@extends('layouts.user')

@section('title', 'Shop')

@section('content')

@php
    $categories = \App\Models\Category::with('subCategories')->get();
@endphp

<main class="no-main">
    <section class="section-shop">
        <div class="container">
            <div class="shop__content">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <div class="ps-shop--sidebar">
                            <div class="sidebar__category">
                                <div class="sidebar__title">ALL CATEGORIES</div>
                                <ul class="menu--mobile">
                                    <li class="daily-deals category-item"><a href="flash-sale.html">Daily Deals</a></li>
                                    <li class="category-item"><a href="shop-categories.html">Top Promotions</a></li>
                                    <li class="category-item"><a class="active" href="shop-categories.html">New Arrivals</a></li>
                                    @foreach ($categories as $category)
                                        <li class="menu-item-has-children category-item"><a href="shop-categories.html">{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                @foreach ($category->subCategories as $subCategory)
                                                    <li><a href="shop-view-grid.html">{{ $subCategory['name'] }}</a></li>
                                                @endforeach
                                                <li class="see-all"><a href="shop-view-grid.html">See all products <i class='icon-chevron-right'></i></a></li>
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9">
                        <a class="ps-button shop__link" href="shop-view-listing.html">Shop all product<i class="icon-chevron-right"></i></a>
                        <div class="filter__mobile">
                            <div class="viewtype--block">
                                <div class="viewtype__sortby">
                                    <div class="select">
                                        <select class="single-select2-no-search" name="state">
                                            <option value="popularity" selected="selected">Sort by popularity</option>
                                            <option value="price">Sort by price</option>
                                            <option value="sale">Sort by sale of</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="result__sort">
                            <div class="viewtype--block">
                                <div class="viewtype__sortby">
                                    <div class="select">
                                        <select class="single-select2-no-search" name="state">
                                            <option value="popularity" selected="selected">Sort by popularity</option>
                                            <option value="price">Sort by price</option>
                                            <option value="sale">Sort by sale of</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="viewtype__select"> <span class="text">View: </span>
                                    <form id="rppForm" action="{{ route('shop') }}" method="get">
                                        <div class="select">
                                            <select onchange="document.getElementById('rppForm').submit()" class="single-select2-no-search" name="rpp">
                                                <option value="24" @if(request('rpp') == 24) selected @endif>24 per page</option>
                                                <option value="12" @if(request('rpp') == 12) selected @endif>12 per page</option>
                                                <option value="4" @if(request('rpp') == 4) selected @endif>4 per page</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="result__content">
                            <div class="section-shop--grid">
                                <div class="row m-0">
                                    @foreach ($products as $product)
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
                                                <button class="mt-3 ps-product__addcart"><i class="icon-cart"></i>Add to cart</button>
                                                <div class="ps-product__box">
                                                    <a class="ps-product__wishlist" href="wishlist.html">Wishlist</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="ps-pagination blog--pagination">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
