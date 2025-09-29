@extends('layouts.app')

@section('content')
<div class="container">
    <div class="banner-header banner-lbook3 space-30">
        <img src="{{asset('frontend/images/banner-catalog1.jpg')}}" alt="Banner-header">
        <div class="text">
            <h3>all products</h3>
            <p><a href="{{ route('home') }}" title="Home">Home</a><i class="fa fa-caret-right"></i>Produk</p>
        </div>
    </div>
</div>
 <!-- End Banner Grid -->
<div class="container">
    <div id="primary" class="col-xs-12 col-md-9">  
            <div class="wrap-breadcrumb">
                <div class="ordering">
                    <div class="float-left">
                        {{-- <span class="col active"></span>
                        <span class="list"></span> --}}
                        {{-- <p class="result-count">Showing 1-12 of 30 relults</p> --}}
                    </div>
                    <div class="float-right">
                    <form action="#" method="get" class="order-by">
                        <p>Sort by :</p>
                        <select class="orderby" name="orderby">
                                <option>popularity</option>
                                <option selected="selected">average rating</option>
                                <option>newness</option>
                                <option>price: low to high</option>
                                <option>price: high to low</option>
                        </select>
                    </form>
                    </div>
                </div>
            </div>
            <div class="shop-products products-size-small">
                <div class="products">
                    @foreach ($produk as $value)
                        <div class="product">
                            <div class="product-images">
                                <a href="javascript:void(0)" title="product-images">
                                    <img class="primary_image" src="{{asset('frontend/'.$value->image)}}" alt="" width="100" height="180" sizes="(max-width: 300px) 100vw, 300px"/>
                                </a>
                                <div class="action">
                                    <a class="add-cart" id="tambahcart" data-id="{{$value->id}}" title="Add to cart"></a>
                                    <a class="wish" data-id="{{$value->id}}" title="Remove from Cart"></a>
                                </div>
                            </div>
                            <a href="javascript:void(0)" title="{{$value->nama}}"><p class="product-title">{{$value->nama}}</p></a>
                            @if ($value->harga_diskon == 0)
                                <p class="product-price">Rp.{{number_format($value->harga, 0, ',', '.')}}</p>
                            @else
                                <p class="product-price-old">Rp.{{number_format($value->harga, 0, ',', '.')}}</p>
                                <p class="product-price">Rp.{{number_format($value->harga_diskon, 0, ',', '.')}}</p>
                            @endif
                            @if ($value->info != null)
                                <p>{{$value->info}}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- End product-content products  -->
            <div class="row">
                <div class="col">
                    <ul class="pagination float-right">
                        {{ $produk->links() }}
                    </ul>
                </div>
            </div>
            <!-- End pagination-container -->
    </div>
    <!-- End Primary -->
        
    <div id="secondary" class="widget-area col-xs-12 col-md-3">
        <aside class="widget widget_link">
            <h3 class="widget-title">Kategori</h3>
            <ul>
                <li><a href="{{route("shop")}}" title="Semua Produk">Semua Produk</a></li>
                @foreach ($kategori as $kategori)
                    <li><a href="{{route("shop")."/".$kategori->slug}}" title="{{$kategori->nama}}">{{$kategori->nama}}</a></li>
                @endforeach
                {{-- <li><a href="#" title="Artek">Buah</a><span class="count">(09)</span></li> --}}
            </ul>
        </aside>
    </div>
    <!-- End Secondary -->
</div>
<!-- end product sidebar -->
    
<div id="back-to-top">
    <i class="fa fa-long-arrow-up"></i>
</div>
@endsection
@section('scriptjs')
<script src="{{asset('frontend/js/js/home.js')}}"></script>
@endsection