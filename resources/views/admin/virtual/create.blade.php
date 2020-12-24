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
                        <div class="col-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Bước 1. Thêm user</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <p>Thêm User nếu có ít user, để tạo ra lịch sử ảo khách quan</p>
                                    <p>Nếu đã có nhiều User thì không cần phải tạo thêm nữa</p>
                                    <form id="add-users" action="{{ asset('admin/virtual/create-users') }}" method="post">
                                        @method('post')
                                        @csrf
                                        <div class="form-group">
                                            <label for="count_user">Số lượng user</label>
                                            <input type="number" class="form-control" id="count_user" name="count_user" placeholder="Số lượng user muốn tạo">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-primary button-config">Thêm User</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Bước 2. Thêm lịch sử ảo</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="add-histories" action="{{ asset('admin/virtual/create-histories') }}" method="post">
                                        @method('post')
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <input type="hidden" name="spin_id" value="{{ $id }}">
                                        <div class="form-group">
                                            <label for="count_history">Số lượng lịch sử</label>
                                            <input type="number" class="form-control" id="count_history" name="count_history" placeholder="Số lượng lịch sử muốn tạo">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-primary button-config">Thêm Lịch sử</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#add-users').validate({
                            rules: {
                                count_user: 'required',
                            },
                            messages: {
                                count_user: 'Số lượng user chưa được nhập.'
                            },
                            submitHandler: function(form) {
                                let url = $(form).attr('action');
                                let method = $(form).attr('method');
                                let params = $(form).serializeArray();
                                let formData = new FormData();
                                $.each(params, function (i, val) {
                                    formData.append(val.name, val.value);
                                });
                                callAjax(url, method, formData).then(function (res) {
                                    if (res.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Thành Công !',
                                            text: res.message || ''
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi !',
                                            text: res.message || ''
                                        });
                                    }
                                });
                            }
                        });

                        $('#add-histories').validate({
                            rules: {
                                count_user: 'required',
                            },
                            messages: {
                                count_user: 'Số lượng user chưa được nhập.'
                            },
                            submitHandler: function(form) {
                                let url = $(form).attr('action');
                                let method = $(form).attr('method');
                                let params = $(form).serializeArray();
                                let formData = new FormData();
                                $.each(params, function (i, val) {
                                    formData.append(val.name, val.value);
                                });
                                callAjax(url, method, formData).then(function (res) {
                                    if (res.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Thành Công !',
                                            text: res.message || ''
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi !',
                                            text: res.message || ''
                                        });
                                    }
                                });
                            }
                        });
                    });
                </script>
            </div>
            <!-- End of Main Content -->
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
