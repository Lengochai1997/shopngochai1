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
                    <!-- ATM -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thông tin ATM</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="atm" action="{{ asset('admin/setting/save-atm') }}" method="post">
                                        <div class="form-group">
                                            <label for="atm_name">Chủ Tài khoản</label>
                                            <input type="text" class="form-control" id="atm_name" name="atm_name" placeholder="Chủ Tài khoản" value="{{ isset($config_atm['atm_name']) ? $config_atm['atm_name'] : '' }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="atm_number">Số Tài khoản</label>
                                            <input type="text" class="form-control" id="atm_number" name="atm_number" placeholder="Số Tài khoản" value="{{ isset($config_atm['atm_number']) ? $config_atm['atm_number'] : '' }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="atm_bank">Ngân hàng</label>
                                            <input type="text" class="form-control" id="atm_bank" name="atm_bank" placeholder="Ngân hàng" value="{{ isset($config_atm['atm_bank']) ? $config_atm['atm_bank'] : '' }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="atm_branch">Chi nhánh</label>
                                            <input type="text" class="form-control" id="atm_branch" name="atm_branch" placeholder="Chi nhánh" value="{{ isset($config_atm['atm_branch']) ? $config_atm['atm_branch'] : '' }}" />
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#atm').validate({
                                                rules: {
                                                    atm_name: 'required',
                                                    atm_number: 'required',
                                                    atm_bank: 'required',
                                                    atm_branch: 'required',
                                                },
                                                messages: {
                                                    atm_name: 'Chủ tài khoản chưa được điền.',
                                                    atm_number: 'Số tài khoản chưa được điền.',
                                                    atm_bank: 'Ngân hàng chưa được điền.',
                                                    atm_branch: 'Chi nhánh chưa được điền.',
                                                },
                                                submitHandler: function (form) {
                                                    let url = $(form).attr('action');
                                                    let method = $(form).attr('method');
                                                    let params = $(form).serializeArray();
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
                    <!-- Vi điện tử -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Thông tin ATM</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="wallet" action="{{ asset('admin/setting/save-wallet') }}" method="post">
                                        <div class="form-group">
                                            <label for="wallet_name">Tên Ví điện tử</label>
                                            <input type="text" class="form-control" id="wallet_name" name="wallet_name" placeholder="Tên Ví điện tử" value="{{ isset($config_wallet['wallet_name']) ? $config_wallet['wallet_name'] : '' }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="wallet_tel">Số điện thoại</label>
                                            <input type="text" class="form-control" id="wallet_tel" name="wallet_tel" placeholder="Số điện thoại" value="{{ isset($config_wallet['wallet_tel']) ? $config_wallet['wallet_tel'] : '' }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="wallet_user">Tên chủ tài khoản</label>
                                            <input type="text" class="form-control" id="wallet_user" name="wallet_user" placeholder="Tên chủ tài khoản" value="{{ isset($config_wallet['wallet_user']) ? $config_wallet['wallet_user'] : '' }}" />
                                        </div>

                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#wallet').validate({
                                                rules: {
                                                    wallet_name: 'required',
                                                    wallet_tel: 'required',
                                                    wallet_user: 'required',
                                                },
                                                messages: {
                                                    wallet_name: 'Tên Ví điện tử chưa được điền.',
                                                    wallet_tel: 'Số điện thoại chưa được điền.',
                                                    wallet_user: 'Tên chủ tài khoản chưa được điền.',
                                                },
                                                submitHandler: function (form) {
                                                    let url = $(form).attr('action');
                                                    let method = $(form).attr('method');
                                                    let params = $(form).serializeArray();
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
