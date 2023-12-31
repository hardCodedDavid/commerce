@extends('layouts.admin')

@section('title', 'New Sale')

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
{{--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
{{--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>--}}
<style>
    .select2-selection__choice {
        color: white !important;
        background: #190D3F !important;
    }
    .select2-selection__choice__remove {
        color: white !important;
    }
</style>
@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">New Sale</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.sales') }}">Sale</a></li>
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
        <div class="row">
            <!-- Start col -->
            <form method="POST" action="{{ route('admin.transactions.sales.store') }}" id="createSaleForm" class="col-lg-12">
                @csrf
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Customer Detail</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6 my-1">
                                <label class="col-form-label">Name</label>
                                <div>
                                    <input type="text" value="{{ old('customer_name') }}" name="customer_name" class="form-control">
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
                                    <input type="email" value="{{ old('customer_email') }}" name="customer_email" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 my-1">
                                <label class="col-form-label">Phone</label>
                                <div>
                                    <input type="text" value="{{ old('customer_phone') }}" name="customer_phone" placeholder="2349000000000" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6 my-1">
                                <label class="col-form-label">Address</label>
                                <div>
                                    <input class="form-control" name="customer_address" value="{{ old('customer_address') }}" type="text" placeholder="Address" id="searchTextField" autocomplete="on" runat="server" />
                                    <input type="hidden" id="cityLat" name="cityLat" value="{{ old('cityLat') }}" />
                                    <input type="hidden" id="cityLng" name="cityLng" value="{{ old('cityLng') }}" />
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
                                            @foreach (old('products') as $key=>$currentProduct)
                                            <div data-repeater-item class="repeater">
                                                <div class="form-group row d-flex align-items-start">
                                                    <div class="col-sm-4 my-2">
                                                        <label class="form-label">Product</label>
                                                        <select name="products[{{ $key }}][product]" required class="form-control select2-single item-name">
                                                            <option value="">Select Product</option>
                                                            @foreach ($products as $product)
                                                                <option @if ($currentProduct['product'] == $product['id'])
                                                                    selected
                                                                @endif value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" value="{{ $currentProduct['id'] }}" name="products[{{ $key }}][id]" class="product-ids">
                                                        @error('products.'.$key.'.product')
                                                            <span class="text-danger small" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div><!--end col-->

                                                    <div class="col-sm-4 my-2 item-quantity">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number" step="any" value="{{ $currentProduct['quantity'] }}" name="products[{{ $key }}][quantity]" placeholder="0" class="form-control">
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
                                                        </select>
                                                    </div>

                                                    @foreach ($variations as $variation)
                                                        <div class="col-sm-3 my-2 variation-{{ $variation['name'] }}">
                                                            <label class="form-label text-capitalize">{{ $variation['name'] }}</label>
                                                            <select name="products[{{ $key }}][{{ $variation['name'] }}]" class="select2-single form-control">
                                                                <option value="">Select {{ $variation['name'] }}</option>
                                                            </select>
                                                        </div><!--end col-->
                                                    @endforeach

                                                    <div class="col-sm-12 my-2 item-numbers">
                                                        <label class="form-label">Item Number(s)</label>
                                                        <span class="text-danger d-flex mx-auto small" role="alert">
                                                            <strong id="item-number-warning">Select Quantity</strong>
                                                        </span>
                                                        <select class="select2-multi-select form-control" name="products[{{ $key }}][item_numbers]" id="oldItemNumbers-{{ $key }}" multiple="multiple">
                                                            <option value="">Select Item Number</option>
{{--                                                            @if(isset($currentProduct['item_numbers']))--}}
{{--                                                                @php $product = App\Models\Product::find($currentProduct['product']); @endphp--}}
{{--                                                                @if($product)--}}
{{--                                                                    @foreach($product->itemNumbers()->where('status', 'available')->get() as $curKey => $item)--}}
{{--                                                                        <option value="{{ $item['id'] }}">{{ $item['no'] }}</option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                @endif--}}
{{--                                                            @endif--}}
                                                        </select>
                                                        @error('products.'.$key.'.item_numbers')
                                                            <span class="text-danger small" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

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
                                        <div data-repeater-item class="repeater">
                                            <div class="form-group row d-flex align-items-end">
                                                <div class="col-sm-4 my-2">
                                                    <label class="form-label">Product</label>
                                                    <select name="products[0][product]" required class="select2-single form-control item-name" onchange="$(this).parent().find('.product-ids').val($(this).val())">
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" value="" name="products[0][id]" class="product-ids">
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
                                                    <span class="text-danger d-flex mx-auto small" role="alert">
                                                        <strong id="item-number-warning">Select Quantity</strong>
                                                    </span>
                                                    <select class="select2-multi-select form-control" name="products[0][item_numbers]" multiple="multiple">
                                                        <option value="">Select Item Number</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1 my-2">
                                                    <span data-repeater-delete class="btn btn-outline-danger">
                                                        <span class="fa fa-trash me-1"></span>
                                                    </span>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                            <hr>
                                        </div><!--end /div-->
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
                                    <input type="date" value="{{ old('date') }}" name="date" class="form-control"/>
                                </div>
                                @error('date')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="productTitle" class="col-form-label">Additional Note</label>
                                <textarea name="note" class="form-control" rows="4">{{ old('note') }}</textarea>
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
                                                        <input id="shippingFee" value="{{ old('shipping_fee') }}" name="shipping_fee" type="number" step="any" class="form-control" placeholder="0.00">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="payment-title">Additional Fee</td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    <li>
                                                        <input id="additionalFee" value="{{ old('additional_fee') }}" name="additional_fee" type="number" step="any" class="form-control" placeholder="0.00">
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
                <button onclick="confirmSubmission('createSaleForm')" class="btn btn-primary">Create Sale</button>
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
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('PLACES_API_KEY') }}&libraries=places" type="text/javascript"></script>
    <script>

        $(document).ready(() => {
            const select2 = $('.select2-multi-select')
            select2.select2({
                placeholder: 'Select an item number',
                tags: true
            });
            setTimeout(() => {
                $('.item-quantity input').on('input', function () {
                    updateQty($(this).parent().parent().find('.item-numbers select'))
                })
                $('.item-numbers select').on('change', function () {
                    updateQty(this)
                })
            }, 10)
            setTimeout(() => {
                const itemNumbers = $('.item-numbers select')
                itemNumbers.each(i => updateQty(itemNumbers[i]))
            }, 1000)
        })
        const variationList = {!! json_encode($variations) !!};
        const productsList = $('#productsList');
        const additionalFee = $('#additionalFee');
        const shippingFee = $('#shippingFee');
        productsList.on('change', 'div div div select.item-name', function() {
            fetchProductDetailsAndComputeSubTotal($(this));
        })

        productsList.find('div div div select.item-name').each(function() {
            fetchProductDetailsAndComputeSubTotal($(this));
        })

        function reInitializeSingleSelect() {
            setTimeout(() => {
                $('.select2-single').select2()
                const repeaters = $('.repeater')
                $(repeaters[repeaters.length - 1]).find('.item-numbers select').attr('id', 'oldItemNumbers-'+(repeaters.length - 1)).html('')
                $('.select2-multi-select').select2({placeholder: 'Select an item number', tags: true});

                $('.item-quantity input').on('input', function () {
                    updateQty($(this).parent().parent().find('.item-numbers select'))
                })
                $('.item-numbers select').on('change', function () {
                    updateQty(this)
                })
            }, 10)
        }

        additionalFee.on('input', computeSubTotal);

        shippingFee.on('input', computeSubTotal);

        productsList.on('input', 'div div div.item-unit-price input', computeSubTotal);

        productsList.on('input', 'div div div.item-quantity input', computeSubTotal);

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

        function clearBrands(el){
            el.parent().parent().find('.item-brand select').html('<option value="">Select Brand</option>');
        }

        function setItemNumbers(el, itemNumbers) {
            if(el) {
                itemNumbers.forEach(itemNumber => {
                    el.parent().parent().find('.item-numbers select').append(`<option value="${itemNumber.id}">${itemNumber.no}</option>`);
                });

                const oldProducts = {!! json_encode(old('products')) !!};
                if (oldProducts)
                    if (oldProducts.length > 0) {
                        $(oldProducts).each(i => {
                            const itemNumbers = oldProducts[i]['item_numbers']
                            if (itemNumbers)
                                if (itemNumbers.length > 0) {
                                    $(`#oldItemNumbers-${i} option`).each(function () {
                                        if (itemNumbers.find(cur => parseInt($(this).prop('value')) === parseInt(cur))) $(this).prop('selected', true);
                                    })
                                }
                        });
                    }

                $('.select2-multi-select').select2({
                    placeholder: 'Select an item number',
                    tags: true
                });
            }
        }

        function updateQty(el) {
            const qty = $(el).parent().parent().find('.item-quantity input').val() ?? 0
            const text = $(el).prev().children()[0]
            const val = $(el).val().length

            if (parseInt(qty) !== parseInt(val) || parseInt(qty) < 1)
                $(text).parent().addClass('text-danger').removeClass('text-success')
            else
                $(text).parent().removeClass('text-danger').addClass('text-success')
            if (qty < 1)
                $(text).html('Select quantity')
            else
                $(text).html(val + ' of ' + qty + ' selected')
        }

        function clearItemNumbers(el){
            if (el) {
                el.parent().parent().find('.item-numbers select').html('');
                el.parent().parent().find('.item-numbers select').select2({
                    placeholder: 'Select an item number', tags: true
                });
            }
        }

        function setPrice(el, price){
            el.parent().parent().find('.item-unit-price input').val(price);
        }

        function clearPrice(el){
            el.parent().parent().find('.item-unit-price input').val('');
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
            $('#totalAmount').text(`₦ ${numberFormat(fetchTotal())}`)
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

        function fetchProductDetails(el) {
            $.ajax({
                type: 'GET',
                url: '/admin/'+ el.val() +'/getProductDetails',
                success: function (data) {
                    clearBrands(el);
                    clearVariations(el);
                    clearPrice(el);
                    // clearItemNumbers(el, 'new');
                    setItemNumbers(el, data.itemNumbers);
                    setBrands(el, data.brands);
                    setVariations(el, data.variations);
                    setPrice(el, data.sell_price);
                    // $(el).parent().parent().find('.item-quantity input').val(data.quantity)
                    computeSubTotal()
                    $('.select2-multi-select').select2({
                        placeholder: 'Select an item number',
                        tags: true
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function initialize() {
            var input = document.getElementById('searchTextField');
            var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                // document.getElementById('city2').value = place.name;
                document.getElementById('cityLat').value = place.geometry.location.lat();
                document.getElementById('cityLng').value = place.geometry.location.lng();
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@endsection
