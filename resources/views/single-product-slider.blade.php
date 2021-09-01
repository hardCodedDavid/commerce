@php
    $count = $product->reviews()->where('status', 'approved')->count();
    $rating = $count > 0 ? $product->reviews()->where('status', 'approved')->sum('rating')/$count : 0;
    $rate5 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '>=', 4.5)->count()/$count) * 100, 2) : 0;
    $rate4 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '>=', 3.5)->where('rating', '<', 4.5)->count()/$count) * 100, 2) : 0;
    $rate3 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '>=', 2.5)->where('rating', '<', 3.5)->count()/$count) * 100, 2) : 0;
    $rate2 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '>=', 1.5)->where('rating', '<', 2.5)->count()/$count) * 100, 2) : 0;
    $rate1 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '<', 1.5)->count()/$count) * 100, 2) : 0;
@endphp

<div class="ps-product--standard"><a href="{{ route('product.detail', $product['code']) }}"><img class="ps-product__thumbnail" style="height: 120px;" src="{{ asset($product->media->first()['url']) }}" alt="{{ $product['name'] }}" /></a>
    <div class="ps-product__content">
        <p class="ps-product-price-block"><span class="ps-product__sale">₦{{ $product->getFormattedDiscountedPrice() }}</span><span class="ps-product__price">₦{{ $product->getFormattedActualPrice() }}</span><span class="ps-product__off" style="font-size: 11px">{{ $product->getDiscountedPercent() }}% Off</span></p>
        <p class="ps-product__type"></p><a href="{{ route('product.detail', $product['code']) }}">
            <div class="ps-product__rating">
                <select class="rating-stars">
                    <option value=""></option>
                    <option value="1" {{ ($rating > 0 && $rating < 1.5) ? 'selected' : '' }}>1</option>
                    <option value="2" {{ ($rating >= 1.5 && $rating < 2.5) ? 'selected' : '' }}>2</option>
                    <option value="3" {{ ($rating >= 2.5 && $rating < 3.5) ? 'selected' : '' }}>3</option>
                    <option value="4" {{ ($rating >= 3.5 && $rating < 4.5) ? 'selected' : '' }}>4</option>
                    <option value="5" {{ $rating >= 4.5 ? 'selected' : '' }}>5</option>
                </select><span>({{ $count }})</span>
            </div>
            <h5 class="ps-product__name">{{ $product['name'] }}</h5>
        </a>
        <p class="ps-product__unit">
            @foreach ($product->categories->take(2) as $category)
                <div class="badge badge-light mx-1">{{ $category['name'] }}</div>
            @endforeach
        </p>
    </div>
    <div class="ps-product__footer">
        @if ($product['in_stock'])
        <div class="def-number-input number-input safari_only">
            <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
            <input class="quantity" min="0" name="quantity" value="1" type="number" />
            <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
        </div>
        <button onclick="addToCart({{ $product['id'] }}, this.parentNode.querySelector('input[type=number]').value)" class="mt-4 ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button>
        @else
        <button class="mt-4 ps-product__addcart" style="background: #e91313" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Out of Stock</button>
        @endif
        <div class="ps-product__box">
            <a class="ps-product__wishlist" onclick="addToWishlist({{ $product['id'] }})" href="javascript:void(0);">Wishlist</a>
        </div>
    </div>
</div>
