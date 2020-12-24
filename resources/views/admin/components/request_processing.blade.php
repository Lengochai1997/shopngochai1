<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Xử lý yêu cầu</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <table id="list-data-2" class="table pb-3">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Thao tác</th>
                <th scope="col">Ngày tạo</th>
                <th scope="col">Người tạo</th>
                <th scope="col">Loại</th>
                <th scope="col">Tài khoản/ID</th>
                <th scope="col">Mật khẩu</th>
                <th scope="col">Số lượng</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#list-data-2').DataTable({
                    "searching": true,
                    @if($agent->isMobile())
                    "scrollX": true,
                    @endif
                    "ordering": false,
                    "columnDefs": [
                        {
                            "targets": 1,
                            "render": function (id, type, full, meta) {
                                let baseUrl = '{!! asset('admin/wallet') !!}';
                                let urlApproved = `${baseUrl}/approved/${id}`;
                                let urlCancel = `${baseUrl}/refuse/${id}`;
                                return `
                                                    <div class="btn-group">
                                                        <button class="btn btn-outline-success" data-url="${urlApproved}" onclick="approved(this)">Phê duyệt</button>
                                                        <button class="btn btn-outline-danger" data-url="${urlCancel}" onclick="refuse(this)">Từ chối</button>
                                                    </div>
                                                `;
                            }
                        }
                    ],
                    "processing": true,
                    "serverSide": true,
                    "bProcessing": true,
                    "sDom": 'R<l>rt<ip><"clear">',
                    "bServerSide": true,
                    "sAjaxSource": '{!! asset('admin/wallet/history?status=0') !!}',
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
                        {data: 'created'},
                        {
                            data: 'user', render: function(user) {
                                if (user != null) {
                                    return user.name ? user.name : user.username;
                                }
                                return '';
                            }
                        },
                        {data: 'type'},
                        {
                            data: 'data', render: function (data) {
                                if (data.username) {
                                    return data.username;
                                }
                                if (data.id) {
                                    return data.id;
                                }
                                return '';
                            }
                        },
                        {
                            data: 'data', render: function (data) {
                                if (data.password) {
                                    return data.password;
                                }
                                return '';
                            }
                        },
                        {data: 'value'},
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

            // phê duyệt yêu cầu
            function approved(elem) {
                let url = $(elem).attr('data-url');
                callAjax(url).then(res => {
                    let message = res.message;
                    $('#list-data-2').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công !',
                        text: message
                    });
                });
            }

            // từ chối yêu cầu
            function refuse(elem) {
                let url = $(elem).attr('data-url');
                callAjax(url).then(res => {
                    let message = res.message;
                    $('#list-data-2').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công !',
                        text: message
                    });
                });
            }
        </script>
    </div>
</div>
