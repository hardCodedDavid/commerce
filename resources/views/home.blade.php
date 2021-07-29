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
                            ->orderBy('sold', 'desc')
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
    <div class="ps-promotion--default">
        <div class="container">
            <div class="row m-0">
                @foreach ($banners->where('position', 'side')->take(4) as $banner)
                    <div class="col-6 col-lg-3">
                        <a href="#">
                            <img src="{{ asset($banner['url']) }}" alt="alt" />
                        </a>
                    </div>
                @endforeach
            </div>
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
                                <div class="ps-product--vertical">
                                    <div class="ps-product__content">
                                        <a class="ps-product__name" href="{{ route('category.products', $category) }}"><strong>{{ $category['name'] }}</strong></a>
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
                        @include('single-product-slider', ['product' => $deal])
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
                            @foreach ($topSelling->take(8) as $product)
                                @include('single-product', ['product' => $product])
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
                            @foreach ($newArrivals->take(8) as $product)
                                @include('single-product', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
