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
                                    <h6 class="m-0 font-weight-bold text-primary">thông tin chung</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="general" action="{{ asset('admin/setting/save/general') }}" method="post">
                                        @csrf
                                        @method('post')
                                        <div class="form-group row">
                                            <label for="title" class="col-sm-3 col-form-label col-form-label-sm">tiêu đề trang web</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="tiêu đề trang web" value="{{ isset($config['title']) ? $config['title'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-3 col-form-label col-form-label-sm">mô tả</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="description" name="description" placeholder="mô tả" value="{{ isset($config['description']) ? $config['description'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="keyword" class="col-sm-3 col-form-label col-form-label-sm">từ khóa tìm kiếm</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="keyword" name="keyword" placeholder="từ khóa tìm kiếm" value="{{ isset($config['keyword']) ? $config['keyword'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="domain" class="col-sm-3 col-form-label col-form-label-sm">tên miền</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="domain" name="domain" placeholder="tên miền" value="{{ isset($config['domain']) ? $config['domain'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="hotline" class="col-sm-3 col-form-label col-form-label-sm">hotline</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="hotline" name="hotline" placeholder="hotline" value="{{ isset($config['hotline']) ? $config['hotline'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="admin_name" class="col-sm-3 col-form-label col-form-label-sm">tên quản trị</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="admin_name" name="admin_name" placeholder="tên quản trị" value="{{ isset($config['admin_name']) ? $config['admin_name'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="admin_facebook" class="col-sm-3 col-form-label col-form-label-sm">facebook quản trị</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="admin_facebook" name="admin_facebook" placeholder="facebook quản trị" value="{{ isset($config['admin_facebook']) ? $config['admin_facebook'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="fanpage" class="col-sm-3 col-form-label col-form-label-sm">fanpage</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="fanpage" name="fanpage" placeholder="fanpage" value="{{ isset($config['fanpage']) ? $config['fanpage'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="link_video" class="col-sm-3 col-form-label col-form-label-sm">video trang chủ</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" id="link_video" name="link_video" placeholder="video trang chủ" value="{{ isset($config['link_video']) ? $config['link_video'] : '' }}"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alert" class="col-sm-3 col-form-label col-form-label-sm">nội dung thông báo</label>
                                            <div class="col-sm-9">
                                                <textarea name="alert" id="alert" class="form-control form-control-sm text-editor" rows="3">{{ isset($config['alert']) ? $config['alert'] : '' }}</textarea>
                                            </div>
                                        </div>
{{--                                        <div class="form-group row">--}}
{{--                                            <label for="random_status" class="col-sm-3 col-form-label col-form-label-sm">trạng thái random</label>--}}
{{--                                            <div class="col-sm-9">--}}
{{--                                                <select class="form-control form-control-sm" id="random_status" name="random_status">--}}
{{--                                                    <option value="1" {{ isset($config['random_status']) && $config['random_status'] == 1 ? 'selected' : '' }}>Hoạt động</option>--}}
{{--                                                    <option value="0" {{ isset($config['random_status']) && $config['random_status'] == 0 ? 'selected' : '' }}>Bảo trì</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-group row">--}}
{{--                                            <label for="status_website" class="col-sm-3 col-form-label col-form-label-sm">trạng thái website</label>--}}
{{--                                            <div class="col-sm-9">--}}
{{--                                                <select class="form-control form-control-sm" id="status_website" name="status_website">--}}
{{--                                                    <option value="1" {{ isset($config['status_website']) && $config['status_website'] == 1 ? 'selected' : '' }}>Hoạt động</option>--}}
{{--                                                    <option value="0" {{ isset($config['status_website']) && $config['status_website'] == 0 ? 'selected' : '' }}>Bảo trì</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <input type="hidden" name="random_status" value="1" />
                                        <input type="hidden" name="status_website" value="1" />
                                        <div class="form-group row">
                                            <label for="voucher" class="col-sm-3 col-form-label col-form-label-sm">phần thưởng top nạp thẻ</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm text-editor" id="voucher" name="voucher" placeholder="phần thưởng" >{{ isset($config['voucher']) ? $config['voucher'] : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="voucher" class="col-sm-3 col-form-label col-form-label-sm">giao diện</label>
                                            <div class="col-sm-9">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="theme" id="light" value="light" @if(isset($config['theme']) && $config['theme'] == 'light') checked @endif>
                                                    <label class="form-check-label" for="light">
                                                        Sáng
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="theme" id="dark" value="dark" @if(isset($config['theme']) && $config['theme'] == 'dark') checked @endif>
                                                    <label class="form-check-label" for="dark">
                                                        Tối
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" class="btn btn-sm btn-primary button-config">lưu thông tin</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#general').validate({
                                                rules: {
                                                    title: 'required',
                                                    domain: 'required',
                                                    hotline: 'required',
                                                },
                                                messages: {
                                                    title: 'Tiêu đề không được bỏ trống.',
                                                    domain: 'Tên miền không được bỏ trống.',
                                                    hotline: 'Hotline không được bỏ trống.',
                                                },
                                                submitHandler: function (form) {
                                                    let url = $(form).attr('action');
                                                    let params = $(form).serializeArray();
                                                    let formData = new FormData();
                                                    $.each(params, function (i, val) {
                                                        formData.append(val.name, val.value);
                                                    });
                                                    callAjax(url, 'POST', formData).then(res => {
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
                                                    });
                                                    return false;
                                                }
                                            });
                                        });
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
