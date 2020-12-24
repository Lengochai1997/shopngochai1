@extends('layout.index')

@section('title')
    Đăng nhập
@endsection

@section('content')
    <div class="c-layout-page content-dark">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="login-box-body box-custom">
                <p class="login-box-msg">Đăng nhập hệ thống</p>
                <span class="help-block" style="text-align: center;color: #dd4b39"></span>
                <form id="login" action="{{ asset('login') }}" method="POST">
                    @csrf
                    @method('post')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Tài khoản của {{ isset($config['domain']) ? $config['domain'] : '' }}" minlength="4" maxlength="30" required="">
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="32" placeholder="Mật khẩu" required="">
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="checkbox icheck">
                                <label style="color: #666">
                                    <input type="checkbox" name="remember" id="remember"> Ghi nhớ
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin: 0 auto;">Đăng nhập</button>
                        </div>
                    </div>
                </form>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#login').validate({
                            rules: {
                                username: 'required',
                                password: 'required',
                            },
                            messages: {
                                username: 'Tài khoản chưa được nhập',
                                password: 'Mật khẩu chưa được nhập',
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
                                        title: 'Đăng nhập thành công',
                                        text: 'Chuyển về trang chủ'
                                    });
                                    window.location.href = '{!! asset('') !!}';
                                    $(form).trigger('reset');
                                });
                            }
                        });
                    });
                </script>

                <div class="social-auth-links text-center">
                    <p style="margin-top: 5px">- HOẶC -</p>
                    <a href="{{ asset('register') }}" class="btn  btn-vk btn-vk btn-flat"><i class="icon-key icons"></i> Tạo tài khoản</a>
                    <a href="{{ asset('facebook/redirect') }}" class="btn  btn-social btn-facebook btn-flat d-inline-block"><i class="fa fa-facebook"></i>Facebook</a>
                </div>
                <!-- /.social-auth-links -->
            </div>
            <!-- /.login-box-body -->
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
