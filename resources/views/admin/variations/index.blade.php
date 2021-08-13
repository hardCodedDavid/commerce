@extends('layouts.admin')

@section('title', 'Variations')

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
                <h4 class="page-title">Variations</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Variations</li>
                    </ol>
                </div>
            </div>
            @can('Add Variations')
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <button type="button" class="btn btn-primary mt-1" data-toggle="modal" data-target="#variation-modal"><i class="ri-add-fill mr-2"></i>New Variation</button>
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
                        <h5 class="card-title my-1">Variations</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="default-datatable" class="display table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><i class="fa fa-list-ul"></i></th>
                                        <th>Name</th>
                                        <th>Types</th>
                                        <th>Products</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($variations as $key=>$variation)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $variation['name'] }}</td>
                                            <td>
                                                @if (count($variation->items) > 0)
                                                    @foreach ($variation->items as $subvariation)
                                                        <span class="badge badge-secondary-inverse">{{ $subvariation['name'] }}</span>
                                                    @endforeach
                                                @else
                                                    ---
                                                @endif
                                            </td>
                                            <td>{{ $variation->items()->has('products')->count() }}</td>
                                            <td>{{ $variation['created_at']->format('M d, Y') }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button style="white-space: nowrap" class="btn small btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="icon-lg fa fa-angle-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                        @can('Edit Variations')
                                                        <button onclick="populateEditModal({{ $variation['id'] }}, '{{ $variation['name'] }}', '{{ $variation->items->map(function($sub){ return ['id' => $sub['id'],'name' => $sub['name']]; }); }}')" data-toggle="modal" data-target="#edit-variation-modal" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-edit mr-2"></i> <span class="">Edit</span></button>
                                                        @endcan
                                                        @can('Delete Variations')
                                                        <button onclick="event.preventDefault(); confirmSubmission('deleteForm{{ $variation['id'] }}')" class="dropdown-item d-flex align-items-center"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-trash-o mr-2"></i> <span class="">Delete</span></button>
                                                        <form method="POST" id="deleteForm{{ $variation['id'] }}" action="{{ route('admin.variations.destroy', $variation) }}">
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
    <div class="modal fade" id="variation-modal" tabindex="-1" role="dialog" aria-labelledby="variation-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="variation-modal-label">New Variation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="createVariationModal" action="{{ route('admin.variations.store') }}">
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
                            <label for="email" class="col-form-label">Types:</label>
                            <div class="small">Hit enter to add new subvariation</div>
                            <input type="text" value="{{ old('types') }}" name="types" id="tagsinput-default" class="form-control" data-role="tagsinput" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('createVariationModal')" class="btn btn-primary">Create Variation</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-variation-modal" tabindex="-1" role="dialog" aria-labelledby="edit-variation-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-variation-modal-label">Edit Variation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateVariationForm">
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
                            <label for="email" class="col-form-label">Types: <span class="text-danger">*</span></label>
                            <div class="repeater-default">
                                <div id="oldVariationsList" data-repeater-list="types">
                                    <div data-repeater-item="">
                                        <div class="form-group row d-flex align-items-end">

                                            <div class="col-10">
                                                <input type="text" name="types[0][name]" class="form-control">
                                                <input type="hidden" name="types[0][id]">
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
                            @error('types')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="confirmSubmission('updateVariationForm')" class="btn btn-primary">Update Variation</button>
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
    function populateEditModal(id, name, variations) {
        $('#updatedname').val(name);
        $oldVariationsList = $('#oldVariationsList');
        const formattedVariations = JSON.parse(variations);
        if (formattedVariations.length > 0) {
            let newHtml = '';
            formattedVariations.forEach((variation, index) => {
                newHtml += ` <div data-repeater-item="">
                                <div class="form-group row d-flex align-items-end">

                                    <div class="col-10">
                                        <input type="text" name="types[${index}][name]" value="${variation.name}" class="form-control">
                                        <input type="hidden" name="types[${index}][id]" value="${variation.id}">
                                    </div><!--end col-->

                                    <div class="col-2">
                                        <span data-repeater-delete="" class="btn btn-outline-danger">
                                            <span class="fa fa-trash me-1"></span>
                                        </span>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </div><!--end /div-->`;
            });
            $oldVariationsList.html(newHtml);
        }
        $('#updateVariationForm').prop('action', `/admin/variations/${id}/update`);
    }
</script>
@endsection