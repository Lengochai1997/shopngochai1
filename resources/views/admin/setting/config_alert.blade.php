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
                        <div class="col-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thêm thông báo</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="form-data" action="{!! asset('admin/setting/config-alert') !!}" method="post">
                                        <div class="form-group">
                                            <label for="name">Thông báo</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Thông báo">
                                            <small id="nameHelp" class="form-text text-muted">Đây là tên thông báo, đặt tên bất kì (dễ nhớ là được)</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="url">Url</label>
                                            <input type="text" class="form-control" id="url" name="url" placeholder="Url">
                                            <small id="urlHelp" class="form-text text-muted">Đây là uri, ví dụ: trang chủ là /, nạp thẻ là /user/nap-the, nạp atm /user/nap-atm,... </small>
                                        </div>
                                        <div class="form-group">
                                            <label for="alert">Nội dung thông báo</label>
                                            <textarea class="form-control text-editor" id="alert" name="alert" placeholder="Nội dung thông báo"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Cấu hình</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#form-data').validate({
                                                rules: {
                                                    name: {
                                                        required: true,
                                                    },
                                                    url: {
                                                        required: true,
                                                    },
                                                    alert: {
                                                        required: false,
                                                    },

                                                },
                                                messages: {
                                                    name: {
                                                        required: 'Thông báo không được bỏ trống.',
                                                    },
                                                    url: {
                                                        required: 'URi không được bỏ trống.',
                                                    },
                                                },
                                                submitHandler: function(form) {
                                                    let url = $(form).attr('action');
                                                    let method = $(form).attr('method');
                                                    let params = $(form).serializeArray();
                                                    let formData = new FormData();
                                                    $.each(params, function (i, val) {
                                                        formData.append(val.name, val.value);
                                                    });
                                                    callAjax(url, method, formData).then(function (res) {
                                                        if (res.status === 'success') {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Thành Công !',
                                                                text: res.message || ''
                                                            }).then(() => {
                                                                location.reload();
                                                            });
                                                        } else {
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Lỗi !',
                                                                text: res.message || ''
                                                            });
                                                        }
                                                    });
                                                }
                                            })
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Danh sách thông báo</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Thông báo</th>
                                            <th scope="col">URL</th>
{{--                                            <th scope="col">Thao tác</th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($alerts as $alert)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $alert['name'] }}</td>
                                            <td>{{ $alert['url'] }}</td>
{{--                                            <td>--}}
{{--                                                <button class="btn btn-primary" data-id="{{ $alert['id'] }}" onclick="editAlert(this);">--}}
{{--                                                    <i class="fa fa-pen"></i>--}}
{{--                                                </button>--}}
{{--                                                <button class="btn btn-danger">--}}
{{--                                                    <i class="fa fa-trash"></i>--}}
{{--                                                </button>--}}
{{--                                            </td>--}}
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <script>
                                        function editAlert(elem) {
                                            let id = $(elem).data('id');
                                            modal.openModal(`{!! asset('admin/alert/alert/') !!}/${id}/edit?popup=true`);
                                        }

                                        function deleteAlert() {

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
