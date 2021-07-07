<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Oct 2020 00:22:46 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Olian is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, admin theme, bootstrap 4, responsive, sass support, ui kits, crm, ecommerce">
    <meta name="author" content="Themesbox17">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title')</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">
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
    @yield('style')
    <!-- End css -->
</head>
<body class="vertical-layout">
    <!-- Start Infobar Setting Sidebar -->
    <div id="infobar-settings-sidebar" class="infobar-settings-sidebar">
        <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
            <h4>Settings</h4><a href="javascript:void(0)" id="infobar-settings-close" class="infobar-settings-close"><span class="iconbar"><i class="ri-close-line menu-hamburger-close"></i></span></a>
        </div>
        <div class="infobar-settings-sidebar-body">
            <div class="custom-mode-setting">
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Popup Notification</h6></div>
                    <div class="col-4"><input type="checkbox" class="js-switch-setting-first" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Message Sound</h6></div>
                    <div class="col-4"><input type="checkbox" class="js-switch-setting-second" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Generate Report</h6></div>
                    <div class="col-4"><input type="checkbox" class="js-switch-setting-third" /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Email Statement</h6></div>
                    <div class="col-4"><input type="checkbox" class="js-switch-setting-fourth" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Invoice PDF</h6></div>
                    <div class="col-4"><input type="checkbox" class="js-switch-setting-fifth" checked /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Add Users</h6></div>
                    <div class="col-4"><input type="checkbox" class="js-switch-setting-sixth" /></div>
                </div>
                <div class="row align-items-center pb-3">
                    <div class="col-8"><h6 class="mb-0">Show Sidebar</h6></div>
                    <div class="col-4"><input type="checkbox" class="js-switch-setting-seventh" checked /></div>
                </div>
                <div class="row align-items-center">
                    <div class="col-8"><h6 class="mb-0">Sticky Topbar</h6></div>
                    <div class="col-4"><input type="checkbox" class="js-switch-setting-eightth" checked /></div>
                </div>
            </div>
        </div>
    </div>
    <div class="infobar-settings-sidebar-overlay"></div>
    <!-- End Infobar Setting Sidebar -->
    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
        <div class="leftbar">
            <!-- Start Sidebar -->
            <div class="sidebar">
                <!-- Start Logobar -->
                <div class="logobar">
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-large"><img src="{{ asset('admin/assets/images/logo.svg') }}" class="img-fluid" alt="logo"></a>
                    <a href="{{ route('admin.dashboard') }}" class="logo logo-small"><img src="{{ asset('admin/assets/images/small_logo.svg') }}" class="img-fluid" alt="logo"></a>
                </div>
                <!-- End Logobar -->
                <!-- Start Navigationbar -->
                <div class="navigationbar">
                    <ul class="vertical-menu">
                        <li class="vertical-header">Main</li>
                        <li @if (Route::is(['admin.dashboard']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="ri-dashboard-line"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.products', 'admin.products.create']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.products') }}">
                                <i class="ri-stack-line"></i><span>Products</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.transactions.purchases',
                                            'admin.transactions.sales',
                                            'admin.transactions.purchases.create',
                                            'admin.transactions.sales.create']))
                            class="active"
                        @endif>
                            <a href="javaScript:void();">
                                <i class="ri-file-list-2-line"></i><span>Transactions</span><i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="vertical-submenu">
                                <li><a href="{{ route('admin.transactions.purchases') }}">Purchase</a></li>
                                <li>
                                    <a href="javaScript:void();">Sales<i class="ri-arrow-right-s-line"></i></a>
                                    <ul class="vertical-submenu">
                                        <li><a href="{{ route('admin.transactions.sales') }}">All</a></li>
                                        <li><a href="{{ route('admin.transactions.sales', 'online') }}">Online</a></li>
                                        <li><a href="{{ route('admin.transactions.sales', 'offline') }}">Offline</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li @if (Route::is(['admin.suppliers']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.suppliers') }}">
                                <i class="ri-account-box-line"></i><span>Suppliers</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.suppliers']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.suppliers') }}">
                                <i class="ri-bar-chart-line"></i><span>Analytics</span>
                            </a>
                        </li>
                        <li class="vertical-header">Online Store</li>
                        <li @if (Route::is(['admin.users']))
                            class="active"
                        @endif>
                            <a href="javaScript:void();">
                                <i class="ri-user-3-line"></i><span>Users</span><i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="vertical-submenu">
                                <li><a href="{{ route('admin.users') }}">All</a></li>
                                <li><a href="{{ route('admin.users', 'verified') }}">Verified</a></li>
                                <li><a href="{{ route('admin.users', 'unverified') }}">Unverified</a></li>
                            </ul>
                        </li>
                        <li @if (Route::is(['admin.products.listed']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.products.listed') }}">
                                <i class="ri-todo-line"></i><span>Listed Products</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.banners']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.banners') }}">
                                <i class="ri-bill-line"></i><span>Banners</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.orders']))
                            class="active"
                        @endif>
                            <a href="javaScript:void();">
                                <i class="ri-table-2"></i><span>Orders</span><i class="ri-arrow-right-s-line"></i>
                            </a>
                            <ul class="vertical-submenu">
                                <li><a href="{{ route('admin.orders') }}">All</a></li>
                                <li><a href="{{ route('admin.orders', 'pending') }}">Pending</a></li>
                                <li><a href="{{ route('admin.orders', 'processing') }}">Processing</a></li>
                                <li><a href="{{ route('admin.orders', 'delivered') }}">Delivered</a></li>
                                <li><a href="{{ route('admin.orders', 'cancelled') }}">Cancelled</a></li>
                            </ul>
                        </li>
                        <li class="vertical-header">Others</li>
                        <li @if (Route::is(['admin.categories']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.categories') }}">
                                <i class="ri-bubble-chart-line"></i><span>Categories</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.brands']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.brands') }}">
                                <i class="ri-contacts-book-upload-line"></i><span>Brands</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.variations']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.variations') }}">
                                <i class="ri-apps-line"></i><span>Variations</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.admins']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.admins') }}">
                                <i class="ri-user-2-line"></i><span>Administrators</span>
                            </a>
                        </li>
                        <li @if (Route::is(['admin.authorization']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.authorization') }}">
                                <i class="ri-user-settings-line"></i><span>Authorization</span>
                            </a>
                        </li>
                        {{-- <li @if (Route::is(['admin.notifications']))
                            class="active"
                        @endif>
                            <a href="{{ route('admin.notifications') }}">
                                <i class="ri-notification-2-line"></i><span>Notifications</span>
                            </a>
                        </li> --}}
                        <li>
                            <a href="#" onclick="event.preventDefault(); confirmSubmission('logout-form');">
                                <i class="ri-todo-line"></i><span>Logout</span>
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
                <!-- End Navigationbar -->
            </div>
            <!-- End Sidebar -->
        </div>
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            <div class="topbar-mobile">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="mobile-logobar">
                            <a href="{{ route('admin.dashboard') }}" class="mobile-logo"><img src="{{ asset('admin/assets/images/logo.svg') }}" class="img-fluid" alt="logo"></a>
                        </div>
                        <div class="mobile-togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="topbar-toggle-icon">
                                        <a class="topbar-toggle-hamburger" href="javascript:void();">
                                            <span class="iconbar">
                                                <i class="ri-more-fill menu-hamburger-horizontal"></i>
                                                <i class="ri-more-2-fill menu-hamburger-vertical"></i>
                                            </span>
                                         </a>
                                     </div>
                                </li>
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="javascript:void();">
                                            <span class="iconbar">
                                                <i class="ri-menu-2-line menu-hamburger-collapse"></i>
                                                <i class="ri-close-line menu-hamburger-close"></i>
                                            </span>
                                         </a>
                                     </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Topbar -->
            <div class="topbar">
                <!-- Start row -->
                <div class="row align-items-center">
                    <!-- Start col -->
                    <div class="col-md-12 align-self-center">
                        <div class="togglebar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="menubar">
                                        <a class="menu-hamburger" href="javascript:void();">
                                            <span class="iconbar">
                                                <i class="ri-menu-2-line menu-hamburger-collapse"></i><i class="ri-close-line menu-hamburger-close"></i>
                                            </span>
                                         </a>
                                     </div>
                                </li>
                                <li class="list-inline-item">
                                    <div class="searchbar">
                                        <form>
                                            <div class="input-group">
                                              <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                              <div class="input-group-append">
                                                <button class="btn" type="submit" id="button-addon2"><i class="ri-search-line"></i></button>
                                              </div>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="infobar">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <div class="settingbar">
                                        <a href="javascript:void(0)" id="infobar-settings-open" class="infobar-icon">
                                            <span class="iconbar"><i class="ri-settings-3-line"></i></span>
                                        </a>
                                    </div>
                                </li>
                                {{-- <li class="list-inline-item">
                                    <div class="notifybar">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="iconbar"><i class="ri-notification-3-line"></i><span class="live-icon"></span></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                                <div class="notification-dropdown-title">
                                                    <h5>Notifications<a href="#">Clear all</a></h5>
                                                </div>
                                                <ul class="list-unstyled">
                                                    <li class="media dropdown-item">
                                                        <span class="action-icon badge badge-primary"><i class="ri-archive-line"></i></span>
                                                        <div class="media-body">
                                                            <h5 class="action-title">Product Added</h5>
                                                            <p><span class="timing">Today, 08:40 AM</span></p>
                                                        </div>
                                                    </li>
                                                    <li class="media dropdown-item">
                                                        <span class="action-icon badge badge-success"><i class="ri-price-tag-3-line"></i></span>
                                                        <div class="media-body">
                                                            <h5 class="action-title">Sale Started</h5>
                                                            <p><span class="timing">Today, 03:45 PM</span></p>
                                                        </div>
                                                    </li>
                                                    <li class="media dropdown-item">
                                                        <span class="action-icon badge badge-warning"><i class="ri-file-text-line"></i></span>
                                                        <div class="media-body">
                                                            <h5 class="action-title">Kelly Reported</h5>
                                                            <p><span class="timing">5 June 2020, 02:20 PM</span></p>
                                                        </div>
                                                    </li>
                                                    <li class="media dropdown-item">
                                                        <span class="action-icon badge badge-danger"><i class="ri-file-user-line"></i></span>
                                                        <div class="media-body">
                                                            <h5 class="action-title">John Resigned</h5>
                                                            <p><span class="timing">2 June 2020, 11:11 AM</span></p>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="notification-dropdown-footer">
                                                    <h5><a href="#">See all</a></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li> --}}
                                <li class="list-inline-item">
                                    <div class="profilebar">
                                        <div class="dropdown">
                                          <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ asset('admin/assets/images/users/profile.svg') }}" class="img-fluid" alt="profile"><span class="live-icon">John D</span></a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                                <a class="dropdown-item" href="#"><i class="ri-user-6-line"></i>My Profile</a>
                                                <a class="dropdown-item" href="#"><i class="ri-mail-line"></i>Email</a>
                                                <a class="dropdown-item" href="#"><i class="ri-settings-3-line"></i>Settings</a>
                                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); confirmSubmission('logout-form');"><i class="ri-shut-down-line"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End row -->
            </div>
            <!-- End Topbar -->
            <!-- Start Breadcrumbbar -->
            @yield('breadcrumbs')
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->
            @yield('content')
            <!-- End Contentbar -->
            @yield('modal')
            <!-- Start Footerbar -->
            <div class="footerbar">
                <footer class="footer">
                    <p class="mb-0">© 2020 Olian - All Rights Reserved.</p>
                </footer>
            </div>
            <!-- End Footerbar -->
        </div>
        <!-- End Rightbar -->
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
    <!-- Core js -->
    <script src="{{ asset('admin/assets/js/core.js') }}"></script>
    <script>
        const success = {!! json_encode(session('success')) !!};
        const error = {!! json_encode(session('error')) !!};
        const warning = {!! json_encode(session('warning')) !!};
        const errors = {!! json_encode($errors->any()) !!}
        if (success)
            new PNotify( {
                title: 'Success', text: success, type: 'success'
            });

        if (errors)
            new PNotify( {
                title: 'Error', text: 'Invalid input data', type: 'error'
            });

        if (error)
            new PNotify( {
                title: 'Error', text: error, type: 'error'
            });

        if (warning)
            new PNotify( {
                title: 'Warning', text: warning, type: 'primary'
            });

        function confirmSubmission(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger m-l-10',
                confirmButtonText: 'Yes, proceed!'
            }).then(function () {
                $('#'+id).submit();
            });
        };
        function numberFormat(amount, decimal = ".", thousands = ",") {
            try {
                amount = Number.parseFloat(amount);
                let decimalCount = Number.isInteger(amount) ? 0 : amount.toString().split('.')[1].length;
                const negativeSign = amount < 0 ? "-" : "";
                let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
                let j = (i.length > 3) ? i.length % 3 : 0;
                return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
            } catch (e) {
                console.log(e)
            }
        }
    </script>
    @yield('script')
    <!-- End js -->
</body>

<!-- Mirrored from themesbox.in/admin-templates/olian/html/light-vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 18 Oct 2020 00:25:24 GMT -->
</html>