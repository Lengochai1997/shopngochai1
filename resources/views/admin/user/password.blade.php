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
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">đổi mật khẩu</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form action="{{ asset('admin/user/change-password/'.$id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-3 col-form-label col-form-label-sm">mật khẩu</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="mật khẩu"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password_comfirm" class="col-sm-3 col-form-label col-form-label-sm">xác nhận mật khẩu</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control form-control-sm" id="password_comfirm" name="password_comfirm" placeholder="xác nhận mật khẩu"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-primary button-config">đổi mật khẩu</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
