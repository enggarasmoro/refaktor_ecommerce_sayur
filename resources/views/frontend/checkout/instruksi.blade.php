@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="container">
        @if ($message = Session::get('gagal'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="banner-header banner-lbook3">
            <img src="{{asset('frontend/images/banner-catalog1.jpg')}}" alt="Banner-header">
            <div class="text">
                <h3>Order Completed</h3>
                <p><a href="{{ route('home') }}" title="Home">Home</a><i class="fa fa-caret-right"></i>Order Completed</p>
            </div>
        </div>
    </div>
    @if ($order->id_bank == "COD")
        <div class="container container-ver2 space-padding-tb-30">
            <div class="box float-left order-complete center space-50">
                <div class="icon space-20">
                    <img src="{{asset('frontend/images/icon-order-complete.png')}}" alt="icon">
                </div>                    
                <p class="box center space-50">Terimakasih telah melakukan melakukan order di paksayur.com.Pesanan anda akan segera kami proses.</p>
                <hr>
                <div class="box col-md-6 center">
                    <h3 class="title-brand">YOUR ORDER</h3>
                    <div class="info-order">
                        <div class="product-name">
                            <ul>
                                <li class="head">
                                    <span class="name">Nama Produk</span>
                                    <span class="qty"><b>QTY</b></span>
                                    <span class="total"><b>SUB TOTAL</b></span>
                                </li>
                                @php
                                    $total = 0;             
                                @endphp
                                @foreach ($orderdetail as $item)
                                    <li>
                                        <span class="name">{{$item->namaproduk}}</span>
                                        <span class="qty">{{$item->qty}}</span>
                                        <span class="total">Rp.{{number_format($item->total, 0, ',', '.')}}</span>
                                    </li>
                                    @php
                                        $total += $item->total;             
                                    @endphp    
                                @endforeach
                            </ul>
                        </div>
                        <!-- End product-name -->
                        <ul class="product-order">
                            <li>
                                <span class="left">CART SUBTOTAL</span>
                                <span class="right">Rp.{{number_format($total, 0, ',', '.')}}</span>
                            </li>
                            <li>
                                <span class="left">Ongkos Kirim</span>
                                <span class="right">Rp.{{number_format($order->ongkir, 0, ',', '.')}}</span>
                            </li>
                            @if ($order->harga_package != "0")
                                <li>
                                    <span class="left">Ongkos Pengemasan</span>
                                    <span class="right">Rp.{{number_format($order->harga_package, 0, ',', '.')}}</span>
                                </li>
                            @endif
                            @if ($order->nominal != null)
                                <li>
                                    <span class="left">Diskon Voucher</span>
                                    <span class="right">Rp.{{number_format($order->nominal, 0, ',', '.')}}</span>
                                </li>
                            @endif
                            @if ($order->id_bank != "COD")
                                <li>
                                    <span class="left">Kode Unik</span>
                                    <span class="right">Rp.{{number_format($order->kode_unik, 0, ',', '.')}}</span>
                                </li>
                            @endif
                            <li>
                                <span class="left">ORDER TOTAL</span>
                                <span class="right brand">Rp.{{number_format($order->total, 0, ',', '.')}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End cat-box-container -->
    @else
        <div class="container container-ver2 space-padding-tb-30">
            <div class="box float-left order-complete center space-50">
                <div class="icon space-20">
                    <img src="{{asset('frontend/images/icon-order-complete.png')}}" alt="icon">
                </div>                    
                <p class="box center space-50">Terimakasih telah melakukan melakukan order di paksayur.com.Agar pesanan segera di proses silahkan Pergi ke pusat ATM terdekat atau gunakan Internet / m-Banking Anda dan transfer jumlah uang ke nomor rekening bank berikut. Jangan lupa untuk memasukkan ID pesanan saat mentransfer uang</p>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <h3 class="title-brand">Our bank details</h3>
                            <div class="info-order">
                                <div class="product-name">
                                    <ul>
                                        <li>
                                            <span class="name">Bank</span>
                                            <span class="qty"><b>{{$order->namabank}}</b></span>
                                        </li>
                                        <li>
                                            <span class="name">Atas Nama</span>
                                            <span class="qty"><b>{{$order->atasnama}}</b></span>
                                        </li>
                                        <li>
                                            <span class="name">No Rekening</span>
                                            <span class="qty"><b>{{$order->norek}}</b></span>
                                        </li>
                                        <li>
                                            <span class="name">Total Bayar</span>
                                            <span class="qty"><b>Rp.{{number_format($order->total, 0, ',', '.')}}</b></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End col-md-8 -->
                    <div class="col-md-6 space-30">
                        <div class="box">
                            <h3 class="title-brand">YOUR ORDER</h3>
                            <div class="info-order">
                                <div class="product-name">
                                    <ul>
                                        <li class="head">
                                            <span class="name">Nama Produk</span>
                                            <span class="qty"><b>QTY</b></span>
                                            <span class="total"><b>SUB TOTAL</b></span>
                                        </li>
                                        @php
                                            $total = 0;             
                                        @endphp
                                        @foreach ($orderdetail as $item)
                                            <li>
                                                <span class="name">{{$item->namaproduk}}</span>
                                                <span class="qty">{{$item->qty}}</span>
                                                <span class="total">Rp.{{number_format($item->total, 0, ',', '.')}}</span>
                                            </li>
                                            @php
                                                $total += $item->total;             
                                            @endphp    
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- End product-name -->
                                <ul class="product-order">
                                    <li>
                                        <span class="left">CART SUBTOTAL</span>
                                        <span class="right">Rp.{{number_format($total, 0, ',', '.')}}</span>
                                    </li>
                                    <li>
                                        <span class="left">Ongkos Kirim</span>
                                        <span class="right">Rp.{{number_format($order->ongkir, 0, ',', '.')}}</span>
                                    </li>
                                    @if ($order->harga_package != "0")
                                        <li>
                                            <span class="left">Ongkos Pengemasan</span>
                                            <span class="right">Rp.{{number_format($order->harga_package, 0, ',', '.')}}</span>
                                        </li>
                                    @endif
                                    @if ($order->nominal != null)
                                        <li>
                                            <span class="left">Diskon Voucher</span>
                                            <span class="right">Rp.{{number_format($order->nominal, 0, ',', '.')}}</span>
                                        </li>
                                    @endif
                                    <li>
                                        <span class="left">Kode Unik</span>
                                        <span class="right">Rp.{{number_format($order->kode_unik, 0, ',', '.')}}</span>
                                    </li>
                                    <li>
                                        <span class="left">ORDER TOTAL</span>
                                        <span class="right brand">Rp.{{number_format($order->total, 0, ',', '.')}}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End cat-box-container -->
    @endif
    
</div>
@endsection
