@extends('layouts.admin')

@section('title', 'Edit Purchase')

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
                <h4 class="page-title">Edit Purchase</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.purchases') }}">Purchase</a></li>
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
            <form method="POST" action="{{ route('admin.transactions.purchases.update', $purchase) }}" id="updatePurchaseForm" class="col-lg-12">
                @csrf
                @method('PUT')
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Supplier Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="productTitle" class="col-form-label">Select Supplier</label>
                                <div>
                                    <select id="supplierField" onchange="toggleSuppierDetailsButton()" name="supplier" class="form-control select2-single">
                                        <option value="">Select Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option @if (old('supplier') && old('supplier') == $supplier['id'])
                                                selected
                                            @elseif($purchase['supplier_id'] == $supplier['id'])
                                                selected
                                            @endif value="{{ $supplier['id'] }}">{{ $supplier['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <button style="display: none" id="getSupplierDetailBtn" type="button" onclick="getSupplierDetails()" class="mt-2 btn btn-sm btn-primary">View Supplier Details</button>
                                </div>
                                @error('supplier')
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
                        <h5 class="card-title">Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-horizontal well">
                            <fieldset>
                                <div class="repeater-default">
                                    <div id="productsList" data-repeater-list="products">
                                        @if (old('products'))
                                            @if (count(old('products')) > 0)
                                                @foreach (old('products') as $key => $currentProduct)
                                                    @php $itemCount = \App\Models\PurchaseItem::find($currentProduct['purchaseItemId'])->itemNumbers()->count(); @endphp
                                                    <div data-repeater-item class="repeater">
                                                        <div class="form-group row d-flex align-items-end">
                                                            <div class="col-sm-4 my-2">
                                                                <input type="hidden" name="products[0][purchaseItemId]" value="{{ $currentProduct['purchaseItemId'] }}">
                                                                <label class="form-label">Product</label>
                                                                <select name="products[{{ $key }}][product]" required class="select2-single form-control item-name">
                                                                    <option value="">Select Product</option>
                                                                    @foreach ($products as $product)
                                                                        <option @if ($currentProduct['product'] == $product['id'])
                                                                            selected
                                                                        @endif value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="products[{{ $key }}][ids]" value="{{ $currentProduct['ids'] }}" class="product">
                                                                @error('products.'.$key.'.product')
                                                                    <span class="text-danger small" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div><!--end col-->

                                                            <div class="col-sm-4 my-2 item-quantity">
                                                                <label class="form-label">Quantity</label>
                                                                <input type="number" step="any" value="{{ $currentProduct['quantity'] }}" name="products[{{ $key }}][quantity]" placeholder="0" oninput="addItemNumberFields(this, '{{ $key }}', $(this).next().val())" class="form-control quantity">
                                                                <input type="hidden" value="{{ $itemCount }}">
                                                                @error('products.'.$key.'.quantity')
                                                                    <span class="text-danger small" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div><!--end col-->

                                                            <div class="col-sm-4 my-2 item-unit-price">
                                                                <label class="form-label">Unit Price</label>
                                                                <input type="number" step="any" value="{{ $currentProduct['price'] }}" name="products[{{ $key }}][price]" placeholder="0" class="form-control">
                                                                @error('products.'.$key.'.price')
                                                                    <span class="text-danger small" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div><!--end col-->

                                                            @php
                                                                $purchaseItem = App\Models\PurchaseItem::find($currentProduct['purchaseItemId']);
                                                            @endphp

                                                            <div class="col-sm-3 my-2 item-brand">
                                                                <label class="form-label">Brand</label>
                                                                <select name="products[{{ $key }}][brand]" class="select2-single form-control">
                                                                    <option value="">Select Brand</option>
                                                                    @if($currentProduct['purchaseItemId'])
                                                                        @foreach ($purchaseItem->product->brands()->get() as $brand)
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
                                                                    <select name="products[{{ $key }}][{{ $variation['name'] }}]" class="select2-single form-control">
                                                                        <option value="">Select {{ $variation['name'] }}</option>
                                                                        @if($currentProduct['purchaseItemId'])
                                                                            @foreach ($purchaseItem->variationItems()->where('variation_id', $variation['id'])->get() as $currentItem)
                                                                                <option @if (in_array($currentItem['id'], $purchaseItem->getVariationItemsIdToArray()))
                                                                                    selected
                                                                                @endif value="{{ $currentItem['id'] }}">{{ $currentItem['name'] }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div><!--end col-->
                                                            @endforeach

                                                            <div class="col-sm-12 my-2 item-numbers">
                                                                <label class="form-label">Item Number(s)</label>
                                                                <div id="existingItemNumbers" class="row old-item-number-fields">
                                                                    @if(isset($currentProduct['old_item_numbers']))
                                                                        @foreach($currentProduct['old_item_numbers'] as $curKey => $item)
                                                                            <div class="col-md-4">
                                                                                @if($item['status'] == 'sold')
                                                                                    <div style="position: relative">
                                                                                        <span style="position: absolute; right: 8px; top: 6px" class="text-info">sold</span>
                                                                                        <input type="text" value="{{ $item['no'] }}" readonly name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][no]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][no]" class="form-control item-number-values my-2">
                                                                                        <input type="hidden" value="{{ $item['id'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][id]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][id]" class="item-number-values my-2">
                                                                                        <input type="hidden" value="{{ $item['status'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][status]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][status]" class="item-number-values my-2">
                                                                                    </div>
                                                                                @else
                                                                                    <div class="d-flex justify-content-between">
                                                                                        <input type="text" value="{{ $item['no'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][no]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][no]" class="form-control item-number-values my-2">
                                                                                        <input type="hidden" value="{{ $item['id'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][id]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][id]" class="item-number-values">
                                                                                        <input type="hidden" value="{{ $item['status'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][status]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][status]" class="item-number-values my-2">
                                                                                        <div class="ml-3 align-self-center">
                                                                                            <button type="button" onclick="deleteItemNumber(this, '{{ $item['id'] }}')" class="btn btn-danger-rgba"> <i class="fa fa-trash-o"></i></button>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @error('products.'.$key.'.old_item_numbers.'.$curKey.'.no')
                                                                                    <span class="text-danger small" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                                <div class="form-group row d-flex align-items-end new-item-number-fields" id="newItemNumbers">
                                                                    @if(isset($currentProduct['item_numbers']))
                                                                        @foreach($currentProduct['item_numbers'] as $curKey => $item)
                                                                            <div class="col-md-4 my-1">
                                                                                <div class="d-flex justify-content-between">
                                                                                    <input type="text" name="products[{{ $key }}][item_numbers][{{ $curKey }}]" required class="form-control item-number-values my-2" id="products[{{ $key }}][item_numbers][{{ $curKey }}]" placeholder="Enter Unique Item Number" value="{{ $item }}">
                                                                                    <div class="ml-3 align-self-center">
                                                                                        <span class="btn btn-outline-danger" onclick="removeItemNumberFields(this)">
                                                                                            <span class="fa fa-trash me-1"></span>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                                @error('products.'.$key.'.item_numbers.'.$curKey)
                                                                                    <span class="text-danger small" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                @enderror
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div><!--end col-->
                                                        </div><!--end row-->
                                                        <hr>
                                                    </div><!--end /div-->
                                                @endforeach
                                            @else
                                                <div data-repeater-item  class="repeater">
                                                    <div class="form-group row d-flex align-items-end">
                                                        <div class="col-sm-4 my-2">
                                                            <label class="form-label">Product</label>
                                                            <input type="hidden" name="products[0][purchaseItemId]">
                                                            <select name="products[0][product]" required class="form-control select2-single item-name">
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
                                                            <select name="products[0][brand]" class="select2-single form-control">
                                                                <option value="">Select Brand</option>
                                                            </select>
                                                        </div>

                                                        @foreach ($variations as $variation)
                                                            <div class="col-sm-3 my-2 variation-{{ $variation['name'] }}">
                                                                <label class="form-label text-capitalize">{{ $variation['name'] }}</label>
                                                                <select name="products[0][{{ $variation['name'] }}]" class="select2-single form-control">
                                                                    <option value="">Select {{ $variation['name'] }}</option>
                                                                </select>
                                                            </div><!--end col-->
                                                        @endforeach


                                                        <div class="col-sm-12 my-2 item-numbers">
                                                            <label class="form-label">Item Number(s)</label>
                                                            <div class="form-group row d-flex align-items-end new-item-number-fields" id="newItemNumbers"></div>
                                                        </div>

                                                    </div><!--end row-->
                                                    <hr>
                                                </div><!--end /div-->
                                            @endif
                                        @else
                                            @php
                                                $fetchedPurchaseItems = $purchase->items()->get();
                                            @endphp
                                            @if (count($fetchedPurchaseItems) > 0)
                                                @foreach ($fetchedPurchaseItems as $key => $currentProduct)
                                                    @php $itemCount = $currentProduct->itemNumbers()->count(); @endphp
                                                    <div data-repeater-item class="repeater">
                                                        <div class="form-group row d-flex align-items-end">
                                                            <div class="col-sm-4 my-2">
                                                                <input type="hidden" name="products[{{ $key }}][purchaseItemId]" value="{{ $currentProduct['id'] }}">
                                                                <label class="form-label">Product</label>
                                                                <select name="products[{{ $key }}][product]" required class="form-control select2-single item-name">
                                                                    <option value="">Select Product</option>
                                                                    @foreach ($products as $product)
                                                                        <option @if ($currentProduct['product_id'] == $product['id'])
                                                                            selected
                                                                        @endif value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="products[{{ $key }}][ids]" value="{{ $key }}" class="product">
                                                                @error('products.'.$key.'.product')
                                                                    <span class="text-danger small" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div><!--end col-->

                                                            <div class="col-sm-4 my-2 item-quantity">
                                                                <label class="form-label">Quantity</label>
                                                                <input type="number" step="any" value="{{ $currentProduct['quantity'] }}" name="products[{{ $key }}][quantity]" placeholder="0" oninput="addItemNumberFields(this, '{{ $key }}', $(this).next().val())" class="form-control quantity">
                                                                <input type="hidden" value="{{ $itemCount }}">
                                                                @error('products.'.$key.'.quantity')
                                                                    <span class="text-danger small" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div><!--end col-->

                                                            <div class="col-sm-4 my-2 item-unit-price">
                                                                <label class="form-label">Unit Price</label>
                                                                <input type="number" step="any" value="{{ $currentProduct['price'] }}" name="products[{{ $key }}][price]" placeholder="0" class="form-control">
                                                                @error('products.'.$key.'.price')
                                                                    <span class="text-danger small" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div><!--end col-->

                                                            <div class="col-sm-3 my-2 item-brand">
                                                                <label class="form-label">Brand</label>
                                                                <select name="products[{{ $key }}][brand]" class="select2-single form-control">
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
                                                                    <select name="products[0][{{ $variation['name'] }}]" class="select2-single form-control">
                                                                        <option value="">Select {{ $variation['name'] }}</option>
                                                                        @foreach ($currentProduct->product->variationItems()->where('variation_id', $variation['id'])->get() as $currentItem)
                                                                            <option @if (in_array($currentItem['id'], $currentProduct->getVariationItemsIdToArray()))
                                                                                selected
                                                                            @endif value="{{ $currentItem['id'] }}">{{ $currentItem['name'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div><!--end col-->
                                                            @endforeach

                                                            <div class="col-sm-12 my-2 item-numbers">
                                                                <label class="form-label">Item Number(s)</label>
                                                                <div id="existingItemNumbers" class="row old-item-number-fields">
                                                                    @foreach($currentProduct->itemNumbers as $curKey => $item)
                                                                        <div class="col-md-4">
                                                                            @if($item['status'] == 'sold')
                                                                                <div style="position: relative">
                                                                                    <span style="position: absolute; right: 8px; top: 6px" class="text-info">sold</span>
                                                                                    <input type="text" value="{{ $item['no'] }}" readonly name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][no]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][no]" class="form-control item-number-values my-2">
                                                                                    <input type="hidden" value="{{ $item['id'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][id]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][id]" class="item-number-values">
                                                                                    <input type="hidden" value="{{ $item['status'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][status]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][status]" class="item-number-values">
                                                                                </div>
                                                                            @else
                                                                                <div class="d-flex justify-content-between">
                                                                                    <input type="text" value="{{ $item['no'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][no]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][no]" class="form-control item-number-values my-2">
                                                                                    <input type="hidden" value="{{ $item['id'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][id]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][id]" class="item-number-values">
                                                                                    <input type="hidden" value="{{ $item['status'] }}" name="products[{{ $key }}][old_item_numbers][{{ $curKey }}][status]" id="products[{{ $key }}][old_item_numbers][{{ $curKey }}][status]" class="item-number-values">
                                                                                    <div class="ml-3 align-self-center">
                                                                                        <button type="button" onclick="deleteItemNumber(this, '{{ $item['id'] }}')" class="btn btn-danger-rgba"> <i class="fa fa-trash-o"></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="form-group row d-flex align-items-end new-item-number-fields" id="newItemNumbers"></div>
                                                            </div>
                                                        </div><!--end row-->
                                                        <hr>
                                                    </div><!--end /div-->
                                                @endforeach
                                            @else
                                                <div data-repeater-item class="repeater">
                                                    <div class="form-group row d-flex align-items-end">
                                                        <div class="col-sm-4 my-2">
                                                            <label class="form-label">Product</label>
                                                            <input type="hidden" name="products[0][purchaseItemId]">
                                                            <select name="products[0][product]" required class="form-control select2-single item-name">
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
                                                            <select name="products[0][brand]" class="select2-single form-control">
                                                                <option value="">Select Brand</option>
                                                            </select>
                                                        </div><!--end col-->

                                                        @foreach ($variations as $variation)
                                                            <div class="col-sm-3 my-2 variation-{{ $variation['name'] }}">
                                                                <label class="form-label text-capitalize">{{ $variation['name'] }}</label>
                                                                <select name="products[0][{{ $variation['name'] }}]" class="select2-single form-control">
                                                                    <option value="">Select {{ $variation['name'] }}</option>
                                                                </select>
                                                            </div><!--end col-->
                                                        @endforeach

                                                        <div class="col-sm-12 my-2 item-numbers">
                                                            <label class="form-label">Item Number(s)</label>
                                                            <div class="form-group row d-flex align-items-end new-item-number-fields" id="newItemNumbers"></div>
                                                        </div>
                                                    </div><!--end row-->
                                                    <hr>
                                                </div><!--end /div-->
                                            @endif
                                        @endif
                                    </div><!--end repet-list-->
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
                                <label for="productTitle" class="col-form-label">Purchase Date</label>
                                <div class="input-group">
                                    <input type="date" value="{{ old('date') ?? $purchase['date']->format('Y-m-d') }}" name="date" class="form-control"/>
                                </div>
                                @error('date')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="productTitle" class="col-form-label">Additional Note</label>
                                <textarea name="note" class="form-control" rows="4">{{ old('note') ?? $purchase['note'] }}</textarea>
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
                                                        <input id="shippingFee" value="{{ old('shipping_fee') ?? $purchase['shipping_fee'] }}" name="shipping_fee" type="number" step="any" class="form-control" placeholder="0.00">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="payment-title">Additional Fee</td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    <li>
                                                        <input id="additionalFee" value="{{ old('additional_fee') ?? $purchase['additional_fee'] }}" name="additional_fee" type="number" step="any" class="form-control" placeholder="0.00">
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
                <button onclick="confirmSubmission('updatePurchaseForm')" class="btn btn-primary">Update Purchase</button>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection


@section('modal')
<div class="modal fade" id="show-supplier-modal" tabindex="-1" role="dialog" aria-labelledby="show-supplier-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="show-supplier-modal-label">Supplier Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="form-group">
                        <label for="currentname" class="col-form-label">Name: <span class="text-danger">*</span></label>
                        <input disabled type="text" name="name" class="form-control" id="currentname">
                    </div>
                    <div class="form-group">
                        <label for="currentemail" class="col-form-label">Email:</label>
                        <input disabled type="email" name="email" class="form-control" id="currentemail">
                    </div>
                    <div class="form-group">
                        <label for="currentphone" class="col-form-label">Phone:</label>
                        <input disabled type="tel" name="phone" class="form-control" id="currentphone">
                    </div>
                    <div class="form-group">
                        <label for="currenttransactions" class="col-form-label">Transactions:</label>
                        <input disabled type="tel" name="transactions" class="form-control" id="currenttransactions">
                    </div>
                    <div class="form-group">
                        <label for="currentaddress" class="col-form-label">Address:</label>
                        <textarea disabled name="address" class="form-control" id="currentaddress"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
        renameItemNumberFields();

        function refreshRepeater() {
            setTimeout(() => {
                const repeaters = $('.repeater')
                $(repeaters[repeaters.length - 1]).find('.old-item-number-fields').html('')
                $(repeaters[repeaters.length - 1]).find('.new-item-number-fields').html('')
                $($(repeaters[repeaters.length - 1]).find('.item-quantity input')[1]).val(0)
                $($(repeaters[repeaters.length - 1]).find('.product')).val(repeaters.length - 1)
            }, 10)
        }

        function removeItemNumberFields(input) {
            const qty = $(input).parent().parent().parent().parent().parent().parent().find('.item-quantity input')
            if (parseInt(qty.val()) > 0)
                qty.val(parseInt(qty.val()) - 1)
            $(input).parent().parent().parent().remove()
            computeSubTotal()
        }
        function addItemNumberFields(input, pid) {
            const quantity = parseInt($(input).val())
            const count = parseInt($(input).next().val())
            let html = '';
            if (quantity > count && quantity <= 50) {
                for(let i = 0; i < (quantity - count); i++) html += `
                    <div class="col-md-4 my-1">
                        <div class="d-flex justify-content-between">
                            <input type="text" name="products[${pid}][item_numbers][${i}]" required class="form-control item-number-values my-2" id="products[${pid}][item_numbers][${i}]" placeholder="Enter Unique Item Number">
                            <div class="ml-3 align-self-center">
                                <span class="btn btn-outline-danger" onclick="removeItemNumberFields(this)">
                                    <span class="fa fa-trash me-1"></span>
                                </span>
                            </div>
                        </div>
                    </div>`
                $(input).parent().parent().find('.new-item-number-fields').html(html)
            } else {
                $(input).val(count)
                $(input).parent().parent().find('.new-item-number-fields').html('')
            }
        }

        function renameItemNumberFields() {
            const itemFields = $('.item-number-values');
            setTimeout(() => {
                itemFields.each(i => $(itemFields[i]).prop('name', $(itemFields[i]).prop('id')))
            }, 50)
        }

        productsList.on('change', 'div div div select.item-name', function() {
            fetchProductDetailsAndComputeSubTotal($(this));
        })

        toggleSuppierDetailsButton();
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

        function toggleSuppierDetailsButton()
        {
            if ($('#supplierField').find(":selected").prop('value')) $('#getSupplierDetailBtn').fadeIn(500);
            else $('#getSupplierDetailBtn').fadeOut(500);
        }

        function fetchProductDetails(el){
            $.ajax({
                type: 'GET',
                url: '/admin/'+ el.val() +'/getProductDetails',
                success: function (data) {
                    clearBrands(el);
                    clearVariations(el);
                    setBrands(el, data.brands);
                    setPrice(el, data.buy_price);
                    setVariations(el, data.variations);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function deleteItemNumber(el, id) {
            $.ajax({
                type: 'DELETE',
                url: '/admin/item-number/'+ id +'/delete',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function (res) {
                    console.log(res)
                    new PNotify( {
                        title: 'Success', text: res.msg, type: 'success'
                    });
                    $(el).parent().parent().parent().parent().parent().parent().find('.item-quantity input.quantity').val(res.count)
                    $(el).parent().parent().parent().parent().parent().parent().find('.item-quantity input.quantity').next().val(res.count)
                    $(el).parent().parent().parent().remove()
                    computeSubTotal()
                },
                error: function(err) {
                    console.log(err);
                    new PNotify( {
                        title: 'Error', text: err['responseJSON'].msg, type: 'error'
                    });
                }
            });
        }

        function getSupplierDetails() {
            const id = $('#supplierField').find(":selected").prop('value');
            if (id) {
                $.ajax({
                type: 'GET',
                url: '/admin/'+ id +'/getSupplierDetails',
                success: function (data) {
                    $('#currentname').val(data.name);
                    $('#currentemail').val(data.email);
                    $('#currentphone').val(data.phone);
                    $('#currentaddress').val(data.address);
                    $('#currenttransactions').val(data.transactions);
                    $('#show-supplier-modal').modal();
                },
                error: function(err) {
                    console.log(err);
                }
            });
            }
        }

    </script>
@endsection
