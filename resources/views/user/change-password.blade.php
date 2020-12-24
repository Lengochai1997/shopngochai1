@extends('layout.index')

@section('title', 'Thông tin người dùng')

@section('content')
    <div class="c-layout-page content-dark">
        <div class="c-layout-page">
            <!-- BEGIN: PAGE CONTENT -->
            <div class="m-t-20 visible-sm visible-xs"></div>
            <center style="max-width:1140px; margin: 0 auto;" class="hidden-xs">
                <div class="c-layout-breadcrumbs-1 c-bgimage c-subtitle c-fonts-uppercase c-fonts-bold c-bg-img-center" style="background-image: url('https://htsa.nicknso.com/style/images/cover-2.png');background-position: center;width:100%;height: 350px;background-repeat: no-repeat;background-position: center;background-size: cover;">
                    <div class="container">
                        <div class="c-page-title c-pull-left">
                            <h3 class="c-font-uppercase c-font-bold c-font-white c-font-20 c-font-slim">&nbsp;</h3>
                        </div>
                    </div>
                </div>
            </center>
            @include('user.partials.info_member')
            <div class="c-layout-page" style="margin-top: 20px;">
                <div class="container">
                    @include('user.partials.sidebar', ['active' => 2])
                    <div class="c-layout-sidebar-content ">
                        <!-- BEGIN: PAGE CONTENT -->
                        <!-- BEGIN: CONTENT/SHOPS/SHOP-CUSTOMER-DASHBOARD-1 -->
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold">Đổi mật khẩu</h3>
                            <div class="c-line-left"></div>
                        </div>
                        <form id="change-password" action="{{ asset('user/change-password') }}" class="form-horizontal form-charge">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mật khẩu cũ:</label>
                                <div class="col-md-6">
                                    <input class="form-control c-square c-theme" id="old_password" name="old_password" type="password" maxlength="32" placeholder="Mật khẩu hiện tại">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mật khẩu mới:</label>
                                <div class="col-md-6">
                                    <input class="form-control c-square c-theme" id="password" name="password" type="password" maxlength="32" placeholder="Mật khẩu mới">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Xác nhận:</label>
                                <div class="col-md-6">
                                    <input class="form-control c-square c-theme" id="password_confirmation" name="password_confirmation" type="password" maxlength="32" placeholder="Xác nhận mật khẩu mới">
                                </div>
                            </div>
                            <div class="form-group c-margin-t-40">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" class="btn btn-submit c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Đổi mật khẩu</button>
                                </div>
                            </div>
                        </form>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#change-password').validate({
                                    rules: {
                                        old_password: 'required',
                                        password: 'required',
                                        password_confirmation: {
                                            required: true,
                                            equalTo: "#password"
                                        },
                                    },
                                    messages: {
                                        old_password: 'Mật khẩu không được bỏ trống.',
                                        password: 'Mật khẩu mới không được bỏ trống.',
                                        password_confirmation: {
                                            required: 'Xác nhận mật khẩu không được bỏ trống.',
                                            equalTo: 'Xác nhận mật khẩu không khớp.'
                                        },
                                    },
                                    submitHandler: function (form) {
                                        let url = $(form).attr('action');
                                        let params = $(form).serializeArray();
                                        let formData = new FormData();
                                        $.each(params, function (i, val) {
                                            formData.append(val.name, val.value);
                                        });
                                        callAjax(url, 'POST', formData).then(res => {
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
                                        return false;
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <!-- END: PAGE CONTENT -->
        </div>
    </div>
@endsection

@section('css')
    <style>
        .login-box, .register-box {
            width: 400px;
            margin: 7% auto;

            padding: 20px;;
        }



        @media (max-width: 767px){
            .login-box, .register-box {
                width: 100%;
            }

        }

        .login-box-msg, .register-box-msg {
            margin: 0;
            text-align: center;
            padding: 0 20px 20px 20px;
            text-align: center;
            font-size: 20px;;
            font-weight: bold;
        }

        .error {
            color: red;
            font-size: 15px;
        }

        .box-custom{
            border: 1px solid #cccccc;
            padding: 20px;

            color: #666;
        }

    </style>
@endsection

@section('js')
    <script type="text/javascript" src="/admin_asset/vendor/jquery-validate/jquery.validate.min.js"></script>
@endsection
