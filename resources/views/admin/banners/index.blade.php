@extends('layouts.admin')

@section('title', 'Banners')

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
                <h4 class="page-title">Banners</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Banners</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#banner-modal"><i class="ri-add-fill mr-2"></i>New Banner</button>
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
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title my-1">Banners</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list-ul"></i></th>
                                        <th>Banner</th>
                                        <th>Position</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banners as $key=>$banner)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img style="border-radius: 3px" width="100px" src="{{ asset($banner['url']) }}" alt="Banner{{ $key+1 }}"></td>
                                            <td>{{ $banner['position'] }}</td>
                                            <td>{{ $banner['created_at']->format('M d, Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                        <button onclick="populateEditModal({{ $banner['id'] }}, '{{ $banner['position'] }}')" data-toggle="modal" data-target="#edit-banner-modal" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></button>
                                                        <button onclick="event.preventDefault(); confirmSubmission('deleteForm{{ $banner['id'] }}')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                                                        <form method="POST" id="deleteForm{{ $banner['id'] }}" action="{{ route('admin.banners.destroy', $banner) }}">
                                                            @csrf
                                                            @method('DELETE')
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
    <!-- End Contentbar -->
@endsection

@section('modal')
    <div class="modal fade" id="banner-modal" tabindex="-1" role="dialog" aria-labelledby="banner-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="banner-modal-label">New Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="createBannerForm" action="{{ route('admin.banners.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="position" class="col-form-label">Position: <span class="text-danger">*</span></label>
                            <select name="position" class="form-control" id="position">
                                <option value="">Select Position</option>
                                <option @if(old('position') == "top") selected @endif value="top">Top</option>
                                <option @if(old('position') == "side") selected @endif value="side">Side</option>
                                <option @if(old('position') == "bottom") selected @endif value="bottom">Bottom</option>
                            </select>
                            @error('position')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">File: <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control-file" id="file">
                            @error('file')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('createBannerForm')" class="btn btn-primary">Create Banner</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-banner-modal" tabindex="-1" role="dialog" aria-labelledby="edit-banner-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-banner-modal-label">Edit Banner</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="updateBannerForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="position" class="col-form-label">Position: <span class="text-danger">*</span></label>
                            <select name="position" id="updatedPosition" class="form-control" id="position">
                                <option value="">Select Position</option>
                                <option value="top">Top</option>
                                <option value="side">Side</option>
                                <option value="bottom">Bottom</option>
                            </select>
                            @error('position')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">File:</label>
                            <input type="file" name="file" class="form-control-file" id="file">
                            @error('file')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('updateBannerForm')" class="btn btn-primary">Update Banner</button>
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
<script>
    function populateEditModal(id, position) {
        $('#updatedPosition option').each(function() {
            if ($(this).prop('value') === position) $(this).prop('selected', true);
        });
        $('#updateBannerForm').prop('action', `/admin/banners/${id}/update`);
    }
</script>
@endsection