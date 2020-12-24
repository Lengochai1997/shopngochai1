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
                                    <h6 class="m-0 font-weight-bold text-primary">Thêm vòng quay</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="create-spin" action="{{ asset('admin/spin/coin/'.$item->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        @include('admin.spin_coin.partials.entry', ['mode' => 'edit'])
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-primary button-config">Sửa vòng quay</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#create-spin').validate({
                                                rules: {
                                                    title: 'required',
                                                    key_1: 'required',
                                                    key_2: 'required',
                                                    key_3: 'required',
                                                    key_4: 'required',
                                                    key_5: 'required',
                                                    key_6: 'required',
                                                    key_7: 'required',
                                                    key_8: 'required',
                                                    ratio_1: 'required',
                                                    ratio_2: 'required',
                                                    ratio_3: 'required',
                                                    ratio_4: 'required',
                                                    ratio_5: 'required',
                                                    ratio_6: 'required',
                                                    ratio_7: 'required',
                                                    ratio_8: 'required',
                                                    total: 'required',
                                                    price: 'required',
                                                },
                                                messages: {
                                                    title: 'Tiêu đề vòng quay chưa được nhập.',
                                                    key_1: 'Thuộc tính 1 chưa được điền.',
                                                    key_2: 'Thuộc tính 2 chưa được điền.',
                                                    key_3: 'Thuộc tính 3 chưa được điền.',
                                                    key_4: 'Thuộc tính 4 chưa được điền.',
                                                    key_5: 'Thuộc tính 5 chưa được điền.',
                                                    key_6: 'Thuộc tính 6 chưa được điền.',
                                                    key_7: 'Thuộc tính 7 chưa được điền.',
                                                    key_8: 'Thuộc tính 8 chưa được điền.',
                                                    ratio_1: 'Tỉ lệ 1 phải được điền.',
                                                    ratio_2: 'Tỉ lệ 2 phải được điền.',
                                                    ratio_3: 'Tỉ lệ 3 phải được điền.',
                                                    ratio_4: 'Tỉ lệ 4 phải được điền.',
                                                    ratio_5: 'Tỉ lệ 5 phải được điền.',
                                                    ratio_6: 'Tỉ lệ 6 phải được điền.',
                                                    ratio_7: 'Tỉ lệ 7 phải được điền.',
                                                    ratio_8: 'Tỉ lệ 8 phải được điền.',
                                                    total: 'Nổ hũ chưa được điền.',
                                                    price: 'Giá quay chưa được điền.',
                                                },
                                                submitHandler: function(form) {
                                                    let params = $(form).serializeArray();
                                                    let url = $(form).attr('action');

                                                    let formData = new FormData();
                                                    $.each(params, function (i, val) {
                                                        formData.append(val.name, val.value);
                                                    });

                                                    let thumbnail = $('#thumbnail')[0].files[0];
                                                    if (thumbnail) {
                                                        formData.append('thumbnail', thumbnail);
                                                    }
                                                    let image = $('#image')[0].files[0];
                                                    if (image) {
                                                        formData.append('image', image);
                                                    }
                                                    callAjax(url, 'post', formData).then(res => {
                                                        if (res.status === 'success') {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Thành công',
                                                                text: res.message,
                                                            });
                                                        }
                                                    })
                                                }
                                            });
                                        });

                                        function postAjax(url, method, formData) {
                                            return new Promise(resolve => {
                                                $.ajax({
                                                    url: url,
                                                    type: method,
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    data: formData,
                                                    contentType: false,
                                                    processData: false,
                                                    beforeSend: function() {
                                                        showLoading();
                                                    },
                                                    success: function(res) {
                                                        resolve(res);
                                                    },
                                                    error: function (err) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Lỗi !',
                                                            text: 'Xin thử lại, '+err.message,
                                                        });
                                                    },
                                                    complete: function () {
                                                        hideLoading();
                                                    }
                                                });
                                            })
                                        }
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
