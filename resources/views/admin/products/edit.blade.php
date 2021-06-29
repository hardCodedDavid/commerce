@extends('layouts.admin')

@section('title', 'Edit Product')

@section('style')

@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Edit Product</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
        <form class="row" id="updateProductForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update', $product) }}">
            @csrf
            @method('PUT')
            <!-- Start col -->
            <div class="col-lg-8 col-xl-9">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Product Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-12 col-form-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" name="name" class="form-control" value="{{ old('name') ?? $product['name'] }}" id="name">
                                @error('name')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-12 col-form-label">Description</label>
                            <div class="col-sm-12">
                                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') ?? $product['description'] }}</textarea>
                                @error('description')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Other Detail</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-xl-4">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="nav flex-column nav-pills" id="v-pills-product-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link mb-2 active" id="v-pills-general-tab" data-toggle="pill" href="#v-pills-general" role="tab" aria-controls="v-pills-general" aria-selected="true"><i class="ri-remixicon-line mr-2"></i>Pricing</a>
                                    <a class="nav-link mb-2" id="v-pills-gallery-tab" data-toggle="pill" href="#v-pills-gallery" role="tab" aria-controls="v-pills-gallery" aria-selected="false"><i class="ri-gallery-line mr-2"></i>Gallery</a>
                                    <a class="nav-link mb-2" id="v-pills-stock-tab" data-toggle="pill" href="#v-pills-stock" role="tab" aria-controls="v-pills-stock" aria-selected="false"><i class="ri-dropbox-line mr-2"></i>Stock</a>
                                    <a class="nav-link mb-2" id="v-pills-advanced-tab" data-toggle="pill" href="#v-pills-advanced" role="tab" aria-controls="v-pills-advanced" aria-selected="false"><i class="ri-settings-3-line mr-2"></i>Advanced</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-8">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="tab-content" id="v-pills-product-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel" aria-labelledby="v-pills-general-tab">
                                        <div class="form-group row">
                                            <label for="regularPrice" class="col-sm-4 col-form-label">Buy Price(₦)</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="any" value="{{ old('buy_price') ?? $product['buy_price'] }}" name="buy_price" class="form-control" id="regularPrice" placeholder="100">
                                                @error('price')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="sellPrice" class="col-sm-4 col-form-label">Sell Price(₦)</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="any" value="{{ old('sell_price') ?? $product['sell_price'] }}" name="sell_price" class="form-control" id="sellPrice" placeholder="100">
                                                @error('price')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="salePrice" class="col-sm-4 col-form-label">Discount(₦)</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="any" value="{{ old('discount') ?? $product['discount'] }}" name="discount" class="form-control" id="salePrice" placeholder="50">
                                                @error('sale_price')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show" id="v-pills-gallery" role="tabpanel" aria-labelledby="v-pills-gallery-tab">
                                        <div class="repeater-default">
                                            <div class="row" id="existingMedia">
                                                @foreach ($product->media()->get() as $media)
                                                    <div class="col-md-6">
                                                        <div class="card m-b-30">
                                                            <img class="card-img-top" src="{{ asset($media['url']) }}" alt="Card image cap">
                                                            <div class="card-body">
                                                                <button type="button" onclick="deleteMedia({{ $media['id'] }})" class="btn btn-danger-rgba">Remove <i class="fa fa-trash-o"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div id="imageFileFields">
                                                @for ($i=0;$i<(5-$product->media()->count());$i++)
                                                    <div class="form-group row d-flex align-items-end">
                                                        <div class="col-9 my-1">
                                                            <label for="image_{{ $i+1 }}">Image {{ $i+1 }}</label>
                                                            <input type="file" id="image_{{ $i+1 }}" name="media[]" class="form-control-file" placeholder="100">
                                                            @error('media')
                                                                <span class="text-danger small" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div><!--end col-->

                                                        <div class="col-3 my-1 text-right">
                                                            <span class="image-field-remove-button btn btn-outline-danger">
                                                                <span class="fa fa-trash me-1"></span>
                                                            </span>
                                                        </div><!--end col-->
                                                    </div><!--end row-->
                                                @endfor
                                            </div><!--end /div-->
                                            <div class="form-group mb-0 row">
                                                <div class="col-sm-12">
                                                    <span class="btn btn-outline-secondary" id="addImageFieldButton">
                                                        <span class="fa fa-plus"></span> Add Image
                                                    </span>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </div> <!--end repeter-->
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-stock" role="tabpanel" aria-labelledby="v-pills-stock-tab">
                                        <div class="form-group row">
                                            <label for="sku" class="col-sm-4 col-form-label">SKU</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="sku" value="{{ old('sku') ?? $product['sku'] }}" class="form-control" id="sku" placeholder="SKU001">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="stockStatus" class="col-sm-4 col-form-label">Stock Status</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="in_stock" id="stockStatus">
                                                    <option @if($product['in_stock'] == 1) selected @endif value="instock">In Stock</option>
                                                    <option @if($product['in_stock'] == 0) selected @endif value="outofstock">Out of Stock</option>
                                                </select>
                                                @error('in_stock')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="stockQuantity" class="col-sm-4 col-form-label">Quantity</label>
                                            <div class="col-sm-8">
                                                <input type="number" value="{{ old('quantity') ?? $product['quantity'] }}" name="quantity" class="form-control" id="stockQuantity" placeholder="100">
                                                @error('quantity')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-advanced" role="tabpanel" aria-labelledby="v-pills-advanced-tab">
                                        <div class="form-group row">
                                            <label for="weight" class="col-sm-3 col-form-label">Weight(kg)</label>
                                            <div class="col-sm-9">
                                                <input type="number" step="any" value="{{ old('weight') ?? $product['weight'] }}" name="weight" class="form-control" id="weight" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="purchaseNote" class="col-sm-3 col-form-label">Purchase note</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="note" id="purchaseNote" rows="3" placeholder="Purchase note">{{ old('note') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="feature" class="col-sm-3 col-form-label">Website Feature?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="feature" id="feature">
                                                    <option @if($product['is_listed'] == 1) selected @endif value="feature">Feature</option>
                                                    <option @if($product['is_listed'] == 0) selected @endif value="do_not_feature">Don't Feature</option>
                                                </select>
                                                @error('feature')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
            <!-- Start col -->
            <div class="col-lg-4 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Categories</h5>
                    </div>
                    <div class="card-body">
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="categories[]" class="category-item custom-control-input" @foreach ($product->categories()->get() as $currentCategory)
                                        @if ($currentCategory['id'] == $category['id'])
                                            checked
                                        @endif
                                    @endforeach value="{{ $category['id'] }}" id="{{ $category['name'] }}">
                                    <label class="custom-control-label" for="{{ $category['name'] }}">{{ $category['name'] }}</label>
                                </div>
                            @endforeach
                            @error('categories')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        @else
                            <div>No Categories</div>
                        @endif
                    </div>
                </div>
                @if (count($brands) > 0)
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">Brands</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($brands as $brand)
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="brands[]" class="custom-control-input" @foreach ($product->brands()->get() as $currentBrand)
                                        @if ($currentBrand['id'] == $brand['id'])
                                            checked
                                        @endif
                                    @endforeach value="{{ $brand['id'] }}" id="{{ $brand['name'] }}">
                                    <label class="custom-control-label" for="{{ $brand['name'] }}">{{ $brand['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">SubCategories</h5>
                    </div>
                    <div class="card-body" id="subCategoriesContainer">
                        <div>Select a category</div>
                    </div>
                </div>
                @if (count($variations) > 0)
                    @foreach ($variations as $variation)
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="card-title">{{ $variation['name'] }}</h5>
                            </div>
                            <div class="card-body">
                                @foreach ($variation->items as $item)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="variations[]" @foreach ($product->variationItems()->get() as $currentVariation)
                                            @if ($currentVariation['id'] == $item['id'])
                                                checked
                                            @endif
                                        @endforeach class="custom-control-input" value="{{ $item['id'] }}" id="{{ $item['name'] }}">
                                        <label class="custom-control-label" for="{{ $item['name'] }}">{{ $item['name'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- End col -->
            <div class="col-12 text-right">
                <button type="button" onclick="confirmSubmission('updateProductForm')" class="btn btn-primary mt-3 mb-4">Update Product</button>
            </div>
        </form>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')
    <script src="{{ asset('admin/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/jquery.form-repeater.js') }}"></script>
    <script>
        // $(document).ready(function() {
            const subCategoriesContainer = $('#subCategoriesContainer');
            const addImageFieldButton = $('#addImageFieldButton');
            const imageFileFields = $('#imageFileFields');
            const existingMedia = $('#existingMedia');
            let max = 5 - {!! json_encode($product->media()->count()) !!};
            let html = '';

            imageFileFields.on('click', 'div div .image-field-remove-button', function() {
                $(this).parent().parent().remove();
                renameFileFields();
            });

            addImageFieldButton.on('click', () => {
                const oldHtml = imageFileFields.html();
                const nextField = imageFileFields.children().length + 1;
                if (nextField <= max) {
                    imageFileFields.append(`
                    <div class="form-group row d-flex align-items-end">
                        <div class="col-9 my-1">
                            <label for="image_${nextField}">Image ${nextField}</label>
                            <input type="file" id="image_${nextField}" name="media[]" class="form-control-file" placeholder="100">
                        </div>

                        <div class="col-3 my-1 text-right">
                            <span class="btn image-field-remove-button btn-outline-danger">
                                <span class="fa fa-trash me-1"></span>
                            </span>
                        </div>
                    </div>`);
                }
            });

            $('.category-item').each(function(){
                $(this).on('click', setSelectedSubCategories);
            });

            setSelectedSubCategories();

            function setSelectedSubCategories(){
                const selectedCategories = [];
                $('.category-item:checkbox:checked').each(function(){
                    selectedCategories.push($(this).val());
                });
                if (selectedCategories.length > 0)
                    fetchRequiredSubCategories(selectedCategories);
                else
                    subCategoriesContainer.html('<div>Select a category</div>');
            }

            function renameFileFields(){
                imageFileFields.children().each(function(index) {
                    const label = $(this).find('label');
                    const input = $(this).find('input');
                    label.text('Image ' + (index + 1));
                    label.prop('for', 'image_' + (index + 1));
                    input.prop('id', 'image_' + (index + 1));
                })
            }

            function fetchRequiredSubCategories(ids){
                $.ajax({
                    type: 'GET',
                    url: '/admin/getSubcategoriesByIds',
                    data: { ids },
                    success: function (data) {
                        html = '';
                        if (data.length > 0) {
                            data.forEach(res => {
                                html += `<div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="subcategories[]" class="custom-control-input" value="${res.id}" id="${res.name}">
                                            <label class="custom-control-label" for="${res.name}">${res.name}</label>
                                        </div>`;
                            })
                        }else {
                            html = '<div>No Subcategory</div>';
                        }
                        subCategoriesContainer.html(html);
                    },
                    error: function() {
                        subCategoriesContainer.html('<div>Select a category</div>');
                    }
                });
            }

            function deleteMedia(id){
                $.ajax({
                    type: 'DELETE',
                    url: '/admin/products/{{ $product['code'] }}/media/remove',
                    data: { _token: '{{ csrf_token() }}', id },
                    success: function (data) {
                        let mediaHtml = '';
                        data.forEach(media => {
                            mediaHtml += `<div class="col-md-6">
                                        <div class="card m-b-30">
                                            <img class="card-img-top" src="${media.url}" alt="Card image cap">
                                            <div class="card-body">
                                                <button type="button" onclick="deleteMedia(${media.id})" class="btn btn-danger-rgba">Remove <i class="fa fa-trash-o"></i></button>
                                            </div>
                                        </div>
                                    </div>`;
                        });
                        existingMedia.html(mediaHtml);
                        max = 5 - (data.length);
                        addImageFieldButton.click();
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            }
        // });
    </script>
@endsection