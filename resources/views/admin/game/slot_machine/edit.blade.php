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
                                    <h6 class="m-0 font-weight-bold text-primary">Thêm game Máy xèng {{ ucfirst($model) }}</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form id="create-data" action="{{ asset('admin/slot-machine/slot-machine/'.$item->id) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('put')
                                                <input type="hidden" name="model" value="{{ $model }}">
                                                @include('admin.game.slot_machine.partials.entry_'.$model, ['mode' => 'edit'])
                                                <div class="form-group row">
                                                    <div class="col-sm-12 text-center">
                                                        <button type="submit" class="btn btn-primary button-config">Sửa game Máy xèng</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('#create-data').validate({
                                                        rules: {
                                                            type: 'required',
                                                            title: 'required',
                                                            price: 'required',
                                                            url: 'required',
                                                            status: 'required',
                                                        },
                                                        messages: {
                                                            type: 'Loại coin chưa được chọn',
                                                            title: 'Tiêu đề chưa được nhập.',
                                                            price: 'Giá chưa được nhập',
                                                            url: 'Url chưa được nhập',
                                                            status: 'Trạng thái chưa được chọn'
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

