@extends('layout.index')

@section('title', 'Nạp ATM')

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
                    @include('user.partials.sidebar', ['active' => 6])
                    <div class="c-layout-sidebar-content ">
                        <div class="c-content-tab-4 c-opt-3" role="tabpanel">
                            <ul class="nav nav-justified" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#bank" role="tab" data-toggle="tab" class="c-font-16">ATM</a>
                                </li>
                                <li role="presentation">
                                    <a href="#wallet" role="tab" data-toggle="tab" class="c-font-16">Ví điện tử</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="bank">
                                    <ul class="c-tab-items p-t-0 p-b-0 p-l-5 p-r-5">
                                        <li class="c-font-dark">
                                            <table class="table table-striped">
                                                <tbody>
                                                <tr>
                                                    <th colspan="3">Thông tin tài khoản ngân hàng</th>
                                                </tr>
                                                </tbody><tbody>
                                                <tr>
                                                    <th colspan="1">Chủ TK:<br>{{ isset($config_atm['atm_name']) ? $config_atm['atm_name'] : '' }}</th>
                                                    <th>Số Tài Khoản<br>{{ isset($config_atm['atm_number']) ? $config_atm['atm_number'] : '' }}</th>
                                                    <th colspan="5">
                                                        Ngân Hàng<br>{{ isset($config_atm['atm_bank']) ? $config_atm['atm_bank'] : '' }}<br>
                                                        Chi Nhánh<br>{{ isset($config_atm['atm_branch']) ? $config_atm['atm_branch'] : '' }}
                                                    </th>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </li>
                                    </ul>
                                </div>
                                <div role="tabpanel" class="tab-pane fade in" id="wallet">
                                    <ul class="c-tab-items p-t-0 p-b-0 p-l-5 p-r-5">
                                        <li class="c-font-dark">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th colspan="2">Thông tin tài khoản ví điện tử</th>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ isset($config_wallet['wallet_name']) ? $config_wallet['wallet_name'] : '' }}</td>
                                                        <th>{{ isset($config_wallet['wallet_tel']) ? $config_wallet['wallet_tel'] : '' }} - {{ isset($config_wallet['wallet_user']) ? $config_wallet['wallet_user'] : '' }}</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p>Nội dung thanh toán: Nap Tien {UID hoặc số điện thoại}</p>
                        <p>Chuyển xong liên hệ <a class="c-font-blue-3 c-font-bold" target="_blank" href="{{ isset($config['fanpage']) ? $config['fanpage'] : '' }}">FanPage Admin</a> để được xử lý.</p>
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
