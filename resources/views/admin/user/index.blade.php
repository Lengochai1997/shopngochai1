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
                                    <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div>
                                        <table id="list-users" class="table pb-3">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Thao tác</th>
                                                <th scope="col">Tên</th>
                                                <th scope="col">Tên đăng nhập</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Tổng tiền</th>
                                            </tr>
                                            </thead>
                                        </table>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $('#list-users').DataTable({
                                                    "searching": true,
                                                    @if($agent->isMobile())
                                                    "scrollX": true,
                                                    @endif
                                                    "ordering": false,
                                                    "columnDefs": [
                                                        {
                                                            "targets": 1,
                                                            "render": function (id, type, full, meta) {
                                                                let baseUrl = '{!! asset('admin/user/user') !!}';
                                                                let urlEdit = `${baseUrl}/${id}/edit`;
                                                                let urlDelete = `${baseUrl}/${id}`;
                                                                return `
                                                                <div class="btn-group">
                                                                    <button class="btn btn-outline-success" data-url="${urlEdit}" onclick="editItem(this)"><i class="fas fa-pencil-alt"></i></button>
<!--                                                                    <button class="btn btn-outline-danger" data-url="${urlDelete}" onclick="deleteItem(this);"><i class="fas fa-trash-alt"></i></button>-->
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
                                                        "sAjaxSource": '{!! asset('admin/user/list') !!}',
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
                                                        {data: 'id'},
                                                        {data: 'id'},
                                                        {data: 'name'},
                                                        {data: 'username'},
                                                        {data: 'email'},
                                                        {
                                                            data: 'total_money', render: function (total_money) {
                                                                return numeral(total_money).format('0,0') + ' đ';
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
                                                        callAjax(url, 'DELETE', {'_token': '{!! csrf_token() !!}'}).then(res => {
                                                            let message = res.message;
                                                            $('#list-users').DataTable().ajax.reload();
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
