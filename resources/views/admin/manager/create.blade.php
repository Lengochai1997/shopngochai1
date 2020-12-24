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
                                    <h6 class="m-0 font-weight-bold text-primary">Thêm Cộng tác viên</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="create-admin" action="{{ asset('admin/store') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        @include('admin.manager.partials.entry', ['mode' => 'create'])
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-sm btn-primary button-config">Thêm tài khoản</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#create-admin').validate({
                                                rules: {
                                                    name: 'required',
                                                    username: {
                                                        required: true,
                                                        remote: {
                                                            url: '{!! asset('admin/check-unique') !!}',
                                                            type: 'get',
                                                            data: {
                                                                username: function() {
                                                                    return $("#username").val();
                                                                }
                                                            }
                                                        }
                                                    },
                                                    password: 'required',
                                                },
                                                messages: {
                                                    name: 'Tên chưa được nhập',
                                                    username: {
                                                        required: 'Tài khoản chưa được nhập',
                                                        remote: 'Tài khoản đã tồn tại'
                                                    },
                                                    password: 'Mật khẩu chưa được nhập',
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
