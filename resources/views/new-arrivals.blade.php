@extends('layouts.user')

@section('title', 'New Arrivals')

@php
    use App\Models\Category;

    $categories = Category::with('subCategories')->whereHas('products')->get()
@endphp

@section('content')
    <main class="no-main">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="ps-breadcrumb__list">
                    <li class="active"><a href="/">Home</a></li>
                    <li class="active"><a href="/shop">Shop</a></li>
                    @if(is_null($category))
                        <li><a href="javascript:void(0);">New Arrivals</a></li>
                    @else
                        <li class="active"><a href="/new-arrivals">New Arrivals</a></li>
                        <li><a href="javascript:void(0);">{{ $category['name'] }}</a></li>
                    @endif
                </ul>
            </div>
        <section class="section--flashSale">
            <div class="container">
                <div class="flashSale__category">
                    <ul>
                        <li class="@if(is_null($category)) active @endif">
                            <a href="{{ route('newArrivals') }}">All</a>
                        </li>
                        @foreach ($categories as $curCategory)
                            <li class="@if($curCategory['name'] == $category) active @endif"><a href="{{ route('newArrivals', $curCategory['name']) }}">{{ $curCategory['name'] }}</a></li>
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
    </main>
@endsection
