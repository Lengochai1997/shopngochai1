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
                    <div class="row">
                        @if(session('message'))
                        <div class="col-12">
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Quản lý Nổ hữ ảo</h6>
                                    <div>
                                        <button class="btn btn-outline-primary add-slot-machine">
                                            <a href="{{ asset('admin/virtual-history-special/virtual-history-special/create?type=spin') }}">Thêm Vòng quay</a>
                                        </button>
                                        <button class="btn btn-outline-primary add-slot-machine">
                                            <a href="{{ asset('admin/virtual-history-special/virtual-history-special/create?type=spin_coin') }}">Thêm Vòng quay tiền</a>
                                        </button>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    @include('admin.virtual_history.special.partials.list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
