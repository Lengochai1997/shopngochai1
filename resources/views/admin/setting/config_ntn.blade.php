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
                                    <h6 class="m-0 font-weight-bold text-primary">Cấu hình Nạp thẻ nhanh</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="form-data" action="{!! asset('admin/setting/config-ntn') !!}" method="post">
                                        <div class="form-group">
                                            <label for="title">ID</label>
                                            <input type="text" class="form-control" id="id" name="id" placeholder="ID" value="{{ isset($config->id) ? $config->id : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Key</label>
                                            <input type="text" class="form-control" id="key" name="key" placeholder="Key" value="{{ isset($config->key) ? $config->key : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Cấu hình</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('#form-data').validate({
                                            rules: {
                                                id: {
                                                    required: true,
                                                },
                                                key: {
                                                    required: true,
                                                },
                                            },
                                            messages: {
                                                id: {
                                                    required: 'ID không được bỏ trống.',
                                                },
                                                key: {
                                                    required: 'Key không được bỏ trống.',
                                                },
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
                                        })
                                    });
                                    </script>
                                </div>
                            </div>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $("#add-option-quanhuy").validate({
                rules: {
                    quanhuy: {
                        required: true,
                        min: 0,
                    }
                },
                messages: {
                    quanhuy: {
                        required: 'Đây là trường bắt buộc.',
                        min: 'Số lượng phải lớn hơn 0.'
                    }
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
                        console.log(res);
                    });
                }
            });
        });


    </script>
@endsection
