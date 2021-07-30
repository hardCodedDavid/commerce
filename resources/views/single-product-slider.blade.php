<div class="ps-product--standard"><a href="{{ route('product.detail', $product['code']) }}"><img class="ps-product__thumbnail" src="{{ asset($product->media->first()['url']) }}" alt="{{ $product['name'] }}" /></a>
    <div class="ps-product__content">
        <p class="ps-product-price-block"><span class="ps-product__sale">₦{{ $product->getFormattedDiscountedPrice() }}</span><span class="ps-product__price">₦{{ $product->getFormattedActualPrice() }}</span><span class="ps-product__off" style="font-size: 11px">{{ $product->getDiscountedPercent() }}% Off</span></p>
        <p class="ps-product__type"></p><a href="{{ route('product.detail', $product['code']) }}">
            <h5 class="ps-product__name">{{ $product['name'] }}</h5>
        </a>
        <p class="ps-product__unit">
            @foreach ($product->categories->take(2) as $category)
                <div class="badge badge-light mx-1">{{ $category['name'] }}</div>
            @endforeach
        </p>
    </div>
    <div class="ps-product__footer">
        <div class="def-number-input number-input safari_only">
            <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
            <input class="quantity" min="0" name="quantity" value="1" type="number" />
            <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
        </div>
        <button onclick="addToCart({{ $product['id'] }}, this.parentNode.querySelector('input[type=number]').value)" class="mt-4 ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button>
        <div class="ps-product__box">
            <a class="ps-product__wishlist" onclick="addToWishlist({{ $product['id'] }})" href="javascript:void(0);">Wishlist</a>
        </div>
    </div>
</div>