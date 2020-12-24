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
                                    <h6 class="m-0 font-weight-bold text-primary">Sửa thông tin random: {{ $item->title }}</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form id="form-data" action="{{ asset('admin/gift-box/gift/'.$item->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        @include('admin.gift_box.partials.entry', ['mode' => 'edit'])
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-primary button-config">Sửa random</button>
                                            </div>
                                        </div>
                                    </form>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $('#form-data').validate({
                                                rules: {
                                                    type: 'required',
                                                    title: 'required',
                                                    price: 'required',
                                                    boxes: 'required',
                                                    sold: 'required',
                                                    ratio: 'required',
                                                    category: 'required',
                                                },
                                                messages: {
                                                    type: 'required',
                                                    title: 'Tiêu đề chưa được nhập.',
                                                    price: 'Giá chưa được nhập',
                                                    image: 'Chưa có ảnh',
                                                    boxes: 'Tổng quà chưa được nhập',
                                                    sold: 'Đã bán chưa được nhập',
                                                    ratio: 'Tỷ lệ chưa được nhập',
                                                    category: 'Thể loại chưa được nhập',
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
            <!-- End of Main Content -->
            @include('admin.layouts.components.footer')
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
@endsection
