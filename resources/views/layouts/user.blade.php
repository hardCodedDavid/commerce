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
    <title>{{ getenv('APP_NAME') }} - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&amp;amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fonts/Linearicons/Font/demo-files/demo.css') }}">
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
@endphp

<body>
    <header class="header">
        <div class="ps-top-bar">
            <div class="container">
                <div class="top-bar">
                    <div class="top-bar__right">
                        <ul class="nav-top">
                            <li class="nav-top-item contact"><a class="nav-top-link" href="tel:970978-6290"> <i class="icon-telephone"></i><span>Hotline:</span><span class="text-success font-bold">970 978-6290</span></a></li>
                            <li class="nav-top-item"><a class="nav-top-link" href="order-tracking.html">Order Tracking</a></li>
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
                                                <li><a href="#">Profile</a></li>
                                                <li><a href="/cart">Orders</a></li>
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
                    <div class="header-inner__center"><a class="logo open" href="index.html"><img class="img-fluid" width="200px" src="{{ asset('logo/1.png') }}" alt="Logo"></span></a></div>
                    <div class="header-inner__right">
                        <button class="button-icon icon-sm search-mobile"><i class="icon-magnifier"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <section class="ps-header--center header-desktop">
            <div class="container">
                <div class="header-inner">
                    <div class="header-inner__left"><a class="logo" href="index.html"><img class="img-fluid" width="200px" src="{{ asset('logo/1.png') }}" alt="Logo"></a>
                        <ul class="menu">
                            <li class="menu-item-has-children has-mega-menu">
                                <button class="category-toggler"><i class="icon-menu"></i></button>
                                <div class="mega-menu mega-menu-category">
                                    <ul class="menu--mobile menu--horizontal">
                                        <li class="daily-deals category-item"><a href="flash-sale.html">Daily Deals</a></li>
                                        <li class="category-item"><a href="shop-categories.html">Top Promotions</a></li>
                                        <li class="category-item"><a class="active" href="shop-categories.html">New Arrivals</a></li>
                                        @foreach ($categories as $category)
                                            <li class="has-mega-menu category-item"><a href="javascript:void(0);">{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                                <div class="mega-menu">
                                                    <div class="mega-anchor"></div>
                                                    <div class="mega-menu__column">
                                                        <h4>{{ $category['name'] }}<span class="sub-toggle"></span></h4>
                                                        <ul class="sub-menu--mega">
                                                            @foreach ($category->subCategories as $subCategory)
                                                                <li><a href="shop-view-grid.html">{{ $subCategory['name'] }}</a></li>
                                                            @endforeach
                                                            <li class="see-all"><a href="shop-view-grid.html">See all products <i class='icon-chevron-right'></i></a></li>
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
                                            <li class="category-option"><a>{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                                <ul>
                                                    @foreach ($category->subCategories as $subCategory)
                                                        <li><a href="#">{{ $subCategory['name'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div><i class="icon-magnifier search"></i>
                            </div>
                            <input class="form-control input-search" placeholder="I'm searching for...">
                            <div class="input-group-append">
                                <button class="btn">Search</button>
                            </div>
                        </div>
                        <div class="result-search">
                            <ul class="list-result">
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_18a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html"><u>Organic</u> Large Green Bell Pepper</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">$6.90</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_16a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Avocado <u>Organic</u> Hass Large</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">$12.90</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_32a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Tailgater Ham <u>Organic</u> Sandwich</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">$33.49</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_6a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Extreme <u>Organic</u> Light Can</a>
                                            <p class="ps-product__rating">
                                                <select class="rating-stars">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4" selected="selected">4</option>
                                                    <option value="5">5</option>
                                                </select><span>(16)</span>
                                            </p>
                                            <p class="ps-product__meta"> <span class="ps-product__price-sale">$4.99</span><span class="ps-product__is-sale">$8.99</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="cart-item">
                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_22a.jpg" alt="alt" /></a>
                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Extreme <u>Organic</u> Light Can</a>
                                            <p class="ps-product__meta"> <span class="ps-product__price">$12.99</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="header-inner__right">
                        <a class="button-icon icon-md" href="/wishlist"><i class="icon-heart"></i><span class="badge bg-warning">2</span></a>
                        <div class="button-icon btn-cart-header"><i class="icon-cart icon-shop5"></i><span class="badge bg-warning">3</span>
                            <div class="mini-cart">
                                <div class="mini-cart--content">
                                    <div class="mini-cart--overlay"></div>
                                    <div class="mini-cart--slidebar cart--box">
                                        <div class="mini-cart__header">
                                            <div class="cart-header-title">
                                                <h5>Shopping Cart(3)</h5><a class="close-cart" href="javascript:void(0);"><i class="icon-arrow-right"></i></a>
                                            </div>
                                        </div>
                                        <div class="mini-cart__products">
                                            <div class="out-box-cart">
                                                <div class="triangle-box">
                                                    <div class="triangle"></div>
                                                </div>
                                            </div>
                                            <ul class="list-cart">
                                                <li class="cart-item">
                                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_18a.jpg" alt="alt" /></a>
                                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Extreme Budweiser Light Can</a>
                                                            <p class="ps-product__unit">500g</p>
                                                            <p class="ps-product__meta"> <span class="ps-product__price">$3.90</span><span class="ps-product__quantity">(x1)</span>
                                                            </p>
                                                        </div>
                                                        <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                                    </div>
                                                </li>
                                                <li class="cart-item">
                                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_31a.jpg" alt="alt" /></a>
                                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Honest Organic Still Lemonade</a>
                                                            <p class="ps-product__unit">100g</p>
                                                            <p class="ps-product__meta"> <span class="ps-product__price-sale">$5.99</span><span class="ps-product__is-sale">$8.99</span><span class="quantity">(x1)</span>
                                                            </p>
                                                        </div>
                                                        <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                                    </div>
                                                </li>
                                                <li class="cart-item">
                                                    <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_16a.jpg" alt="alt" /></a>
                                                        <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Matures Own 100% Wheat</a>
                                                            <p class="ps-product__unit">1.5L</p>
                                                            <p class="ps-product__meta"> <span class="ps-product__price">$12.90</span><span class="ps-product__quantity">(x1)</span>
                                                            </p>
                                                        </div>
                                                        <div class="ps-product__remove"><i class="icon-trash2"></i></div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mini-cart__footer row">
                                            <div class="col-6 title">TOTAL</div>
                                            <div class="col-6 text-right total">$29.98</div>
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
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="#">Top Selling</a></li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="#">Discounted Deals</a></li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="#">About Us</a></li>
                    <li class="menu-item-has-children has-mega-menu"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
            </div>
        </nav>
        <div class="mobile-search--slidebar">
            <div class="mobile-search--content">
                <div class="mobile-search__header">
                    <div class="mobile-search-box">
                        <div class="input-group">
                            <input class="form-control" placeholder="I'm shopping for..." id="inputSearchMobile">
                            <div class="input-group-append">
                                <button class="btn"> <i class="icon-magnifier"></i></button>
                            </div>
                        </div>
                        <button class="cancel-search"><i class="icon-cross"></i></button>
                    </div>
                </div>
                <div class="mobile-search__result">
                    <h5> <span class="number-result">5</span>search result</h5>
                    <ul class="list-result">
                        <li class="cart-item">
                            <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_18a.jpg" alt="alt" /></a>
                                <div class="ps-product__content"><a class="ps-product__name" href="product-default.html"><u>Organic</u> Large Green Bell Pepper</a>
                                    <p class="ps-product__rating">
                                        <select class="rating-stars">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3" selected="selected">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select><span>(5)</span>
                                    </p>
                                    <p class="ps-product__meta"> <span class="ps-product__price">$6.90</span>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="cart-item">
                            <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_16a.jpg" alt="alt" /></a>
                                <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Avocado <u>Organic</u> Hass Large</a>
                                    <p class="ps-product__meta"> <span class="ps-product__price">$12.90</span>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="cart-item">
                            <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_32a.jpg" alt="alt" /></a>
                                <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Tailgater Ham <u>Organic</u> Sandwich</a>
                                    <p class="ps-product__meta"> <span class="ps-product__price">$33.49</span>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="cart-item">
                            <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_6a.jpg" alt="alt" /></a>
                                <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Extreme <u>Organic</u> Light Can</a>
                                    <p class="ps-product__rating">
                                        <select class="rating-stars">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4" selected="selected">4</option>
                                            <option value="5">5</option>
                                        </select><span>(16)</span>
                                    </p>
                                    <p class="ps-product__meta"> <span class="ps-product__price-sale">$4.99</span><span class="ps-product__is-sale">$8.99</span>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="cart-item">
                            <div class="ps-product--mini-cart"><a href="product-default.html"><img class="ps-product__thumbnail" src="/assets/img/products/01-Fresh/01_22a.jpg" alt="alt" /></a>
                                <div class="ps-product__content"><a class="ps-product__name" href="product-default.html">Extreme <u>Organic</u> Light Can</a>
                                    <p class="ps-product__meta"> <span class="ps-product__price">$12.99</span>
                                    </p>
                                </div>
                            </div>
                        </li>
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
                    <div class="col-12 col-lg-6">
                        <p class="contact__title">Contact Us</p>
                        <p><b><i class="icon-telephone"> </i>Hotline: </b><span>(7:00 - 21:30)</span></p>
                        <p class="telephone">097 978-6290<br>097 343-8888</p>
                        <p> <b>Head office: </b>8049 High Ridge St. Saint Joseph, MI 49085</p>
                        <p> <b>Email us: </b><a href="http://nouthemes.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="b5c6c0c5c5dac7c1f5d3d4c7d8d4c7c19bd6dad8">[email&#160;protected]</a></p>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <p class="contact__title">Quick Links<span class="footer-toggle"><i class="icon-chevron-down"></i></span></p>
                                <ul class="footer-list">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/shop">Shop</a></li>
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                    <li><a href="#">Policy</a></li>
                                    <li><a href="#">FAQs</a></li>
                                </ul>
                                <hr>
                            </div>
                            <div class="col-12 col-lg-6">
                                <p class="contact__title">Products<span class="footer-toggle"><i class="icon-chevron-down"></i></span></p>
                                <ul class="footer-list">
                                    <li><a href="#">Top Selling</a></li>
                                    <li><a href="#">Discounted Deals</a></li>
                                    <li><a href="#">New Arrivals</a></li>
                                    <li><a href="#">Careers</a></li>
                                    <li><a href="#">Our Suppliers</a></li>
                                    <li><a href="#">Accessibility</a></li>
                                </ul>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-footer--categories">
                @foreach ($categories as $category)
                <div class="categories__list"><b>{{ $category['name'] }}: </b>
                    <ul class="menu--vertical">
                        @foreach ($category->subCategories as $subCategory)
                            <li class="menu-item"><a href="shop-categories.html">{{ $subCategory['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            <div class="row ps-footer__copyright">
                <div class="col-12 col-lg-6 ps-footer__text">&copy; {{ date('Y') }} {{ env('APP_NAME') }} All Rights Reversed.</div>
                <div class="col-12 col-lg-6 ps-footer__social"> <a class="icon_social facebook" href="#"><i class="fa fa-facebook-f"></i></a><a class="icon_social twitter" href="#"><i class="fa fa-twitter"></i></a><a class="icon_social google" href="#"><i class="fa fa-google-plus"></i></a><a class="icon_social youtube" href="#"><i class="fa fa-youtube"></i></a><a class="icon_social wifi" href="#"><i class="fa fa-wifi"></i></a></div>
            </div>
        </div>
    </footer>
    <div class="ps-footer-mobile">
        <div class="menu__content">
            <ul class="menu--footer">
                <li class="nav-item"><a class="nav-link" href="index.html"><i class="icon-home3"></i><span>Home</span></a></li>
                <li class="nav-item"><a class="nav-link footer-category" href="javascript:void(0);"><i class="icon-list"></i><span>Category</span></a></li>
                <li class="nav-item"><a class="nav-link footer-cart" href="/cart"><i class="icon-cart"></i><span class="badge bg-warning">3</span><span>Cart</span></a></li>
                <li class="nav-item"><a class="nav-link" href="/wishlist"><i class="icon-heart"></i><span>Wishlist</span></a></li>
                @auth
                <li class="nav-item"><a class="nav-link" href="login-register.html"><i class="icon-user"></i><span>Account</span></a></li>
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
            <div class="category__title">All Departments</div><span class="category__close"><i class="icon-cross"></i></span>
        </div>
        <div class="category__content">
            <ul class="menu--mobile">
                <li class="daily-deals category-item"><a href="flash-sale.html">Daily Deals</a></li>
                <li class="category-item"><a href="shop-categories.html">Top Promotions</a></li>
                <li class="category-item"><a href="shop-categories.html">New Arrivals</a></li>
                @foreach ($categories as $category)
                <li class="menu-item-has-children category-item"><a href="shop-categories.html">{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                    <ul class="sub-menu">
                        @foreach ($category->subCategories as $subCategory)
                            <li><a href="shop-view-grid.html">{{ $subCategory['name'] }}</a></li>
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
                            <a class="dropdown-item" href="#"><b>My Account</b></a>
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item" href="#">Orders</a>
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
                    <li class="menu-item-has-children"><a class="nav-link" href="#">Top Selling</a></li>
                    <li class="menu-item-has-children"><a class="nav-link" href="#">Discounted Deals</a></li>
                    <li class="menu-item-has-children"><a class="nav-link" href="#">About Us</a></li>
                    <li class="menu-item-has-children"><a class="nav-link" href="#">Contact Us</a></li>
            </ul>
        </div>
        <div class="navigation__footer">
            <ul class="menu--icon">
                <li class="footer-item"><a class="footer-link" href="#"><i class="icon-question-circle"></i><span>Help & Contact</span></a></li>
                <li class="footer-item"><a class="footer-link" href="#"><i class="icon-telephone"></i><span>HOTLINE: <span class='text-success'>(+1) 970 978-6290</span> (Free)</span></a></li>
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
</body>
</html>