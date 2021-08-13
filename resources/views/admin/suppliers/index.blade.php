@extends('layouts.admin')

@section('title', 'Suppliers')

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
                <h4 class="page-title">Suppliers</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Suppliers</li>
                    </ol>
                </div>
            </div>
            @can('View Suppliers')
                <div class="col-md-4 col-lg-4">
                    <div class="widgetbar">
                        <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#supplier-modal"><i class="ri-add-fill mr-2"></i>New Supplier</button>
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
                    <div class="card-header">
                        <h5 class="card-title my-1">Suppliers</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list-ul"></i></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Puchases</th>
                                        <th>Transactions</th>
                                        <th>Address</th>
                                        <th>Reg. Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $key=>$supplier)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $supplier['name'] ?? '---' }}</td>
                                            <td>{{ $supplier['email'] ?? '---' }}</td>
                                            <td>{{ $supplier['phone'] ?? '---' }}</td>
                                            <td>{{ count($supplier['purchases']) }}</td>
                                            <td>₦{{ number_format($supplier->getTotalTransactions()) }}</td>
                                            <td>{{ $supplier['address'] ?? '---' }}</td>
                                            <td>{{ $supplier['created_at']->format('M d, Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                        <button onclick="populateShowModal({{ $supplier['id'] }}, '{{ $supplier['name'] }}', '{{ $supplier['email'] }}', '{{ $supplier['phone'] }}', '{{ $supplier['address'] }}', '₦{{ number_format($supplier->getTotalTransactions()) }}')" data-toggle="modal" data-target="#show-supplier-modal" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">View</span></button>
                                                        @can('Edit Suppliers')
                                                            <button onclick="populateEditModal({{ $supplier['id'] }}, '{{ $supplier['name'] }}', '{{ $supplier['email'] }}', '{{ $supplier['phone'] }}', '{{ $supplier['address'] }}')" data-toggle="modal" data-target="#edit-supplier-modal" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></button>
                                                        @endcan
                                                        @can('Delete Suppliers')
                                                            <button onclick="event.preventDefault(); confirmSubmission('deleteForm{{ $supplier['id'] }}')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                                                            <form method="POST" id="deleteForm{{ $supplier['id'] }}" action="{{ route('admin.suppliers.destroy', $supplier) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endcan
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
    <div class="modal fade" id="supplier-modal" tabindex="-1" role="dialog" aria-labelledby="supplier-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplier-modal-label">New Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.suppliers.store') }}" id="createSupplierForm">
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
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone:</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control" id="phone">
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Address:</label>
                            <textarea name="address" class="form-control" id="address">{{ old('address') }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('createSupplierForm')" class="btn btn-primary">Create Supplier</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-supplier-modal" tabindex="-1" role="dialog" aria-labelledby="edit-supplier-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-supplier-modal-label">Edit Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateSupplierForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="updatedname" class="col-form-label">Name: <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="updatedname">
                            @error('name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="updatedemail" class="col-form-label">Email:</label>
                            <input type="email" name="email" class="form-control" id="updatedemail">
                        </div>
                        <div class="form-group">
                            <label for="updatedphone" class="col-form-label">Phone:</label>
                            <input type="tel" name="phone" class="form-control" id="updatedphone">
                        </div>
                        <div class="form-group">
                            <label for="updatedaddress" class="col-form-label">Address:</label>
                            <textarea name="address" class="form-control" id="updatedaddress"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('updateSupplierForm')" class="btn btn-primary">Update Supplier</button>
                </div>
            </div>
        </div>
    </div>

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
    function populateEditModal(id, name, email, phone, address) {
        $('#updatedname').val(name);
        $('#updatedemail').val(email);
        $('#updatedphone').val(phone);
        $('#updatedaddress').val(address);
        $('#updateSupplierForm').prop('action', `/admin/suppliers/${id}/update`);
    }

    function populateShowModal(id, name, email, phone, address, transactions) {
        $('#currentname').val(name);
        $('#currentemail').val(email);
        $('#currentphone').val(phone);
        $('#currentaddress').val(address);
        $('#currenttransactions').val(transactions);
    }
</script>
@endsection