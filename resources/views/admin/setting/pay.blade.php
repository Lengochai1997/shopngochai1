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
                    <div class="col-6">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Danh sách số lượng Quân huy</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <ul id="list-pay-1" class="list-payments ui-sortable">

                                    <li class="payment ui-sortable-handle" data-id="2">
                                        <i class="fas fa-trash-alt delete" data-id="2"></i>
                                        <i class="fas fa-arrows-alt"></i>
                                        <span class="payment-name">50 Quân huy</span>
                                    </li>
                                    <li class="payment ui-sortable-handle" data-id="2">
                                        <i class="fas fa-trash-alt delete" data-id="2"></i>
                                        <i class="fas fa-arrows-alt"></i>
                                        <span class="payment-name">50 Quân huy</span>
                                    </li>
                                    <li class="payment ui-sortable-handle" data-id="2">
                                        <i class="fas fa-trash-alt delete" data-id="2"></i>
                                        <i class="fas fa-arrows-alt"></i>
                                        <span class="payment-name">50 Quân huy</span>
                                    </li>

                                </ul>
                                <div class="buttons">
                                    <button class="btn btn-success">Cập nhật</button>
                                    <button class="btn btn-primary">Lưu vị trí</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Thêm số lượng Quân huy</h6>
                            </div>
                            <div class="card-body">
                                <form id="add-option-quanhuy" action="{!! asset('admin/setting/add-quanhuy') !!}" method="post">
                                    <div class="form-group">
                                        <label for="title">Số quân huy</label>
                                        <input type="text" class="form-control" id="quanhuy" name="quanhuy" placeholder="Quân huy">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </div>
                                </form>
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
