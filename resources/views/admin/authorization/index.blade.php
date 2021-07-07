@extends('layouts.admin')

@section('title', 'Authorization')

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
                <h4 class="page-title">Authorization</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Authorization</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#role-modal"><i class="ri-add-fill mr-2"></i>New Role</button>
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
                        <h5 class="card-title my-1">Roles</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list-ul"></i></th>
                                        <th>Role</th>
                                        <th>Administrator</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key=>$role)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $role['name'] }}</td>
                                            <td>{{ $role->users()->count() }}</td>
                                            <td>{{ $role['created_at']->format('M d, Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                        <button onclick="populateEditModal({{ $role['id'] }}, '{{ $role['name'] }}', '{{ $role->permissions()->get()->map(function($sub){ return ['id' => $sub['id'],'name' => $sub['name']]; }); }}')" data-toggle="modal" data-target="#edit-role-modal" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></button>
                                                        <button onclick="event.preventDefault(); confirmSubmission('deleteForm{{ $role['id'] }}')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                                                        <form method="POST" id="deleteForm{{ $role['id'] }}" action="{{ route('admin.authorization.role.destroy', $role) }}">
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
    <div class="modal fade" id="role-modal" tabindex="-1" role="dialog" aria-labelledby="role-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="role-modal-label">New Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.authorization.role.store') }}" id="createRoleForm">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name: <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="name">
                            @error('name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Permissions: <span class="text-danger">*</span></label>
                            <select class="select2-multi-select form-control" name="permissions[]" multiple="multiple">
                                @foreach ($permissions as $permission)
                                    <option @if (old('permissions')) @foreach (old('permissions') as $oldPermission)
                                        @if ($oldPermission == $permission['id']) selected @endif
                                    @endforeach @endif value="{{ $permission['id'] }}">{{ $permission['name'] }}</option>
                                @endforeach
                            </select>
                            @error('permissions')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('createRoleForm')" class="btn btn-primary">Create Role</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-role-modal" tabindex="-1" role="dialog" aria-labelledby="edit-role-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-role-modal-label">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateRoleForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="updatedname" class="col-form-label">Name: <span class="text-danger">*</span></label>
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control" id="updatedname">
                            @error('name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Permissions: <span class="text-danger">*</span></label>
                            <select id="updatedPermission" class="select2-multi-select form-control" name="permissions[]" multiple="multiple">
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission['id'] }}">{{ $permission['name'] }}</option>
                                @endforeach
                            </select>
                            @error('permissions')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('updateRoleForm')" class="btn btn-primary">Update Role</button>
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
<script src="{{ asset('admin/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('admin/assets/plugins/bootstrap-tagsinput/typeahead.bundle.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/custom-form-select.js') }}"></script>
<script>
    function populateEditModal(id, name, permissions) {
        $('#updatedname').val(name);
        const formattedPermissions = JSON.parse(permissions);
        if (formattedPermissions.length > 0) {
            formattedPermissions.forEach(permission => {
                $('#updatedPermission option').each(function() {
                    console.log($(this));
                    if (parseInt($(this).prop('value')) === permission.id) $(this).prop('selected', true);
                });
            });
            $('.select2-multi-select').select2({
                placeholder: 'Choose',
            });
        }

        $('#updateRoleForm').prop('action', `/admin/authorization/${id}/update`);
    }
</script>
@endsection