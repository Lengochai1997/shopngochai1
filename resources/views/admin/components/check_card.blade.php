<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Duyệt thẻ chậm</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <table id="list-data" class="table pb-3">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Thao tác</th>
                <th scope="col">Ngày nạp</th>
                <th scope="col">Người nạp</th>
                <th scope="col">Nhà mạng</th>
                <th scope="col">Serial</th>
                <th scope="col">Mã thẻ</th>
                <th scope="col">Mệnh giá</th>
                <th scope="col">Trạng thái</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#list-data').DataTable({
                    "searching": true,
                    "scrollX": true,
                    "ordering": false,
                    "columnDefs": [
                        {
                            "targets": 1,
                            "render": function (id, type, full, meta) {
                                let baseUrl = '{!! asset('admin/charge') !!}';
                                let urlApproved = `${baseUrl}/card-true/${id}`;
                                let urlCancel = `${baseUrl}/card-false/${id}`;
                                return `
                                                    <div class="btn-group">
                                                        <button class="btn btn-outline-success" data-url="${urlApproved}" onclick="cardTrue(this)">Thẻ đúng</button>
                                                        <button class="btn btn-outline-danger" data-url="${urlCancel}" onclick="cardFalse(this)">Thẻ sai</button>
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
                    "sAjaxSource": '{!! asset('admin/charge/list?type_id=2&status=1') !!}',
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
                        {data: 'create'},
                        {
                            data: 'user', render: function(user) {
                                return user.name ? user.name : user.username;
                            }
                        },
                        {
                            data: 'payment', render: function(payment) {
                                return payment.key ? payment.key : '';
                            }
                        },
                        {data: 'serial'},
                        {data: 'pin'},
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

            function cardTrue(elem) {
                let url = $(elem).attr('data-url');
                callAjax(url).then(res => {
                    let message = res.message;
                    $('#list-data').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công !',
                        text: message
                    });
                });
            }

            function cardFalse(elem) {
                let url = $(elem).attr('data-url');
                callAjax(url).then(res => {
                    let message = res.message;
                    $('#list-data').DataTable().ajax.reload();
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
