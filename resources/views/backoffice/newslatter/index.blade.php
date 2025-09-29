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
                    Data Master 
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">Data Master</li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a class="link-fx" href="">Newslatter</a>
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
                <h3 class="block-title">Master Newslatter</h3>
            </div>
            <div class="block-content block-content-full">
                <button class="btn btn-success" data-toggle="modal" id="showmodalcreate">Create</button><br><br>
                <div id="modal"></div>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped mb-0" id="master_newslatter">
                    <tbody>
                        <thead>
                            <tr>
                                <th>Keterangan</th>
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
<script src="{{asset('bo/js/js/masternewslatter.js')}}"></script>
@endsection