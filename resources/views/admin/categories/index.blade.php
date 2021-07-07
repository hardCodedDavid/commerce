@extends('layouts.admin')

@section('title', 'Categories')

@section('style')
    <link href="{{ asset('admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet" type="text/css">
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
                <h4 class="page-title">Categories</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#category-modal"><i class="ri-add-fill mr-2"></i>New Category</button>
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
                        <h5 class="card-title my-1">Categories</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list-ul"></i></th>
                                        <th>Name</th>
                                        <th>Sub Categories</th>
                                        <th>Products</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $key=>$category)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $category['name'] }}</td>
                                            <td>
                                                @if (count($category->subCategories) > 0)
                                                    @foreach ($category->subCategories as $subCategory)
                                                        <span class="badge badge-secondary-inverse">{{ $subCategory['name'] }}</span>
                                                    @endforeach
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td>{{ count($category->products) }}</td>
                                            <td>{{ $category['created_at']->format('M d, Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                        <button onclick="populateEditModal({{ $category['id'] }}, '{{ $category['name'] }}', '{{ $category->subCategories->map(function($sub){ return ['id' => $sub['id'],'name' => $sub['name']]; }); }}')" data-toggle="modal" data-target="#edit-category-modal" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></button>
                                                        <button onclick="event.preventDefault(); confirmSubmission('deleteForm{{ $category['id'] }}')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                                                        <form method="POST" id="deleteForm{{ $category['id'] }}" action="{{ route('admin.categories.destroy', $category) }}">
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
    <div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="category-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="category-modal-label">New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.categories.store') }}" id="createCategoryForm">
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
                            <label for="email" class="col-form-label">Subcategories</label>
                            <div class="small">Hit enter to add new subcategory</div>
                            <input type="text" value="{{ old('subcategories') }}" name="subcategories" id="tagsinput-default" class="form-control" data-role="tagsinput" />
                            @error('subcategories')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('createCategoryForm')" class="btn btn-primary">Create Category</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-category-modal" tabindex="-1" role="dialog" aria-labelledby="edit-category-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-category-modal-label">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateCategoryForm">
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
                            <label for="email" class="col-form-label">Subcategories: <span class="text-danger">*</span></label>
                            <div class="repeater-default">
                                <div id="oldSubCategoriesList" data-repeater-list="subcategories">
                                    <div data-repeater-item="">
                                        <div class="form-group row d-flex align-items-end">

                                            <div class="col-10">
                                                <input type="text" name="subcategories[0][name]" class="form-control">
                                                <input type="hidden" name="subcategories[0][id]">
                                            </div><!--end col-->

                                            <div class="col-2">
                                                <span data-repeater-delete="" class="btn btn-outline-danger">
                                                    <span class="fa fa-trash me-1"></span>
                                                </span>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </div><!--end /div-->
                                </div><!--end repet-list-->
                                <div class="form-group mb-0 row">
                                    <div class="col-sm-12">
                                        <span data-repeater-create="" class="btn btn-outline-secondary">
                                            <span class="fa fa-plus"></span> Add
                                        </span>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div> <!--end repeter-->
                            @error('subcategories')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('updateCategoryForm')" class="btn btn-primary">Update Category</button>
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
<script src="{{ asset('admin/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('admin/assets/pages/jquery.form-repeater.js') }}"></script>
<script>
    function populateEditModal(id, name, subCategories) {
        $('#updatedname').val(name);
        $oldSubCategoriesList = $('#oldSubCategoriesList');
        const formattedSubCategories = JSON.parse(subCategories);
        if (formattedSubCategories.length > 0) {
            let newHtml = '';
            formattedSubCategories.forEach((subCategory, index) => {
                newHtml += ` <div data-repeater-item="">
                                <div class="form-group row d-flex align-items-end">

                                    <div class="col-10">
                                        <input type="text" name="subcategories[${index}][name]" value="${subCategory.name}" class="form-control">
                                        <input type="hidden" name="subcategories[${index}][id]" value="${subCategory.id}">
                                    </div><!--end col-->

                                    <div class="col-2">
                                        <span data-repeater-delete="" class="btn btn-outline-danger">
                                            <span class="fa fa-trash me-1"></span>
                                        </span>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end /div-->`;
            });
            $oldSubCategoriesList.html(newHtml);
        }
        $('#updateCategoryForm').prop('action', `/admin/categories/${id}/update`);
    }
</script>
@endsection