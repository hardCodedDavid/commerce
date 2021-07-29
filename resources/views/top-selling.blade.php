@extends('layouts.user')

@section('title', 'Top Selling')

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
                <h3 class="flashSale__title">Top Selling Products</h3>
            </div>
        </div>
        <div class="container">
            <div class="flashSale__category">
                <ul>
                    <li class="@if(is_null($category)) active @endif">
                        <a href="{{ route('deals') }}">All</a>
                    </li>
                    @foreach ($categories as $curCategory)
                        <li class="@if($curCategory['name'] == $category) active @endif"><a href="{{ route('topSelling', $curCategory['name']) }}">{{ $curCategory['name'] }}</a></li>
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
                    {{-- {{ $products->links() }} --}}
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
