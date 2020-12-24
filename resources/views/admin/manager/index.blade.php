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
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Danh sách Cộng tác viên</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <table class="table pb-3" id="list-item">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{ trans('admin::admin.label.name') }}</th>
                                            <th scope="col">{{ trans('admin::admin.label.username') }}</th>
                                            <th scope="col">{{ trans('admin::admin.label.type') }}</th>
                                            <th scope="col">{{ trans('admin::admin.label.count_account') }}</th>
                                            <th scope="col">{{ trans('admin::admin.label.count_random_account') }}</th>
                                            <th scope="col">{{ trans('admin::admin.label.income') }}</th>
                                            <th scope="col">{{ trans('admin::admin.label.real_income') }}</th>
                                            <th scope="col">{{ trans('datatable.label.action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#status').on('change', function () {
                                                $('#list-item').DataTable().ajax.reload();
                                            });
                                            $('#list-item').DataTable({
                                                "searching": true,
                                                @if($agent->isMobile())
                                                "scrollX": true,
                                                @endif
                                                "ordering": false,
                                                "columnDefs": [
                                                    {
                                                        "targets": 8,
                                                        "render": function (id, type, full, meta) {
                                                            let baseUrl = '{!! asset('admin') !!}';
                                                            let urlEdit = `${baseUrl}/edit/${id}`;
                                                            let urlChangePass = `${baseUrl}/change-pass/${id}`;
                                                            let urlResetIncome = `${baseUrl}/reset-income/${id}`;
                                                            let urlDelete = `${baseUrl}/delete/${id}`;
                                                            return `
                                                                <div class="btn-group">
                                                                    <button class="btn btn-outline-success" data-url="${urlEdit}" onclick="editItem(this)"><i class="fas fa-pencil-alt"></i></button>
                                                                    <button class="btn btn-outline-primary" data-url="${urlChangePass}" onclick="editItem(this)"><i class="fas fa-key"></i></button>
                                                                    <button class="btn btn-outline-warning" data-url="${urlResetIncome}" onclick="urlResetIncome(this);"><i class="fas fa-dollar-sign"></i></button>
                                                                    <button class="btn btn-outline-danger" data-url="${urlDelete}" onclick="deleteItem(this);"><i class="fas fa-trash-alt"></i></button>
                                                                </div>
                                                            `;
                                                        }
                                                    }
                                                ],
                                                "processing": true,
                                                "serverSide": true,
                                                "bProcessing": true,
                                                "sDom": 'R<lf>rt<ip><"clear">',
                                                "bServerSide": true,
                                                "sAjaxSource": '{!! asset('admin/list?type=json') !!}',
                                                "fnServerData": function (sSource, aoData, fnCallback) {
                                                    aoData.push({
                                                        'name': 'status',
                                                        'value': $('#status').val(),
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
                                                    {data: 'id'},
                                                    {data: 'name'},
                                                    {data: 'username'},
                                                    {data: 'type'},
                                                    {data: 'count_account'},
                                                    {data: 'count_random_account'},
                                                    {
                                                        data: 'income', render: function (income) {
                                                            return numeral(income).format('0,0');
                                                        }
                                                    },
                                                    {
                                                        data: 'income', render: function (income) {
                                                            return numeral(income*0.4).format('0,0');
                                                        }
                                                    },
                                                    {data: 'id'},
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

                                        function editItem(elem) {
                                            let url = $(elem).attr('data-url');
                                            window.location.href = url;
                                        }

                                        function deleteItem(elem) {
                                            let url = $(elem).attr('data-url');
                                            Swal.fire({
                                                title: 'Bạn có muốn xóa ?',
                                                text: "Sẽ tiến hành xóa khi bấm Đồng ý",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Đồng ý',
                                                cancelButtonText: 'Hủy'
                                            }).then((result) => {
                                                if (result.value) {
                                                    callAjax(url, 'GET').then(res => {
                                                        let message = res.message;
                                                        $('#list-item').DataTable().ajax.reload();
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Thành công !',
                                                            text: message
                                                        });
                                                    });
                                                }
                                            });
                                        }

                                        function urlResetIncome(elem) {
                                            let url = $(elem).attr('data-url');
                                            Swal.fire({
                                                title: 'Tiến hành thanh toán cho CTV ?',
                                                text: 'Sau khi thanh toán thì thu nhập của CTV về 0 đồng.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Đồng ý',
                                                cancelButtonText: 'Hủy'
                                            }).then((result) => {
                                                if (result.value) {
                                                    callAjax(url, 'GET').then(res => {
                                                        let message = res.message;
                                                        $('#list-item').DataTable().ajax.reload();
                                                        Swal.fire({
                                                            icon: 'success',
                                                            title: 'Thành công !',
                                                            text: message
                                                        });
                                                    });
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <script type="text/javascript">

            </script>
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
