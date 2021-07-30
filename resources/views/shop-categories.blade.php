@extends('layouts.user')

@section('title', $category['name'])

@php
    $categories = \App\Models\Category::with('subCategories')->whereHas('products', function ($q) {
        $q->where('discount', '>', 0);
    })->get();
@endphp

@section('content')
<main class="no-main">
    <section class="section-shop shop-categories--default">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="ps-shop--sidebar">
                        <div class="sidebar__category">
                            <div class="sidebar__title">SUBCATEGORIES</div>
                            <div class="ps-widget--category">
                                <ul>
                                    @if ($category->subCategories)
                                        @foreach ($category->subCategories as $subCat)
                                            @if ($subCat['name'] == $subcategory)
                                                <li><a href="#"><strong>{{ $subCat['name'] }}</strong></a></li>
                                            @else
                                                <li><a href="{{ route('category.products', ['category' => $category, 'subcategory' => $subCat['name']]) }}">{{ $subCat['name'] }}</a></li>
                                            @endif
                                        @endforeach
                                    @else
                                        <li><a href="#">No sub categories</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="category__top">
                        <div class="category__header my-4">
                            @if ($subcategory)
                                <h3 class="category__name">{{ ucfirst($subcategory) }}</h3>
                            @else
                                <h3 class="category__name">{{ ucfirst($category['name']) }}</h3>
                            @endif
                        </div>
                        <div class="shop__block category__carousel">
                            <div class="owl-carousel" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="5" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="5" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">
                                @foreach ($category->subCategories as $subCat)
                                    <div class="categogy-item">
                                        <div class="categogy-name">{{ $subCat['name'] }}</div>
                                        <div class="categogy-number">{{ $subCat->products->count() }} items</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="result__header">
                        <h4 class="title">{{ $count }}<span>Products Found</span></h4>
                    </div>
                    <div class="result__sort mt-5">
                        <div class="viewtype--block">
                            <div class="viewtype__sortby">
                                <form id="sortFormMobile" action="">
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
                            <div class="viewtype__select"> <span class="text">View: </span>
                                <form id="rppForm" action="">
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
                    <div class="result__header mobile">
                        <h4 class="title">{{ $count }}<span>Products Found</span></h4>
                    </div>
                    <div class="result__content mt-4">
                        <div class="flashSale__product">
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
    </section>
</main>
@endsection
