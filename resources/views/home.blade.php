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
                @php
                    $cat = $categories[0];
                    unset($categories[0]);
                @endphp
                <div class="featured__first text-center">
                    <div class="ps-product--vertical">
                        <a href="{{ route('category.products', $cat) }}"><img class="ps-product__thumbnail" src="{{ asset($cat->products()->first() ? ($cat->products()->first()->media()->first()['url'] ?? null) : null) }}" alt="alt" /></a>
                        <div class="ps-product__content">
                            <a class="ps-product__name" href="{{ route('category.products', $cat) }}">{{ $cat['name'] }}</a>
                            <p class="ps-product__quantity">{{ $cat->products()->count() }} item(s)</p>
                        </div>
                    </div>
                </div>
                <div class="featured__group">
                    <div class="row m-0">
                        @foreach($categories->take(8) as $key => $category)
                            <div class="col-3 p-0">
                                <div class="ps-product--vertical">
                                    <a href="{{ route('category.products', $category) }}"><img class="ps-product__thumbnail" src="{{ asset($cat->products()->first() ? ($cat->products()->first()->media()->first()['url'] ?? null) : null) }}" alt="alt" /></a>
                                    <div class="ps-product__content">
                                        <a class="ps-product__name" href="{{ route('category.products', $category) }}">{{ $category['name'] }}</a>
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
                        <a class="ps-product--vertical item-first" href="{{ route('category.products', $cat) }}">
                            <img class="ps-product__thumbnail" src="{{ asset($cat->products()->first() ? ($cat->products()->first()->media()->first()['url'] ?? null) : null) }}" alt="alt" />
                            <div class="ps-product__content">
                                <h5 class="ps-product__name">{{ $cat['name'] }}</h5>
                                <p class="ps-product__quantity">{{ $cat->products()->count() }} item(s)</p>
                            </div>
                        </a>
                        @foreach($categories->take(8) as $category)
                            <a class="ps-product--vertical" href="#">
                                <img class="ps-product__thumbnail" src="{{ asset($cat->products()->first() ? ($cat->products()->first()->media()->first()['url'] ?? null) : null) }}" alt="alt" />
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

    <section class="section-categories--default">
        <div class="container">
            <div class="categories--floating">
                @foreach($categories->take(5) as $key => $cat)
                    <a class="floating-item" href="#category-{{ $key + 1 }}"><i class="icon-arrow-wave"></i></a>
                @endforeach
            </div>
            @foreach($categories->take(5) as $key => $category)
                <div class="categories--block">
                    <h3><a class="categories__title" id="category-{{ $key + 1 }}">{{ ucwords($category['name']) }}</a></h3>
                    <div class="categories__content">
                        <div class="categories__promotion">
                            <div class="slick-single-item">
                                @foreach($category->banners as $banner)
                                    <div class="categories-carousel">
                                        <a href="{{ route('category.products', $category) }}">
                                            <img class="carousel__thumbnail" src="{{ asset($banner->url) }}" alt="alt" />
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row categories__list">
                                @php
                                    $subCategories = [];
                                    foreach ($category->subCategories()->get()->take(15) as $sub)
                                        $subCategories[] = $sub;
                                    $subCategories1 = array_splice($subCategories, 0, 8);
                                    $subCategories2 = array_splice($subCategories, 8, 7);
                                @endphp
                                @foreach($subCategories1 as $subCategory)
                                    <div class="col-6">
                                        <div class="categories__list-item"><a href="{{ route('category.products', [$category, $subCategory->id]) }}">{{ ucwords($subCategory['name']) }}</a></div>
                                    </div>
                                @endforeach
                                @foreach($subCategories2 as $subCategory)
                                    <div class="col-6">
                                        <div class="categories__list-item"><a href="{{ route('category.products', [$category, $subCategory->id]) }}">{{ ucwords($subCategory['name']) }}</a></div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="categories__footer">
                                <a href="{{ route('category.products', $category) }}"><u>View all</u><i class="icon-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="categories__products">
                            <div class="row m-0">
                                @foreach($category->products()->get()->take(8) as $product)
                                    @include('single-product', ['product' => $product])
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection
