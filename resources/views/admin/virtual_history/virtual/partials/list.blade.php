<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="type">Loại</label>
            <select class="form-control" id="type" name="type">
                <option selected disabled>Chọn loại</option>
                @foreach(config('history_virtual.type') as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="type">Vòng quay</label>
            <select class="form-control" id="ref_id" name="ref_id">
                <option selected disabled>Chọn vòng quay</option>
                @foreach($spins as $spin)
                    <option value="{{ $spin['id'] }}">{{ $spin['title'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <table class="table pb-3" id="list-random">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Thao tác</th>
                <th scope="col">Người quay</th>
                <th scope="col">Kết quả</th>
                <th scope="col">Thời gian</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#type').on('change', function () {
                    $('#list-random').DataTable().ajax.reload();
                });
                $('#ref_id').on('change', function () {
                    $('#list-random').DataTable().ajax.reload();
                });
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
                                let baseUrl = '{!! asset('admin/virtual-history/virtual-history') !!}';
                                let urlEdit = `${baseUrl}/${id}/edit`;
                                let urlDelete = `${baseUrl}/${id}`;
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
                    "sAjaxSource": '{!! asset('admin/virtual-history/virtual-history?type=json') !!}',
                    "fnServerData": function (sSource, aoData, fnCallback) {
                        aoData.push({
                            'name': 'spin_type',
                            'value': $('#type').val(),
                        });
                        aoData.push({
                            'name': 'ref_id',
                            'value': $('#ref_id').val(),
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
                        {data: 'id'},
                        {data: 'name'},
                        {data: 'result'},
                        {data: 'time'},
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
    </div>
</div>


