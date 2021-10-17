@extends('layouts.admin')

@section('title', ucwords($product['name']))

@php
    $variations = App\Models\Variation::all();
@endphp

@section('style')

@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Product Details</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
     <!-- Start Contentbar -->
     <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-xl-5">
                                <div class="product-slider-box product-box-for">
                                    @foreach ($product->media()->get() as $media)
                                        <div class="product-preview">
                                            <img src="{{ asset($media['url']) }}" class="img-fluid" alt="Product">
                                            @if ($product->isDiscounted())
                                                <p><span class="badge badge-success font-14">{{ $product->getDiscountedPercent() }}% off</span></p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="product-slider-box product-box-nav">
                                    @foreach ($product->media()->get() as $media)
                                        <div class="product-preview">
                                            <img src="{{ asset($media['url']) }}" class="img-fluid" alt="{{ ucwords($product['name']) }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-7">
                                <h2 class="font-22">{{ ucwords($product['name']) }}</h2>
                                <p class="mb-4">{{ $product['description'] }}</p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Buy Price: </span><span><span class="font-16">₦</span>{{ number_format($product->buy_price) }}</span></p>
                                @if ($product->isDiscounted())
                                    <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Sell Price: </span><s class="mr-3"><span class="font-16">₦</span>{{ $product->getFormattedActualPrice() }}</s><span><span class="font-16">₦</span>{{ $product->getFormattedDiscountedPrice() }}</span></p>
                                @else
                                    <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Sell Price: </span><span><span class="font-16">₦</span>{{ $product->getFormattedDiscountedPrice() }}</span></p>
                                @endif
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Code: </span><span>{{ $product->code }}</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Total Sold: </span><span>{{ $product->sold }}</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Discount: </span><span><span class="font-16">₦</span>{{ number_format($product->discount) }}</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">SKU: </span><span>{{ $product->sku }}</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Item/Part Number: </span><span>{{ $product->sku }}</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Quantity: </span><span>{{ $product->quantity }}</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Weight: </span><span>{{ $product->weight }} Kg</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Stock: </span><span>@if ($product->in_stock) <span class="badge badge-success">In Stock<span> @else <span class="badge badge-danger">Out of Stock<span> @endif </span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Online Store: </span><span>@if ($product->is_listed) <span class="badge badge-success">Featured<span> @else <span class="badge badge-danger">Not Featured<span> @endif </span></p>
                                @if ($product->categories()->count() > 0)
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Categories: @foreach ($product->categories()->get() as $category)
                                        <span style="font-size: 12px" class="mx-1 badge badge-light">{{ $category['name'] }}</span>
                                    @endforeach</p>
                                @endif
                                @if ($product->subCategories()->count() > 0)
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Subcategories: @foreach ($product->subCategories()->get() as $subCat)
                                        <span style="font-size: 12px" class="mx-1 badge badge-light">{{ $subCat['name'] }}</span>
                                    @endforeach</p>
                                @endif
                                @if ($product->brands()->count() > 0)
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Brands: @foreach ($product->brands()->get() as $brand)
                                    <span style="font-size: 12px" class="mx-1 badge badge-light">{{ $brand['name'] }}</span>
                                @endforeach</p>
                                @endif
                                @foreach ($variations as $variation)
                                    @if ($product->variationItems()->where('variation_id', $variation['id'])->count() > 0)
                                    <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">{{ $variation['name'] }}: @foreach ($product->variationItems()->where('variation_id', $variation['id'])->get() as $item)
                                            <span style="font-size: 12px" class="mx-1 badge badge-light">{{ $item['name'] }}</span>
                                        @endforeach</p>
                                    @endif
                                @endforeach
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Note: </span><span>{{ $product->note ?? '----' }}</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Created Date: </span><span>{{ $product->created_at->format('M d, Y \a\t h:i A') }}</span></p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Available Item Numbers: </span>
                                    @foreach($product->itemNumbers()->where('status', 'available')->get() as $item)
                                        <span style="font-size: 12px" class="mx-1 badge badge-light">{{ $item['no'] }}</span>
                                    @endforeach
                                </p>
                                <p class="text-primary font-15 f-w-7 my-md-2 my-3"><span class="font-weight-normal">Sold Item Numbers: </span>
                                    @foreach($product->itemNumbers()->where('status', 'sold')->get() as $item)
                                        <span style="font-size: 12px" class="mx-1 badge badge-light">{{ $item['no'] }}</span>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="small mx-1"><i>created by:</i> {{ $product->getCreatedBy() }}</span>
                            @if($product['updated_by'] && $product['updated_by'] != $product['last_updated_by'])
                                <span class="small mx-1"><i>last updated by:</i> {{ $sale->getLastUpdatedBy() }}</span>
                            @else
                                <span class="small mx-1"><i>updated by:</i> {{ $product->getUpdatedBy() }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')
<script src="{{ asset('admin/assets/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/custom-ecommerce-single-product.js') }}"></script>
@endsection
