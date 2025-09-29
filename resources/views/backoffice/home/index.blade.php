@extends('layouts.appbo')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Hero -->
    <div class="bg-image overflow-hidden" style="background-image: url('{{asset('bo/media/photos/photo3@2x.jpg')}}');">
        <div class="bg-primary-dark-op">
            <div class="content content-narrow content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center mt-5 mb-2 text-center text-sm-left">
                    <div class="flex-sm-fill">
                        <h1 class="font-w600 text-white mb-0 invisible" data-toggle="appear">Dashboard</h1>
                        <h2 class="h4 font-w400 text-white-75 mb-0 invisible" data-toggle="appear" data-timeout="250">Welcome Administrator</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content content-narrow">
        <!-- Stats -->
        <div class="row">
            <div class="col-6 col-md-3 col-lg-6 col-xl-4">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Total Pesanan OnHold({{$bulan}})</div>
                        <div class="font-size-h2 font-w400 text-dark">{{$totalordermasuk}}</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-4">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Total Pesanan Proses({{$bulan}})</div>
                        <div class="font-size-h2 font-w400 text-dark">{{$totalorderproses}}</div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-6 col-xl-4">
                <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="javascript:void(0)">
                    <div class="block-content block-content-full">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Total Provit ({{$bulan}})</div>
                        <div class="font-size-h2 font-w400 text-dark">Rp.{{number_format($order->total, 0, ',', '.')}}</div>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Stats -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection
