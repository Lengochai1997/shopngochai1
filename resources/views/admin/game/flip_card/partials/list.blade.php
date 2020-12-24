<table class="table pb-3" id="list-random">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Thao tác</th>
        <th scope="col">Tiêu đề</th>
        <th scope="col">Url</th>
        <th scope="col">Giá quay</th>
        <th scope="col">Loại</th>
        <th scope="col">Trạng thái</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function () {
        $('#list-random').DataTable({
            "searching": true,
            @if($agent->isMobile())
            "scrollX": true,
            @endif
            "ordering": false,
            "colReorder": false,
            "columnDefs": [
                {
                    "targets": 1,
                    "render": function (id, type, full, meta) {
                        let baseUrl = '{!! asset('admin/flip-card/flip-card') !!}';
                        let urlEdit = `${baseUrl}/${id}/edit`;
                        let urlDelete = `${baseUrl}/${id}`;
                        let urlStar = `{!! asset('admin') !!}/star/star?type=flip_card&type_id=${id}`;
                        return `
                            <div class="btn-group">
                                <button class="btn btn-outline-success" data-url="${urlEdit}" onclick="editItem(this)"><i class="fas fa-pencil-alt"></i></button>
                                <button class="btn btn-outline-secondary" data-url="${urlStar}" onclick="listStar(this);"><i class="fas fa-star"></i></button>
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
            "sAjaxSource": '{!! asset('admin/flip-card/flip-card?type=json') !!}',
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
                {data: 'title'},
                {data: 'url'},
                {
                    data: 'price', render: function (price) {
                        return numeral(price).format('0,0');
                    }
                },
                {data: 'type'},
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

    function editItem(elem) {
        let url = $(elem).attr('data-url');
        window.location.href = url;
    }

    function listStar(elem) {
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
                    $('#list-random').DataTable().ajax.reload();
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
