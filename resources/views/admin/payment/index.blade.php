@extends('admin.layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="admin_asset/css/style_payment.css">
@endsection
@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">
    @include('admin.layouts.components.slidebar')
    <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
            @include('admin.layouts.components.topbar')
            <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            @include('admin.payment.partials.list')
                        </div>
                        <div class="col-sm-12 col-md-6">
                            @include('admin.payment.partials.create')
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
