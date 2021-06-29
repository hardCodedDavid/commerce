@extends('layouts.admin')

@section('title', 'New Sale')

@section('style')
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
                <h4 class="page-title">New Sale</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.transactions.sales') }}">Sale</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New</li>
                    </ol>
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
                        <h5 class="card-title">Customer Detail</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <div class="col-md-6 my-1">
                                    <label class="col-form-label">Name</label>
                                    <div>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 my-1">
                                    <label class="col-form-label">Email</label>
                                    <div>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 my-1">
                                    <label class="col-form-label">Phone</label>
                                    <div>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6 my-1">
                                    <label class="col-form-label">Address</label>
                                    <div>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Products</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="form-horizontal well">
                            <fieldset>
                                <div class="repeater-default">
                                    <div data-repeater-list="car">
                                        <div data-repeater-item>
                                            <div class="form-group row d-flex align-items-end">

                                                <div class="col-sm-4 my-2">
                                                    <label class="form-label">Make</label>
                                                    <select name="car[0][make]" class="form-control">
                                                        <option value="volkswagon" selected="">Volkswagon</option>
                                                        <option value="honda">Honda</option>
                                                        <option value="ford">Ford</option>
                                                    </select>
                                                </div><!--end col-->

                                                <div class="col-sm-4 my-2">
                                                    <label class="form-label">Model</label>
                                                    <input type="text" name="car[0][model]" value="Beetle" class="form-control">
                                                </div><!--end col-->

                                                <div class="col-sm-3 my-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="customCheck1" name="car[0][features][]" value="ac">
                                                        <label class="form-check-label" for="customCheck1">
                                                            Air Conditioning
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="customCheck2" name="car[0][features][]" value="abs">
                                                        <label class="form-check-label" for="customCheck2">
                                                            Anti-Lock Brakes
                                                        </label>
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-sm-1 my-2">
                                                    <span data-repeater-delete class="btn btn-outline-danger">
                                                        <span class="fa fa-trash me-1"></span>
                                                    </span>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                            <hr>
                                        </div><!--end /div-->
                                    </div><!--end repet-list-->
                                    <div class="form-group mb-0 row">
                                        <div class="col-sm-12">
                                            <span data-repeater-create class="btn btn-outline-secondary">
                                                <span class="fa fa-plus"></span> Add Product
                                            </span>
                                        </div><!--end col-->
                                    </div><!--end row-->
                                </div> <!--end repeter-->
                            </fieldset><!--end fieldset-->
                        </form><!--end form-->
                    </div><!--end card-body-->
                </div>
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Other Details</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="productTitle" class="col-form-label">Sale Date</label>
                                    <div class="input-group">
                                        <input type="text" id="default-date" class="datepicker-here form-control" placeholder="dd/mm/yyyy" aria-describedby="basic-addon2"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><i class="ri-calendar-line"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="productTitle" class="col-form-label">Additional Note</label>
                                    <textarea class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="offset-md-6 col-md-6 p-0">
                            <div class="total-payment p-0">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="payment-title">Subtotal</td>
                                            <td>$496.00</td>
                                        </tr>
                                        <tr>
                                            <td class="payment-title">Shipping</td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    <li>
                                                        <input type="text" class="form-control" placeholder="0.00">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="payment-title">Additional Fee</td>
                                            <td>
                                                <ul class="list-unstyled mb-0">
                                                    <li>
                                                        <input type="text" class="form-control" placeholder="0.00">
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="payment-title">Total</td>
                                            <td class="text-dark"><strong>$491.00</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!--end col-->
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection

@section('script')
    <script src="{{ asset('admin/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/jquery.form-repeater.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/datepicker/i18n/datepicker.en.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/custom-form-datepicker.js') }}"></script>
@endsection