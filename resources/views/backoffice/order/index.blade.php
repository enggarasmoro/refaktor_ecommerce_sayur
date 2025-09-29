<?php //dd(auth()); ?>
@extends('layouts.appbo')

@section('content')
<!-- Main Container -->
<main id="main-container">
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill h3 my-2">
                    Order
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Order</li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="">Order</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Dynamic Table Full -->
        <div class="block">
            <div class="block-header">
                <h3 class="block-title">Order</h3>
            </div>
            <div class="block-content block-content-full">
                <div id="modal"></div>
                <form id="exportlaporan" class="form-inline">
                    <div class="form-group">
                        <label>Rekap Laporan</label>&nbsp;&nbsp;
                        <input type="text" class="form-control" id="date" name="date" placeholder="Pilih Tanggal" data-mode="range">
                    </div>
                    &nbsp;&nbsp;
                    <div class="form-group">
                        <div class="btn-group" role="group">
                            <a class="btn btn-primary waves-effect waves-light" href="#" role="button" id="downloadlaporan">Download</a>
                        </div>
                    </div>
                </form>
                <br>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <div class="tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#one" role="tab">On Hold</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#two" role="tab">Proses</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#three" role="tab">Complete</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#four" role="tab">Cancel</a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content table-responsive">
                        <div class="tab-pane active" id="one" role="tabpanel">
                            <table class="table table-bordered table-striped mb-0" id="onhold">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama</th>
                                        <th>No Tlpn</th>
                                        <th>Payment</th>
                                        <th>Bank</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Kota</th>
                                        <th>Jam Kirim</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="two" role="tabpanel">
                            <table class="table table-bordered table-striped mb-0" id="proses">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama</th>
                                        <th>No Tlpn</th>
                                        <th>Payment</th>
                                        <th>Bank</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Kota</th>
                                        <th>Jam Kirim</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="three" role="tabpanel">
                            <table class="table table-bordered table-striped mb-0" id="complete">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama</th>
                                        <th>No Tlpn</th>
                                        <th>Payment</th>
                                        <th>Bank</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Kota</th>
                                        <th>Jam Kirim</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="four" role="tabpanel">
                            <table class="table table-bordered table-striped mb-0" id="cancel">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama</th>
                                        <th>No Tlpn</th>
                                        <th>Payment</th>
                                        <th>Bank</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Kota</th>
                                        <th>Jam Kirim</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection
@section('scriptjs')
<script src="{{asset('bo/js/js/order.js')}}"></script>
@endsection
