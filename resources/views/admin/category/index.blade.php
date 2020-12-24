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
                                    <h6 class="m-0 font-weight-bold text-primary">danh sách danh mục game</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div>
                                        <table class="table pb-3">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">tiêu đề</th>
                                                <th scope="col">tổng tài khoản</th>
                                                <th scope="col">đã bán</th>
                                                <th scope="col">chức năng</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($categories as $category)
                                                <tr>
                                                    <td>{{ $category->id }}</td>
                                                    <td>{{ $category->title }}</td>
                                                    <td>{{ $category->count_account }}</td>
                                                    <td>{{ $category->count_sold }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button class="btn btn-primary">
                                                                <a href="{{ asset('admin/category/category/'.$category->id.'/edit') }}" style="color: white;">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </a>
                                                            </button>
                                                            <button class="btn btn-danger" data-id="{{ $category->id }}" onclick="deleteCategory(this);">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        {{ $categories->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <script type="text/javascript">
                function deleteCategory(elem) {
                    let id = $(elem).attr('data-id');
                    swal.fire({
                        'icon': 'question',
                        'title': 'Bạn có chắc chắn muốn xóa ?',
                        'text': 'Nhấn Đồng ý để xóa',
                        'showCancelButton': true,
                        'confirmButtonText': 'Đống ý',
                        'cancelButtonText': 'Hủy'
                    }).then(function () {
                        callAjax('{!! asset('admin/category/category') !!}/'+id, 'DELETE').then(res => {
                            swal.fire({
                                'icon': 'success',
                                'title': 'Xóa thành công',
                                'text': 'Nhẫn OK để tải lại danh sách'
                            }).then(function () {
                                window.location.href = '{!! asset('admin/category/category') !!}';
                            });
                        });
                    });
                }
            </script>
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
