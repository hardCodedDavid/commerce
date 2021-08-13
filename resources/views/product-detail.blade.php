@extends('layouts.user')

@section('title', ucwords($product['name']))

@section('content')

@php
    $variations = App\Models\Variation::all();
@endphp

<main class="no-main">
    <section class="section--product-type section-product--default">
        <div class="container">
            <div class="product__header">
                <h3 class="product__name">{{ $product['name'] }}</h3>
            </div>
            <div class="product__detail">
                <div class="row">
                    <div class="col-12 col-lg-9">
                        <div class="ps-product--detail">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="ps-product__variants">
                                        <div class="ps-product__gallery">
                                            @php
                                                $mediaList = $product->media()->get();
                                            @endphp
                                            @foreach ($mediaList as $key=>$media)
                                                <div class="ps-gallery__item @if($key == 0) active @endif"><img src="{{ asset($media['url']) }}" alt="{{ $product['name'] }}" /></div>
                                            @endforeach
                                        </div>
                                        <div class="ps-product__thumbnail">
                                            <div class="ps-product__zoom">
                                                <img id="ps-product-zoom" src="{{ asset($mediaList->first()['url']) }}" alt="{{ $product['name'] }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    @if ($product->isDiscounted())
                                        <p class="ps-product__sale"><span class="price-sale">₦{{ $product->getFormattedDiscountedPrice() }}</span><span class="price">₦{{ $product->getFormattedActualPrice() }}</span><span class="ps-product__off" style="font-size: 11px">{{ $product->getDiscountedPercent() }}% Off</span></p>
                                    @else
                                        <p class="ps-product__sale"><span class="price-sale">₦{{ $product->getFormattedDiscountedPrice() }}</span></p>
                                    @endif
                                    <div class="ps-product__avai alert__success">Availability: <span>{{ number_format($product['quantity']) }} in stock</span>
                                    </div>
                                    <div class="ps-product__info">
                                        <ul class="list-items">
                                            <div class="mb-2">{{ $product['description'] }}</div>
                                            @if ($product->brands()->count() > 0)
                                            <li class="list-item"> <span><i class="icon-square"></i></span>Brands: @foreach ($product->brands()->get() as $brand)
                                                <span style="font-size: 12px" class="mx-1 bg-light">{{ $brand['name'] }}</span>
                                            @endforeach</li>
                                            @endif
                                            @foreach ($variations as $variation)
                                                @if ($product->variationItems()->where('variation_id', $variation['id'])->count() > 0)
                                                    <li> <span><i class="icon-square"></i></span>{{ $variation['name'] }}: @foreach ($product->variationItems()->where('variation_id', $variation['id'])->get() as $item)
                                                        <span style="font-size: 12px" class="mx-1 bg-light">{{ $item['name'] }}</span>
                                                    @endforeach</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="ps-product__shopping">
                                        <div class="ps-product__quantity">
                                            <label>Quantity: </label>
                                            <div class="def-number-input number-input safari_only">
                                                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                                                <input class="quantity" id="singleProductQty" min="0" name="quantity" value="1" type="number" />
                                                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
                                            </div>
                                        </div>
                                            @if ($product['in_stock'])
                                            <a onclick="addToCart({{ $product['id'] }}, this.parentNode.querySelector('input[type=number]').value)" class="ps-product__addcart ps-button">
                                                <i class="icon-cart"></i>Add to cart
                                            </a>
                                            @else
                                            <a style="background: #e91313" class="ps-product__addcart ps-button">
                                                <i class="icon-cart"></i>Out of Stock
                                            </a>
                                            @endif
                                            <a class="ps-product__icon" onclick="addToWishlist({{ $product['id'] }})" href="javaScript:void(0);"><i class="icon-heart"></i></a>
                                    </div>
                                    <div class="ps-product__category">
                                        <ul>
                                            <li>Categories: @foreach ($product->categories()->get() as $category)
                                                <span style="font-size: 12px" class="mx-1 bg-light">{{ $category['name'] }}</span>
                                            @endforeach</li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__footer">
                                        <a class="ps-product__shop" href="/shop"><i class="icon-store"></i><span>Shop</span></a>
                                        @if ($product['in_stock'])
                                            <a class="ps-product__addcart ps-button" onclick="addToCart({{ $product['id'] }}, document.querySelector('#singleProductQty').value)"><i class="icon-cart"></i>Add to cart</a>
                                        @else
                                            <a class="ps-product__addcart ps-button" style="background: #e91313"><i class="icon-cart"></i>Out of Stock</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="product__related">
                <h3 class="product__name">Related Products</h3>
                <div class="owl-carousel" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="5" data-owl-item-xs="2" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="5" data-owl-item-xl="5" data-owl-duration="1000" data-owl-mousedrag="on">
                    @foreach ($related as $prod)
                        <div class="ps-post--product">
                            @include('single-product-slider', ['product' => $prod])
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</main>

@endsection