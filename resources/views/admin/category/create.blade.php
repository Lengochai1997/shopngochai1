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
                                    <h6 class="m-0 font-weight-bold text-primary">thêm danh mục</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="add-category" action="{{ asset('admin/category/category') }}" method="post">
                                        @csrf
                                        @method('post')
                                        @include('admin.category.partials.entry', ['mode' => 'create'])
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-sm btn-primary button-config">thêm danh mục</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#add-category').validate({
                                                rules: {
                                                    title: 'required',
                                                    key: 'required',
                                                },
                                                messages: {
                                                    title: 'Tiêu đề không được để trống.',
                                                    key: 'Key không được để trống.',
                                                },
                                                submitHandler: function(form) {
                                                    let params = $(form).serializeArray();
                                                    let url = $(form).attr('action');
                                                    let formData = new FormData();
                                                    $.each(params, function (i, val) {
                                                        formData.append(val.name, val.value);
                                                    });
                                                    let images = $('#images')[0].files[0];
                                                    if (images) {
                                                        formData.append('images', images);
                                                    }
                                                    callAjax(url, 'post', formData).then(res => {
                                                        if (res.status === 'success') {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Thành công',
                                                                text: res.message,
                                                            }).then(function () {
                                                                window.location.href = '{!! asset('admin/category/category') !!}';
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
