<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="apple-touch-icon.html" rel="apple-touch-icon">
    <link rel="shortcut icon" href="{{ asset('logo/5.png') }}">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    @yield('styles')
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&amp;amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fonts/Linearicons/Font/demo-files/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nouislider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jquery-bar-rating/dist/themes/fontawesome-stars.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl-carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/lightGallery/dist/css/lightgallery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

@php
    $categories = \App\Models\Category::with('subCategories')->get();
    $topSellingSubCategories = \App\Models\SubCategory::with(['products', 'category'])->get()->sortBy(function($subCategory)
    {
        return $subCategory->products->count();
    })->take(5);
    $settings = App\Models\Setting::first();
@endphp

<body>
    <header class="header">
        <div class="ps-top-bar">
            <div class="container">
                <div class="top-bar">
                    <div class="top-bar__left">
                        <ul class="nav-top">
                            <li class="nav-top-item"><a class="nav-top-link" href="#">{{ env('APP_NAME') }}: {{ \App\Models\Setting::first()['motto'] ?? 'No 1 automobile part store in Nigeria.' }}</a></li>
                        </ul>
                    </div>
                    <div class="top-bar__right">
                        <ul class="nav-top">
                            @if ($settings['phone_1'])<li class="nav-top-item contact"><a class="nav-top-link" href="tel:{{ $settings['phone_1'] }}"> <i class="icon-telephone"></i><span>Hotline:</span><span class="text-success font-bold">{{ $settings['phone_1'] }}</span></a></li>@endif
                            <li class="nav-top-item"><a class="nav-top-link" href="/order-tracking">Order Tracking</a></li>
                            @guest
                                <li class="nav-top-item"><a class="nav-top-link pr-1" href="/login"><i class="icon-user"></i> Login</a><a class="nav-top-link px-0" href="/register"> / Register</a> </li>
                            @else
                                <li class="nav-top-item account"><a class="nav-top-link" href="javascript:void(0);"> <i class="icon-user"></i>Hi! <span class="font-bold">{{ auth()->user()->getDisplayName() }}</span></a>
                                    <div class="account--dropdown">
                                        <div class="account-anchor">
                                            <div class="triangle"></div>
                                        </div>
                                        <div class="account__content">
                                            <ul class="account-list">
                                                <li class="title-item"><a href="javascript:void(0);">My Account</a></li>
                                                <li><a href="/account">Profile</a></li>
                                                <li><a href="/orders">Orders</a></li>
                                                <li><a href="/wishlist">Wishlist</a></li>
                                            </ul>
                                            <hr><a class="account-logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="javascript:void(0)"><i class="icon-exit-left"></i>Log out</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="ps-header--center header--mobile">
            <div class="container">
                <div class="header-inner">
                    <div class="header-inner__left">
                        <button class="navbar-toggler"><i class="icon-menu"></i></button>
                    </div>
                    <div class="header-inner__center"><a class="logo open" href="/"><img class="img-fluid" width="200px" src="{{ asset($settings->store_logo ?? null) }}" alt="Logo"></a></div>
                    <div class="header-inner__right">
                        <button class="button-icon icon-sm search-mobile"><i class="icon-magnifier"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <section class="ps-header--center header-desktop">
            <div class="container">
                <div class="header-inner">
                    <div class="header-inner__left"><a class="logo" href="/"><img class="img-fluid" width="200px" src="{{ asset($settings->store_logo ?? null) }}" alt="Logo"></a>
                        <ul class="menu">
                            <li class="menu-item-has-children has-mega-menu">
                                <button class="category-toggler"><i class="icon-menu"></i></button>
                                <div class="mega-menu mega-menu-category">
                                    <ul class="menu--mobile menu--horizontal">
                                        <li class="daily-deals category-item"><a href="/new-arrivals">New Arrivals</a></li>
                                        <li class="category-item"><a class="active" href="/top-selling">Top Selling</a></li>
                                        @foreach ($categories as $category)
                                            <li class="has-mega-menu category-item"><a href="{{ route('category.products', $category['name']) }}">{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                                <div class="mega-menu">
                                                    <div class="mega-anchor"></div>
                                                    <div class="mega-menu__column">
                                                        <h4>{{ $category['name'] }}<span class="sub-toggle"></span></h4>
                                                        <ul class="sub-menu--mega">
                                                            @foreach ($category->subCategories as $subCategory)
                                                                <li><a href="{{ route('category.products', ['category' => $category, 'subcategory' => $subCategory['name']]) }}">{{ $subCategory['name'] }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="header-inner__center">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="header-search-select"><span class="current">All<i class="icon-chevron-down"></i></span>
                                    <ul class="list">
                                        <li class="category-option active" data-value="option"><a href="javascript:void(0);">All</a></li>
                                        @foreach ($categories as $category)
                                            <li class="category-option"><a href="{{ route('category.products', $category) }}">{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                                <ul>
                                                    @foreach ($category->subCategories as $subCategory)
                                                        <li><a href="{{ route('category.products', ['category' => $category, 'subcategory' => $subCategory['name']]) }}">{{ $subCategory['name'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div><i class="icon-magnifier search"></i>
                            </div>
                            <input oninput="searchProduct(this.value)" class="form-control input-search" placeholder="I'm searching for...">
                            <div class="input-group-append">
                                <button class="btn">Search</button>
                            </div>
                        </div>
                        @if (count($topSellingSubCategories) > 0)
                        <div class="trending-search">
                            <ul class="list-trending">
                                <li class="title"><a>Top selling subcategories: </a></li>
                                @foreach ($topSellingSubCategories as $topSellingSubCategory)
                                <li class="trending-item"><a href="{{ route('category.products', ['category' => $topSellingSubCategory->category, 'subcategory' => $topSellingSubCategory['name']]) }}">{{ $topSellingSubCategory['name'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="result-search">
                            <ul class="list-result web">
                            </ul>
                        </div>
                    </div>
                    <div class="header-inner__right">
                        <a class="button-icon icon-md" href="/wishlist"><i class="icon-heart"></i><span class="badge bg-warning wishlist-items-count"></span></a>
                        <div class="button-icon btn-cart-header"><i class="icon-cart icon-shop5"></i><span class="badge bg-warning cart-items-count"></span>
                            <div class="mini-cart">
                                <div class="mini-cart--content">
                                    <div class="mini-cart--overlay"></div>
                                    <div class="mini-cart--slidebar cart--box">
                                        <div class="mini-cart__header">
                                            <div class="cart-header-title">
                                                <h5>Shopping Cart(<span class="cart-items-count-alt"></span>)</h5><a class="close-cart" href="javascript:void(0);"><i class="icon-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="mini-cart__products">
                                            <div class="out-box-cart">
                                                <div class="triangle-box">
                                                    <div class="triangle"></div>
                                                </div>
                                            </div>
                                            <ul class="list-cart">
                                            </ul>
                                        </div>
                                        <div class="mini-cart__footer row">
                                            <div class="col-6 title">TOTAL</div>
                                            <div class="col-6 text-right cart-total-amount total">₦</div>
                                            <div class="col-12 d-flex"><a class="view-cart" href="/cart">View cart</a><a class="checkout" href="/checkout">Checkout</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <nav class="navigation">
            <div class="container">
                <ul class="menu">
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="/">Home</a></li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="/shop">Shop</a></li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="/new-arrivals">New Arrivals</a></li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="/top-selling">Top Selling</a></li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="/deals">Discounted Deals</a></li>
                </ul>
            </div>
        </nav>
        <div class="mobile-search--slidebar">
            <div class="mobile-search--content">
                <div class="mobile-search__header">
                    <div class="mobile-search-box">
                        <div class="input-group">
                            <input class="form-control" oninput="searchProduct(this.value)" placeholder="I'm shopping for..." id="inputSearchMobile">
                            <div class="input-group-append">
                                <button class="btn"> <i class="icon-magnifier"></i></button>
                            </div>
                        </div>
                        <button class="cancel-search"><i class="icon-cross"></i></button>
                    </div>
                </div>
                <div class="mobile-search__result">
                    <h5> <span class="number-result"></span>search result</h5>
                    <ul class="list-result mobile">
                    </ul>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="ps-footer">
        <div class="container">
            <div class="ps-footer--contact">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <p class="contact__title">Contact Us</p>
                        <p><b><i class="icon-telephone"> </i>Hotline: </b><span>(7:00 - 21:30)</span></p>
                        <p class="telephone">{{ $settings['phone_1'] }}<br>{{ $settings['phone_2'] }}</p>
                        <p> <b>Head office: </b>{{ $settings['address'] }}</p>
                        <p> <b>Email us: </b><a href="mailto:{{ $settings['email'] }}" >{{ $settings['email'] }}</a></p>
                        <div class="mt-4 col-12 d-flex">
                            <a class="icon_social facebook" target="_blank" href="{{ $settings['facebook'] ?? '#' }}"><i class="fa fa-facebook-f"></i></a>
                            <a class="icon_social twitter" target="_blank" href="{{ $settings['twitter'] ?? '#' }}"><i class="fa fa-twitter"></i></a>
                            <a class="icon_social google" target="_blank" href="mailto:{{ $settings['email'] ?? '#' }}"><i class="fa fa-google-plus"></i></a>
                            <a class="icon_social youtube" target="_blank" href="{{ $settings['youtube'] ?? '#' }}"><i class="fa fa-youtube"></i></a>
                            <a class="icon_social google" target="_blank" href="{{ $settings['instagram'] ?? '#' }}"><i class="fa fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <p class="contact__title">Help and Info <span class="footer-toggle"><i class="icon-chevron-down"></i></span></p>
                                <ul class="footer-list">
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                    <li><a href="/order-tracking">Track Order</a></li>
                                    <li><a href="/login">Account</a></li>
                                    <li><a href="#">Marksot Limited</a></li>
                                </ul>
                                <hr>
                            </div>
                            <div class="col-12 col-lg-6">
                                <p class="contact__title">Knowledge Base <span class="footer-toggle"><i class="icon-chevron-down"></i></span></p>
                                <ul class="footer-list">
                                    <li><a href="/faqs">FAQs</a></li>
                                    <li><a href="#">Return Policy</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Shipping Policy</a></li>
                                    <li><a href="#">Term of Use</a></li>
                                </ul>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <p class="contact__title">Newsletter Subscription</p>
                        <p>Join our email subscription now to get updates on <b>promotions </b>and <b>coupons.</b></p>
                        <form action="{{ route('newsletter') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-prepend"><i class="icon-envelope"></i></div>
                                <input class="form-control" type="email" name="email" required placeholder="Enter your email...">
                                <div class="input-group-append">
                                    <button class="btn">Subscribe</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
{{--            <div class="ps-footer--categories">--}}
{{--                @foreach ($categories as $category)--}}
{{--                <div class="categories__list"><b>{{ $category['name'] }}: </b>--}}
{{--                    <ul class="menu--vertical">--}}
{{--                        @foreach ($category->subCategories as $subCategory)--}}
{{--                            <li class="menu-item"><a href="{{ route('category.products', ['category' => $category, 'subcategory' => $subCategory['name']]) }}">{{ $subCategory['name'] }}</a></li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
            <div class="row ps-footer__copyright">
                <div class="col-12 col-lg-6">
                    <div>&copy; {{ date('Y') }} {{ env('APP_NAME') }} All Rights Reversed.</div>
                </div>
                <div class="col-12 col-lg-6 text-lg-right text-left">
                    <div>Powered by <a target="_blank" class="font-weight-bold" href="https://www.softwebdigital.com">Soft-Web Digital</a></div>
                </div>

            </div>
        </div>
    </footer>
    <div class="ps-footer-mobile">
        <div class="menu__content">
            <ul class="menu--footer">
                <li class="nav-item"><a class="nav-link" href="/"><i class="icon-home3"></i><span>Home</span></a></li>
                <li class="nav-item"><a class="nav-link footer-category" href="javascript:void(0);"><i class="icon-list"></i><span>Category</span></a></li>
                <li class="nav-item"><a class="nav-link footer-cart" href="/cart"><i class="icon-cart"></i><span class="badge bg-warning cart-items-count"></span><span>Cart</span></a></li>
                <li class="nav-item"><a class="nav-link" href="/wishlist"><i class="icon-heart"></i><span class="badge bg-warning wishlist-items-count"></span><span>Wishlist</span></a></li>
                @auth
                <li class="nav-item"><a class="nav-link" href="/account"><i class="icon-user"></i><span>Account</span></a></li>
                @endauth
            </ul>
        </div>
    </div>
    <button class="btn scroll-top"><i class="icon-chevron-up"></i></button>
    <div class="ps-preloader" id="preloader">
        <div class="ps-preloader-section ps-preloader-left"></div>
        <div class="ps-preloader-section ps-preloader-right"></div>
    </div>
    <div class="ps-category--mobile">
        <div class="category__header">
            <div class="category__title">All Categories</div><span class="category__close"><i class="icon-cross"></i></span>
        </div>
        <div class="category__content">
            <ul class="menu--mobile">
                <li class="daily-deals category-item"><a href="/deals">Deals</a></li>
                <li class="category-item"><a href="/top-selling">Top Selling</a></li>
                @foreach ($categories as $category)
                <li class="menu-item-has-children category-item"><a href="{{ route('category.products', $category['name']) }}">{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                    <ul class="sub-menu">
                        @foreach ($category->subCategories as $subCategory)
                            <li><a href="{{ route('category.products', ['category' => $category, 'subcategory' => $subCategory['name']]) }}">{{ $subCategory['name'] }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <nav class="navigation--mobile">
        <div class="navigation__header">
            <div class="navigation-title">
                <button class="close-navbar-slide"><i class="icon-arrow-left"></i></button>
                @guest
                <div>
                    <span> <i class="icon-user"></i></span>
                    <span class="account">
                        <a href="/login">Login /</a> <a href="/register">Register</a></span>
                </div>
                @else
                    <div>
                        <span> <i class="icon-user"></i>Hi, </span>
                        <span class="account">{{ auth()->user()->getDisplayName() }}</span>
                        <a class="dropdown-user" href="#" id="dropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-chevron-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownAccount">
                            <a class="dropdown-item" href="/account"><b>My Account</b></a>
                            <a class="dropdown-item" href="/orders">Orders</a>
                            <a class="dropdown-item" href="/wishlist">Wishlist</a>
                            <a class="dropdown-divider"></a>
                            <a class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="javascript:void(0);"><i class="icon-exit-left"></i>Log out</a>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
        <div class="navigation__content">
            <ul class="menu--mobile">
                <li class="menu-item-has-children"><a class="nav-link" href="/">Home</a></li>
                    <li class="menu-item-has-children"><a class="nav-link" href="/shop">Shop</a></li>
                    <li class="menu-item-has-children"><a class="nav-link" href="/new-arrivals">New Arrivals</a></li>
                    <li class="menu-item-has-children"><a class="nav-link" href="/top-selling">Top Selling</a></li>
                    <li class="menu-item-has-children"><a class="nav-link" href="/deals">Discounted Deals</a></li>
                    <li class="menu-item-has-children"><a class="nav-link" href="/order-tracking">Order Tracking</a></li>
            </ul>
        </div>
    </nav>
    <script src="{{ asset('assets/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.matchHeight-min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-bar-rating/dist/jquery.barrating.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/slick/slick.js') }}"></script>
    <script src="{{ asset('assets/plugins/lightGallery/dist/js/lightgallery-all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/nouislider.min.js') }}"></script>
    <!-- custom code-->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/notify.min.js') }}"></script>
    <script>
        const success = {!! json_encode(session('success')) !!};
        const error = {!! json_encode(session('error')) !!};
        const warning = {!! json_encode(session('warning')) !!};
        const info = {!! json_encode(session('info')) !!};
        const errors = {!! json_encode($errors->any()) !!};

        if (success)
            $.notify(success, 'success');
        if (errors)
            $.notify('Invalid input data', 'error');

        if (error)
            $.notify(error, 'error');
        if (warning)
            $.notify(warning, 'warning');
        if (info)
            $.notify(info, 'info');

        let fetchDetailedCart = '{{ request()->route()->getName() ?? null }}' === 'cart';
        let fetchDetailedWishList = '{{ request()->route()->getName() ?? null }}' === 'wishlist';
        fetchCart();
        fetchWishlist();
        function addToCart(id, qty = 1) {
            if (qty < 1) return;
            $.ajax({
                url: `/add-to-cart/${id}`,
                type: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}' },
                data: { quantity: qty },
                dataType: 'json',
                success: function (data) {
                    $.notify("Item added to cart", "success");
                    updateCartView(data);
                    if (fetchDetailedCart) updateDetailedCartView(data);
                },
                error: function (res) {
                    $.notify("There was an error adding item to cart", "error");
                }
            });
        }

        function addToWishlist(id) {
            $.ajax({
                url: `/wishlist/add/${id}`,
                type: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}' },
                dataType: 'json',
                success: function (data) {
                    $.notify("Item wishlisted", "success");
                    updateWishlistView(data);
                    if (fetchDetailedWishList) updateDetailedWishlistView(data);
                },
                error: function (res) {
                    $.notify("There was an error wishlisting item", "error");
                }
            });
        }

        function updateCart(id, qty) {
            if (qty < 1) return;
            $.ajax({
                url: `/update-cart/${id}`,
                type: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}' },
                data: { quantity: qty },
                dataType: 'json',
                success: function (data) {
                    $.notify("Cart item updated", "success");
                    updateCartView(data);
                    if (fetchDetailedCart) updateDetailedCartView(data);
                },
                error: function (res) {
                    $.notify("There was an error updating cart", "error");
                }
            });
        }

        function clearCart() {
            $.ajax({
                url: `/clear-cart`,
                type: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}' },
                dataType: 'json',
                success: function (data) {
                    $.notify("Cart has been cleared", "success");
                    updateCartView(data);
                    if (fetchDetailedCart) updateDetailedCartView(data);
                },
                error: function (res) {
                    $.notify("There was an error clearing cart", "error");
                }
            });
        }

        function removeFromCart(id) {
            $.ajax({
                url: `/remove-from-cart/${id}`,
                type: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}' },
                dataType: 'json',
                success: function (data) {
                    $.notify("Item removed from cart", "success");
                    if (!fetchDetailedCart) $('.mini-cart').addClass('open');
                    updateCartView(data);
                    if (fetchDetailedCart) updateDetailedCartView(data);
                },
                error: function (res) {
                    $('.mini-cart').addClass('open');
                    $.notify("There was an error removing item from cart", "error");
                }
            });
        }

        function removeFromWishlist(id) {
            $.ajax({
                url: `/wishlist/remove/${id}`,
                type: 'POST',
                headers: {'X-CSRF-Token': '{{ csrf_token() }}' },
                dataType: 'json',
                success: function (data) {
                    $.notify("Item removed from wishlist", "success");
                    updateWishlistView(data);
                    if (fetchDetailedWishList) updateDetailedWishlistView(data);
                },
                error: function (res) {
                    $.notify("Error removing item from wishlist", "error");
                }
            });
        }

        function addToCartAndRemoveFromWishlist(id) {
            addToCart(id);
            removeFromWishlist(id);
        }

        function fetchCart() {
            $.ajax({
                url: `/cart/fetch`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    updateCartView(data);
                    if (fetchDetailedCart) updateDetailedCartView(data);
                },
                error: function (res) {
                    $.notify("There was an error fetching your cart", "error");
                }
            });
        }

        function searchProduct(val) {
            $('.result-search').addClass('open');
            if (val.length < 2) {
                $('.list-result').html('<li class="cart-item text-center">Enter Search value</li>');
                $('.number-result').text('0');
                return;
            };
            $.ajax({
                url: `/product/search/${val}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    let html = '';
                    let htmlMobile = '';
                    data.forEach(item => {
                        html += `<li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="/product/${item.code}/details"><img class="ps-product__thumbnail" src="${item.media[0]}" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="/product/${item.code}/details"><u>Organic</u> ${item.name}</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">₦${numberFormat(item.price)}</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>`;
                        htmlMobile += `<li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="/product/${item.code}/details"><img class="ps-product__thumbnail" src="${item.media[0]}" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="/product/${item.code}/details">Avocado <u>Organic</u> ${item.name}</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">₦${numberFormat(item.price)}</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>`;
                    });
                    if (data.length === 0)
                        html = htmlMobile = '<li class="cart-item text-center">No products found</li>';
                    $('.list-result.web').html(html);
                    $('.list-result.mobile').html(htmlMobile);
                    $('.number-result').text(data.length);
                },
                error: function (res) {
                    $.notify("There was an error fetching products", "error");
                }
            });
        }

        function fetchWishlist() {
            $.ajax({
                url: `/wishlist/fetch`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    updateWishlistView(data);
                    if (fetchDetailedWishList) updateDetailedWishlistView(data);
                },
                error: function (res) {
                    $.notify("There was an error fetching your wishlist", "error");
                }
            });
        }


        function updateCartView(data) {
            let html = '';
            let cartTotal = $('.cart-total-amount');
            let cartItemsCount = $('.cart-items-count');
            let cartItemsCountAlt = $('.cart-items-count-alt');
            let count = 0;
            data.items.forEach(item => {
                count += parseInt(item.quantity);
                html += `<li class="cart-item">
                            <div class="ps-product--mini-cart">
                                <a href="/product/${item.product.code}/details">
                                    <img class="ps-product__thumbnail" src="${item.product.media[0]}" alt="alt" />
                                </a>
                                <div class="ps-product__content"><a class="ps-product__name" href="/product/${item.product.code}/details">${item.product.name}</a>
                                    <p class="ps-product__unit">${item.product.weight} Kg</p>
                                    <p class="ps-product__meta"> <span class="ps-product__price">₦${numberFormat(item.product.price)}</span><span class="ps-product__quantity">(x${item.quantity})</span>
                                    </p>
                                </div>
                                <div onclick="removeFromCart(${item.product.id})" class="ps-product__remove"><i class="icon-trash2"></i></div>
                            </div>
                        </li>`;
            });
            cartTotal.text(`₦${numberFormat(data.total)}`);
            if (data.items.length < 1){
                cartItemsCount.hide();
                $('.list-cart').html(`<li class="cart-item text-center">Cart is empty<li>`);
            } else {
                cartItemsCount.show();
                $('.list-cart').html(html);
            };
            cartItemsCount.text(count);
            cartItemsCountAlt.text(count);
        }

        function updateWishlistView(data)
        {
            let wishlistItemsCount = $('.wishlist-items-count');
            wishlistItemsCount.text(data.length);
            if (data.length > 0) {
                wishlistItemsCount.show();
            } else {
                wishlistItemsCount.hide();
            }
        }

        function updateDetailedCartView(data) {
            let html = '';
            data.items.forEach(item => {
                html += ` <div class="shopping-cart-row">
                            <div class="cart-product">
                                <div class="ps-product--mini-cart"><a href="/product/${item.product.code}/details"><img class="ps-product__thumbnail" src="${item.product.media[0]}" alt="alt" /></a>
                                    <div class="ps-product__content">
                                        <h5><a class="ps-product__name" href="/product/${item.product.code}/details">${item.product.name}</a></h5>
                                        <p class="ps-product__unit">${item.product.weight} Kg</p>
                                        <p class="ps-product__meta">Price: <span class="ps-product__price">₦${numberFormat(item.product.price)}</span></p>
                                        <div class="def-number-input number-input safari_only">
                                            <button class="minus" onclick="updateCart(${item.product.id}, (parseInt(this.parentNode.querySelector('input[type=number]').value) - 1))"><i class="icon-minus"></i></button>
                                            <input class="quantity" min="0" name="quantity" value="${item.quantity}" type="number" />
                                            <button class="plus" onclick="updateCart(${item.product.id}, (parseInt(this.parentNode.querySelector('input[type=number]').value) + 1))"><i class="icon-plus"></i></button>
                                        </div><span class="ps-product__total">Total: <span>₦${numberFormat(item.product.price * item.quantity)}</span></span>
                                    </div>
                                    <div onclick="removeFromCart(${item.product.id})" class="ps-product__remove"><i class="icon-trash2"></i></div>
                                </div>
                            </div>
                            <div class="cart-price"><span class="ps-product__price">₦${numberFormat(item.product.price)}</span>
                            </div>
                            <div class="cart-quantity">
                                <div class="def-number-input number-input safari_only">
                                    <button class="minus" onclick="updateCart(${item.product.id}, (parseInt(this.parentNode.querySelector('input[type=number]').value) - 1))"><i class="icon-minus"></i></button>
                                    <input class="quantity" min="0" name="quantity" value="${item.quantity}" type="number" />
                                    <button class="plus" onclick="updateCart(${item.product.id}, (parseInt(this.parentNode.querySelector('input[type=number]').value) + 1))"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                            <div class="cart-total"> <span class="ps-product__total">₦${numberFormat(item.product.price * item.quantity)}</span>
                            </div>
                            <div onclick="removeFromCart(${item.product.id})" class="cart-action"><i class="icon-trash2"></i></div>
                        </div>`;
            });
            if (data.items.length < 1){
                $('.shopping-cart-body').html(`<div class="cart-item text-center py-3">Cart is empty<div>`);
            } else {
                $('.shopping-cart-body').html(html);
            };
        }

        function updateDetailedWishlistView(data) {
            let html = '';
            let htmlMobile = '';
            data.forEach(item => {
                html += `<tr>
                            <td>
                                <div onclick="removeFromWishlist(${item.id})" class="wishlist__trash"><i class="icon-trash2"></i></div>
                            </td>
                            <td>
                                <div class="ps-product--vertical"><a href="/product/${item.code}/details"><img class="ps-product__thumbnail" src="${item.media[0]}" alt="alt" /></a>
                                    <div class="ps-product__content">
                                        <h5><a class="ps-product__name" href="/product/${item.code}/details">${item.name}</a></h5>
                                        <p class="ps-product__unit">${item.weight}Kg</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="ps-product__price-sale">₦${numberFormat(item.price)}</span><span class="ps-product__is-sale mx-1">₦${numberFormat(item.actualPrice)}</span>
                            </td>
                            <td><span class="ps-product__${item.inStock ? 'instock' : 'ofstock'}">${item.inStock ? 'In stock' : 'Out of stock'}</span>
                            </td>
                            <td>
                                <button onclick="addToCartAndRemoveFromWishlist(${item.id})" class="btn wishlist__btn add-cart"><i class="icon-cart"></i>Add to cart</button>
                            </td>
                        </tr>`;
                htmlMobile += `<div class="col-6 col-md-4 p-0">
                                <div class="ps-product--standard"><a class="ps-product__trash" onclick="removeFromWishlist(${item.id})" href="javascript:void(0);"><i class="icon-trash2"></i></a><a href="/product/${item.code}/details"><img class="ps-product__thumbnail" src="${item.media[0]}" alt="alt" /></a>
                                    <div class="ps-product__content">
                                        <p class="ps-product__${item.inStock ? 'instock' : 'ofstock'}">${item.inStock ? 'In stock' : 'Out of stock'}</p><a href="/product/${item.code}/details">
                                            <h5 class="ps-product__name">${item.name}</h5>
                                        </a>
                                        <p class="ps-product__unit">${item.weight}Kg</p>
                                        <p class="ps-product__meta"><span class="ps-product__price">₦${numberFormat(item.price)}</span></p>
                                    </div>
                                    <div class="ps-product__footer">
                                        <button onclick="addToCartAndRemoveFromWishlist(${item.id})" class="ps-product__addcart">Add to cart</button>
                                    </div>
                                </div>
                            </div>`;
            });
            if (data.length < 1){
                $('.wishlist__tbody').html(`<tr class="cart-item text-center py-3"><td colspan="5">Wishlist is empty</td><tr>`);
                $('.wishlist__product--mobile-products').html(`<div class="col-12 text-center py-3">Wishlist is empty<div>`);
            } else {
                $('.wishlist__tbody').html(html);
                $('.wishlist__product--mobile-products').html(htmlMobile);
            };
        }

        function numberFormat(amount, decimal = ".", thousands = ",") {
            try {
                amount = Number.parseFloat(amount);
                let decimalCount = Number.isInteger(amount) ? 0 : amount.toString().split('.')[1].length;
                const negativeSign = amount < 0 ? "-" : "";
                let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                let j = (i.length > 3) ? i.length % 3 : 0;
                return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
            } catch (e) {
                console.log(e)
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
