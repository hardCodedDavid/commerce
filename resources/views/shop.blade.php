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
                                    <li class="daily-deals category-item"><a href="/deals">Daily Deals</a></li>
                                    <li class="category-item"><a href="/top-selling">Top Selling</a></li>
                                    @foreach ($categories as $category)
                                        <li class="menu-item-has-children category-item"><a href="{{ route('category.products', $category) }}">{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                @foreach ($category->subCategories as $subCategory)
                                                    <li><a href="{{ route('category.products', ['category' => $category, 'subcategory' => $subCategory['name']]) }}">{{ $subCategory['name'] }}</a></li>
                                                @endforeach
                                                <li class="see-all"><a href="/shop">See all products <i class='icon-chevron-right'></i></a></li>
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9">
                        <a class="mt-3 ps-button shop__link" href="/shop">Shop all product<i class="icon-chevron-right"></i></a>
                        <div class="filter__mobile">
                            <div class="viewtype--block">
                                <div class="viewtype__sortby">
                                    <form id="sortFormMobile" action="{{ route('shop') }}">
                                        <div class="select">
                                            <input type="hidden" name="rpp" value="{{ request('rpp') }}">
                                            <select onchange="document.getElementById('sortFormMobile').submit()" class="single-select2-no-search" name="sort">
                                                <option value="">Sort</option>
                                                <option @if(request('sort') == 'name') selected @endif value="name">By name</option>
                                                <option @if(request('sort') == 'price') selected @endif value="price">By price</option>
                                                <option @if(request('sort') == 'sale') selected @endif value="sale">By sales</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="result__sort">
                            <div class="viewtype--block">
                                <div class="viewtype__sortby">
                                    <form id="sortForm" action="{{ route('shop') }}">
                                        <div class="select">
                                            <input type="hidden" name="rpp" value="{{ request('rpp') }}">
                                            <select onchange="document.getElementById('sortForm').submit()" class="single-select2-no-search" name="sort">
                                                <option value="">Sort</option>
                                                <option @if(request('sort') == 'name') selected @endif value="name">By name</option>
                                                <option @if(request('sort') == 'price') selected @endif value="price">By price</option>
                                                <option @if(request('sort') == 'sale') selected @endif value="sale">By sales</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="viewtype__select"> <span class="text">View: </span>
                                    <form id="rppForm" action="{{ route('shop') }}" method="get">
                                        <div class="select">
                                            <input type="hidden" name="sort" value="{{ request('sort') }}">
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
                                        @include('single-product', ['product' => $product])
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
