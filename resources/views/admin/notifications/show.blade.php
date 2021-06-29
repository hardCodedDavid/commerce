@extends('layouts.admin')

@section('title', 'Notifications')

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Notification Details</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.notifications') }}">Notifications</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
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
                    <div class="email-rightbar">
                        <div class="card email-open-box m-b-30">
                            <div class="card-header">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item"><h5 class="mt-2 mb-0">Save your ideas about Business Trip</h5></li>
                                    <li class="list-inline-item float-right"><a href="#"><i class="ri-folder-3-line font-20"></i></a></li>
                                    <li class="list-inline-item float-right"><a href="#"><i class="ri-printer-line font-20"></i></a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="row m-b-30">
                                    <div class="col-md-5">
                                        <div class="media">
                                          <img class="align-self-center mr-3" src="{{ asset('admin/assets/images/users/men.svg') }}" alt="Generic placeholder image">
                                          <div class="media-body">
                                            <h6 class="mt-0">John Doe</h6>
                                            <p class="text-muted mb-0">johndoe@email.com</p>
                                          </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="open-email-head">
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">25 July, 2019, 1:05 PM</li>
                                                <li class="list-inline-item"><a href="#"><i class="ri-star-line font-20"></i></a></li>
                                                <li class="list-inline-item"><a href="#"><i class="ri-reply-line font-20"></i></a></li>
                                                <li class="list-inline-item"><a href="#"><i class="ri-more-2-fill menu-hamburger-vertical font-20"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="mt-0">Welcome to here</h6>
                                        <p class="text-muted">Hi,</p>
                                        <p class="text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        <p class="text-muted">It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        <p class="text-muted">Thank You.</p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top" src="{{ asset('admin/assets/images/email/file-attached-1.jpg') }}" alt="Generic placeholder image">
                                            <div class="card-body text-center">
                                                <button type="button" class="btn btn-secondary-rgba">Download</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img class="card-img-top" src="{{ asset('admin/assets/images/email/file-attached-2.jpg') }}" alt="Generic placeholder image">
                                            <div class="card-body text-center">
                                            <button type="button" class="btn btn-secondary-rgba">Download</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="open-email-footer">

                                    <div class="row text-right">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary-rgba my-1"><i class="ri-reply-line mr-2"></i>Reply</button>
                                            <button type="button" class="btn btn-success-rgba my-1">Forward<i class="ri-share-forward-line ml-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End Contentbar -->
    <!-- End col -->
@endsection

@section('script')
    <script src="{{ asset('admin/assets/plugins/tabledit/jquery.tabledit.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom/custom-table-editable.js') }}"></script>
@endsection