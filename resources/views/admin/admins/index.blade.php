@extends('layouts.admin')

@section('title', 'Administrators')

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
                <h4 class="page-title">Administrators</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Administrators</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#administrator-modal"><i class="ri-add-fill mr-2"></i>New Administrator</button>
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
                        <h5 class="card-title my-1">Administrators</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list-ul"></i></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Ation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $key=>$admin)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $admin['name'] }}</td>
                                            <td>{{ $admin['email'] }}</td>
                                            <td>{{ $admin->roles()->first()['name'] ?? '---' }}</td>
                                            <td>
                                                @if ($admin['id'] != 1)
                                                <div class="dropdown">
                                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                        <button onclick="populateEditModal({{ $admin['id'] }}, '{{ $admin['name'] }}', '{{ $admin['email'] }}', '{{ $admin->roles()->first()['id'] }}')" data-toggle="modal" data-target="#edit-administrator-modal" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></button>
                                                        <button onclick="event.preventDefault(); confirmSubmission('deleteForm{{ $admin['id'] }}')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                                                        <form method="POST" id="deleteForm{{ $admin['id'] }}" action="{{ route('admin.admins.destroy', $admin) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </div>
                                                @endif
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
    <div class="modal fade" id="administrator-modal" tabindex="-1" role="dialog" aria-labelledby="administrator-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="administrator-modal-label">New Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="createAdminForm" action="{{ route('admin.admins.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name: <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="name">
                            @error('name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email: <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email">
                            @error('email')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role" class="col-form-label">Role: <span class="text-danger">*</span></label>
                            <select name="role" class="form-control" id="role">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option @if(old('role') == $role['id']) selected @endif value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                @endforeach
                                @error('role')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('createAdminForm')" class="btn btn-primary">Create Administrator</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-administrator-modal" tabindex="-1" role="dialog" aria-labelledby="edit-administrator-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-administrator-modal-label">Edit Administrator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateAdminForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="updatedname" class="col-form-label">Name: <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="updatedname">
                            @error('name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="updatedemail" class="col-form-label">Email: <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="updatedemail">
                            @error('email')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="updatedRole" class="col-form-label">Role: <span class="text-danger">*</span></label>
                            <select name="role" class="form-control" id="updatedRole">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                    <option @if(old('role') == $role['id']) selected @endif value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                @endforeach
                                @error('role')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('updateAdminForm')" class="btn btn-primary">Update Administrator</button>
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
    function populateEditModal(id, name, email, role) {
        $('#updatedRole option').each(function() {
            if ($(this).prop('value') === role) $(this).prop('selected', true);
        });
        $('#updatedname').val(name);
        $('#updatedemail').val(email);
        $('#updateAdminForm').prop('action', `/admin/administrators/${id}/update`);
    }
</script>
@endsection