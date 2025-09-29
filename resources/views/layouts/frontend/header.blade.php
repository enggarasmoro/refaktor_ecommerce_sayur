<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<title>Paksayur | {{ $title }}</title>
        <link rel="shortcut icon" href="{{asset('frontend/images/icon/favicon.png')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('frontend/images/icon/cropped-transp-color.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('frontend/images/icon/cropped-transp-color.png')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/bootstrap.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/style.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/vendor/owl-slider.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/vendor/settings.css')}}"/>
        <link rel="stylesheet" type="text/css" href="{{asset('frontend/vendor/slick.css')}}"/>
        <script type="text/javascript" src="{{asset('frontend/js/jquery-3.2.0.min.js')}}"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />

        <!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('bo/css/custom.css')}}">
    </head>
    <body>
        @if ($title == "Home")
            <div class="popup-content">
                <div class="popup-content-wrapper">
                <div class="popup-container">
                    <a href="#" class="close-popup fa fa-times-circle"></a>
                        <div class="images">
                            <img class="img-responsive" src="{{asset('frontend/'.$newslatter->image)}}" alt="newsletter">
                        </div>
                        <div class="text">
                            <div class="popup-content-text">
                                <!--<img class="logo" src="{{asset('frontend/images/icon/cropped-transp-color.png')}}" alt="Logo-images">-->
                                <p><strong> {{$newslatter->keterangan}}</strong></p>
                                <br/>
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width: 50%;margin-left: auto;margin-right: auto;  border: 2px solid;">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">Waktu</th>
                                                <th style="text-align: center">Jam Pengiriman</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengiriman as $pengiriman)
                                                <tr>
                                                    <td>{{$pengiriman->pengiriman}}</td>
                                                    <td>{{$pengiriman->jam_kirim}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content popup-search">
                    <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
                    <div class="modal-body">
                        <div class="input-group">
                            <form class="form-horizontal validasi" method="POST" action="{{ route('shop.search') }}">
                                @csrf
                                <input type="text" class="form-control control-search" placeholder="Search and hit enter..." name="nama">
                                <button class="button_search" type="submit">Search</button>
                            </form>
                        </div><!-- /input-group -->

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- End pushmenu -->
    <div class="wrappage">
        <header id="header" class="header-v3 header-v2">
            <div id="topbar" class="topbar-ver2">
                <div class="container container-ver2">
                    <div class="inner-topbar box">
                        <div class="float-left">
                            <p><a href="http://wa.me/6281241938647"><img src="{{asset('frontend/images/icon-phone-header.png.png')}}" alt="icon"> Call us <span> +62 812-4193-8647</span></a></p>
                        </div>
                    </div>
                </div>
                <!-- End container -->
            </div>
            <!-- End topbar -->
            <div class="header-top">
                    <div class="container container-ver2">
                    <div class="box">
                        <p class="icon-menu-mobile"><i class="fa fa-bars" ></i></p>
                        <div class="logo"><a href="#" title="Uno">
                        <img src="{{asset('frontend/images/logopaksayurbaru.png')}}" alt="images">
                        </a></div>
                        <div class="logo-mobile"><a href="#" title="Xanadu"><img src="{{asset('frontend/images/logopaksayurbaru.png')}}" alt="Xanadu-Logo"></a></div>

                        <div class="box-right">
                            <div class="cart hover-menu">
								<p class="icon-cart" title="Add to cart">
                                    <i class="icon"></i>
                                    <div class="total_cart">
                                        <span class="cart-count">{{(isset($cart_detail))?count($cart_detail):"0"}}</span>
                                    </div>
								</p>
								<div class="cart-list list-menu">
                                    <ul class="list">
                                        @php
                                            $total = 0;             
                                        @endphp
                                        <div class="datacartlist">
                                            <div class="listprod">
                                                @if (isset($cart_detail))
                                                    @foreach ($cart_detail as $itemcartdetail)
                                                        <li>
                                                            <a href="#" title="" class="cart-product-image"><img src="{{asset('frontend')."/".$itemcartdetail->image}}" alt="Product" width="32" height="60"></a>
                                                            <div class="text">
                                                                <p class="product-name">{{$itemcartdetail->namaproduk}}</p>
                                                                <p class="product-price"><span class="price">Rp.{{number_format($itemcartdetail->total, 0, ',', '.')}}</span></p>
                                                                <p class="qty">QTY:{{$itemcartdetail->qty}}</p>
                                                            </div>
                                                            <a class="close" href="{{route("shop.deletecart",$itemcartdetail->id)}}" title="close"><i class="fa fa-times-circle"></i></a>
                                                        </li> 
                                                        @php
                                                            $total += $itemcartdetail->total;             
                                                        @endphp
                                                    @endforeach        
                                                @endif
                                            </div>
                                        </div>  
                                    </ul>
                                    <div class="datacarttotal">
                                        <div class="totalprod">
                                            <p class="total"><span class="left">Total:</span> <span class="right">Rp.{{number_format($total, 0, ',', '.')}}</span></p>
                                        </div>
                                    </div>
									<div class="bottom">
										<a class="link-v1" href="{{route("mycart")}}" title="viewcart">View Cart</a>
										<a class="link-v1 rt" href="{{route("checkout")}}" title="checkout">Check out</a>
									</div>
								</div>
							</div>
                            <div class="search dropdown" data-toggle="modal" data-target=".bs-example-modal-lg">
                                <i class="icon"></i>
                            </div>
                        </div>
                        <nav class="mega-menu">
                        <!-- Brand and toggle get grouped for better mobile display -->
                          <ul class="nav navbar-nav" id="navbar">
                            <li class="level1"><a href="{{ route('home') }}" title="About us">Home</a></li>
                            <li class="level1 active dropdown"><a href="{{ route('shop') }}" title="Home">Belanja</a>
                                <ul class="menu-level-1 dropdown-menu">
									@foreach ($kategori as $kategori)
										<li class="level2"><a href="{{route("shop")."/".$kategori->slug}}" title="{{$kategori->nama}}">{{$kategori->nama}}</a></li>
									@endforeach
                                </ul>
                            </li>
							@if (auth()->guard()->check())
								<li class="level1 active dropdown">
									<a title="account" href="#">
										{{Auth::user()->email}}
									</a>
									<ul class="menu-level-1 dropdown-menu">
										<li class="level2"><a href="{{ route('myaccount') }}">Profil</a></li>
										<li class="level2">
											<a href="{{ route('logout') }}"
												onclick="event.preventDefault();
												document.getElementById('logout-form').submit();">
												{{ __('Logout') }}
											</a>

											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												@csrf
											</form>
										</li>
									</ul>
								</li>
							@else
								<li class="level1"><a href="{{ route('login') }}" title="Login">Login</a></li>
							@endif
							
                          </ul>
                        </nav>
                    </div>                
                    </div>
                    <!-- End container -->
                </div>
                <!-- End header-top -->
        </header><!-- /header -->