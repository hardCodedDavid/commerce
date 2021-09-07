@extends('layouts.admin')

@section('title', 'Subscriptions')

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
                <h4 class="page-title">Subscriptions</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Subscriptions</li>
                    </ol>
                </div>
            </div>
            @can('Send Newsletter')
                <div class="col-md-4 col-lg-4">
                    <div class="widgetbar">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#mail-modal" class="btn btn-primary"><i class="ri-send-plane-2-fill mr-2"></i>Send Newsletter</a>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection

@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header d-sm-flex d-block justify-content-between align-content-center">
                        <h5 class="card-title my-1">Subscriptions</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="subscriptionTable" class="table">
                                <thead>
                                <tr>
                                    <th><i class="fa fa-list-ul"></i></th>
                                    <th>Email</th>
                                    <th>Date</th>
                                    @can('Delete Subscriptions')
                                        <th>Action</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subscriptions as $key => $sub)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $sub->email }}</td>
                                        <td>{{ Carbon\Carbon::make($sub->created_at)->format('M d, Y') }}</td>
                                        @can('Delete Subscriptions')
                                            <td>
                                                <div class="dropdown">
                                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)" type="button" onclick="event.preventDefault(); confirmSubmission('deleteForm-{{ $sub->id }}')"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash mr-2"></i> <span class="">Delete</span></a>
                                                        <form method="POST" id="deleteForm-{{ $sub->id }}" class="d-none" action="{{ route('admin.deleteSubscription', $sub->id) }}">
                                                            @csrf @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        @endcan
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
    <!-- End Contentbar -->
@endsection

@section('modal')
    <div class="modal fade" id="mail-modal" tabindex="-1" role="dialog" aria-labelledby="mail-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="show-supplier-modal-label">Newsletter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('admin.sendMail') }}">
                        @csrf
                        <div class="form-group">
                            <label for="subject" class="col-form-label">Subject: <span class="text-danger">*</span></label>
                            <input type="text" name="subject" required class="form-control" id="subject" value="{{ old('subject') }}">
                            @error('name') <span class="text-danger" role="alert"> {{ $message }} </span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="body" class="col-form-label">Body: <span class="text-danger">*</span></label>
                            <textarea name="body" id="body" required class="form-control" cols="30" rows="5">{!! old('body') !!}</textarea>
                            @error('body') <span class="text-danger" role="alert"> {{ $message }} </span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="additional_note" class="col-form-label">Additional Note: </label>
                            <textarea name="additional_note" id="additional_note" class="form-control" cols="30" rows="3">{!! old('additional_note') !!}</textarea>
                            @error('additional_note') <span class="text-danger" role="alert"> {{ $message }} </span> @enderror
                        </div>
                        <div class="form-group text-right m-3">
                            <button type="submit" class="btn btn-success"><i class="fa fa-send mr-2"></i> Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace( 'body' );
            $('#subscriptionTable').DataTable({
                "lengthMenu": [50, 100, 200, 500]
            });
        });
    </script>
@endsection
