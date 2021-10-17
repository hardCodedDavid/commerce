@extends('layouts.user')

@section('title', 'Shop')

@section('content')

@php
    $categories = \App\Models\Category::with('subCategories')->get();
    $variations = \App\Models\Variation::with('items')->get();
    $min = \App\Models\Product::where('is_listed', 1)->orderBy('sell_price', 'asc')->first()['sell_price'] ?? 0;
    $max = \App\Models\Product::where('is_listed', 1)->orderBy('sell_price', 'desc')->first()['sell_price'] ?? 0;
    $brands = \App\Models\Brand::get();
@endphp

<main class="no-main">
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="ps-breadcrumb__list">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="javascript:void(0);">Shop</a></li>
            </ul>
        </div>
    </div>
    <section class="section-shop">
        <div class="container">
            <div class="shop__content">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <div class="ps-shop--sidebar" style="max-height: 95%; overflow-y: auto">
                            <div class="sidebar__category">
                                <div class="sidebar__title">ALL CATEGORIES</div>
                                <ul class="menu--mobile" style="max-height: 200px; overflow-y: auto">
                                    <li class="daily-deals category-item"><a href="/deals">Daily Deals</a></li>
                                    <li class="category-item"><a href="/top-selling">Top Selling</a></li>
                                    @foreach ($categories as $category)
                                        <li class="menu-item-has-children category-item"><a href="{{ route('category.products', $category) }}">{{ $category['name'] }}</a><span class="sub-toggle"><i class="icon-chevron-down"></i></span>
                                            <ul class="sub-menu">
                                                @foreach ($category->subCategories as $subCategory)
                                                    <li><a href="{{ route('category.products', ['category' => $category, 'subcategory' => $subCategory['name']]) }}">{{ $subCategory['name'] }}</a></li>
                                                @endforeach
                                                <li class="see-all"><a href="/shop">See all products <i class='icon-chevron-right'></i></a></li>
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <form method="post" action="{{ route('shop.filter') }}" class="sidebar__sort">
                                @csrf
                                <div class="sidebar__block open">
                                    <div class="sidebar__title">BY PRICE<span class="shop-widget-toggle"><i class="icon-minus"></i></span></div>
                                    <div class="block__content">
                                        <div class="block__price">
                                            <div id="slide-price"></div>
                                        </div>
                                        <div class="block__input">
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">&#8358;</span></div>
                                                <input name="from" class="form-control" type="text" id="input-with-keypress-0">
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">&#8358;</span></div>
                                                <input name="to" class="form-control" type="text" id="input-with-keypress-1">
                                            </div>
                                            <button onclick="$('#from-filter').val($('#input-with-keypress-0').val());
                                                $('#to-filter').val($('#input-with-keypress-1').val());
                                                $('#filter-by-price-form').submit()">Go</button>
                                        </div>
                                    </div>
                                </div>
                                @if (count($brands) > 0)
                                    <div class="sidebar__block open">
                                        <div class="sidebar__title">BY BRAND<span class="shop-widget-toggle"><i class="icon-minus"></i></span></div>
                                        <div class="block__content" style="max-height: 200px; overflow-y: auto">
                                            <ul>
                                                @foreach ($brands as $brand)
                                                    <li>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="brands[]" id="brand-{{ $brand['name'] }}" value="{{ $brand['id'] }}">
                                                            <label for="brand-{{ $brand['name'] }}">{{ $brand['name'] }}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                @foreach ($variations as $variation)
                                    @if (count($variation->items) > 0)
                                        <div class="sidebar__block open">
                                            <div class="sidebar__title">BY {{ strtoupper($variation['name']) }}<span class="shop-widget-toggle"><i class="icon-minus"></i></span></div>
                                            <div class="block__content" style="max-height: 200px; overflow-y: auto">
                                                <ul>
                                                    @foreach ($variation->items as $item)
                                                        <li>
                                                            <div class="form-check">
                                                                <input class="form-check-input" name="variations[]" type="checkbox" id="{{ $variation['name'] }}-{{ $item['name'] }}" value="{{ $item['id'] }}">
                                                                <label for="{{ $variation['name'] }}-{{ $item['name'] }}">{{ $item['name'] }}</label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <button class="mb-5" style="
                                    border: 1px solid #dddddd;
                                    color: #222;
                                    font-weight: bold;
                                    border-radius: 3px;
                                    padding: 10px 15px;
                                    font-size: 14px;
                                    width: 100%;
                                ">Add Filter</button>
                            </form>
                            <form action="{{ route('shop.filter') }}" method="post" class="d-none" id="filter-by-price-form">
                                @csrf
                                <input type="text" name="from" value="" class="d-none" id="from-filter">
                                <input type="text" name="to" value="" class="d-none" id="to-filter">
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-lg-9">
                        <a class="mt-3 ps-button shop__link" href="/shop">Shop all product<i class="icon-chevron-right"></i></a>
                        <div class="filter__mobile">
                            <div class="viewtype--block">
                                <div class="viewtype__sortby">
                                    <form id="sortFormMobile" action="{{ route('shop') }}">
                                        <div class="select">
                                            <input type="hidden" name="rpp" value="{{ request('rpp') }}">
                                            <select onchange="document.getElementById('sortFormMobile').submit()" class="single-select2-no-search" name="sort">
                                                <option value="">Sort</option>
                                                <option @if(request('sort') == 'name') selected @endif value="name">By name</option>
                                                <option @if(request('sort') == 'price') selected @endif value="price">By price</option>
                                                <option @if(request('sort') == 'sale') selected @endif value="sale">By sales</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="result__sort">
                            <div class="viewtype--block">
                                <div class="viewtype__sortby">
                                    <form id="sortForm" action="{{ route('shop') }}">
                                        <div class="select">
                                            <input type="hidden" name="rpp" value="{{ request('rpp') }}">
                                            <select onchange="document.getElementById('sortForm').submit()" class="single-select2-no-search" name="sort">
                                                <option value="">Sort</option>
                                                <option @if(request('sort') == 'name') selected @endif value="name">By name</option>
                                                <option @if(request('sort') == 'price') selected @endif value="price">By price</option>
                                                <option @if(request('sort') == 'sale') selected @endif value="sale">By sales</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="viewtype__select"> <span class="text">View: </span>
                                    <form id="rppForm" action="{{ route('shop') }}" method="get">
                                        <div class="select">
                                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                                            <select onchange="document.getElementById('rppForm').submit()" class="single-select2-no-search" name="rpp">
                                                <option value="24" @if(request('rpp') == 24) selected @endif>24 per page</option>
                                                <option value="12" @if(request('rpp') == 12) selected @endif>12 per page</option>
                                                <option value="4" @if(request('rpp') == 4) selected @endif>4 per page</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="result__content">
                            <div class="section-shop--grid">
                                <div class="row m-0">
                                    @if (count($products) > 0)
                                        @foreach ($products as $product)
                                            @include('cat-products', ['product' => $product])
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center">
                                            <h3 class="text-center">No products found</h3>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="ps-pagination blog--pagination">
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
    <script>
        slidePriceWidget();
        function slidePriceWidget() {
            const min = parseFloat({{ $min }});
            const max = parseFloat({{ $max }});
            const from = (!isNaN({{ $from }}) && !isNaN({{ $to }})) ? parseFloat('{{ $from }}') : randomIntFromInterval(min, max);
            const to = (!isNaN({{ $from }}) && !isNaN({{ $to }})) ? parseFloat('{{ $to }}') : randomIntFromInterval(min, max);
            var rangeSlider = document.getElementById('slide-price');
            if (rangeSlider) {
                var input0 = document.getElementById('input-with-keypress-0');
                var input1 = document.getElementById('input-with-keypress-1');
                var inputs = [input0, input1];
                noUiSlider.create(rangeSlider, {
                    start: [from, to],
                    connect: true,
                    step: 1,
                    range: {
                        min: [min],
                        max: [max]
                    }
                });

                rangeSlider.noUiSlider.on("update", function(values, handle) {
                    inputs[handle].value = values[handle];

                    /* begin Listen to keypress on the input */
                    function setSliderHandle(i, value) {
                        var r = [null, null];
                        r[i] = value;
                        rangeSlider.noUiSlider.set(r);
                    }

                    inputs.forEach(function(input, handle) {
                        input.addEventListener("change", function() {
                            setSliderHandle(handle, this.value);
                        });

                        input.addEventListener("keydown", function(e) {
                            var values = rangeSlider.noUiSlider.get();
                            var value = Number(values[handle]);

                            // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
                            var steps = rangeSlider.noUiSlider.steps();

                            // [down, up]
                            var step = steps[handle];

                            var position;

                            // 13 is enter,
                            // 38 is key up,
                            // 40 is key down.
                            switch (e.which) {
                                case 13:
                                setSliderHandle(handle, this.value);
                                break;

                                case 38:
                                // Get step to go increase slider value (up)
                                position = step[1];

                                // false = no step is set
                                if (position === false) {
                                    position = 1;
                                }

                                // null = edge of slider
                                if (position !== null) {
                                    setSliderHandle(handle, value + position);
                                }

                                break;

                                case 40:
                                position = step[0];

                                if (position === false) {
                                    position = 1;
                                }

                                if (position !== null) {
                                    setSliderHandle(handle, value - position);
                                }

                                break;
                            }
                        });
                    });
                });
            }
        }

        function randomIntFromInterval(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min)
        }
    </script>
@endsection
