@extends('layouts.admin')

@section('title', 'Edit Sale')

@section('style')
<link href="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/plugins/datepicker/datepicker.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Edit Sale</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.sales') }}">Sale</a></li>
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
        <div class="row">
            <!-- Start col -->
            <form method="POST" action="{{ route('admin.transactions.sales.update', $sale) }}" id="updateSaleForm" class="col-lg-12">
                @csrf
                @method('PUT')
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Customer Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6 my-1">
                                <label class="col-form-label">Name</label>
                                <div>
                                    <input type="text" value="{{ old('customer_name') ?? $sale['customer_name'] }}" name="customer_name" class="form-control">
                                </div>
                                @error('customer_name')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 my-1">
                                <label class="col-form-label">Email</label>
                                <div>
                                    <input type="email" value="{{ old('customer_email') ?? $sale['customer_email'] }}" name="customer_email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 my-1">
                                <label class="col-form-label">Phone</label>
                                <div>
                                    <input type="text" value="{{ old('customer_phone') ?? $sale['customer_phone'] }}"  placeholder="2349000000000" name="customer_phone" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 my-1">
                                <label class="col-form-label">Address</label>
                                <div>
                                    <input type="text" value="{{ old('customer_address') ?? $sale['customer_address'] }}" name="customer_address" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal well">
                            <fieldset>
                                <div class="repeater-default">
                                    <div id="productsList" data-repeater-list="products">
                                        @if (old('products'))
                                            @if (count(old('products')) > 0)
                                                @foreach (old('products') as $key=>$currentProduct)
                                                <div data-repeater-item>
                                                    <div class="form-group row d-flex align-items-end">
                                                        <div class="col-sm-4 my-2">
                                                            <input type="hidden" name="products[0][saleItemId]" value="{{ $currentProduct['saleItemId'] }}">
                                                            <label class="form-label">Product</label>
                                                            <select name="products[0][product]" required class="form-control item-name select2-single">
                                                                <option value="">Select Product</option>
                                                                @foreach ($products as $product)
                                                                    <option @if ($currentProduct['product'] == $product['id'])
                                                                        selected
                                                                    @endif value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('products.'.$key.'.product')
                                                                <span class="text-danger small" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div><!--end col-->

                                                        <div class="col-sm-4 my-2 item-quantity">
                                                            <label class="form-label">Quantity</label>
                                                            <input type="number" step="any" value="{{ $currentProduct['quantity'] }}" name="products[0][quantity]" placeholder="0" class="form-control">
                                                            @error('products.'.$key.'.quantity')
                                                                <span class="text-danger small" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div><!--end col-->

                                                        <div class="col-sm-4 my-2 item-unit-price">
                                                            <label class="form-label">Unit Price</label>
                                                            <input type="number" step="any" value="{{ $currentProduct['price'] }}" name="products[0][price]" placeholder="0" class="form-control">
                                                            @error('products.'.$key.'.price')
                                                                <span class="text-danger small" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div><!--end col-->

                                                        @php
                                                            $saleItem = App\Models\SaleItem::find($currentProduct['saleItemId']);
                                                        @endphp

                                                        <div class="col-sm-3 my-2 item-brand">
                                                            <label class="form-label">Brand</label>
                                                            <select name="products[0][brand]" class="form-control select2-single">
                                                                <option value="">Select Brand</option>
                                                                @if($currentProduct['saleItemId'])
                                                                    @foreach ($saleItem->product->brands()->get() as $brand)
                                                                        <option @if ($brand['id'] == $currentProduct['brand'])
                                                                            selected
                                                                        @endif value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div><!--end col-->

                                                        @foreach ($variations as $variation)
                                                            <div class="col-sm-3 my-2 variation-{{ $variation['name'] }}">
                                                                <label class="form-label text-capitalize">{{ $variation['name'] }}</label>
                                                                <select name="products[0][{{ $variation['name'] }}]" class="form-control select2-single">
                                                                    <option value="">Select {{ $variation['name'] }}</option>
                                                                    @if($currentProduct['saleItemId'])
                                                                        @foreach ($saleItem->variationItems()->where('variation_id', $variation['id'])->get() as $currentItem)
                                                                            <option @if (in_array($currentItem['id'], $saleItem->getVariationItemsIdToArray()))
                                                                                selected
                                                                            @endif value="{{ $currentItem['id'] }}">{{ $currentItem['name'] }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div><!--end col-->
                                                        @endforeach

                                                        <div class="col-sm-1 my-2">
                                                            <span data-repeater-delete class="btn btn-outline-danger">
                                                                <span class="fa fa-trash me-1"></span>
                                                            </span>
                                                        </div><!--end col-->
                                                    </div><!--end row-->
                                                    <hr>
                                                </div><!--end /div-->
                                                @endforeach
                                            @else
                                            <div data-repeater-item>
                                                <div class="form-group row d-flex align-items-end">
                                                    <div class="col-sm-4 my-2">
                                                        <label class="form-label">Product</label>
                                                        <input type="hidden" name="products[0][saleItemId]">
                                                        <select name="products[0][product]" required class="form-control item-name select2-single">
                                                            <option value="">Select Product</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div><!--end col-->

                                                    <div class="col-sm-4 my-2 item-quantity">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number" step="any" name="products[0][quantity]" placeholder="0" class="form-control">
                                                    </div><!--end col-->

                                                    <div class="col-sm-4 my-2 item-unit-price">
                                                        <label class="form-label">Unit Price</label>
                                                        <input type="number" step="any" name="products[0][price]" placeholder="0" class="form-control">
                                                    </div><!--end col-->

                                                    <div class="col-sm-3 my-2 item-brand">
                                                        <label class="form-label">Brand</label>
                                                        <select name="products[0][brand]" class="form-control select2-single">
                                                            <option value="">Select Brand</option>
                                                        </select>
                                                    </div><!--end col-->

                                                    @foreach ($variations as $variation)
                                                        <div class="col-sm-3 my-2 variation-{{ $variation['name'] }}">
                                                            <label class="form-label text-capitalize">{{ $variation['name'] }}</label>
                                                            <select name="products[0][{{ $variation['name'] }}]" class="form-control select2-single">
                                                                <option value="">Select {{ $variation['name'] }}</option>
                                                            </select>
                                                        </div><!--end col-->
                                                    @endforeach

                                                    <div class="col-sm-1 my-2">
                                                        <span data-repeater-delete class="btn btn-outline-danger">
                                                            <span class="fa fa-trash me-1"></span>
                                                        </span>
                                                    </div><!--end col-->
                                                </div><!--end row-->
                                                <hr>
                                            </div><!--end /div-->
                                            @endif
                                        @else
                                        @php
                                            $fetchedSaleItems = $sale->items()->get();
                                        @endphp
                                        @if (count($fetchedSaleItems) > 0)
                                        @foreach ($fetchedSaleItems as $key=>$currentProduct)
                                        <div data-repeater-item>
                                            <div class="form-group row d-flex align-items-end">
                                                <div class="col-sm-4 my-2">
                                                    <input type="hidden" name="products[0][saleItemId]" value="{{ $currentProduct['id'] }}">
                                                    <label class="form-label">Product</label>
                                                    <select name="products[0][product]" required class="form-control item-name select2-single">
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option @if ($currentProduct['product_id'] == $product['id'])
                                                                selected
                                                            @endif value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('products.'.$key.'.product')
                                                        <span class="text-danger small" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div><!--end col-->

                                                <div class="col-sm-4 my-2 item-quantity">
                                                    <label class="form-label">Quantity</label>
                                                    <input type="number" step="any" value="{{ $currentProduct['quantity'] }}" name="products[0][quantity]" placeholder="0" class="form-control">
                                                    @error('products.'.$key.'.quantity')
                                                        <span class="text-danger small" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div><!--end col-->

                                                <div class="col-sm-4 my-2 item-unit-price">
                                                    <label class="form-label">Unit Price</label>
                                                    <input type="number" step="any" value="{{ $currentProduct['price'] }}" name="products[0][price]" placeholder="0" class="form-control">
                                                    @error('products.'.$key.'.price')
                                                        <span class="text-danger small" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div><!--end col-->

                                                <div class="col-sm-3 my-2 item-brand">
                                                    <label class="form-label">Brand</label>
                                                    <select name="products[0][brand]" class="form-control select2-single">
                                                        <option value="">Select Brand</option>
                                                        @foreach ($currentProduct->product->brands()->get() as $brand)
                                                            <option @if ($brand['id'] == $currentProduct['brand_id'])
                                                                selected
                                                            @endif value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div><!--end col-->

                                                @foreach ($variations as $variation)
                                                    <div class="col-sm-3 my-2 variation-{{ $variation['name'] }}">
                                                        <label class="form-label text-capitalize">{{ $variation['name'] }}</label>
                                                        <select name="products[0][{{ $variation['name'] }}]" class="form-control select2-single">
                                                            <option value="">Select {{ $variation['name'] }}</option>
                                                            @foreach ($currentProduct->product->variationItems()->where('variation_id', $variation['id'])->get() as $currentItem)
                                                                <option @if (in_array($currentItem['id'], $currentProduct->getVariationItemsIdToArray()))
                                                                    selected
                                                                @endif value="{{ $currentItem['id'] }}">{{ $currentItem['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div><!--end col-->
                                                @endforeach

                                                <div class="col-sm-1 my-2">
                                                    <span data-repeater-delete class="btn btn-outline-danger">
                                                        <span class="fa fa-trash me-1"></span>
                                                    </span>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                            <hr>
                                        </div><!--end /div-->
                                        @endforeach
                                        @else
                                        <div data-repeater-item>
                                            <div class="form-group row d-flex align-items-end">
                                                <div class="col-sm-4 my-2">
                                                    <label class="form-label">Product</label>
                                                    <input type="hidden" name="products[0][saleItemId]">
                                                    <select name="products[0][product]" required class="form-control item-name select2-single">
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div><!--end col-->

                                                <div class="col-sm-4 my-2 item-quantity">
                                                    <label class="form-label">Quantity</label>
                                                    <input type="number" step="any" name="products[0][quantity]" placeholder="0" class="form-control">
                                                </div><!--end col-->

                                                <div class="col-sm-4 my-2 item-unit-price">
                                                    <label class="form-label">Unit Price</label>
                                                    <input type="number" step="any" name="products[0][price]" placeholder="0" class="form-control">
                                                </div><!--end col-->

                                                <div class="col-sm-3 my-2 item-brand">
                                                    <label class="form-label">Brand</label>
                                                    <select name="products[0][brand]" class="form-control select2-single">
                                                        <option value="">Select Brand</option>
                                                    </select>
                                                </div><!--end col-->

                                                @foreach ($variations as $variation)
                                                    <div class="col-sm-3 my-2 variation-{{ $variation['name'] }}">
                                                        <label class="form-label text-capitalize">{{ $variation['name'] }}</label>
                                                        <select name="products[0][{{ $variation['name'] }}]" class="form-control select2-single">
                                                            <option value="">Select {{ $variation['name'] }}</option>
                                                        </select>
                                                    </div><!--end col-->
                                                @endforeach

                                                <div class="col-sm-1 my-2">
                                                    <span data-repeater-delete class="btn btn-outline-danger">
                                                        <span class="fa fa-trash me-1"></span>
                                                    </span>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                            <hr>
                                        </div><!--end /div-->
                                        @endif
                                        @endif
                                    </div><!--end repet-list-->
                                    <div class="form-group mb-0 row">
                                        <div class="col-sm-12">
                                            <span data-repeater-create onclick="reInitializeSingleSelect()" class="btn btn-outline-secondary">
                                                <span class="fa fa-plus"></span> Add Product
                                            </span>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </div> <!--end repeter-->
                            </fieldset><!--end fieldset-->
                        </div><!--end form-->
                    </div><!--end card-body-->
                </div>
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Other Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="productTitle" class="col-form-label">Sale Date</label>
                                <div class="input-group">
                                    <input type="date" value="{{ old('date') ?? $sale['date']->format('Y-m-d') }}" name="date" class="form-control"/>
                                </div>
                                @error('date')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="productTitle" class="col-form-label">Additional Note</label>
                                <textarea name="note" class="form-control" rows="4">{{ old('note') ?? $sale['note'] }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="offset-md-6 col-md-6 p-0">
                            <div class="total-payment p-0">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="payment-title">Subtotal</td>
                                            <td id="subTotal">₦ 0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="payment-title">Shipping</td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    <li>
                                                        <input id="shippingFee" value="{{ old('shipping_fee') ?? $sale['shipping_fee'] }}" name="shipping_fee" type="number" step="any" class="form-control" placeholder="0.00">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="payment-title">Additional Fee</td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    <li>
                                                        <input id="additionalFee" value="{{ old('additional_fee') ?? $sale['additional_fee'] }}" name="additional_fee" type="number" step="any" class="form-control" placeholder="0.00">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="payment-title">Total</td>
                                            <td class="text-dark"><strong id="totalAmount">₦ 0.00</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!--end col-->
                    </div>
                </div>
            </form>
            <div class="col-12 text-right mt-3 mb-5">
                <button onclick="confirmSubmission('updateSaleForm')" class="btn btn-primary">Update Sale</button>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')
    <script src="{{ asset('admin/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/jquery.form-repeater.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/custom-form-datepicker.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/custom-form-select.js') }}"></script>
    <script>
        const variationList = {!! json_encode($variations) !!};
        const productsList = $('#productsList');
        const additionalFee = $('#additionalFee');
        const shippingFee = $('#shippingFee');
        productsList.on('change', 'div div div select.item-name', function() {
            fetchProductDetailsAndComputeSubTotal($(this));
        })

        computeSubTotal();

        additionalFee.on('input', computeSubTotal);

        shippingFee.on('input', computeSubTotal);

        productsList.on('input', 'div div div.item-unit-price input', computeSubTotal);

        productsList.on('input', 'div div div.item-quantity input', computeSubTotal);

        function reInitializeSingleSelect() {
            setTimeout(() => $('.select2-single').select2(), 10)
        }

        function fetchProductDetailsAndComputeSubTotal(selected) {
            if (selected.val()) {
                fetchProductDetails(selected);
                computeSubTotal();
            }
        }

        function setBrands(el, brands){
            brands.forEach(brand => {
                el.parent().parent().find('.item-brand select').append(`<option value="${brand.id}">${brand.name}</option>`);
            });
        }

        function setPrice(el, price){
            el.parent().parent().find('.item-unit-price input').val(Math.round(price));
        }

        function clearBrands(el){
            el.parent().parent().find('.item-brand select').html('<option value="">Select Brand</option>');
        }

        function setVariations(el, variations) {
            variationList.forEach(item => {
                variations[item.name].forEach(variation => {
                    el.parent().parent().find(`.variation-${item.name} select`).append(`<option value="${variation.id}">${variation.name}</option>`);
                })
            })
        }

        function clearVariations(el) {
            variationList.forEach(item => {
                el.parent().parent().find(`.variation-${item.name} select`).html(`<option value="">Select ${item.name}</option>`);
            })
        }

        function computeSubTotal() {
            $('#subTotal').text(`₦ ${numberFormat(fetchSubTotal())}`);
            $('#totalAmount').text(`₦ ${numberFormat(fetchTotal())}`);
        }

        function fetchTotal() {
            const addFee = parseFloat(additionalFee.val()) || 0;
            const shipFee = parseFloat(shippingFee.val()) || 0;
            const subT = parseFloat(fetchSubTotal()) || 0;
            return (parseFloat(subT + addFee + shipFee).toFixed(2));
        }

        function fetchSubTotal() {
            let subTotal = 0;
            productsList.children().each(function() {
                if ($(this).find('div div select.item-name').val()){
                    const unitPrice = $(this).find('div div.item-unit-price input').val() || 0;
                    const quantity = $(this).find('div div.item-quantity input').val() || 0;
                    subTotal += unitPrice * quantity;
                }
            });
            return subTotal.toFixed(2);
        }

        function fetchProductDetails(el){
            $.ajax({
                type: 'GET',
                url: '/admin/'+ el.val() +'/getProductDetails',
                success: function (data) {
                    clearBrands(el);
                    clearVariations(el);
                    setBrands(el, data.brands);
                    setPrice(el, data.sell_price);
                    setVariations(el, data.variations);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
@endsection