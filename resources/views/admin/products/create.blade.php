@extends('layouts.admin')

@section('title', 'New Product')

@section('style')

@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">New Product</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New</li>
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
        <form class="row" id="createProductForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}">
            @csrf
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
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name">
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
                                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description') }}</textarea>
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
                                    <a class="nav-link mb-2" id="v-pills-full_description-tab" data-toggle="pill" href="#v-pills-full_description" role="tab" aria-controls="v-pills-full_description" aria-selected="false"><i class="ri-file-list-2-line mr-2"></i>Full Description</a>
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
                                                <input type="number" step="any" value="{{ old('buy_price') }}" name="buy_price" class="form-control" id="regularPrice" placeholder="100">
                                                @error('buy_price')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="sellPrice" class="col-sm-4 col-form-label">Sell Price(₦)</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="any" value="{{ old('sell_price') }}" name="sell_price" class="form-control" id="sellPrice" placeholder="100">
                                                @error('sell_price')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="salePrice" class="col-sm-4 col-form-label">Discount(₦)</label>
                                            <div class="col-sm-8">
                                                <input type="number" step="any" value="{{ old('discount') ?? 0 }}" name="discount" class="form-control" id="salePrice" placeholder="50">
                                                @error('discount')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show" id="v-pills-gallery" role="tabpanel" aria-labelledby="v-pills-gallery-tab">
                                        <div class="repeater-default">
                                            <div id="imageFileFields">
                                                <div class="form-group row d-flex align-items-end">

                                                    <div class="col-9 my-1">
                                                        <label for="image_1">Image 1</label>
                                                        <input type="file" required id="image_1" name="media[]" class="form-control-file" placeholder="100">
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
                                                <input type="text" name="sku" value="{{ old('sku') }}" class="form-control" id="sku" placeholder="SKU001">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="stockStatus" class="col-sm-4 col-form-label">Stock Status</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="in_stock" id="stockStatus">
                                                    <option value="instock">In Stock</option>
                                                    <option value="outofstock">Out of Stock</option>
                                                </select>
                                                @error('in_stock')
                                                    <span class="text-danger small" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
{{--                                        <div class="form-group row mb-0">--}}
{{--                                            <label for="stockQuantity" class="col-sm-4 col-form-label">Quantity</label>--}}
{{--                                            <div class="col-sm-8">--}}
{{--                                                <input type="number" value="{{ old('quantity') }}" name="quantity" class="form-control" id="stockQuantity" placeholder="100">--}}
{{--                                                @error('quantity')--}}
{{--                                                    <span class="text-danger small" role="alert">--}}
{{--                                                        <strong>{{ $message }}</strong>--}}
{{--                                                    </span>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-full_description" role="tabpanel" aria-labelledby="v-pills-full_description-tab">
                                        <div class="my-1">
                                            <label for="ckeditor">Full Description <span class="text-danger">*</span></label>
                                            <textarea name="full_description" id="ckeditor" class="ckeditor" cols="30" rows="10">{{ old('full_description') }}</textarea>
                                            @error('full_description')
                                            <span class="text-danger small" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-advanced" role="tabpanel" aria-labelledby="v-pills-advanced-tab">
                                        <div class="form-group row">
                                            <label for="weight" class="col-sm-3 col-form-label">Weight(kg)</label>
                                            <div class="col-sm-9">
                                                <input type="number" step="any" value="{{ old('weight') }}" name="weight" class="form-control" id="weight" placeholder="0">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="purchaseNote" class="col-sm-3 col-form-label">Purchase note</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="note" id="purchaseNote" rows="3" placeholder="Purchase note">{{ old('note') }}</textarea>
                                            </div>
                                        </div>
{{--                                        <div class="form-group row">--}}
{{--                                            <label for="item_number" class="col-sm-3 col-form-label">Item/Part Number</label>--}}
{{--                                            <div class="col-sm-9">--}}
{{--                                                <input type="text" value="{{ old('item_number') }}" name="item_number" class="form-control" id="item_number" placeholder="Item Number">--}}
{{--                                                @error('item_number')--}}
{{--                                                    <span class="text-danger small" role="alert">--}}
{{--                                                        <strong>{{ $message }}</strong>--}}
{{--                                                    </span>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="form-group row mb-0">
                                            <label for="feature" class="col-sm-3 col-form-label">Website Feature?</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="feature" id="feature">
                                                    <option value="feature">Feature</option>
                                                    <option value="do_not_feature">Don't Feature</option>
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
                                    <input type="checkbox" name="categories[]" @if (old('categories') && in_array($category['id'], old('categories')))
                                        checked
                                    @endif class="category-item custom-control-input" value="{{ $category['id'] }}" id="cat-{{ $category['name'] }}">
                                    <label class="custom-control-label" for="cat-{{ $category['name'] }}">{{ $category['name'] }}</label>
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
                                    <input type="checkbox" name="brands[]" @if (old('brands') && in_array($brand['id'], old('brands')))
                                        checked
                                    @endif class="custom-control-input" value="{{ $brand['id'] }}" id="brand-{{ $brand['name'] }}">
                                    <label class="custom-control-label" for="brand-{{ $brand['name'] }}">{{ $brand['name'] }}</label>
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
                                        <input type="checkbox" name="variations[]" @if (old('variations') && in_array($item['id'], old('variations')))
                                            checked
                                        @endif class="custom-control-input" value="{{ $item['id'] }}" id="var-{{ $variation['name'] }}-{{ $item['name'] }}">
                                        <label class="custom-control-label" for="var-{{ $variation['name'] }}-{{ $item['name'] }}">{{ $item['name'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- End col -->
            <div class="col-12 text-right">
                <button type="button" onclick="confirmSubmission('createProductForm')" class="btn btn-primary mt-3 mb-4">Create Product</button>
            </div>
        </form>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')
    <script src="{{ asset('admin/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/jquery.form-repeater.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'full_description' );
            const subCategoriesContainer = $('#subCategoriesContainer');
            const addImageFieldButton = $('#addImageFieldButton');
            const imageFileFields = $('#imageFileFields');
            let html = '';

            imageFileFields.on('click', 'div div .image-field-remove-button', function() {
                $(this).parent().parent().remove();
                renameFileFields();
            });

            addImageFieldButton.on('click', () => {
                const oldHtml = imageFileFields.html();
                const nextField = imageFileFields.children().length + 1;
                if (nextField < 6) {
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
                $(this).on('click', function() {
                    const selectedCategories = [];
                    $('.category-item:checkbox:checked').each(function(){
                        selectedCategories.push($(this).val());
                    });
                    if (selectedCategories.length > 0)
                        fetchRequiredSubCategories(selectedCategories);
                    else
                        subCategoriesContainer.html('<div>Select a category</div>');
                });
            });

            function renameFileFields(){
                imageFileFields.children().each(function(index) {
                    const label = $(this).find('label');
                    const input = $(this).find('input');
                    label.text('Image ' + (index + 1));
                    label.prop('for', 'image_' + (index + 1));
                    input.prop('id', 'image_' + (index + 1));
                    // input.prop('name', 'image_' + (index + 1));
                    if (index === 0) input.prop('required', true);
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
                                            <input type="checkbox" name="subcategories[]" class="custom-control-input" value="${res.id}" id="subCat-${res.name}">
                                            <label class="custom-control-label" for="subCat-${res.name}">${res.name}</label>
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
        });
    </script>
@endsection
