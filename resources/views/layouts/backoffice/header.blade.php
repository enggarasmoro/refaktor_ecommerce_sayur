<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Paksayur &amp; {{ $title }}</title>

        <meta name="description" content="Paksayur &amp; {{ $title }}">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Open Graph Meta -->
        <meta property="og:title" content="Paksayur &amp; {{ $title }}">
        <meta property="og:site_name" content="Paksayur">
        <meta property="og:description" content="Paksayur &amp; {{ $title }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{asset('frontend/images/icon/favicon.png')}}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('frontend/images/icon/cropped-transp-color.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('frontend/images/icon/cropped-transp-color.png')}}">
        <!-- END Icons -->

        <!-- Stylesheets -->

         <!-- Page JS Plugins CSS -->
         <link rel="stylesheet" href="{{asset('bo/js/plugins/datatables/dataTables.bootstrap4.css')}}">
         <link rel="stylesheet" href="{{asset('bo/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css')}}">
         <link rel="stylesheet" href="{{asset('bo/js/plugins/sweetalert2/sweetalert2.min.css')}}">
         <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
         <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
         <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />

        <!-- Fonts and OneUI framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
        <link rel="stylesheet" id="css-main" href="{{asset('bo/css/oneui.min.css')}}">


        <!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('bo/css/custom.css')}}">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/amethyst.min.css"> -->
        <!-- END Stylesheets -->
    </head>
    <body>
        <!-- Page Container -->
        <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed">
            <!-- Sidebar -->
            <nav id="sidebar" aria-label="Main Navigation">
                <!-- Side Header -->
                <div class="content-header bg-white-5">
                    <!-- Logo -->
                    <a class="font-w600 text-dual" href="{{ route('bo.home') }}">
                        <i class="fa fa-circle-notch text-primary"></i>
                        <span class="smini-hide">
                            <span class="font-w700 font-size-h5">ne</span>
                        </span>
                    </a>
                    <!-- END Logo -->
                </div>
                <!-- END Side Header -->

                <!-- Side Navigation -->
                <div class="content-side content-side-full">
                    <ul class="nav-main">
                        <li class="nav-main-heading">Navigation</li>
                        <li class="nav-main-item">
                            <a class="nav-main-link active" href="{{ route('bo.home') }}">
                                <i class="nav-main-link-icon si si-speedometer"></i>
                                <span class="nav-main-link-name">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-settings"></i>
                                <span class="nav-main-link-name">Data Master</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('masteradmin') }}">
                                        <span class="nav-main-link-name">Master User Admin</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('masteruser') }}">
                                        <span class="nav-main-link-name">Master User</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('masterbanner') }}">
                                        <span class="nav-main-link-name">Master Banner</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('configvoucher') }}">
                                        <span class="nav-main-link-name">Master Voucher Diskon</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('configbank') }}">
                                        <span class="nav-main-link-name">Master Bank</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('jamkirim') }}">
                                        <span class="nav-main-link-name">Master Jam Kirim</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('ongkir') }}">
                                        <span class="nav-main-link-name">Master Ongkos Kirim</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('masternewslatter') }}">
                                        <span class="nav-main-link-name">Master Newslatter</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                                <i class="nav-main-link-icon si si-bag"></i>
                                <span class="nav-main-link-name">Produk</span>
                            </a>
                            <ul class="nav-main-submenu">
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('produk') }}">
                                        <span class="nav-main-link-name">Data Produk</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('produkkategori') }}">
                                        <span class="nav-main-link-name">Kategori Produk</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link active" href="{{ route('order') }}">
                                <i class="nav-main-link-icon si si-handbag"></i>
                                <span class="nav-main-link-name">Pesanan Masuk</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END Side Navigation -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="d-flex align-items-center">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        <button type="button" class="btn btn-sm btn-dual mr-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>
                        <!-- END Toggle Sidebar -->

                        <!-- Toggle Mini Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
                        <button type="button" class="btn btn-sm btn-dual mr-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
                            <i class="fa fa-fw fa-ellipsis-v"></i>
                        </button>
                        <!-- END Toggle Mini Sidebar -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="d-flex align-items-center">
                        <!-- User Dropdown -->
                        <div class="dropdown d-inline-block ml-2">
                            <button type="button" class="btn btn-sm btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded" src="{{asset('bo/media/avatars/avatar10.jpg')}}" alt="Header Avatar" style="width: 18px;">
                                <span class="d-none d-sm-inline-block ml-1">{{Auth::guard('admin')->user()->username}}</span>
                                <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="page-header-user-dropdown">
                                <div class="p-3 text-center bg-primary">
                                    <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{asset('bo/media/avatars/avatar10.jpg')}}" alt="">
                                </div>
                                <div class="p-2">
                                    <h5 class="dropdown-header text-uppercase">Actions</h5>
                                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('bo.logout') }}">
                                        <span>Log Out</span>
                                        <i class="si si-logout ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- END User Dropdown -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->
            </header>
            <!-- END Header -->