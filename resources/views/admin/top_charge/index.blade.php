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
                                    <h6 class="m-0 font-weight-bold text-primary">Thay đổi Top nạp thẻ</h6>
                                    <button class="btn btn-success" onclick="resetTop();">Reset top</button>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Tài khoản</th>
                                            <th scope="col">Số tiền nạp</th>
                                            <th scope="col">Lưu</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topCharges as $topCharge)
                                            <tr data-id="{{ $topCharge->id }}">
                                                <th scope="row">{{ $topCharge->id }}</th>
                                                <td>
                                                    <div class="form-group">
                                                        <select name="user_id" id="user_{{ $topCharge->id }}" class="form-control">
                                                            @foreach($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name ? $user->name : $user->username }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" id="total_{{ $topCharge->id }}" name="total" placeholder="Số tiền" value="{{ $topCharge->total }}"/>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success" onclick="saveTopCharge(this);">Lưu</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <script type="text/javascript">
                                        function saveTopCharge(elem) {
                                            let id = $(elem).parents('tr').attr('data-id');
                                            let user_id = $(elem).parents('tr').find('select[name=user_id]').val();
                                            let total = $(elem).parents('tr').find('input[name=total]').val();
                                            let formData = new FormData();
                                            formData.append('id', id);
                                            formData.append('user_id', user_id);
                                            formData.append('total', total);
                                            callAjax('{!! asset('admin/top-charge/save') !!}', 'POST', formData).then(res => {
                                                swal.fire({
                                                    'icon': 'success',
                                                    'title': 'Thành công',
                                                    'text': res.message
                                                });
                                            });
                                        }

                                        function resetTop() {
                                            callAjax('{!! asset('admin/top-charge/reset') !!}').then(res => {
                                                swal.fire({
                                                    'icon': 'success',
                                                    'title': 'Thành công',
                                                    'text': res.message
                                                });
                                            })
                                        }
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
