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
                                    <h6 class="m-0 font-weight-bold text-primary">Sửa thông tin Tài khoản {{ $item->username }}</h6>
                                </div>
                                <div class="card-body">
                                    <form id="create-data" method="post" action="{{ asset('admin/gift-box/box/'.$item->id) }}">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <label for="username">Giá trị</label>
                                            <input type="text" class="form-control" id="value" name="value" placeholder="Giá trị" value="{{ $item->value }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Trạng thái</label>
                                            <select class="form-control" id="status" name="status">
                                                @foreach(config('box.status') as $key => $value)
                                                    <option value="{{ $key }}" {{ $item->status === $key ? 'selected' : '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-primary">Sửa Hòm quà</button>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#create-data').validate({
                                                rules: {
                                                    username: 'required',
                                                    password: 'required'
                                                },
                                                messages: {
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
