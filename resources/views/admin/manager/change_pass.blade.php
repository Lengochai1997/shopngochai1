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
                                    <h6 class="m-0 font-weight-bold text-primary">Đổi mật khẩu đăng nhập Cộng tác viên</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="change-password-admin" action="{{ asset('admin/change-pass/'.$item['id']) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        @include('admin.manager.partials.entry', ['mode' => 'change_pass'])
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-sm btn-primary button-config">Đổi mật khẩu</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#change-password-admin').validate({
                                                rules: {
                                                    password: 'required',
                                                    passwordConfirm: {
                                                        required: true,
                                                        equalTo: '#password'
                                                    }
                                                },
                                                messages: {
                                                    password: 'Mật khẩu chưa được nhập',
                                                    passwordConfirm: {
                                                        required: 'Xác nhận mật khẩu chưa được nhập',
                                                        equalTo: 'Xác nhận mật khẩu và mật khẩu không giống nhau'
                                                    }
                                                }
                                            });
                                        });
                                    </script>
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
