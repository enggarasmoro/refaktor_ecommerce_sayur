@extends('layouts.app')

@section('content')
<div class="container">
    <div class="banner-header banner-lbook3 space-30">
        <img src="{{asset('frontend/images/banner-catalog1.jpg')}}" alt="Banner-header">
        <div class="text">
            <h3>Shopping Cart</h3>
            <p><a href="{{ route('home') }}" title="Home">Home</a><i class="fa fa-caret-right"></i>Shopping Cart</p>
        </div>
    </div>
</div>
 <!-- End Banner Grid -->
 <div class="cart-box-container">
    <div class="container container-ver2 space-padding-tb-30">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('gagal'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="box cart-container">
            <table class="table cart-table space-30">
                <thead>
                    <tr>
                        <th class="product-photo">List Products</th>
                        <th class="produc-name"></th>
                        <th class="produc-price">Price</th>
                        <th class="product-quantity">qty</th>
                        <th class="total-price">Total</th>
                        <th class="product-remove"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                        $ongkoskirim = (isset($ongkir))?$ongkir->ongkir:0;    
                        $voucher = (isset($cart))?$cart->nominal:0;         
                    @endphp
                    @if (isset($cart_detail))
                        @foreach ($cart_detail as $itemcartdetail)
                            <tr class="item_cart">
                                <td class="product-photo"><img src="{{asset('frontend')."/".$itemcartdetail->image}}" alt="{{$itemcartdetail->namaproduk}}" width="100" height="180" sizes="(max-width: 300px) 100vw, 300px"></td>
                                <td class="produc-name"><a href="#" title="">{{$itemcartdetail->namaproduk}}</a></td>
                                <td class="total-price">Rp.{{number_format($itemcartdetail->harga, 0, ',', '.')}}</td>
                                <td class="product-quantity">
                                    <form enctype="multipart/form-data">
                                        <div class="product-signle-options product_15 clearfix">
                                            <div class="selector-wrapper size">
                                                <div class="quantity" data-id="{{$itemcartdetail->id_produk}}">
                                                    <input data-step="1" value="{{$itemcartdetail->qty}}" title="Qty" class="qty" id="qty{{$itemcartdetail->id_produk}}" size="4" type="text" data-id="{{$itemcartdetail->id_produk}}">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="total-price" id="totalprice{{$itemcartdetail->id_produk}}">Rp.{{number_format($itemcartdetail->total, 0, ',', '.')}}</td>
                                <td class="product-remove"><a class="remove" href="{{route("shop.deletecart",$itemcartdetail->id)}}" title="close"><img src="{{asset('frontend/images/icon-delete-cart.png')}}" alt="close"></a></td>
                            </tr>
                            @php
                                $total += $itemcartdetail->total;             
                            @endphp
                        @endforeach
                    @endif
                    
                </tbody>
            </table>
            <div class="row-total">
                <div class="float-left">
                    <h3>Sub Total</h3>
                </div>
                <!--End align-left-->
                <div class="float-right">
                    <p class="subtotal1">Rp.{{number_format($total, 0, ',', '.')}}</p>
                </div>
                <!--End align-right-->
            </div>
            <div class="box space-30">
                <div class="float-right">
                    <a class="link-v1 lh-50 bg-brand" href="{{ route('shop') }}" title="CONTINUS SHOPPING">CONTINUS SHOPPING</a>
                </div>
                <!-- End float-right -->
            </div>
            <!-- End box -->
            <div class="box cart-total space-30">
                <div class="row">
                    <div class="col-md-4 space-30">
                        <div class="item coupon-code">
                            <h3 class="title">COUPON CODE</h3>
                            <p>Enter your coupon code if you have one</p>
                            <form enctype="multipart/form-data" action="{{ route('addkupon') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="hidden" id="idcart" name="idcart" value="{{(isset($cart))?$cart->id:""}}">
                                    <input type="text" class="form-control space-20 @error('kupon') is-invalid @enderror" id="kupon" name="kupon" required>
                                    @error('kupon')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="link-v1 lh-50 rt" title="apply coupon">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                   
                    <div class="col-md-4 space-30 float-right">
                        <div class="item">
                            <h3 class="title">CART TOTAL</h3>
                            @if (isset($ongkir))
                                <p class="box"><span class="float-left">SHIPPING</span><span class="float-right ongkir">Rp.{{number_format($ongkir->ongkir, 0, ',', '.')}}</span></p>
                            @endif
                            <p class="box"><span class="float-left">SUBTOTAL</span><span class="float-right subtotal2">Rp.{{number_format($total, 0, ',', '.')}}</span></p>
                            @if (isset($cart) && $cart->nominal != null)
                                <p class="box"><span class="float-left">Diskon Voucher</span><span class="float-right voucher">Rp.{{number_format($cart->nominal, 0, ',', '.')}}</span></p>
                            @endif
                            <p class="box space-30"><span class="float-left"><b>Total</b></span><span class="float-right"><b class="color-brand total">Rp.{{number_format($total + $ongkoskirim -  $voucher , 0, ',', '.')}}</b></span></p>
                            <a class="link-v1 lh-50 rt" href="{{ route('checkout') }}" title="POCEEED TO CHECKOUT">POCEEED TO CHECKOUT</a>
                        </div>
                    </div>
                    <!-- End col-md-4 -->
                </div>
            </div>
            <!-- End box -->
        </div>
    <!-- End container -->
    </div>
 </div>
@endsection
@section('scriptjs')
<script src="{{asset('frontend/js/js/mycart.js')}}"></script>
@endsection