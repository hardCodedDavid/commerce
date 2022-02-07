@extends('layouts.admin')

@section('title', 'Products')

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
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Products</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>
            </div>
            @can('Add Products')
                <div class="col-md-4 col-lg-4">
                    <div class="widgetbar">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="ri-add-fill mr-2"></i>New Product</a>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <!-- Start col -->
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header d-sm-flex d-block justify-content-between align-content-center">
                    <h5 class="card-title my-1">Products</h5>
                    @can('Export Products')
                    <form method="POST" action="{{ route('admin.products.export') }}" class="d-sm-flex d-block my-1">
                        @csrf
                        <input type="hidden" name="type" value="listed">
                        <div>
                            <input type="text" required name="range" id="range-date" class="datepicker-here form-control" placeholder="From - To" aria-describedby="basic-addon7" />
                        </div>
                        <div>
                            <button class="btn btn-primary"><i class="ri-download-line mr-2"></i>Download CSV</button>
                        </div>
                    </form>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="productTable" class="table">
                            <thead>
                            <tr>
                                <th><i class="fa fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Created By</th>
                                <th>Buy Price</th>
                                <th>Sell Price</th>
                                <th>Discount</th>
                                <th>SKU</th>
                                <th>Stock</th>
                                <th>Avail. Qty</th>
                                <th>Weight</th>
                                <th>Variations</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>
@endsection

@section('script')
    <script src="{{ asset('admin/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/custom-table-datatable.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/custom-form-datepicker.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#productTable').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax":{
                    "url": "{{ route('admin.products.ajax') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}", type: "{{ $type }}"}
                },
                "columns": [
                    { "data": "sn" },
                    { "data": "name" },
                    { "data": "creator" },
                    { "data": "buy_price" },
                    { "data": "sell_price" },
                    { "data": "discount" },
                    { "data": "sku" },
                    { "data": "in_stock" },
                    { "data": "quantity" },
                    { "data": "weight" },
                    { "data": "variations" },
                    { "data": "status" },
                    { "data": "action" }
                ],
                "lengthMenu": [10, 50, 100, 200, 500]
            });
        });
    </script>
@endsection
