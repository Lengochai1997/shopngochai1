@extends('admin.layouts.app')

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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Thông tin</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Số tài khoản đã bán -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tài khoản đã bán</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_account }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Số tài khoản random đã bán -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tài khoản random đã bán</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_random }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(Auth::guard('admin')->user()->is_super == 1)
                            @include('admin.components.admin')
                        @else
                            @include('admin.components.ctv')
                        @endif

                    </div>

                    @if(Auth::guard('admin')->user()->is_super == 1)
                    <div class="row">
                        <!-- Duyệt thẻ chậm -->
                        <div class="col-xl-8 col-lg-7">
                            @include('admin.components.check_card')
                        </div>
                        <!-- Thành viên mới -->
                        <div class="col-xl-4 col-lg-5">
                            @include('admin.components.new_users')
                        </div>
                    </div>
                    <div class="row">
                        <!-- Duyệt thẻ chậm -->
                        <div class="col-xl-12 col-lg-12">
                            @include('admin.components.request_processing')
                        </div>
                    </div>
                    @endif
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
