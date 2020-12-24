@extends('layout.index')

@section('title', 'Nạp thẻ')

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
                    @include('user.partials.sidebar', ['active' => 4])
                    <div class="c-layout-sidebar-content ">
                        <!-- BEGIN: PAGE CONTENT -->
                        <!-- BEGIN: CONTENT/SHOPS/SHOP-CUSTOMER-DASHBOARD-1 -->
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold">Nạp tự động</h3>
                            <div class="c-line-left"></div>
                        </div>
                        <form id="charge" method="POST" action="{{ asset('user/do-charge') }}" class="form-horizontal form-charge">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <label class="col-md-3 control-label">Loại thẻ:</label>
                                <div class="col-md-6">
                                    <select class="form-control  c-square c-theme" id="payment_id" name="payment_id">
                                        <option selected disabled>-- Chọn loại thẻ --</option>
                                        @foreach($payments as $payment)
                                        <option value="{{ $payment['id'] }}">{{ $payment['title'] }} - ({{ config('payment.type')[$payment['type_id']] }}) - ({{ config('payment.gate')[$payment['gate_id']] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mệnh giá:</label>
                                <div class="col-md-6">
                                    <select class="form-control c-square c-theme" id="amount" name="amount">
                                        @foreach(config('payment.amount') as $key => $amount)
                                        <option value="{{ $key }}">{{ $amount }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Số serial:</label>
                                <div class="col-md-6">
                                    <input class="form-control c-square c-theme" type="number" id="serial" name="serial">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Mã số thẻ:</label>
                                <div class="col-md-6">
                                    <input class="form-control c-square c-theme" type="number" id="pin" name="pin">
                                </div>
                            </div>
                            <div class="form-group c-margin-t-40">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" class="btn btn-submit c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Nạp thẻ
                                    </button>
                                </div>
                            </div>
                        </form>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#charge').validate({
                                    rules: {
                                        payment_id: 'required',
                                        amount: 'required',
                                        serial: {
                                            required: true,
                                            minlength: 10,
                                            maxlength: 18,
                                        },
                                        pin: {
                                            required: true,
                                            minlength: 10,
                                            maxlength: 18,
                                        },
                                    },
                                    messages: {
                                        payment_id: 'Loại thẻ chưa được chọn.',
                                        amount: 'Mệnh giá chưa được chọn.',
                                        serial: {
                                            required: 'Số serial chưa được nhập.',
                                            minlength: 'Số serial phải từ 10 đến 18 ký tự',
                                            maxlength: 'Số serial phải từ 10 đến 18 ký tự',
                                        },
                                        pin: {
                                            required: 'Mã số thẻ chưa được nhập.',
                                            minlength: 'Mã số thẻ phải từ 10 đến 18 ký tự',
                                            maxlength: 'Mã số thẻ phải từ 10 đến 18 ký tự',
                                        },
                                    },
                                    submitHandler: function(form) {
                                        let url = $(form).attr('action')+'?type=json';
                                        let method = $(form).attr('method');
                                        let params = $(form).serializeArray();
                                        let formData = new FormData();
                                        $.each(params, function (i, val) {
                                            formData.append(val.name, val.value);
                                        });
                                        callAjax(url, method, formData).then(res => {
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
                                        $(form).trigger("reset");
                                        return false;
                                    }
                                });
                            });
                        </script>
                        <div class="alert alert-info alert-dismissible" role="alert">
                            - LƯU Ý : Nạp đúng mệnh giá thẻ - Sai mệnh giá mất thẻ<br>
                            - Nạp không trừ chiết khẩu,nạp 100k nhận 100k (2-5s/thẻ)<br>
                            - <font color="red">LƯU Ý: Chọn đúng mệnh giá, chọn sai sẽ bị trừ 100% không được hoàn tiền<br>
                            </font>
                        </div>
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
    <script type="text/javascript">
        function refreshCaptcha(){
            var img = document.images['captchaimg'];
            img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
        }
    </script>
@endsection
