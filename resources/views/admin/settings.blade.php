@extends('layouts.admin')

@section('title', 'Settings')

@section('style')
    <!-- Apex css -->
    <link href="{{ asset('admin/assets/plugins/apexcharts/apexcharts.css') }}" rel="stylesheet">
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
                <h4 class="page-title">Settings</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="contentbar">
    <!-- Start row -->
    <div class="row">
        <div class="col-md-8">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title">Business Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" id="updateProfileForm" action="{{ route('admin.business.update') }}" enctype="multipart/form-data" class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') ?? $settings['name'] }}" id="name" placeholder="Name">
                                @error('name')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') ?? $settings['email'] }}" id="email" placeholder="Email Address">
                                @error('email')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_1">Phone 1</label>
                                <input type="text" class="form-control" name="phone_1" value="{{ old('phone_1') ?? $settings['phone_1'] }}" id="phone_1" placeholder="Phone 1">
                                @error('phone_1')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_2">Phone 2 (Optional)</label>
                                <input type="text" class="form-control" name="phone_2" value="{{ old('phone_2') ?? $settings['phone_2'] }}" id="phone_2" placeholder="Phone 2">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="motto">Motto <span class="text-info small">(Displayed at the top left corner in the online store)</span></label>
                                <input type="text" class="form-control" name="motto" value="{{ old('motto') ?? $settings['motto'] }}" id="motto" placeholder="Motto">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" class="form-control" placeholder="Address" rows="4">{{ old('address') ?? $settings['address'] }}</textarea>
                                @error('address')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="facebook">Facebook (Optional)</label>
                                <input type="text" class="form-control" name="facebook" value="{{ old('facebook') ?? $settings['facebook'] }}" id="facebook" placeholder="Facebook">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="twitter">Twitter (Optional)</label>
                                <input type="text" class="form-control" name="twitter" value="{{ old('twitter') ?? $settings['twitter'] }}" id="twitter" placeholder="Twitter">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="instagram">Instagram (Optional)</label>
                                <input type="text" class="form-control" name="instagram" value="{{ old('instagram') ?? $settings['instagram'] }}" id="instagram" placeholder="Instagram">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="youtube">Youtube (Optional)</label>
                                <input type="text" class="form-control" name="youtube" value="{{ old('youtube') ?? $settings['youtube'] }}" id="youtube" placeholder="Youtube">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="linkedin">Linkedin (Optional)</label>
                                <input type="text" class="form-control" name="linkedin" value="{{ old('linkedin') ?? $settings['linkedin'] }}" id="linkedin" placeholder="Linkedin">
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            @if ($settings['logo'])
                                <img src="{{ asset($settings['logo']) }}" alt="logo" width="100px" style="border-radius: 5px">
                            @endif
                            <div class="form-group">
                                <label for="logo">Invoice Logo</label>
                                <input type="file" class="form-control-file" name="logo" id="logo">
                                @error('logo')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($settings['dashboard_logo'])
                                <img src="{{ asset($settings['dashboard_logo']) }}" alt="dashboard_logo" width="100px" style="border-radius: 5px">
                            @endif
                            <div class="form-group">
                                <label for="dashboard_logo">Dashboard Logo</label>
                                <input type="file" class="form-control-file" name="dashboard_logo" id="dashboard_logo">
                                @error('dashboard_logo')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($settings['store_logo'])
                                <img src="{{ asset($settings['store_logo']) }}" alt="store_logo" width="100px" style="border-radius: 5px">
                            @endif
                            <div class="form-group">
                                <label for="store_logo">Online Store Logo</label>
                                <input type="file" class="form-control-file" name="store_logo" id="store_logo">
                                @error('store_logo')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($settings['email_logo'])
                                <img src="{{ asset($settings['email_logo']) }}" alt="email_logo" width="100px" style="border-radius: 5px">
                            @endif
                            <div class="form-group">
                                <label for="email_logo">Email Logo</label>
                                <input type="file" class="form-control-file" name="email_logo" id="email_logo">
                                @error('email_logo')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if ($settings['icon'])
                                <img src="{{ asset($settings['icon']) }}" alt="icon" width="100px" style="border-radius: 5px">
                            @endif
                            <div class="form-group">
                                <label for="icon">Website Icon</label>
                                <input type="file" class="form-control-file" name="icon" id="icon">
                                @error('icon')
                                    <span class="text-danger small" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="button" onclick="confirmSubmission('updateProfileForm')" class="btn  btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-5 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Bank Details</h6>
                    <form action="{{ route('admin.bank.update') }}" id="bankDetailsForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <select name="bank_name" style="height: 40px; font-size: 15px" class="form-control text-dark" id="bankList">
                                @if(count($banks) > 0)
                                    <option value="">Select Bank</option>
                                    @foreach($banks as $bank)
                                        <option @if(old("bank_name") == $bank['name'] || $settings['bank_name'] == $bank['name']) selected @endif value="{{ $bank['name'] }}" data-code="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">Error Fetching Banks</option>
                                @endif
                            </select>
                            @error('bank_name')
                            <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="hidden" id="bankCode" value="@if(count($banks) > 0) @foreach($banks as $bank) @if($settings['bank_name'] == $bank['name']) {{ $bank['code'] }} @endif @endforeach @endif">
                        </div>
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="number" value="{{ old('account_number') ?? $settings['account_number'] }}" style="height: 40px; font-size: 15px" class="form-control" name="account_number" id="account_number" placeholder="Account Number">
                            @error('account_number')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="account_name" class="d-flex justify-content-between">
                                <span class="d-block">Account Name <span class="text-danger">*</span></span>
                                <span id="verifyingDisplay" class="small d-block"></span>
                            </label>
                            <input type="text" readonly value="{{ old('account_name') ?? $settings['account_name'] }}" style="height: 40px; font-size: 15px" class="form-control" name="account_name" id="account_name" placeholder="Account Name">
                            @error('account_name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 text-right">
                            <button class="btn btn-primary" disabled id="submitButton" onclick="confirmSubmission('bankDetailsForm')" type="button">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-5">
                @php $locations = json_decode($settings->pickup_locations, true) ?? []; @endphp
                <div class="card-body">
                    <h6 class="card-title">Pickup Locations</h6>
                    <form method="POST" id="locationsForm" action="{{ route('admin.location.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="locations" class="col-form-label">Locations: <span class="text-danger">*</span></label>
                            <div class="repeater-default">
                                <div id="oldLocations" data-repeater-list="locations">
                                    <div data-repeater-item="">
                                        <div class="form-group row d-flex align-items-end">
                                            <div class="col-10">
                                                <input type="text" name="locations[]" class="form-control" value="">
                                            </div><!--end col-->

                                            <div class="col-2">
                                                <span data-repeater-delete="" class="btn btn-outline-danger">
                                                    <span class="fa fa-trash me-1"></span>
                                                </span>
                                            </div><!--end col-->
                                        </div>
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
                            @error('locations')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @error('locations.*')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-12 text-right">
                            <button class="btn btn-primary" id="submitButton" onclick="confirmSubmission('locationsForm')" type="button">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    <script src="{{ asset('admin/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap-tagsinput/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('admin/assets/pages/jquery.form-repeater.js') }}"></script>
    <script>
        $(document).ready(function (){
            let bankList = $('#bankList');
            let bankCode = $('#bankCode');
            let accountNumber = $('#account_number');
            let accountName = $('#account_name');
            let verifyingDisplay = $('#verifyingDisplay');
            let submitButton = $('#submitButton');
            let autoDelete = $('#autoDelete');
            let deletionInfo = $('#deletionInfo');
            let exchangeRateError = $('#exchangeRateError');
            let updateErrorInfo = $('#updateErrorInfo');
            let pendingTransaction = $('#pendingTransaction');
            let pendingTransactionDuration = $('#pendingTransactionDuration');
            if (bankList.val() && accountName.val() && accountNumber.val())
                submitButton.prop('disabled', false);
            checkForAutoDelete();
            checkForErrorInfo();
            checkForPendingTransactionNotification();
            bankList.on('change', function (){
                $("#bankList option").each(function(){
                    if($(this).val() === $('#bankList').val()){
                        bankCode.val($(this).attr('data-code'))
                    }
                });
                verifyAccountNumber();
            });
            accountNumber.on('input', verifyAccountNumber);
            autoDelete.on('change', checkForAutoDelete);
            exchangeRateError.on('change', checkForErrorInfo);
            pendingTransaction.on('change', checkForPendingTransactionNotification);
            $('.toggleSideBar').each(function (){
                $(this).on('change', function (){
                    if ($(this).val() === 'dark'){
                        $('body').addClass('sidebar-dark');
                    }else if($(this).val() === 'light'){
                        $('body').removeClass('sidebar-dark');
                    }
                });
            });

            const locations = {!! json_encode($locations) !!};
            let html = ''
            locations.forEach((cur, index) => {
                html += `
                <div data-repeater-item="">
                    <div class="form-group row d-flex align-items-end">
                        <div class="col-10">
                            <input type="text" name="locations[${index}]" class="form-control" value="${cur}">
                        </div><!--end col-->

                        <div class="col-2">
                            <span data-repeater-delete="" class="btn btn-outline-danger">
                                <span class="fa fa-trash me-1"></span>
                            </span>
                        </div><!--end col-->
                    </div>
                </div>
            `;
            })
            $('#oldLocations').html(html)

            function checkForPendingTransactionNotification()
            {
                if (pendingTransaction.prop('checked')){
                    pendingTransactionDuration.show(500);
                }else{
                    pendingTransactionDuration.hide(500);
                }
            }
            function checkForErrorInfo(){
                if (exchangeRateError.prop('checked')){
                    updateErrorInfo.show(500);
                }else{
                    updateErrorInfo.hide(500);
                }
            }
            function checkForAutoDelete(){
                if (autoDelete.prop('checked')){
                    deletionInfo.show(500);
                }else{
                    deletionInfo.hide(500);
                }
            }
            function verifyAccountNumber(){
                if (bankList.val() && accountNumber.val().length === 10 && bankCode.val()){
                    verifyingDisplay.text('Verifying account number...');
                    verifyingDisplay.removeClass('d-none');
                    verifyingDisplay.removeClass('text-danger');
                    verifyingDisplay.removeClass('text-success');
                    verifyingDisplay.addClass('text-info');
                    $.ajax({
                        url: "https://api.paystack.co/bank/resolve",
                        data: { account_number: accountNumber.val(), bank_code: bankCode.val().trim() },
                        type: "GET",
                        beforeSend: function(xhr){
                            xhr.setRequestHeader('Authorization', 'Bearer {{ env('PAYSTACK_SECRET_KEY') }}');
                            xhr.setRequestHeader('Content-Type', 'application/json');
                            xhr.setRequestHeader('Accept', 'application/json');
                        },
                        success: function(res) {
                            verifyingDisplay.removeClass('text-info');
                            verifyingDisplay.addClass('text-success');
                            verifyingDisplay.text('Account details verified');
                            accountName.val(res.data.account_name);
                            submitButton.prop('disabled', false);
                        },
                        error: function (err){
                            let msg = 'Error processing verification';
                            verifyingDisplay.removeClass('text-info');
                            verifyingDisplay.addClass('text-danger');
                            submitButton.prop('disabled', true);
                            if (parseInt(err.status) === 422){
                                msg = 'Account details doesn\'t match any record';
                            }
                            verifyingDisplay.text(msg);
                        }
                    });
                }else{
                    accountName.val("");
                    verifyingDisplay.addClass('d-none');
                }
            }
        });
    </script>
@endsection
