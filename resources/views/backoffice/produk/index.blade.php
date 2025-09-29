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
                    Produk
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Produk</li>
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
                <h3 class="block-title">Produk</h3>
            </div>
            <div class="block-content block-content-full">
                <button class="btn btn-success" data-toggle="modal" id="showmodalcreate">Create</button><br><br>
                <div id="modal"></div>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped mb-0" id="produk">
                    <tbody>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>Info</th>
                                <th>Harga</th>
                                <th>Harga Diskon</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
@endsection
@section('scriptjs')
<script src="{{asset('bo/js/js/produk.js')}}"></script>
@endsection

