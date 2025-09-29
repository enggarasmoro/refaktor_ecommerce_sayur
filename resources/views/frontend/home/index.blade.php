@extends('layouts.app')

@section('content')
<div class="tp-banner-container hidden-dot ver1">
    <div class="tp-banner" >
            <ul>    <!-- SLIDE  -->
                @foreach ($banner as $banner)
                    <!-- SLIDE  -->
                    <li data-transition="random" data-slotamount="6" data-masterspeed="1000" >
                        <!-- MAIN IMAGE -->
                        <img src="{{asset('frontend/'.$banner->image)}}"  alt="Futurelife-home2-slideshow"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">                        
                        <!-- LAYER NR. 9 -->
                        <div class="tp-caption color-ea8800 customin randomrotateout font-ro tp-resizeme size-130 weight-300 uppercase"
                            data-x="585"
                            data-y="245"
                            data-customin="x:0;y:0;z:0;rotationX:90;rotationY:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                            data-speed="500"
                            data-start="2000"
                            data-easing="Power4.easeOut"
                            data-splitin="chars"
                            data-splitout="none"
                            data-elementdelay="0.1"
                            data-endelementdelay="0.1"
                            style="z-index: 3">
                        </div>

                        <!-- LAYER NR. 3 -->
                        <div class="tp-caption color-2b2b2b font-ros weight-400 skewfromleft customout size-20 letter-spacing-2"
                            data-x="505"
                            data-y="403"
                            data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-speed="800"
                            data-start="1600"
                            data-easing="Power4.easeOut"
                            data-endspeed="300"
                            data-endeasing="Power1.easeIn"
                            data-captionhidden="on"
                            style="z-index: 4">
                        </div>

                        <!-- LAYER NR. 7 -->
                        <div class="tp-caption skewfromleft customout font-roc link-1 bg-brand color-white height-40 size-16"
                            data-x="865"
                            data-y="460"
                            data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
                            data-speed="800"
                            data-start="1500"
                            data-easing="Power4.easeOut"
                            data-endspeed="300"
                            data-endeasing="Power1.easeIn"
                            data-captionhidden="on"
                            style="z-index: 5">
                        </div>
                        <!-- LAYER NR. 8s -->
                    </li>
                    <!-- SLIDER -->
                @endforeach
            </ul>
            <div class="tp-bannertimer"></div>
    </div>
</div>
<!-- End container -->

<div class="container container-ver2 space-30">
    <div class="title-text-v2">
        <h3>Lastest Products</h3>
    </div>
    <div class="featured-products products-size-small">
        <ul class="tabs tabs-title">
            <li class="item" rel="all">Show All</li>
            @foreach ($kategori as $value)
                <li class="item" rel="{{$value->slug}}">{{$value->nama}}</li>
                {{-- <li class="item" rel="{{$value->nama}}"><a class="nav-link" href="{{route("home")."/".$value->slug}}">{{$value->nama}}</a></li> --}}
            @endforeach
            
        </ul>
        <div class="tab-container space-10">
            <div id="all" class="tab-content">
                <div class="products">
                    <div class="all"></div>
                </div>
                <!-- End product-tab-content products -->
            </div>
            <!-- End tab-content -->
            @foreach ($kategori as $value)
                <div id="{{$value->slug}}" class="tab-content">
                    <div class="products">
                        <div class="{{$value->slug}}"></div>
                    </div>
                    <!-- End product-tab-content products -->
                </div>
                <!-- End tab-content -->
            @endforeach
        </div>
        {{-- <div class="box center space-padding-tb-30 space-10">
            <a class="link-v1 color-brand font-300" href="#" title="View All">View All</a>
        </div> --}}
        <!-- End viewall -->
    </div>
</div>
<!-- End container-ver2 -->

<div id="back-to-top">
    <i class="fa fa-long-arrow-up"></i>
</div>
@endsection
@section('scriptjs')
<script src="{{asset('frontend/js/js/home.js')}}"></script>
@endsection