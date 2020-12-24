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
                                    <h6 class="m-0 font-weight-bold text-primary">Cấu hình Naptudong.com</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="form-data" action="{!! asset('admin/setting/config-ntd') !!}" method="post">
                                        <div class="form-group">
                                            <label for="partner_id">Partner ID</label>
                                            <input type="text" class="form-control" id="partner_id" name="partner_id" placeholder="Partner ID" value="{{ isset($config->partner_id) ? $config->partner_id : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="partner_key">Partner key</label>
                                            <input type="text" class="form-control" id="partner_key" name="partner_key" placeholder="Partner key" value="{{ isset($config->partner_key) ? $config->partner_key : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Cấu hình</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                    $(document).ready(function () {
                                        $('#form-data').validate({
                                            rules: {
                                                partner_id: {
                                                    required: true,
                                                },
                                                partner_key: {
                                                    required: true,
                                                },
                                            },
                                            messages: {
                                                key: {
                                                    required: 'Partner ID không được bỏ trống.',
                                                },
                                                callback: {
                                                    required: 'Partner key không được bỏ trống.',
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
