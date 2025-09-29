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
                <h3>Checkout</h3>
                <p><a href="{{ route('home') }}" title="Home">Home</a><i class="fa fa-caret-right"></i>Checkout</p>
            </div>
        </div>
    </div>
    <form class="form-horizontal validasi" method="POST" action="{{ route('addorder') }}">
        <div class="cart-box-container check-out">
            <div class="container container-ver2 space-padding-tb-30">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="title-brand">BILLING ADDRESS</h3>
                                @csrf
                                <input type="hidden" name="idcart" value="{{$cart_detail[0]->id_cart}}">
                                <input type="hidden" name="hargaPengemasan" id="hargaPengemasan">
                                <div class="form-group">
                                    <label for="inputfname" class=" control-label">Nama <span class="color">*</span></label>                            
                                    <input type="text" placeholder="Masukan Nama" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{(auth()->guard()->check())?Auth::user()->name:""}}" parsley-trigger="change" required> 
                                    @error('nama')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror 
                                </div>
                                <div>
                                    <div class="form-group col-md-6">
                                        <label for="inputemail" class=" control-label">Email<span class="color">*</span></label>                            
                                        <input type="email" placeholder="Masukan email..." id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{(auth()->guard()->check())?Auth::user()->email:""}}" parsley-trigger="change" required>
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror   
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputphone" class=" control-label">Phone<span class="color">*</span></label>                            
                                        <input type="number" placeholder="Masukan NoHp..." id="nohp" name="nohp" class="form-control @error('nohp') is-invalid @enderror" value="{{(auth()->guard()->check())?Auth::user()->nohp:""}}" parsley-trigger="change" required>  
                                        @error('nohp')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror 
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group col-md-6">
                                        <label for="inputcountry1" class=" control-label">Kota<span class="color">*</span></label>
                                        <select id="kota" name="kota" class="country form-control" parsley-trigger="change" required>
                                            @foreach ($kota as $kota)
                                                @if (auth()->guard()->check())
                                                    @if ($kota->id == Auth::user()->kota)
                                                        <option value="{{$kota->id}}" selected>{{$kota->nama}}</option>
                                                    @endif            
                                                @endif
                                                <option value="{{$kota->id}}">{{$kota->nama}}</option>
                                            @endforeach
                                        </select>  
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputpostcode" class=" control-label">Kode Pos <span class="color">*</span></label>                            
                                        <input type="text" placeholder="Masukan Kode Pos" id="kodepos" name="kodepos" class="form-control @error('kodepos') is-invalid @enderror" value="{{(auth()->guard()->check())?Auth::user()->kodepos:""}}" parsley-trigger="change" required>  
                                        @error('kodepos')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror 
                                    </div>    
                                </div> 
                                <div class="form-group">
                                    <label for="inputstreet" class=" control-label">Alamat<span class="color">*</span></label>                            
                                    <input type="text" placeholder="Masukan Alamat" id="alamat" name="alamat" class="form-control space-20 @error('alamat') is-invalid @enderror" value="{{(auth()->guard()->check())?Auth::user()->alamat:""}}" parsley-trigger="change" required>  
                                    @error('alamat')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> 
                                <div class="form-group">
                                    <label for="inputcountry1" class=" control-label">Tanggal Kirim<span class="color">*</span></label>
                                    <input type="text" class="form-control datepicker" placeholder="Pilih Tanggal Kirim" name="tgl_kirim" parsley-trigger="change" required>
                                </div>
                                <div class="form-group">
                                    <label for="inputcountry1" class=" control-label">Jam Kirim<span class="color">*</span></label>
                                    <select id="jamkirim" name="jamkirim" class="country form-control" parsley-trigger="change" required>
                                        @foreach ($jamkirim as $jamkirim)
                                            <option value="{{$jamkirim->id}}">{{$jamkirim->pengiriman}}</option>
                                        @endforeach
                                    </select>  
                                </div>
                                <div class="form-group">
                                    <label for="inputcountry1" class=" control-label">Pengemasan <span class="color">*</span></label>
                                    <select id="package" name="package" class="country form-control" parsley-trigger="change" required>
                                        @foreach ($package as $package)
                                            <option value="{{$package->nama}}" data-harga="{{$package->harga}}">{{$package->nama}} (Rp.{{number_format($package->harga, 0, ',', '.')}})</option>
                                        @endforeach
                                    </select>  
                                </div>
                                <div class="form-group">
                                    <label for="inputstreet" class=" control-label">Notes<span class="color">*</span></label>    
                                    <textarea maxlength="1000" data-msg-required="Silahkan Masukan keterangan." rows="8" class="form-control space-20 @error('note') is-invalid @enderror" name="note" id="note"></textarea>                        
                                </div> 
                                <h3 class="title-brand">PAYMENT MENTHOD</h3>
                                <ul class="tabs">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="radio" name="id_bank" value="COD" parsley-trigger="change" required>
                                            &nbsp;<label>Cash On Delivery</label>
                                        </div>
                                    </div>
                                    @foreach ($bank as $bank)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="radio" name="id_bank" value={{$bank->id}} parsley-trigger="change" required>
                                                &nbsp;<label>Transfer Bank {{$bank->nama}}</label>
                                                {{-- <label><img width="100" height="100" alt="" class="img-fluid" src="{{asset('frontend')."/".$bank->foto}}"></label> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>           
                                <br>            
                                <input type="submit" value="PLACE ORDER" name="proceed" class="link-v1 box lh-50 rt full">
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
                                            @foreach ($cart_detail as $item)
                                                <li>
                                                    <span class="name">{{$item->namaproduk}}</span>
                                                    <span class="qty">{{$item->qty}}</span>
                                                    <span class="total">Rp.{{number_format($item->total, 0, ',', '.')}}</span>
                                                </li>    
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- End product-name -->
                                    <ul class="product-order">
                                        <li>
                                            <span class="left">CART SUBTOTAL</span>
                                            <span class="right">Rp.{{number_format($totalbelanja, 0, ',', '.')}}</span>
                                        </li>
                                        <li id="biayaPengemasan">
                                            <span class="left">Ongkos Pengemasan</span>
                                            <span class="right pengemasan"></span>
                                        </li>
                                        <li>
                                            <span class="left">Ongkos Kirim</span>
                                            <span class="right">Rp.{{number_format($ongkir->ongkir, 0, ',', '.')}}</span>
                                        </li>
                                        @if ($cart_detail[0]->nominal != null)
                                            <li>
                                                <span class="left">Diskon Voucher</span>
                                                <span class="right">Rp.{{number_format($cart_detail[0]->nominal, 0, ',', '.')}}</span>
                                            </li>
                                        @endif
                                        <li>
                                            <span class="left">ORDER TOTAL</span>
                                            <span class="right grandtotal">Rp.{{number_format($totalbelanja+$ongkir->ongkir-$cart_detail[0]->nominal, 0, ',', '.')}}</span>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End info-order -->
                                {{-- <div class="payment-order box float-left">
                                    
                                </div> --}}
                            
                            </div>
                        </div>
                    </div>
                <!-- End row -->
            </div>
            <!-- End container -->
        </div>
    </form>

    <!-- End cat-box-container -->
</div>
@endsection
@section('scriptjs')
<script>
    $(document).ready(function(){
        $("#hargaPengemasan").val($("#package").find(":selected").data("harga"));
        if($("#package").val() == "plastik"){
            $("#biayaPengemasan").hide();
        }else{
            $("#biayaPengemasan").show();
            $(".pengemasan").html($("#package").find(":selected").data("harga"));
        }

        $("#package").change(function() {
            var package = $("#package").val();
            var harga = $(this).find(":selected").data("harga");
            var totalbelanja = "{{$totalbelanja}}";
            var ongkir = "{{$ongkir->ongkir}}";
            var diskon = "{{$cart_detail[0]->nominal}}";

            if(diskon == ""){
                diskon = 0;
            }else{
                diskon = parseFloat(diskon);
            }

            $("#hargaPengemasan").val(harga);
            if(package != "plastik"){
                $("#biayaPengemasan").show();
                $(".pengemasan").html("Rp."+convertToRupiah(Math.round(harga)));
                $(".grandtotal").html("Rp."+convertToRupiah(Math.round(parseFloat(totalbelanja)+parseFloat(ongkir)+harga-diskon)));
            }else{
                $("#biayaPengemasan").hide();
                $(".pengemasan").html("Rp."+convertToRupiah(Math.round(harga)));
                $(".grandtotal").html("Rp."+convertToRupiah(Math.round(parseFloat(totalbelanja)+parseFloat(ongkir)-diskon)));
            }
        });
    });

    function convertToRupiah(angka){   
        var rupiah = '';        
        // var money = angka.toFixed(0)
        if(angka!=""&&angka!=undefined&&angka!=null){
            var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
            return rupiah.split('',rupiah.length-1).reverse().join('');
        }else{
            return 0;
        }
    }
</script>
@endsection