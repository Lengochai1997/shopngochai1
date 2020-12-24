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
                        <div class="col-sm-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Chọn danh mục Random:</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="random_id" class="col-sm-3">Danh mục Random</label>
                                        <select class="form-control form-control-sm col-sm-6" id="random_id" name="random_id">
                                            @foreach($items as $i)
                                                <option value="{{ $i->id }}" @if($i->id == $item->id) selected @endif>{{ $i->title }}</option>
                                            @endforeach
                                        </select>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $('#random_id').on('change', function () {
                                                    let id = $(this).val();
                                                    location.href = '{!! asset('admin/gift-box/list-boxes') !!}/' + id;
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thêm Tài khoản cho random: {{ $item->title }}</h6>
                                </div>
                                <div class="card-body">
                                    <form id="create-data" method="post" action="{{ asset('admin/gift-box/box') }}">
                                        <input type="hidden" name="gift_id" value="{{ $item->id }}">
                                        <div class="form-group">
                                            <label for="boxes">Danh sách hòm quà</label>
                                            <textarea class="form-control" id="boxes" name="boxes" rows="5" placeholder="00|11"></textarea>
                                            <small id="boxesHelp" class="form-text text-muted">Ghi chú: Các hòm quà cách nhau bởi dấu |.</small>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary">Thêm Tài khoản</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#create-data').validate({
                                                rules: {
                                                    boxes: 'required'
                                                },
                                                messages: {
                                                    boxes: 'Danh sách hòm quà không được bỏ trống.'
                                                },
                                                submitHandler: function(form) {
                                                    let params = $(form).serializeArray();
                                                    let url = $(form).attr('action');
                                                    let method = $(form).attr('method');
                                                    let formData = new FormData();
                                                    $.each(params, function (i, val) {
                                                        formData.append(val.name, val.value);
                                                    });
                                                    callAjax(url, method, formData).then(res => {
                                                        if (res.status === 'success') {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Thành Công !',
                                                                text: res.message || ''
                                                            });
                                                        } else {
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Lỗi !',
                                                                text: res.message || ''
                                                            });
                                                        }
                                                        $('#create-data').trigger("reset");
                                                        $('#list-accounts').DataTable().ajax.reload();
                                                    });
                                                }
                                            })
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Danh sách Tài khoản cho {{ $item->title }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="filter row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group row">
                                                <label for="type" class="col-sm-3">Trạng thái</label>
                                                <select class="form-control form-control-sm col-sm-9" id="status" name="status">
                                                    <option value="" selected>Tất cả</option>
                                                    @foreach(config('box.status') as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table pb-3" id="list-accounts">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Chức năng</th>
                                            <th scope="col">Giá trị</th>
                                            <th scope="col">Trạng thái</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#status').on('change', function () {
                                                $('#list-accounts').DataTable().ajax.reload();
                                            });
                                            $('#list-accounts').DataTable({
                                                "searching": true,
                                                @if($agent->isMobile())
                                                "scrollX": true,
                                                @endif
                                                "ordering": false,
                                                "columnDefs": [
                                                    {
                                                        "targets": 1,
                                                        "render": function (id, type, full, meta) {
                                                            let baseUrl = '{!! asset('admin/gift-box/box') !!}';
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
                                                "serverSide": true,
                                                "bProcessing": true,
                                                "sDom": 'R<lf>rt<ip><"clear">',
                                                "bServerSide": true,
                                                "sAjaxSource": '{!! asset('admin/gift-box/box') !!}',
                                                "fnServerData": function (sSource, aoData, fnCallback) {
                                                    if ($('#type').val() !== '') {
                                                        aoData.push({
                                                            'name': 'status',
                                                            'value': $('#status').val()
                                                        });
                                                        aoData.push({
                                                            'name': 'gift_id',
                                                            'value': '{!! $item->id !!}'
                                                        });
                                                    }
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
                                                    {data: 'value'},
                                                    {data: 'status'}
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

                                        function listAccount(elem) {
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
                                                        $('#list-accounts').DataTable().ajax.reload();
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
