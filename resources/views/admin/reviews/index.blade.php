@extends('layouts.admin')

@section('title', 'Reviews')

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
                <h4 class="page-title">Reviews</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reviews</li>
                    </ol>
                </div>
            </div>
{{--            @can('Add Reviews')--}}
{{--                <div class="col-md-4 col-lg-4">--}}
{{--                    <div class="widgetbar">--}}
{{--                        <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary"><i class="ri-add-fill mr-2"></i>New Review</a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endcan--}}
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
                        <h5 class="card-title my-1">Reviews</h5>
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
                            <table id="reviewTable" class="table">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-list-ul"></i></th>
                                    <th>Name</th>
                                    <th>Review</th>
                                    <th>Status</th>
                                    <th>Date Added</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reviews as $key => $review)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $review['name'] }}</td>
                                        <td>{!! $review['review'] !!}</td>
                                        <td><span class="small badge @if($review['status'] == 'approved') badge-success-inverse @elseif($review['status'] == 'declined') badge-danger-inverse @else badge-secondary-inverse @endif mx-1">{{ $review['status'] }}</span></td>
                                        <td>{{ \Carbon\Carbon::make($review['created_at'])->format('Y/m/d') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action <i class="icon-lg fa fa-angle-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                    <a class="dropdown-item d-flex align-items-center" href="'{{ route('admin.products.show', $review['id']) }}"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-eye mr-2"></i> <span class="">View</span></a>
                                                    <a type="button" href="javascript:void(0)" onclick="event.preventDefault(); confirmSubmission('approveForm-{{ $review['id'] }}')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-check mr-2"></i> <span class="">Approve</span></a>
                                                    <a type="button" href="javascript:void(0)" onclick="event.preventDefault(); confirmSubmission('declineForm-{{ $review['id'] }}')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-times mr-2"></i> <span class="">Decline</span></a>
                                                    <form method="POST" id="approveForm-{{ $review['id'] }}" class="d-none" action="{{ route('admin.reviews.action', [$review['id'], 'approved']) }}">
                                                        @csrf @method('PUT')
                                                    </form>
                                                    <form method="POST" id="declineForm-{{ $review['id'] }}" class="d-none" action="{{ route('admin.reviews.action', [$review['id'], 'declined']) }}">
                                                        @csrf @method('PUT')
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
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
            $('#reviewTable').DataTable({
                {{--"processing": true,--}}
                {{--"serverSide": true,--}}
                {{--"searching": true,--}}
                {{--"ajax":{--}}
                {{--    "url": "{{ route('admin.products.ajax') }}",--}}
                {{--    "dataType": "json",--}}
                {{--    "type": "POST",--}}
                {{--    "data":{ _token: "{{csrf_token()}}", type: "{{ $type }}"}--}}
                {{--},--}}
                {{--"columns": [--}}
                {{--    { "data": "sn" },--}}
                {{--    { "data": "item_number" },--}}
                {{--    { "data": "name" },--}}
                {{--    { "data": "buy_price" },--}}
                {{--    { "data": "sell_price" },--}}
                {{--    { "data": "discount" },--}}
                {{--    { "data": "sku" },--}}
                {{--    { "data": "in_stock" },--}}
                {{--    { "data": "quantity" },--}}
                {{--    { "data": "weight" },--}}
                {{--    { "data": "variations" },--}}
                {{--    { "data": "status" },--}}
                {{--    { "data": "action" }--}}
                {{--],--}}
                "lengthMenu": [50, 100, 200, 500]
            });
        });
    </script>
@endsection
