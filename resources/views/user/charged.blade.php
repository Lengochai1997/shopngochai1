@extends('layout.index')

@section('title', 'Thẻ đã nạp')

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
                    @include('user.partials.sidebar', ['active' => 5])
                    <div class="c-layout-sidebar-content ">
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold">Thẻ cào đã nạp</h3>
                            <div class="c-line-left"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group m-b-10 c-square">
                                    <span class="input-group-addon" id="payment">Loại thẻ</span>
                                    <select id="payment_id" name="payment_id" class="form-control c-square c-theme">
                                        <option value="0">Tất cả</option>
                                        @foreach($payments as $payment)
                                            <option value="{{ $payment['id'] }}">{{ $payment['title'] }} - ({{ config('payment.type')[$payment['type_id']] }}) - ({{ config('payment.gate')[$payment['gate_id']] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group m-b-10 c-square">
                                    <span class="input-group-addon">Trạng thái</span>
                                    <select id="status" name="status" class="form-control c-square c-theme">.
                                        <option value="0">Tất cả</option>
                                        @foreach(config('charge.status') as $key => $status)
                                            <option value="{{ $key }}">{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="list-charge" class="table table-hover table-custom-res">
                                    <thead>
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Loại thẻ</th>
                                        <th>Mã thẻ</th>
                                        <th>Serial</th>
                                        <th>Mệnh giá</th>
                                        <th>Kết quả</th>
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
                                $('#payment_id').on('change', function () {
                                    $('#list-charge').DataTable().ajax.reload();
                                });
                                $('#status').on('change', function () {
                                    $('#list-charge').DataTable().ajax.reload();
                                });
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
                                    "sAjaxSource": '{!! asset('charge/list') !!}',
                                    "fnServerData": function (sSource, aoData, fnCallback) {
                                        let payment_id = $('#payment_id').val();
                                        aoData.push({
                                            'name': 'payment_id',
                                            'value': payment_id
                                        });
                                        let status = $('#status').val();
                                        aoData.push({
                                            'name': 'status',
                                            'value': status
                                        });
                                        $.ajax({
                                            dataType: 'json',
                                            url: sSource,
                                            method: 'GET',
                                            data: aoData,
                                            success: fnCallback
                                        });
                                    },
                                    "columns": [
                                        {
                                            data: 'create', render: function (create) {
                                                return moment(create).format('HH:mm:ss - DD/DD/YYYY');
                                            }
                                        },
                                        {
                                            data: 'payment', render: function(payment) {
                                                return payment.title;
                                            }
                                        },
                                        {data: 'pin'},
                                        {data: 'serial'},
                                        {data: 'amount'},
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
