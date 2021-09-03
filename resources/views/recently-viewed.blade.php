@extends('layouts.user')

@section('title', 'Recently Viewed')

@section('content')
    <main class="no-main">
        <div class="ps-breadcrumb">
            <div class="container">
                <ul class="ps-breadcrumb__list">
                    <li class="active"><a href="/">Home</a></li>
                    <li class="active"><a href="/shop">Shop</a></li>
                    <li><a href="javascript:void(0);">Recently Viewed</a></li>
                </ul>
            </div>
        </div>
        <section class="section--flashSale">
            <div class="flashSale__header">
                <div class="container">
                    <h3 class="flashSale__title">Your Recently Viewed Products</h3>
                </div>
            </div>
            <div class="container">
                <div class="flashSale__product">
                    <div class="row m-0">
                        @foreach ($products as $product)
                            @php $product = App\Models\Product::find($product['id']) @endphp
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
