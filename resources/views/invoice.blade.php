<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/page-invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Oct 2020 00:47:12 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Olian is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, admin theme, bootstrap 4, responsive, sass support, ui kits, crm, ecommerce">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ ucwords($type) }} Receipt</title>
    <link rel="shortcut icon" href="{{ asset('logo/5.png') }}">
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="{{ asset('admin/assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet">
    <!-- Slick css -->
    <link href="{{ asset('admin/assets/plugins/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/plugins/pnotify/css/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="vertical-layout">
    <div id="containerbar">
        <div class="col-md-10 mx-auto">
             <!-- Start Contentbar -->
            <div class="contentbar">
                <!-- End row -->
                <div class="row justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="invoice">
                                    <div class="invoice-head">
                                        <div class="row">
                                            @php
                                                $settings = App\Models\Setting::first();
                                            @endphp
                                            <div class="col-12 col-md-7 col-lg-7">
                                                <div class="invoice-logo">
                                                    <img src="{{ asset($settings['logo']) }}" class="img-fluid" alt="">
                                                </div>
                                                <h4>{{ $settings['name'] ?? env('APP_NAME') }}</h4>
                                                <p class="mb-0">{{ $settings['address'] }}</p>
                                            </div>
                                            <div class="col-12 col-md-5 col-lg-5">
                                                <div class="invoice-name">
                                                    <p class="mb-1">No : <b>#{{ $data['code'] }}</b></p>
                                                    <p class="mb-0">{{ $data['date']->format('d M, Y') }}</p>
                                                    <h4 class="text-success mb-0 mt-3">₦{{ number_format($data->getTotal()) }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($type == 'sales')
                                    <div class="invoice-billing">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="invoice-address">
                                                    <h6 class="mb-3">Customer Details</h6>
                                                    <h6 class="text-muted">{{ $data['customer_name'] }}</h6>
                                                    <ul class="list-unstyled">
                                                        <li>{{ $data['customer_address'] }}</li>
                                                        <li>{{ $data['customer_phone'] }}</li>
                                                        <li>{{ $data['customer_email'] }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @if ($data['note'])
                                            <div class="col-md-6">
                                                <div class="invoice-address">
                                                    <h6 class="mb-3">Sale Note</h6>
                                                    <ul class="list-unstyled">
                                                        <li>{{ $data['note'] }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @else
                                    <div class="invoice-billing">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="invoice-address">
                                                    <h6 class="mb-3">Supplier Details</h6>
                                                    <h6 class="text-muted">{{ $data['supplier']['name'] }}</h6>
                                                    <ul class="list-unstyled">
                                                        <li>{{ $data['supplier']['address'] }}</li>
                                                        <li>{{ $data['supplier']['phone'] }}</li>
                                                        <li>{{ $data['supplier']['email'] }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @if ($data['note'])
                                            <div class="col-md-6">
                                                <div class="invoice-address">
                                                    <h6 class="mb-3">Purchase Note</h6>
                                                    <ul class="list-unstyled">
                                                        <li>{{ $data['note'] }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    <div class="invoice-summary">
                                        <div class="table-responsive ">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Brand</th>
                                                        @foreach ($variations as $variation)
                                                            <th scope="col">{{ ucfirst($variation['name']) }}</th>
                                                        @endforeach
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Item Number(s)</th>
                                                        <th scope="col">Unit Price</th>
                                                        <th scope="col">Total Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data->items()->get() as $key=>$item)
                                                        <tr>
                                                            <th scope="row">{{ $key + 1 }}</th>
                                                            <td>{{ $item->product['name'] }}</td>
                                                            <td>{{ $item->brand['name'] ?? 'N/A' }}</td>
                                                            @foreach ($variations as $variation)
                                                                @php $value = null; @endphp
                                                                @foreach ($item->product->variationItems()->get() as $currentVariationItem)
                                                                    @if ($currentVariationItem['variation_id'] == $variation['id'])
                                                                        @php $value = $currentVariationItem['name'] @endphp
                                                                    @endif
                                                                @endforeach
                                                                <td>{{ $value ?? 'N/A' }}</td>
                                                            @endforeach
                                                            <td>{{ $item['quantity'] }}</td>
                                                            <td>
                                                                @foreach (json_decode($item['item_numbers'], true) as $number)
                                                                    <span class="small bg-light mx-1 px-1">{{ array_values($number)[0] }}</span>
                                                                @endforeach
                                                            </td>
                                                            <td>₦{{ number_format($item['price']) }}</td>
                                                            <td>₦{{ number_format($item['price'] * $item['quantity']) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="invoice-summary-total">
                                        <div class="row">
                                            <div class="offset-md-6 col-md-6">
                                                <div class="order-total table-responsive ">
                                                    <table class="table table-borderless text-right">
                                                        <tbody>
                                                            <tr>
                                                                <td>Sub Total :</td>
                                                                <td>₦{{ number_format($data->getSubTotal()) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Shipping Fee :</td>
                                                                <td>₦{{ $data['shipping_fee'] ?? 0 }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Additional Fee :</td>
                                                                <td>₦{{ $data['additional_fee'] ?? 0 }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="f-w-7 font-18"><h5>Total :</h5></td>
                                                                <td class="f-w-7 font-18"><h5>₦{{ number_format($data->getTotal()) }}</h5></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-footer">
                                        <div class="row align-items-center">
                                            <div class="offset-md-4 col-md-8 d-flex justify-content-end">
                                                <div class="invoice-footer-btn">
                                                    <a href="javascript:window.print()" id="printBtn" class="btn btn-primary py-1 font-16"><i class="ri-printer-line mr-2"></i>Print</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Contentbar -->
        </div>
        <!-- End Rightbar -->
    </div>
    <script>
        document.getElementById('printBtn').click();
    </script>
</body>

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/page-invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Oct 2020 00:47:16 GMT -->
</html>
