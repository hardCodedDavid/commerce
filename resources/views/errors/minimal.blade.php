<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/error-404.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Oct 2020 00:47:55 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('logo/5.png') }}">
    <title>@yield('title')</title>
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="{{ asset('admin/assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet">
    <!-- Slick css -->
    <link href="{{ asset('admin/assets/plugins/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/plugins/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/plugins/pnotify/css/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css">
</head>
<body class="vertical-layout">
    <!-- Start Containerbar -->
    <div id="containerbar" class="containerbar authenticate-b">
        <!-- Start Container -->
        <div class="container">
            <div class="auth-box error-box">
                <!-- Start row -->
                 <div class="row no-gutters align-items-center justify-content-center">
                    <!-- Start col -->
                    <div class="col-md-8 col-lg-6">
                        <div class="text-center">
                            <img src="{{ asset('logo/7.png') }}" class="img-fluid error-logo" alt="logo">
                            {{-- <img src="assets/images/error/404.svg" class="img-fluid error-image" alt="404"> --}}
                            <h1 class="my-4 font-weight-bolder" style="font-size: 70px">@yield('code')</h1>
                            <h4 class="error-subtitle mb-4">@yield('message')</h4>
                            @guest
                            <a href="/" class="btn btn-primary font-16"><i class="ri-home-5-line mr-2"></i> Go Back to Home</a>
                            @else
                            @if(Auth::guard('admin')->check())
                            <a href="/admin/dashboard" class="btn btn-primary font-16"><i class="ri-home-5-line mr-2"></i> Go Back to Dashboard</a>
                            @else
                            <a href="/" class="btn btn-primary font-16"><i class="ri-home-5-line mr-2"></i> Go Back to Home</a>
                            @endif
                            @endguest
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->
    <script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/detect.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vertical-menu.js') }}"></script>
    <!-- Switchery js -->
    <script src="{{ asset('admin/assets/plugins/switchery/switchery.min.js') }}"></script>
    <!-- Slick js -->
    <script src="{{ asset('admin/assets/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/pnotify/js/pnotify.custom.min.js') }}"></script>
    <!-- End js -->
</body>

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/error-404.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Oct 2020 00:47:56 GMT -->
</html>