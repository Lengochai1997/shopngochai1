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
                                    <h6 class="m-0 font-weight-bold text-primary">Thêm tài khoản</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="create-account" action="{{ asset('admin/account/account') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        @include('admin.account.partials.entry', ['mode' => 'create'])
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-sm btn-primary button-config">Thêm tài khoản</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#create-account').validate({
                                                rules: {
                                                    category_id: 'required',
                                                    type_id: 'required',
                                                    username: 'required',
                                                    password: 'required',
                                                    price: 'required',
                                                },
                                                messages: {
                                                    category_id: 'Danh mục chưa được chọn',
                                                    type_id: 'Loại game chưa được chọn',
                                                    username: 'Tài khoản chưa được nhập',
                                                    password: 'Mật khẩu chưa được nhập',
                                                    price: 'Giá tiền chưa được nhập',
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

@section('css')
    <link rel="stylesheet" href="/admin_asset/css/style_account.css">
@endsection
