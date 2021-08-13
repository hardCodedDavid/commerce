<div class="col-6 col-md-4 col-lg-3 p-0">
    <div class="ps-product--standard">
        <a href="{{ route('product.detail', $product['code']) }}">
            <img class="ps-product__thumbnail" src="{{ asset($product->media->first()['url']) }}" alt="{{ $product['name'] }}" />
        </a>
        @if ($product->isNew())
            <span class="ps-badge ps-product__new">New </span>
        @endif
        @if ($product->isDiscounted())
            <span class="ps-badge ps-product__offbadge">{{ $product->getDiscountedPercent() }}% Off </span>
        @endif
        <div class="ps-product__content">
            <h5><a class="ps-product__name" href="{{ route('product.detail', $product['code']) }}">{{ $product['name'] }}</a></h5>
            @if ($product->isDiscounted())
            <p class="ps-product-price-block"><span class="ps-product__sale">₦{{ $product->getFormattedDiscountedPrice() }}</span><span class="ps-product__price">₦{{ $product->getFormattedActualPrice() }}</span><span class="ps-product__off" style="font-size: 11px">{{ $product->getDiscountedPercent() }}% Off</span></p>
            @else
                <p class="ps-product-price-block"><span class="ps-product__price-default">₦{{ $product->getFormattedDiscountedPrice() }}</span>
                </p>
            @endif
        </div>
        <div class="ps-product__footer">
            @if ($product['in_stock'])
            <div class="def-number-input number-input safari_only">
                <button class="minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()"><i class="icon-minus"></i></button>
                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                <button class="plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()"><i class="icon-plus"></i></button>
            </div>
            <button onclick="addToCart({{ $product['id'] }}, this.parentNode.querySelector('input[type=number]').value)" class="mt-5 ps-product__addcart" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Add to cart</button>
            @else
            <button class="mt-4 ps-product__addcart" style="background: #e91313" data-toggle="modal" data-target="#popupAddToCart"><i class="icon-cart"></i>Out of Stock</button>
            @endif
            <div class="ps-product__box">
                <a class="ps-product__wishlist" onclick="addToWishlist({{ $product['id'] }})" href="javascript:void(0);">Wishlist</a>
            </div>
        </div>
    </div>
</div>