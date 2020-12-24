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
                                    <h6 class="m-0 font-weight-bold text-primary">Thêm Mục Random</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="create-data" action="{{ asset('admin/random/random') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        @include('admin.random.partials.entry', ['mode' => 'create'])
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-primary button-config">Thêm mục Random</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#create-data').validate({
                                                rules: {
                                                    title: 'required',
                                                    thumbnail: 'required',
                                                    count_account: 'required',
                                                    count_selled: 'required',
                                                },
                                                messages: {
                                                    title: 'Tiêu đề chưa được nhập.',
                                                    thumbnail: 'Ảnh thu nhỏ chưa có.',
                                                    count_account: 'Tổng Tài khoản chưa được nhập.',
                                                    count_selled: 'Đã bán chưa được nhập',
                                                },
                                                submitHandler: function(form) {
                                                    let params = $(form).serializeArray();
                                                    let url = $(form).attr('action');
                                                    let method = $(form).attr('method');
                                                    let formData = new FormData();
                                                    $.each(params, function (i, val) {
                                                        formData.append(val.name, val.value);
                                                    });
                                                    let thumbnail = $('#thumbnail')[0].files[0];
                                                    if (thumbnail) {
                                                        formData.append('thumbnail', thumbnail);
                                                    }
                                                    callAjax(url, method, formData).then(res => {
                                                        if (res.status === 'success') {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Thành công',
                                                                text: res.message,
                                                            }).then(function () {
                                                                window.location.href = '{!! asset('admin/random/random') !!}';
                                                            });
                                                        }
                                                    })
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
