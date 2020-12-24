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
                                    <h6 class="m-0 font-weight-bold text-primary">Thêm tỉ lệ riêng</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="add-ratio" action="{{ asset('admin/star/star') }}" method="post">
                                        @method('post')
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <input type="hidden" name="type_id" value="{{ $type_id }}">
                                        <div class="form-group">
                                            <label for="ids">ID Người dùng</label>
                                            <input type="text" class="form-control" id="ids" name="ids" placeholder="id|id|id">
                                            <small id="idsHelp" class="form-text text-muted">Định dạng nhập: id|id. VD: 12|34</small>
                                        </div>
                                        @include('admin.star.ratios.'.$type)
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-primary button-config">Thêm Tỉ lệ riêng</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#add-ratio').validate({
                                                rules: {
                                                    ids: 'required',
                                                },
                                                messages: {
                                                    ids: 'ID người dùng chưa được nhập.'
                                                },
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
