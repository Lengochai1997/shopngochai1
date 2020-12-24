@extends('layout.index')

@section('title', 'Rút Kim cương')

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
                    @include('user.partials.sidebar', ['active' => 10])
                    <div class="c-layout-sidebar-content ">
                        <!-- BEGIN: PAGE CONTENT -->
                        <!-- BEGIN: CONTENT/SHOPS/SHOP-CUSTOMER-DASHBOARD-1 -->
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold" style="margin: 0px;">Rút Kim cương</h3>
                            <p style="margin: 5px 0px;font-size: 19px;font-weight: bold;">Bạn hiện có <span style="color: red;">{{ $wallet ? number_format($wallet->kimcuong) : 0 }}</span> Kim cương.</p>
                            <div class="c-line-left"></div>
                        </div>
                        <form id="charge" method="POST" action="{{ asset('wallet/without-kimcuong') }}" class="form-horizontal form-charge">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <label for="value" class="col-md-3 control-label">Số Kim cương rút:</label>
                                <div class="col-md-6">
                                    <select class="form-control c-square c-theme" id="value" name="value">
                                        <option value="90">90 Kim cương</option>
                                        <option value="230">230 Kim cương</option>
                                        <option value="465">465 Kim cương</option>
                                        <option value="950">950 Kim cương</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="id" class="col-md-3 control-label">ID nhân Kim cương:</label>
                                <div class="col-md-6">
                                    <input class="form-control c-square c-theme" type="text" id="id" name="id">
                                </div>
                            </div>
                            <div class="form-group c-margin-t-40">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" class="btn btn-submit c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Rút Kim cương
                                    </button>
                                </div>
                            </div>
                        </form>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#charge').validate({
                                    rules: {
                                        value: {
                                            required: true,
                                            min: 0
                                        },
                                        id: {
                                            required: true,
                                        }
                                    },
                                    messages: {
                                        value: {
                                            required: 'Số kim cương chưa được chọn.',
                                            min: 'Số kim cương phải lớn hơn 0.'
                                        },
                                        id: {
                                            required: 'ID chưa được nhập.'
                                        }

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
                        <div class="c-content-title-1" style="margin-top: 40px;">
                            <h3 class="c-font-uppercase c-font-bold">Lịch sử rút</h3>
                            <div class="c-line-left"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="list-charge" class="table table-hover table-custom-res">
                                    <thead>
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Loại</th>
                                        <th>Tài khoản/ID</th>
                                        <th>Số lượng</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="8">
                                            <center>Không có dữ liệu<center></center></center>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <script type="text/javascript">
                            let tbListCharge;
                            $(document).ready(function () {
                                tbListCharge = $('#list-charge').DataTable({
                                    "searching": true,
                                    @if($agent->isMobile())
                                    "scrollX": true,
                                    @endif
                                    "ordering": false,
                                    "processing": true,
                                    "serverSide": true,
                                    "bProcessing": true,
                                    "sDom": 'R<>rt<ip><"clear">',
                                    "bServerSide": true,
                                    "sAjaxSource": '{!! asset('wallet/list?type=kimcuong') !!}',
                                    "fnServerData": function (sSource, aoData, fnCallback) {
                                        $.ajax({
                                            dataType: 'json',
                                            url: sSource,
                                            method: 'GET',
                                            data: aoData,
                                            success: fnCallback
                                        });
                                    },
                                    "columns": [
                                        {data: 'created'},
                                        {data: 'type'},
                                        {data: 'data'},
                                        {data: 'value'},
                                        {data: 'status'},
                                    ],
                                    "pageLength": 10,
                                    "oLanguage": {
                                        "sZeroRecords": "{!! trans('datatable.sZeroRecords') !!}",
                                        "sInfoEmpty": "{!! trans('datatable.sInfoEmpty') !!}",
                                        "sProcessing": "{!! trans('datatable.sProcessing') !!}",
                                        "sInfo": "{!! trans('datatable.sInfo') !!}",
                                        "sLengthMenu": "{!! trans('datatable.sLengthMenu') !!}",
                                        "sLoadingRecords ": "{!! trans('datatable.sLoadingRecords') !!}",
                                        "sSearch": "{!! trans('datatable.sSearch') !!}",
                                        "oPaginate": {
                                            "sFirst": "{!! trans('datatable.oPaginate.sFirst') !!}",
                                            "sPrevious": "{!! trans('datatable.oPaginate.sPrevious') !!}",
                                            "sNext": "{!! trans('datatable.oPaginate.sNext') !!}",
                                            "sLast": "{!! trans('datatable.oPaginate.sLast') !!}"
                                        }
                                    },
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
    <script type="text/javascript">
        function refreshCaptcha(){
            var img = document.images['captchaimg'];
            img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
        }
    </script>
@endsection
