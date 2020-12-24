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
                                    <h6 class="m-0 font-weight-bold text-primary">Sửa Lịch sử ảo</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form id="create-data" action="{{ asset('admin/virtual-history/virtual-history/'.$item->id) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                @include('admin.virtual_history.virtual.partials.entry', ['mode' => 'edit'])
                                                <div class="form-group row">
                                                    <div class="col-sm-12 text-center">
                                                        <button type="submit" class="btn btn-primary button-config">Sửa</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('#create-data').validate({
                                                        rules: {
                                                            type: 'required',
                                                            ref_id: 'required',
                                                            name: 'required',
                                                            result: 'required',
                                                            time: 'required',
                                                        },
                                                        messages: {
                                                            type: 'Loại coin chưa được chọn',
                                                            ref_id: 'Vòng quay chưa được chọn',
                                                            name: 'Người quay chưa được nhập',
                                                            result: 'Kết quả chưa được nhập',
                                                            time: 'Thời gian chưa được nhập',
                                                        },
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection

