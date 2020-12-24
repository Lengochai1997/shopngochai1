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
            <div class="c-layout-page">
                <div class="container content-gray">
                    @include('user.partials.sidebar', ['active' => 1])
                    <div class="c-layout-sidebar-content ">
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold">Thông tin tài khoản</h3>
                            <div class="c-line-left"></div>
                        </div>
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th scope="row">ID của bạn:</th>
                                <th>{{ Auth::user()->id }}</th>
                            </tr>
                            <tr>
                                <th scope="row">Tên tài khoản:</th>
                                <th>{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->username }}</th>
                            </tr>
                            <tr>
                                <th scope="row">Số dư tài khoản:</th>
                                <td><b class="text-danger">{{ isset(Auth::user()->total_money) ? number_format(Auth::user()->total_money) : 0 }} đ</b></td>
                            </tr>
                            <tr>
                                <th scope="row">Số Kim cuong:</th>
                                <td><b class="text-danger">{{ isset($wallet->kimcuong) ? number_format($wallet->kimcuong) : 0 }} kim cương</b></td>
                            </tr>
                            <tr>
                                <th scope="row">Số Quân huy:</th>
                                <td><b class="text-danger">{{ isset($wallet->quanhuy) ? number_format($wallet->quanhuy) : 0 }} quân huy</b></td>
                            </tr>
                            <tr>
                                <th scope="row">Nhóm tài khoản:</th>
                                <td><font color="black">Thành viên</font></td>
                            </tr>
                            <tr>
                                <th scope="row">Ngày Tham Gia:</th>
                                <td>{{ isset(Auth::user()->created_at) ? Auth::user()->created_at->format('m/d/Y') : '' }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- END: PAGE CONTENT -->
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

        .box-custom{
            border: 1px solid #cccccc;
            padding: 20px;

            color: #666;
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
@endsection
