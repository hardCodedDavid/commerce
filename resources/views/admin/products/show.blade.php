@extends('layouts.admin')

@section('title', 'Product Details')

@section('style')

@endsection

@section('breadcrumbs')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Product Details</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products') }}">Products</a></li>
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
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-xl-5">
                                <div class="product-slider-box product-box-for">
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_01.jpg') }}" class="img-fluid" alt="Product">
                                        <p><span class="badge badge-success font-14">25% off</span></p>
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_02.jpg') }}" class="img-fluid" alt="Product">
                                        <p><span class="badge badge-primary font-14">New</span></p>
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_03.jpg') }}" class="img-fluid" alt="Product">
                                        <p><span class="badge badge-danger font-14">Price Drop</span></p>
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_04.jpg') }}" class="img-fluid" alt="Product">
                                        <p><span class="badge badge-success font-14">Sale</span></p>
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_05.jpg') }}" class="img-fluid" alt="Product">
                                        <p><span class="badge badge-warning font-14">Trending</span></p>
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_06.jpg') }}" class="img-fluid" alt="Product">
                                        <p><span class="badge badge-info font-14">Popular</span></p>
                                    </div>
                                </div>
                                <div class="product-slider-box product-box-nav">
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_01.jpg') }}" class="img-fluid" alt="Product">
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_02.jpg') }}" class="img-fluid" alt="Product">
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_03.jpg') }}" class="img-fluid" alt="Product">
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_04.jpg') }}" class="img-fluid" alt="Product">
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_05.jpg') }}" class="img-fluid" alt="Product">
                                    </div>
                                    <div class="product-preview">
                                        <img src="{{ asset('admin/assets/images/ecommerce/product_img_06.jpg') }}" class="img-fluid" alt="Product">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-7">
                                <p><span class="badge badge-light font-16">Pupular</span></p>
                                <h2 class="font-22">Apple Watch</h2>
                                <p>
                                    <i class="ri-star-fill text-warning"></i>
                                    <i class="ri-star-fill text-warning"></i>
                                    <i class="ri-star-fill text-warning"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <span class="ml-2">25 Ratings</span>
                                </p>
                                <p class="text-primary font-26 f-w-7 my-3"><sup class="font-16">$</sup>350</p>
                                <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                                <div class="custom-radio-button mt-3">
                                    <h6>Select Color</h6>
                                    <div class="form-check-inline radio-primary">
                                      <input type="radio" id="customRadioInline5" name="customRadioInline2" class="" checked>
                                      <label for="customRadioInline5"></label>
                                    </div>
                                    <div class="form-check-inline radio-secondary">
                                      <input type="radio" id="customRadioInline6" name="customRadioInline2" class="">
                                      <label for="customRadioInline6"></label>
                                    </div>
                                    <div class="form-check-inline radio-success">
                                      <input type="radio" id="customRadioInline7" name="customRadioInline2" class="">
                                      <label for="customRadioInline7"></label>
                                    </div>
                                    <div class="form-check-inline radio-danger">
                                      <input type="radio" id="customRadioInline8" name="customRadioInline2" class="">
                                      <label for="customRadioInline8"></label>
                                    </div>
                                    <div class="form-check-inline radio-warning">
                                      <input type="radio" id="customRadioInline9" name="customRadioInline2" class="">
                                      <label for="customRadioInline9"></label>
                                    </div>
                                    <div class="form-check-inline radio-info">
                                      <input type="radio" id="customRadioInline10" name="customRadioInline2" class="">
                                      <label for="customRadioInline10"></label>
                                    </div>
                                    <div class="form-check-inline radio-light">
                                      <input type="radio" id="customRadioInline11" name="customRadioInline2" class="">
                                      <label for="customRadioInline11"></label>
                                    </div>
                                    <div class="form-check-inline radio-dark">
                                      <input type="radio" id="customRadioInline12" name="customRadioInline2" class="">
                                      <label for="customRadioInline12"></label>
                                    </div>
                                </div>
                                <div class="button-list mt-5 mb-5">
                                    <button type="button" class="btn btn-danger font-18"><i class="ri-heart-2-line"></i></button>
                                    <button type="button" class="btn btn-primary font-18"><i class="ri-shopping-cart-line mr-2"></i>Add to Cart</button>
                                    <button type="button" class="btn btn-success font-17">Buy Now</button>
                                </div>
                                <div class="button-list">
                                    <h6 class="mb-3">Share this product</h6>
                                    <a href="#" class="btn btn-primary-rgba rounded-circle font-18"><i class="ri-facebook-line"></i></a>
                                    <a href="#" class="btn btn-info-rgba rounded-circle font-18"><i class="ri-twitter-line"></i></a>
                                    <a href="#" class="btn btn-danger-rgba rounded-circle font-18"><i class="ri-instagram-line"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->
        </div>
        <!-- End row -->
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Product Details</h5>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs custom-tab-line mb-3" id="defaultTabLine" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="description-tab-line" data-toggle="tab" href="#description-line" role="tab" aria-controls="description-line" aria-selected="true"><i class="ri-file-text-line mr-2"></i>Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="review-tab-line" data-toggle="tab" href="#review-line" role="tab" aria-controls="review-line" aria-selected="false"><i class="ri-star-line mr-2"></i>Review</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="guide-tab-line" data-toggle="tab" href="#guide-line" role="tab" aria-controls="guide-line" aria-selected="false"><i class="ri-book-2-line mr-2"></i>Guide</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="defaultTabContentLine">
                            <div class="tab-pane fade show active" id="description-line" role="tabpanel" aria-labelledby="description-tab-line">
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            </div>
                            <div class="tab-pane fade" id="review-line" role="tabpanel" aria-labelledby="review-tab-line">
                                <ul class="list-unstyled">
                                    <li class="media">
                                        <img src="{{ asset('admin/assets/images/users/men.svg" ') }}class="img-fluid mr-3" alt="user">
                                        <div class="media-body">
                                            <h5 class="font-16 mt-0 mb-1">John Smith</h5>
                                            <p class="text-muted font-14">
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill text-warning"></i>
                                            </p>
                                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </li>
                                    <li class="media my-4">
                                        <img src="{{ asset('admin/assets/images/users/boy.svg" ') }}class="img-fluid mr-3" alt="user">
                                        <div class="media-body">
                                            <h5 class="font-16 mt-0 mb-1">Michelle Johnson</h5>
                                            <p class="text-muted font-14">
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill"></i>
                                            </p>
                                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <img src="{{ asset('admin/assets/images/users/girl.svg" ') }}class="img-fluid mr-3" alt="user">
                                        <div class="media-body">
                                            <h5 class="font-16 mt-0 mb-1">Denzel Page</h5>
                                            <p class="text-muted font-14">
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill text-warning"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                                <i class="ri-star-fill"></i>
                                            </p>
                                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="guide-line" role="tabpanel" aria-labelledby="guide-tab-line">
                                <ul>
                                    <li>Lorem ipsum dolor sit amet</li>
                                    <li>Consectetur adipiscing elit</li>
                                    <li>Integer molestie lorem at massa</li>
                                    <li>Facilisis in pretium nisl aliquet</li>
                                    <li>Nulla volutpat aliquam velit
                                        <ul>
                                            <li>Phasellus iaculis neque</li>
                                            <li>Purus sodales ultricies</li>
                                            <li>Vestibulum laoreet porttitor sem</li>
                                            <li>Ac tristique libero volutpat at</li>
                                        </ul>
                                    </li>
                                    <li>Faucibus porta lacus fringilla vel</li>
                                    <li>Aenean sit amet erat nunc</li>
                                    <li>Eget porttitor lorem</li>
                                </ul>
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
@endsection

@section('script')
<script src="{{ asset('admin/assets/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom/custom-ecommerce-single-product.js') }}"></script>
@endsection