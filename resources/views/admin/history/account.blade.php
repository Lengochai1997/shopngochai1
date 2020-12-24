@extends('admin.layouts.app')

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
                    <div class="col-sm-12">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Lịch sử mua tài khoản</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <table id="list-bought" class="table table-hover table-custom-res">
                                    <thead>
                                    <tr>
                                        <th>Người mua</th>
                                        <th>Thời gian</th>
                                        <th>Tài khoản</th>
                                        <th>Mật khẩu</th>
                                        <th>Giá</th>
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
                                <script type="text/javascript">
                                    let tbListCharge;
                                    $(document).ready(function () {
                                        tbListCharge = $('#list-bought').DataTable({
                                            "searching": true,
                                            @if($agent->isMobile())
                                            "scrollX": true,
                                            @endif
                                            "ordering": false,
                                            "processing": true,
                                            "serverSide": true,
                                            "bProcessing": true,
                                            "sDom": 'R<f>rt<ip><"clear">',
                                            "bServerSide": true,
                                            "sAjaxSource": '{!! asset('admin/history/account?type=json') !!}',
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
                                                    data: 'user',
                                                    render: function (user) {
                                                        if (user.name) {
                                                            return user.name;
                                                        } else {
                                                            return user.username;
                                                        }
                                                    }
                                                },
                                                {
                                                    data: 'created',
                                                    render: function (created) {
                                                        return moment(created).format('HH:mm:ss DD/MM/YYYY');
                                                    }
                                                },
                                                {
                                                    data: 'account',
                                                    render: function (account) {
                                                        return account.username
                                                    }
                                                },
                                                {
                                                    data: 'account',
                                                    render: function (account) {
                                                        return account.password
                                                    }
                                                },
                                                {
                                                    data: 'account',
                                                    render: function (account) {
                                                        return numeral(account.price).format(0,0) + ' vnđ';
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
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
