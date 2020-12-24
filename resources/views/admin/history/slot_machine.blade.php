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
                                <h6 class="m-0 font-weight-bold text-primary">Lịch sử quay xèng</h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <table id="list-bought" class="table table-hover table-custom-res">
                                    <thead>
                                    <tr>
                                        <th>Thời gian</th>
                                        <th>Người mua</th>
                                        <th>Loại</th>
                                        <th>Giá</th>
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
                                            "sAjaxSource": '{!! asset('admin/history/slot-machine?type=json') !!}',
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
                                                        return moment(created).format('HH:mm:ss DD/MM/YYYY');
                                                    }
                                                },
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
                                                {data: 'slot_machine_title'},
                                                {
                                                    data: 'slot_machine_price', render: function (slot_machine_price) {
                                                        return numeral(slot_machine_price).format(0,0) + ' vnđ';
                                                    }
                                                },
                                                {data: 'result'},
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
