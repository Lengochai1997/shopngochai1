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
                        <div class="col-sm-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Sửa thông tin Tài khoản {{ $account->username }}</h6>
                                </div>
                                <div class="card-body">
                                    <form id="create-data" method="post" action="{{ asset('admin/spin/account/'.$account->id) }}">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="type_id">Thuộc tính</label>
                                            <select class="form-control" id="type_id" name="type_id">
                                                @foreach($properties as $key => $property)
                                                    <option value="{{ $key }}">{{ $property }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Tài khoản</label>
                                            <input type="text" class="form-control" id="username" name="username" placeholder="Tài khoản" value="{{ $account->username }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Mật khẩu</label>
                                            <input type="text" class="form-control" id="password" name="password" placeholder="Mật khẩu" value="{{ $account->password }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Trạng thái</label>
                                            <select class="form-control" id="status" name="status">
                                                @foreach(config('spin.status_account') as $key => $status)
                                                    <option value="{{ $key }}" {{ $account->status === $key ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary">Sửa Tài khoản</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#create-data').validate({
                                                rules: {
                                                    type_id: 'required',
                                                    username: 'required',
                                                    password: 'required'
                                                },
                                                messages: {
                                                    type_id: 'Thuộc tính chưa được chọn.',
                                                    username: 'Tài khoản không được bỏ trống.',
                                                    password: 'Mật khẩu không được bỏ trống.'
                                                },

                                            })
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
