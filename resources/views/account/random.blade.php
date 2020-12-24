@extends('layout.index')

@section('title', 'Tài khoản Random đã mua')

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
                    @include('user.partials.sidebar', ['active' => 9])
                    <div class="c-layout-sidebar-content">
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold">Tài khoản Random đã mua</h3>
                            <div class="c-line-left"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="list-data" class="table table-hover table-custom-res">
                                    <thead>
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Tài khoản</th>
                                        <th>Random</th>
                                        <th>Giá</th>
                                        <th></th>
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
                                tbListCharge = $('#list-data').DataTable({
                                    "searching": true,
                                    @if($agent->isMobile())
                                    "scrollX": true,
                                    @endif
                                    "columnDefs": [
                                        {
                                            "targets": 4,
                                            "render": function (id, type, full, meta) {
                                                let accountId = full.account.id;
                                                let urlView = '{!! asset('random/info') !!}/' + accountId;
                                                return `
                                                    <button class="btn btn-outline-success" data-url="${urlView}" onclick="viewItem(this)"><i class="fa fa-eye"></i> Thông tin</button>
                                                `;
                                            }
                                        }
                                    ],
                                    "ordering": false,
                                    "processing": true,
                                    "serverSide": true,
                                    "bProcessing": true,
                                    "sDom": 'R<>rt<ip><"clear">',
                                    "bServerSide": true,
                                    "sAjaxSource": '{!! asset('history-random/list') !!}',
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
                                        {
                                            data: 'created',
                                            render: function (created) {
                                                return moment(created).format('DD/MM/YYYY');
                                            }
                                        },
                                        {
                                            data: 'account',
                                            render: function (account) {
                                                return account.username
                                            }
                                        },
                                        {data: 'random'},
                                        {
                                            data: 'price',
                                            render: function (price) {
                                                return numeral(price).format('0,0') + ' vnđ';
                                            }
                                        },
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
