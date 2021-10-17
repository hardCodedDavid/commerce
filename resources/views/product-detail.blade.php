@extends('layouts.user')

@section('title', ucwords($product['name']))

@section('content')

@php
    use App\Models\Variation;

    $variations = Variation::all();
    $count = $product->reviews()->where('status', 'approved')->count();
    $rating = $count > 0 ? $product->reviews()->where('status', 'approved')->sum('rating')/$count : 0;
    $rate5 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '>=', 4.5)->count()/$count) * 100, 2) : 0;
    $rate4 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '>=', 3.5)->where('rating', '<', 4.5)->count()/$count) * 100, 2) : 0;
    $rate3 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '>=', 2.5)->where('rating', '<', 3.5)->count()/$count) * 100, 2) : 0;
    $rate2 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '>=', 1.5)->where('rating', '<', 2.5)->count()/$count) * 100, 2) : 0;
    $rate1 = $count > 0 ? round((float) ($product->reviews()->where('status', 'approved')->where('rating', '<', 1.5)->count()/$count) * 100, 2) : 0;
    if (auth()->check())
        $recent = json_decode(auth()->user()['recent_views'], true) ?? [];
    else
        $recent = json_decode(session('recent_views'), true) ?? [];
@endphp


<main class="no-main">
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="ps-breadcrumb__list">
                <li class="active"><a href="/">Home</a></li>
                <li class="active"><a href="/shop">Shop</a></li>
                <li><a href="javascript:void(0);">{{ $product['name'] }}</a></li>
            </ul>
        </div>
    </div>
    <section class="section--product-type section-product--default">
        <div class="container">
            <div class="product__header">
                <h3 class="product__name">{{ $product['name'] }}</h3>
                <div class="row">
                    <div class="col-12 col-lg-7 product__code">
                        <select class="rating-stars">
                            <option value=""></option>
                            <option value="1" {{ ($rating > 0 && $rating < 1.5) ? 'selected' : '' }}>1</option>
                            <option value="2" {{ ($rating >= 1.5 && $rating < 2.5) ? 'selected' : '' }}>2</option>
                            <option value="3" {{ ($rating >= 2.5 && $rating < 3.5) ? 'selected' : '' }}>3</option>
                            <option value="4" {{ ($rating >= 3.5 && $rating < 4.5) ? 'selected' : '' }}>4</option>
                            <option value="5" {{ $rating >= 4.5 ? 'selected' : '' }}>5</option>
                        </select><span class="product__review">{{ $count }} Customer Review</span><span class="product__id">SKU: <span>{{ $product['sku'] ?? '------' }}</span></span>
                    </div>
                    <div class="col-12 col-lg-5">
                        <div class="ps-social--share">
                            <div id="fb-root"></div>
                            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v11.0" nonce="z5gm17mX"></script>
                            <div class="fb-share-button" data-href="{{ route('product.detail', $product['code']) }}" data-layout="button" data-size="small">
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(route('product.detail', $product['code'])) }}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
                            </div>
                            <a class="ps-social__icon twitter " target="_blank"
                               href="https://twitter.com/share?ref_src=twsrc%5Etfw&text={{ $product['name'] }}&url={{ route('product.detail', $product['code']) }}"
                               data-url="{{ route('product.detail', $product['code']) }}"
                               data-show-count="false">
                                <i class="fa fa-twitter"></i><span>Share</span>
                            </a>
                        </div>
                    </div>
                </div>
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

                                    <div class="ps-product__variable"><span>Weight:  {{ round($product['weight'], 2) }}Kg</span></div>

                                    <div class="ps-product__avai alert__success">Availability: <span>{{ number_format($product['quantity']) }} in stock</span></div>
                                    <div class="mb-2">{{ $product['description'] }}</div>
                                    <div class="ps-product__info">
                                        <ul class="ps-list--rectangle">
                                            @if ($product->brands()->count() > 0)
                                            <li class="list-item"> <span><i class="icon-square"></i></span>Brands: @foreach ($product->brands()->get() as $brand)
                                                <span style="font-size: 12px" class="mx-1 bg-light">{{ $brand['name'] }}</span>
                                            @endforeach</li>
                                            @endif
                                            @foreach ($variations as $variation)
                                                @if ($product->variationItems()->where('variation_id', $variation['id'])->count() > 0)
                                                    <li> <span><i class="icon-square mr-1"></i> </span> {{ $variation['name'] }}: @foreach ($product->variationItems()->where('variation_id', $variation['id'])->get() as $item)
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
                                            <li>Brands:
                                                @foreach($product->brands as $brand)
                                                    <a href="javascript:void(0)" class='text-success'>{{ $brand['name'] ?? '' }}</a>
                                                @endforeach
                                            </li>
                                            <li>Categories:
                                                @foreach ($product->categories()->get() as $category)
                                                    <a href="{{ route('category.products', $category) }}" style="font-size: 12px" class="mx-1 bg-light">{{ $category['name'] }}</a>
                                                @endforeach
                                            </li>
                                            <li>Tags:
                                                @foreach($product->subcategories()->get() as $subcategory)
                                                    <a href='{{ route('category.products', ['category' => $subcategory->category, 'subcategory' => $subcategory['name']]) }}' style="font-size: 12px" class="mx-1 bg-light">{{ $subcategory['name'] }}</a>
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="ps-product__footer">
                                        <a class="ps-product__shop" href="/shop"><i class="icon-store"></i><span>Shop</span></a>
                                        @if ($product['in_stock'])
                                            <a class="ps-product__addcart ps-button" onclick="addToCart({{ $product['id'] }}, document.querySelector('#singleProductQty').value)"><i class="icon-cart"></i>Add to cart</a>
                                            <a class="ps-product__shop" href="{{ route('checkout') }}" title="checkout"><i class="icon-exit"></i><span>Checkout</span></a>
                                        @else
                                            <a class="ps-product__addcart ps-button" style="background: #e91313"><i class="icon-cart"></i>Out of Stock</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="ps-product--extention">
{{--                            <div class="extention__block">--}}
{{--                                <div class="extention__item">--}}
{{--                                    <div class="extention__icon"><i class="icon-truck"></i></div>--}}
{{--                                    <div class="extention__content"> <b class="text-black">Free Shipping </b>apply to all orders over <span class="text-success">$100</span></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="extention__block">--}}
{{--                                <div class="extention__item">--}}
{{--                                    <div class="extention__icon"><i class="icon-leaf"></i></div>--}}
{{--                                    <div class="extention__content">Guranteed <b class="text-black">100% Organic </b>from natural farmas </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="extention__block">--}}
{{--                                <div class="extention__item border-none">--}}
{{--                                    <div class="extention__icon"><i class="icon-repeat-one2"></i></div>--}}
{{--                                    <div class="extention__content"> <b class="text-black">1 Day Returns </b>if you change your mind</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="extention__block">
                                <div class="extention__item">
                                    <div class="extention__content"> 7% discount on shipping for products above N220,000.</div>
                                </div>
                            </div>
                            <div class="extention__block">
                                <div class="extention__item">
                                    <div class="extention__content"> Fast and reliable repair services for mobile phones. </div>
                                </div>
                            </div>
                            <div class="extention__block">
                                <div class="extention__item">
                                    <div class="extention__content"> 3 days free return for products with the seal still intact </div>
                                </div>
                            </div>
                            <div class="extention__block">
                                <div class="extention__item border-none">
                                    <div class="extention__content"> Manufacturer warranty on all products. </div>
                                </div>
                            </div>
                            <div class="extention__block extention__contact">
                                <p> <span class="text-black">Hotline Order: </span>Free 7:00-21:30</p>
                                <h4 class="extention__phone">{{ \App\Models\Setting::first()->phone_1 }}</h4>
                                <h4 class="extention__phone">{{ \App\Models\Setting::first()->phone_2 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="product__content">
                <ul class="nav nav-pills" role="tablist" id="productTabDetail">
                    <li class="nav-item"><a class="nav-link active" id="description-tab" data-toggle="tab" href="#description-content" role="tab" aria-controls="description-content" aria-selected="true">Description</a></li>
                    <li class="nav-item"><a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews-content" role="tab" aria-controls="reviews-content" aria-selected="false">Reviews({{ $count }})</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="description-content" role="tabpanel" aria-labelledby="description-tab">
                        @if($product->full_description)
                            {!! $product->full_description !!}
                        @else
                            <h5>No Description</h5>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="reviews-content" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="ps-product--reviews">
                            <div class="row">
                                <div class="col-12 col-lg-5">
                                    <div class="review__box">
                                        <div class="product__rate">{{ number_format((float) $rating, 2, '.', '') }}</div>
                                        <select class="rating-stars">
                                            <option value=""></option>
                                            <option value="1" {{ ($rating > 0 && $rating < 1.5) ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ ($rating >= 1.5 && $rating < 2.5) ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ ($rating >= 2.5 && $rating < 3.5) ? 'selected' : '' }}>3</option>
                                            <option value="4" {{ ($rating >= 3.5 && $rating < 4.5) ? 'selected' : '' }}>4</option>
                                            <option value="5" {{ $rating >= 4.5 ? 'selected' : '' }}>5</option>
                                        </select>
                                        <p>Avg. Star Rating: <b class="text-black">({{ $count }} reviews)</b></p>
                                        <div class="review__progress">
                                            <div class="progress-item"><span class="star">5 Stars</span>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $rate5 }}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div><span class="percent">{{ $rate5 }}%</span>
                                            </div>
                                            <div class="progress-item"><span class="star">4 Stars</span>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $rate4 }}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div><span class="percent">{{ $rate4 }}%</span>
                                            </div>
                                            <div class="progress-item"><span class="star">3 Stars</span>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $rate3 }}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div><span class="percent">{{ $rate3 }}%</span>
                                            </div>
                                            <div class="progress-item"><span class="star">2 Stars</span>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $rate2 }}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div><span class="percent">{{ $rate2 }}%</span>
                                            </div>
                                            <div class="progress-item"><span class="star">1 Stars</span>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $rate1 }}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div><span class="percent">{{ $rate1 }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-7">
                                    <div class="review__title">Add A Review</div>
                                    <p class="mb-0">Your email will not be published. Required fields are marked <span class="text-danger">*</span></p>
                                    <form method="post" action="{{ route('product.review', $product->id) }}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-12 form-group--block">
                                                <div class="input__rating">
                                                    <label>Your rating: <span>*</span></label>
                                                    <select class="rating-stars" onchange="$('#rating').val($(this).val()); console.log($(this).val())">
                                                        <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1</option>
                                                        <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2</option>
                                                        <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3</option>
                                                        <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4</option>
                                                        <option value="5" {{ !in_array(old('rating'), [1,2,3,4]) ? 'selected' : '' }}>5</option>
                                                    </select>
                                                    <input type="hidden" name="rating" id="rating" value="5">
                                                </div>
                                            </div>
                                            <div class="col-12 form-group--block">
                                                <label for="review">Review: <span>*</span></label>
                                                <textarea class="form-control" name="review" id="review" required>{{ old('review') }}</textarea>
                                                @error('review') <span class="text-danger" role="alert">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-12 col-lg-6 form-group--block">
                                                <label for="name">Name: <span>*</span></label>
                                                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required>
                                                @error('name') <span class="text-danger" role="alert">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-12 col-lg-6 form-group--block">
                                                <label for="email">Email:</label>
                                                <input class="form-control" name="email" id="email" type="email" value="{{ old('email') }}">
                                                @error('email') <span class="text-danger" role="alert">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-12 form-group--block">
                                                <button class="btn ps-button ps-btn-submit">Submit Review</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="ps--comments">
                                <h5 class="comment__title">{{ $count }} Comments</h5>
                                <ul class="comment__list">
                                    @foreach($product->reviews()->where('status', 'approved')->latest()->get()->take(5) as $comment)
                                        <li class="comment__item">
                                            <div class="item__avatar"><img src="{{ $comment['email'] ? \App\Http\Controllers\HomeController::getAvatar($comment['email']) : asset('assets/img/avatar.png') }}" style="border-radius: 100%;" alt="alt" /></div>
                                            <div class="item__content">
                                                <div class="item__name">{{ $comment->name }}</div>
                                                <div class="item__date">- {{ \Carbon\Carbon::make($comment->created_at)->format('M d, Y') }}</div>
{{--                                                <div class="item__check"> <i class="icon-checkmark-circle"></i>Verified Purchase</div>--}}
                                                <div class="item__rate">
                                                    <select class="rating-stars">
                                                        <option value="1" {{ ((float) $comment['rating'] > 0 && (float) $comment['rating'] < 1.5) ? 'selected' : '' }}>1</option>
                                                        <option value="2" {{ ((float) $comment['rating'] >= 1.5 && (float) $comment['rating'] < 2.5) ? 'selected' : '' }}>2</option>
                                                        <option value="3" {{ ((float) $comment['rating'] >= 2.5 && (float) $comment['rating'] < 3.5) ? 'selected' : '' }}>3</option>
                                                        <option value="4" {{ ((float) $comment['rating'] >= 3.5 && (float) $comment['rating'] < 4.5) ? 'selected' : '' }}>4</option>
                                                        <option value="5" {{ (float) $comment['rating'] >= 4.5 ? 'selected' : '' }}>5</option>
                                                    </select>
                                                </div>
                                                <p class="item__des">{!! $comment['review'] !!}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <section class="section-recent--default ps-home--block">
        <div class="container">
            <div class="ps-block__header">
                <h3 class="ps-block__title">Your Recent Viewed</h3><a class="ps-block__view" href="{{ route('recentlyViewed') }}">View all <i class="icon-chevron-right"></i></a>
            </div>
            <div class="recent__content">
                <div class="owl-carousel" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="true" data-owl-item="8" data-owl-item-xs="3" data-owl-item-sm="3" data-owl-item-md="5" data-owl-item-lg="8" data-owl-item-xl="8" data-owl-duration="1000" data-owl-mousedrag="on">
                    @foreach($recent as $product)
                        <a class="recent-item" href="{{ route('product.detail', $product['code']) }}"><img src="{{ asset($product['media'][0]['url'] ?? null) }}" height="100" alt="" /></a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
