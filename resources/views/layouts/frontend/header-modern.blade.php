<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=375, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<title>Paksayur | {{ $title }}</title>
        <link rel="shortcut icon" href="{{asset('frontend/images/icon/favicon.png')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('frontend/images/icon/cropped-transp-color.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('frontend/images/icon/cropped-transp-color.png')}}">

        <!-- Modern CSS Framework -->
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/modern-style.css')}}"/>

        <!-- Force Mobile Layout CSS -->
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/force-mobile.css')}}"/>

        <!-- Keep existing CSS for compatibility (will gradually phase out) -->
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/bootstrap.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/style.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/vendor/owl-slider.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/vendor/settings.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/vendor/slick.css')}}"/>

        <!-- Google Fonts for modern typography -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <script type="text/javascript" src="{{asset('frontend/js/jquery-3.2.0.min.js')}}"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />

        <!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('bo/css/custom.css')}}">

        <!-- Modern Header Styles -->
        <style>
            /* Override for smooth transition */
            .legacy-hidden {
                display: none !important;
            }

            /* Mobile menu toggle */
            .mobile-menu-toggle {
                display: none;
                background: none;
                border: none;
                font-size: 1.5rem;
                color: var(--gray-700);
                cursor: pointer;
                padding: var(--space-3);
                border-radius: var(--radius-lg);
                transition: all var(--transition-fast);
            }

            .mobile-menu-toggle:hover {
                background-color: var(--gray-100);
            }

            /* Mobile Navigation Overlay */
            .mobile-nav-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: var(--z-modal-backdrop);
                opacity: 0;
                visibility: hidden;
                transition: all var(--transition-normal);
            }

            .mobile-nav-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .mobile-nav-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 300px;
                height: 100vh;
                background: var(--white);
                z-index: var(--z-modal);
                padding: var(--space-6);
                transition: all var(--transition-normal);
                box-shadow: var(--shadow-xl);
                overflow-y: auto;
            }

            .mobile-nav-menu.active {
                right: 0;
            }

            .mobile-nav-header {
                display: flex;
                justify-content: between;
                align-items: center;
                margin-bottom: var(--space-6);
                padding-bottom: var(--space-4);
                border-bottom: 1px solid var(--gray-200);
            }

            .mobile-nav-close {
                background: none;
                border: none;
                font-size: 1.5rem;
                color: var(--gray-500);
                cursor: pointer;
                padding: var(--space-2);
                border-radius: var(--radius-lg);
                transition: all var(--transition-fast);
                margin-left: auto;
            }

            .mobile-nav-close:hover {
                background-color: var(--gray-100);
                color: var(--gray-700);
            }

            .mobile-nav-item {
                margin-bottom: var(--space-3);
            }

            .mobile-nav-link {
                display: flex;
                align-items: center;
                gap: var(--space-3);
                padding: var(--space-4);
                color: var(--gray-700);
                text-decoration: none;
                border-radius: var(--radius-lg);
                transition: all var(--transition-fast);
                font-weight: 500;
            }

            .mobile-nav-link:hover,
            .mobile-nav-link.active {
                background-color: var(--primary-color);
                color: var(--white);
            }

            .mobile-nav-submenu {
                margin-left: var(--space-8);
                margin-top: var(--space-2);
            }

            .mobile-nav-submenu-item {
                padding: var(--space-2) var(--space-4);
                margin-bottom: var(--space-1);
            }

            .mobile-nav-submenu-link {
                display: block;
                color: var(--gray-600);
                text-decoration: none;
                font-size: var(--text-sm);
                padding: var(--space-2);
                border-radius: var(--radius-md);
                transition: all var(--transition-fast);
            }

            .mobile-nav-submenu-link:hover {
                background-color: var(--gray-100);
                color: var(--primary-color);
            }

            @media (max-width: 768px) {
                .mobile-menu-toggle {
                    display: block;
                }
                .desktop-nav {
                    display: none;
                }

                .header-content {
                    flex-wrap: wrap;
                    gap: var(--space-3);
                }

                .header-logo {
                    order: 1;
                    flex: 0 0 auto;
                }

                .header-actions {
                    order: 2;
                    flex: 0 0 auto;
                    gap: var(--space-2);
                }

                .header-search {
                    order: 3;
                    width: 100%;
                    flex: 1 1 100%;
                    margin-top: var(--space-3);
                }
            }

            /* Better desktop layout */
            @media (min-width: 769px) {
                .header-content {
                    align-items: center;
                    justify-content: space-between;
                    flex-wrap: nowrap;
                }

                .header-logo {
                    flex: 0 0 auto;
                }

                .header-search {
                    flex: 1 1 auto;
                    max-width: 600px;
                    margin: 0 var(--space-8);
                }

                .header-actions {
                    flex: 0 0 auto;
                }
            }

            @media (max-width: 480px) {
                .container {
                    padding: 0 var(--space-3);
                }

                .header-logo img {
                    height: 35px;
                }

                .mobile-nav-menu {
                    width: 280px;
                }

                .cart-dropdown {
                    min-width: 300px;
                    right: -50px;
                }
            }

            /* Cart dropdown */
            .cart-dropdown {
                position: absolute;
                top: 100%;
                right: 0;
                background: var(--white);
                min-width: 350px;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-xl);
                padding: var(--space-4);
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all var(--transition-fast);
                z-index: var(--z-dropdown);
                border: 1px solid var(--gray-200);
            }

            .header-cart:hover .cart-dropdown {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .cart-item {
                display: flex;
                align-items: center;
                gap: var(--space-3);
                padding: var(--space-3);
                border-bottom: 1px solid var(--gray-100);
            }

            .cart-item:last-child {
                border-bottom: none;
            }

            .cart-item-image {
                width: 50px;
                height: 50px;
                border-radius: var(--radius-lg);
                overflow: hidden;
                flex-shrink: 0;
            }

            .cart-item-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .cart-item-details {
                flex: 1;
            }

            .cart-item-name {
                font-size: var(--text-sm);
                font-weight: 500;
                color: var(--gray-800);
                margin-bottom: var(--space-1);
            }

            .cart-item-price {
                font-size: var(--text-sm);
                color: var(--primary-color);
                font-weight: 600;
            }

            .cart-item-qty {
                font-size: var(--text-xs);
                color: var(--gray-500);
            }

            .cart-item-remove {
                color: var(--gray-400);
                cursor: pointer;
                transition: color var(--transition-fast);
            }

            .cart-item-remove:hover {
                color: var(--danger-color);
            }

            .cart-total {
                display: flex;
                justify-content: between;
                align-items: center;
                padding: var(--space-4) 0;
                border-top: 1px solid var(--gray-200);
                margin-top: var(--space-3);
            }

            .cart-total-label {
                font-weight: 600;
                color: var(--gray-800);
            }

            .cart-total-amount {
                font-weight: 700;
                color: var(--primary-color);
                font-size: var(--text-lg);
            }

            .cart-actions {
                display: flex;
                gap: var(--space-3);
                margin-top: var(--space-4);
            }

            /* User menu dropdown */
            .user-dropdown {
                position: absolute;
                top: 100%;
                right: 0;
                background: var(--white);
                min-width: 200px;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-xl);
                padding: var(--space-2);
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all var(--transition-fast);
                z-index: var(--z-dropdown);
                border: 1px solid var(--gray-200);
            }

            .user-menu:hover .user-dropdown {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .user-dropdown-item {
                display: flex;
                align-items: center;
                gap: var(--space-3);
                padding: var(--space-3) var(--space-4);
                color: var(--gray-700);
                text-decoration: none;
                border-radius: var(--radius-md);
                transition: all var(--transition-fast);
                font-size: var(--text-sm);
            }

            .user-dropdown-item:hover {
                background-color: var(--gray-50);
                color: var(--primary-color);
            }

            .user-dropdown-divider {
                height: 1px;
                background-color: var(--gray-200);
                margin: var(--space-2) 0;
            }

            /* Search suggestions dropdown */
            .search-suggestions {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--white);
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-xl);
                max-height: 300px;
                overflow-y: auto;
                z-index: var(--z-dropdown);
                border: 1px solid var(--gray-200);
                display: none;
            }

            .search-suggestion-item {
                display: flex;
                align-items: center;
                gap: var(--space-3);
                padding: var(--space-3) var(--space-4);
                cursor: pointer;
                transition: background-color var(--transition-fast);
            }

            .search-suggestion-item:hover {
                background-color: var(--gray-50);
            }

            /* IMPROVED HEADER STYLING */
            .header-main {
                padding: var(--space-4) 0;
                border-bottom: 1px solid var(--gray-200);
                background: var(--white);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            }

            .header-content {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: var(--space-6);
                min-height: 60px;
            }

            .header-logo {
                transition: transform var(--transition-fast);
            }

            .header-logo:hover {
                transform: scale(1.05);
            }

            .header-logo img {
                height: 48px;
                width: auto;
                filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            }

            .header-search {
                flex: 1;
                max-width: 500px;
                margin: 0 var(--space-6);
            }

            .search-input {
                position: relative;
                width: 100%;
            }

            .search-input input {
                width: 100%;
                padding: 14px 18px 14px 48px;
                border: 2px solid var(--gray-200);
                border-radius: 50px;
                font-size: 15px;
                outline: none;
                transition: all var(--transition-fast);
                background: var(--gray-50);
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            }

            .search-input input:focus {
                border-color: var(--primary-color);
                background: var(--white);
                box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1), inset 0 1px 3px rgba(0, 0, 0, 0.05);
                transform: translateY(-1px);
            }

            .search-input-icon {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--gray-400);
                font-size: 16px;
            }

            .header-actions {
                display: flex;
                align-items: center;
                gap: var(--space-3);
            }

            .header-cart {
                position: relative;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 50px;
                height: 50px;
                border-radius: var(--radius-lg);
                transition: all var(--transition-fast);
                text-decoration: none;
                color: var(--gray-600);
                background: rgba(247, 250, 252, 0.8);
            }

            .header-cart:hover {
                background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
                transform: translateY(-2px);
                color: var(--primary-color);
                box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
            }

            .cart-badge {
                position: absolute;
                top: 6px;
                right: 6px;
                background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                color: var(--white);
                font-size: 11px;
                font-weight: 700;
                padding: 3px 7px;
                border-radius: 12px;
                min-width: 20px;
                text-align: center;
                line-height: 1.2;
                box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
                animation: cartPulse 2s infinite;
                border: 2px solid var(--white);
            }

            @keyframes cartPulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }

            @keyframes phoneRing {
                0%, 100% { transform: rotate(0deg); }
                25% { transform: rotate(-10deg); }
                75% { transform: rotate(10deg); }
            }

            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 12px 20px;
                font-size: 14px;
                font-weight: 500;
                border: none;
                border-radius: var(--radius-lg);
                cursor: pointer;
                transition: all var(--transition-fast);
                text-decoration: none;
                min-height: 48px;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary-color) 0%, #3b82f6 100%);
                color: var(--white);
                box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--primary-hover) 0%, #2563eb 100%);
                transform: translateY(-2px);
                box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
            }

            .mobile-menu-toggle {
                display: none;
                align-items: center;
                justify-content: center;
                width: 48px;
                height: 48px;
                background: none;
                border: none;
                border-radius: var(--radius-lg);
                cursor: pointer;
                transition: all var(--transition-fast);
            }

            .mobile-menu-toggle:hover {
                background-color: var(--gray-100);
            }

            /* Navigation Improvements */
            .main-nav {
                background: var(--white);
                border-top: 1px solid var(--gray-200);
                padding: 0;
            }

            .nav-menu {
                display: flex;
                align-items: center;
                gap: 0;
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .nav-item {
                position: relative;
            }

            .nav-link {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 16px 24px;
                font-size: 14px;
                font-weight: 500;
                color: var(--gray-700);
                text-decoration: none;
                transition: all var(--transition-fast);
                position: relative;
            }

            .nav-link:hover,
            .nav-link.active {
                color: var(--primary-color);
                background-color: rgba(37, 99, 235, 0.05);
            }

            .nav-link.active::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 3px;
                background: var(--primary-color);
            }

            /* Mobile Responsive Fixes */
            @media (max-width: 768px) {
                .mobile-menu-toggle {
                    display: flex;
                }

                .desktop-nav {
                    display: none;
                }

                .header-content {
                    flex-wrap: wrap;
                    gap: var(--space-3);
                    min-height: 60px;
                }

                .header-logo {
                    order: 1;
                    flex: 0 0 auto;
                }

                .header-actions {
                    order: 2;
                    flex: 0 0 auto;
                    gap: var(--space-2);
                }

                .header-search {
                    order: 3;
                    width: 100%;
                    flex: 1 1 100%;
                    margin: var(--space-3) 0 0 0;
                    max-width: none;
                }

                .search-input input {
                    font-size: 16px; /* Prevent zoom on iOS */
                }
            }

            @media (max-width: 480px) {
                .header-logo img {
                    height: 40px;
                }

                .btn {
                    padding: 10px 16px;
                    font-size: 13px;
                }

                .header-cart {
                    width: 44px;
                    height: 44px;
                }
            }

            /* User Menu Styling */
            .user-menu {
                position: relative;
            }

            .btn-avatar {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 12px;
                border: none;
                background: none;
                cursor: pointer;
                border-radius: var(--radius-lg);
                transition: all var(--transition-fast);
            }

            .btn-avatar:hover {
                background-color: var(--gray-100);
            }

            .avatar {
                width: 36px;
                height: 36px;
                background: var(--primary-color);
                color: var(--white);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                font-weight: 600;
            }

            .btn-avatar i {
                font-size: 12px;
                color: var(--gray-400);
            }

            /* User Dropdown */
            .user-dropdown {
                position: absolute;
                top: 100%;
                right: 0;
                background: var(--white);
                min-width: 220px;
                border-radius: var(--radius-xl);
                box-shadow: var(--shadow-xl);
                padding: var(--space-2);
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all var(--transition-fast);
                z-index: var(--z-dropdown);
                border: 1px solid var(--gray-200);
                margin-top: 8px;
            }

            .user-menu:hover .user-dropdown {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .user-dropdown-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 12px 16px;
                color: var(--gray-700);
                text-decoration: none;
                border-radius: var(--radius-lg);
                font-size: 14px;
                transition: all var(--transition-fast);
            }

            .user-dropdown-item:hover {
                background-color: var(--gray-50);
                color: var(--primary-color);
            }

            .user-dropdown-item.text-danger {
                color: var(--danger-color);
            }

            .user-dropdown-item.text-danger:hover {
                background-color: rgba(239, 68, 68, 0.05);
                color: var(--danger-color);
            }

            .user-dropdown-divider {
                height: 1px;
                background-color: var(--gray-200);
                margin: var(--space-2) 0;
            }
        </style>
    </head>
    <body>
        @if ($title == "Home" && isset($newslatter))
            <div class="popup-content">
                <div class="popup-content-wrapper">
                <div class="popup-container">
                    <a href="#" class="close-popup fa fa-times-circle"></a>
                        <div class="images">
                            <img class="img-responsive" src="{{asset('frontend/'.$newslatter->image)}}" alt="newsletter">
                        </div>
                        <div class="text">
                            <div class="popup-content-text">
                                <p><strong> {{$newslatter->keterangan}}</strong></p>
                                <br/>
                                @if(isset($pengiriman))
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width: 50%;margin-left: auto;margin-right: auto; border: 2px solid;">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center">Waktu</th>
                                                    <th style="text-align: center">Jam Pengiriman</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pengiriman as $pengiriman_item)
                                                    <tr>
                                                        <td>{{$pengiriman_item->pengiriman}}</td>
                                                        <td>{{$pengiriman_item->jam_kirim}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                </div>
                </div>
            </div>
            <!-- End popup  -->
        @endif

        <div class="awe-page-loading">
            <div class="awe-loading-wrapper">
            <div class="awe-loading-icon">
                <img src="{{asset('frontend/images/icon/cropped-transp-color.png')}}" alt="images">
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            </div>
        </div>

        <!-- Modern Search Modal -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content popup-search" style="border-radius: var(--radius-xl); border: none;">
                    <button type="button" class="close" data-dismiss="modal" style="position: absolute; top: 15px; right: 20px; font-size: 24px; color: var(--gray-400);"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <div class="modal-body" style="padding: var(--space-8);">
                        <div class="input-group">
                            <form class="form-horizontal validasi" method="POST" action="{{ route('shop.search') }}" style="width: 100%;">
                                @csrf
                                <div class="search-input" style="position: relative;">
                                    <i class="fas fa-search search-input-icon" style="position: absolute; left: var(--space-4); top: 50%; transform: translateY(-50%); color: var(--gray-400);"></i>
                                    <input type="text" class="form-control" placeholder="Cari produk, kategori..." name="nama" style="width: 100%; padding: var(--space-4) var(--space-4) var(--space-4) var(--space-12); border: 2px solid var(--gray-200); border-radius: var(--radius-full); font-size: var(--text-base); outline: none;">
                                    <button class="btn btn-primary" type="submit" style="position: absolute; right: var(--space-2); top: 50%; transform: translateY(-50%); border-radius: var(--radius-full); padding: var(--space-2) var(--space-6);">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrappage">
            <!-- Modern Header -->
            <header class="modern-header">
                <!-- Top Bar -->
                <div class="header-top" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 1px solid var(--gray-200);">
                    <div class="container">
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 8px 0;">
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <a href="http://wa.me/6281241938647" style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: var(--gray-600); text-decoration: none; transition: color var(--transition-fast);" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--gray-600)'">
                                    <i class="fas fa-phone" style="color: var(--primary-color); animation: phoneRing 2s infinite;"></i>
                                    <span>+62 812-4193-8647</span>
                                </a>
                            </div>
                            <div style="display: flex; align-items: center; gap: 16px; font-size: 13px; color: var(--gray-600);">
                                <span style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fas fa-shipping-fast" style="color: var(--success-color);"></i>
                                    Gratis ongkir untuk pembelian di atas Rp 100.000
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Header -->
                <div class="header-main">
                    <div class="container">
                        <div class="header-content">
                            <!-- Logo -->
                            <div class="header-logo">
                                <a href="{{ route('home') }}" title="Paksayur">
                                    <img src="{{asset('frontend/images/logopaksayurbaru.png')}}" alt="Paksayur Logo" style="height: 45px;">
                                </a>
                            </div>

                            <!-- Search Bar -->
                            <div class="header-search">
                                <form method="POST" action="{{ route('shop.search') }}">
                                    @csrf
                                    <div class="search-input">
                                        <i class="fas fa-search search-input-icon"></i>
                                        <input type="text"
                                               placeholder="Cari produk segar, sayuran, buah..."
                                               name="nama"
                                               autocomplete="off">
                                    </div>
                                </form>
                            </div>

                            <!-- Header Actions -->
                            <div class="header-actions">
                                <!-- Cart -->
                                <div class="header-cart">
                                    <a href="{{route('mycart')}}">
                                        <i class="fas fa-shopping-cart"></i>
                                        @if(isset($cart_detail) && count($cart_detail) > 0)
                                            <span class="cart-badge">{{count($cart_detail)}}</span>
                                        @endif
                                    </a>

                                    <!-- Cart Dropdown -->
                                    @if(isset($cart_detail) && count($cart_detail) > 0)
                                        <div class="cart-dropdown">
                                            <div class="mb-3">
                                                <h6 class="font-semibold text-gray-800 mb-3">Keranjang Belanja</h6>
                                                <div class="max-h-60 overflow-y-auto">
                                                    @php $total = 0; @endphp
                                                    @foreach ($cart_detail as $item)
                                                        <div class="cart-item">
                                                            <div class="cart-item-image">
                                                                <img src="{{asset('frontend').'/'.$item->image}}" alt="{{$item->namaproduk}}">
                                                            </div>
                                                            <div class="cart-item-details">
                                                                <div class="cart-item-name">{{$item->namaproduk}}</div>
                                                                <div class="cart-item-price">Rp {{number_format($item->total, 0, ',', '.')}}</div>
                                                                <div class="cart-item-qty">Qty: {{$item->qty}}</div>
                                                            </div>
                                                            <a href="{{route('shop.deletecart',$item->id)}}" class="cart-item-remove">
                                                                <i class="fas fa-times"></i>
                                                            </a>
                                                        </div>
                                                        @php $total += $item->total; @endphp
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="cart-total">
                                                <div class="flex justify-between items-center w-full">
                                                    <span class="cart-total-label">Total:</span>
                                                    <span class="cart-total-amount">Rp {{number_format($total, 0, ',', '.')}}</span>
                                                </div>
                                            </div>

                                            <div class="cart-actions">
                                                <a href="{{route('mycart')}}" class="btn btn-outline flex-1">Lihat Keranjang</a>
                                                <a href="{{route('checkout')}}" class="btn btn-primary flex-1">Checkout</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- User Menu -->
                                @if (auth()->guard()->check())
                                    <div class="user-menu">
                                        <button class="btn-avatar">
                                            <div class="avatar">
                                                <span>{{strtoupper(substr(Auth::user()->name ?? Auth::user()->email, 0, 1))}}</span>
                                            </div>
                                            <i class="fas fa-chevron-down"></i>
                                        </button>

                                        <div class="user-dropdown">
                                            <div class="px-4 py-3">
                                                <p class="text-sm font-medium text-gray-800">{{Auth::user()->name ?? 'User'}}</p>
                                                <p class="text-xs text-gray-500">{{Auth::user()->email}}</p>
                                            </div>
                                            <div class="user-dropdown-divider"></div>
                                            <a href="{{ route('myaccount') }}" class="user-dropdown-item">
                                                <i class="fas fa-user"></i>
                                                <span>Profil Saya</span>
                                            </a>
                                            <a href="#" class="user-dropdown-item">
                                                <i class="fas fa-shopping-bag"></i>
                                                <span>Pesanan Saya</span>
                                            </a>
                                            <div class="user-dropdown-divider"></div>
                                            <a href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                               class="user-dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt"></i>
                                                <span>Logout</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        <i class="fas fa-user mr-2"></i>
                                        Masuk
                                    </a>
                                @endif

                                <!-- Mobile Menu Toggle -->
                                <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <nav class="main-nav desktop-nav">
                    <div class="container">
                        <ul class="nav-menu">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}">
                                    <i class="fas fa-home"></i>
                                    <span>Home</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('shop') }}" class="nav-link {{ Request::routeIs('shop*') ? 'active' : '' }}">
                                    <i class="fas fa-store"></i>
                                    <span>Belanja</span>
                                    <i class="fas fa-chevron-down text-xs ml-1"></i>
                                </a>
                                <div class="dropdown-menu">
                                    <a href="{{ route('shop') }}" class="dropdown-item">
                                        <i class="fas fa-th-large"></i>
                                        <span>Semua Produk</span>
                                    </a>
                                    @if(isset($kategori))
                                        @foreach ($kategori as $kat)
                                            <a href="{{route('shop').'/'.$kat->slug}}" class="dropdown-item">
                                                <i class="fas fa-tag"></i>
                                                <span>{{$kat->nama}}</span>
                                            </a>
                                        @endforeach
                                    @endif
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-leaf"></i>
                                    <span>Tentang Kami</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-phone"></i>
                                    <span>Kontak</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Mobile Navigation -->
                <div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
                <nav class="mobile-nav-menu" id="mobile-nav-menu">
                    <div class="mobile-nav-header">
                        <div class="flex items-center gap-3">
                            <img src="{{asset('frontend/images/logopaksayurbaru.png')}}" alt="Paksayur" style="height: 30px;">
                            <span class="font-semibold text-gray-800">Menu</span>
                        </div>
                        <button class="mobile-nav-close" id="mobile-nav-close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="mobile-nav-content">
                        <!-- User Info (if logged in) -->
                        @if (auth()->guard()->check())
                            <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center">
                                        <span class="font-medium">{{strtoupper(substr(Auth::user()->name ?? Auth::user()->email, 0, 1))}}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{Auth::user()->name ?? 'User'}}</p>
                                        <p class="text-sm text-gray-500">{{Auth::user()->email}}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Navigation Items -->
                        <div class="mobile-nav-item">
                            <a href="{{ route('home') }}" class="mobile-nav-link {{ Request::routeIs('home') ? 'active' : '' }}">
                                <i class="fas fa-home"></i>
                                <span>Home</span>
                            </a>
                        </div>

                        <div class="mobile-nav-item">
                            <a href="{{ route('shop') }}" class="mobile-nav-link {{ Request::routeIs('shop*') ? 'active' : '' }}">
                                <i class="fas fa-store"></i>
                                <span>Belanja</span>
                            </a>
                            <div class="mobile-nav-submenu">
                                <div class="mobile-nav-submenu-item">
                                    <a href="{{ route('shop') }}" class="mobile-nav-submenu-link">
                                        <i class="fas fa-th-large mr-2"></i>
                                        Semua Produk
                                    </a>
                                </div>
                                @if(isset($kategori))
                                    @foreach ($kategori as $kat)
                                        <div class="mobile-nav-submenu-item">
                                            <a href="{{route('shop').'/'.$kat->slug}}" class="mobile-nav-submenu-link">
                                                <i class="fas fa-tag mr-2"></i>
                                                {{$kat->nama}}
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="mobile-nav-item">
                            <a href="#" class="mobile-nav-link">
                                <i class="fas fa-leaf"></i>
                                <span>Tentang Kami</span>
                            </a>
                        </div>

                        <div class="mobile-nav-item">
                            <a href="#" class="mobile-nav-link">
                                <i class="fas fa-phone"></i>
                                <span>Kontak</span>
                            </a>
                        </div>

                        @if (auth()->guard()->check())
                            <div class="mobile-nav-item">
                                <a href="{{ route('myaccount') }}" class="mobile-nav-link">
                                    <i class="fas fa-user"></i>
                                    <span>Profil Saya</span>
                                </a>
                            </div>

                            <div class="mobile-nav-item">
                                <a href="{{route('mycart')}}" class="mobile-nav-link">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Keranjang Belanja</span>
                                    @if(isset($cart_detail) && count($cart_detail) > 0)
                                        <span class="ml-auto bg-primary text-white text-xs px-2 py-1 rounded-full">{{count($cart_detail)}}</span>
                                    @endif
                                </a>
                            </div>

                            <div class="mobile-nav-item mt-6 pt-6 border-t border-gray-200">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                                   class="mobile-nav-link text-red-600">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        @else
                            <div class="mobile-nav-item mt-6 pt-6 border-t border-gray-200">
                                <a href="{{ route('login') }}" class="mobile-nav-link">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Masuk / Daftar</span>
                                </a>
                            </div>
                        @endif
                    </div>
                </nav>

                <!-- Mobile Navigation Script -->
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const mobileToggle = document.getElementById('mobile-menu-toggle');
                    const mobileOverlay = document.getElementById('mobile-nav-overlay');
                    const mobileMenu = document.getElementById('mobile-nav-menu');
                    const mobileClose = document.getElementById('mobile-nav-close');

                    function openMobileMenu() {
                        mobileOverlay.classList.add('active');
                        mobileMenu.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeMobileMenu() {
                        mobileOverlay.classList.remove('active');
                        mobileMenu.classList.remove('active');
                        document.body.style.overflow = '';
                    }

                    if (mobileToggle) mobileToggle.addEventListener('click', openMobileMenu);
                    if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
                    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);

                    // Force mobile behavior - always keep mobile menu functionality
                    window.addEventListener('resize', function() {
                        // Always keep mobile behavior - don't auto-close menu
                        console.log('Mobile mode forced - screen width:', window.innerWidth);
                    });

                    // Force mobile user agent
                    Object.defineProperty(navigator, 'userAgent', {
                        value: 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Mobile/15E148 Safari/604.1',
                        writable: false
                    });

                    // Force mobile viewport dimensions
                    Object.defineProperty(window.screen, 'width', { value: 375, writable: false });
                    Object.defineProperty(window.screen, 'height', { value: 667, writable: false });

                    // Add mobile class to body
                    document.body.classList.add('force-mobile-mode');
                    document.documentElement.classList.add('force-mobile-mode');
                });
                </script>
            </header>
