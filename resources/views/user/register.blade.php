@extends('layout.index')

@section('title')
    Đăng ký tài khoản
@endsection

@section('content')
    <div class="c-layout-page content-dark">
        <!-- BEGIN: PAGE CONTENT -->
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body box-custom">
                <p class="login-box-msg">Đăng ký thành viên</p>
                <span class="help-block" style="text-align: center;color: #dd4b39"></span>
                <form id="register" action="{{ asset('register') }}" method="POST">
                    @method('post')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Họ và tên">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Tài khoản">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu">
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin: 0 auto;">Đăng ký</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#register').validate({
                            rules: {
                                name: {
                                    required: true,
                                },
                                username: {
                                    required: true,
                                    remote: {
                                        url: '{!! asset('check-username') !!}',
                                        type: 'get',
                                        data: {
                                            username: function() {
                                                return $("#username").val();
                                            }
                                        }
                                    }
                                },
                                password: 'required',
                                password_confirmation: {
                                    required: true,
                                    equalTo: "#password"
                                },
                            },
                            messages: {
                                name: {
                                    required: 'Họ và tên chưa được nhập.',
                                },
                                username: {
                                    required: 'Tên đăng nhập chưa được nhập.',
                                    remote: 'Tên đăng nhập đã tồn tại.'
                                },
                                password: {
                                    required: 'Mật khẩu chưa được nhập.'
                                },
                                password_confirmation: {
                                    required: 'Xác nhận mật khẩu chưa được nhập.',
                                    equalTo: 'Xác nhận mật khẩu không khớp.'
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
                                callAjax(url, method, formData).then(res => {
                                    swal.fire({
                                        icon: 'success',
                                        title: 'Đăng ký thành công',
                                        text: 'Click vào Đăng nhập để đăng nhập.',
                                        confirmButtonText: '<span>Đăng nhập</span>',
                                    }).then(function () {
                                        redirectLogin();
                                    });
                                    $(form).trigger('reset');
                                });
                            }
                        })
                    });
                    function redirectLogin() {
                        window.location.href = '{!! asset('login') !!}';
                    }
                </script>
                <div class="social-auth-links text-center">
                    <p style="margin-top: 5px">- HOẶC -</p>
                    <a href="{{ asset('login') }}" class="btn btn-vk btn-vk btn-flat"><i class="icon-login icons"></i> Đăng nhập</a>
                    <a href="https://shopnickpro.com/fb2" class="btn  btn-social btn-facebook btn-flat d-inline-block"><i class="fa fa-facebook"></i>Facebook</a>
                </div>
            </div>
            <!-- /.social-auth-links -->
        </div>
        <!-- /.login-box-body -->
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
        .box-custom{
            border: 1px solid #cccccc;
            padding: 20px;
            color: #666;
        }
        .error {
            color: red;
            font-size: 15px;
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript">
        function refreshCaptcha(){
            var img = document.images['captchaimg'];
            img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
        }
    </script>
    <script src="{{ asset('admin_asset/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
@endsection
