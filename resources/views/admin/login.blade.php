@extends('admin.layouts.app')

@section('content')
    <!-- Page Wrapper -->
    <div id="wrapper">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Đăng nhập hệ thống</h1>
                                        </div>
                                        <form class="user" action="{{ asset('admin/login') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="username" name="username" aria-describedby="emailHelp" placeholder="tên đăng nhập">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="mật khẩu">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                        </form>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->
@endsection
