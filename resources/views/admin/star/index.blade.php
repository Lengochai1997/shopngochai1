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
                                    <h6 class="m-0 font-weight-bold text-primary">Danh sách tỉ lệ riêng của {{ config('star.type.'.$type) }}</h6>
                                    <button class="btn btn-primary">
                                        <a href="{{ asset('admin/star/star/create?type='.$type.'&type_id='.$type_id) }}">Thêm User</a>
                                    </button>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <table class="table pb-3" id="list-stars">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Người dùng</th>
                                            <th scope="col">Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#list-stars').DataTable({
                                                "searching": true,
                                                @if($agent->isMobile())
                                                "scrollX": true,
                                                @endif
                                                "ordering": false,
                                                "columnDefs": [
                                                    {
                                                        "targets": 2,
                                                        "render": function (id, type, full, meta) {
                                                            let baseUrl = '{!! asset('admin/star') !!}';
                                                            let urlEdit = `${baseUrl}/star/${id}/edit`;
                                                            let urlDelete = `${baseUrl}/star/${id}`;
                                                            return `
                                                                <div class="btn-group">
                                                                    <button class="btn btn-outline-success" data-url="${urlEdit}" onclick="editItem(this)"><i class="fas fa-pencil-alt"></i></button>
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
                                                "sAjaxSource": '{!! asset('admin/star/list?type='.$type.'&type_id='.$type_id) !!}',
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
                                                    {
                                                        data: 'user', render: function (user) {
                                                            if (user.name) {
                                                                return user.name;
                                                            }
                                                            if (user.username) {
                                                                return user.username;
                                                            }
                                                            return '';
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
                                                    callAjax(url, 'DELETE', {'_token': '{!! csrf_token() !!}'}).then(res => {
                                                        let message = res.message;
                                                        $('#list-stars').DataTable().ajax.reload();
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
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
