<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">Thông tin tài khoản #{{ $account->id }}</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td>ID:</td>
                    <th class="text-danger">#{{ $account->id }}</th>
                </tr>
                <tr>
                    <td>Giá tiền:</td>
                    <th class="text-info">{{ number_format($account->price) }} đ</th>
                </tr>
                <tr>
                    <td>Tài khoản:</td>
                    <th class="text-info">
                        <div class="input-group">
                            <input type="text" class="form-control" id="username" value="{{ $account->username ? $account->username : '' }}" readonly>
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button"
                                        data-id="username"
                                        onclick="copyText(this);"
                                >
                                    Copy
                                </button>
                            </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <td>Mật khẩu:</td>
                    <th class="text-info">
                        <div class="input-group">
                            <input type="text" class="form-control" id="password" value="{{ $account->password ? $account->password : '' }}" readonly>
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button"
                                        data-id="password"
                                        onclick="copyText(this);"
                                >
                                    Copy
                                </button>
                            </div>
                        </div>
                    </th>
                </tr>
                @if(isset($data->code) && $data->code != '')
                <tr>
                    <td>Code:</td>
                    <th class="text-info">
                        <div class="input-group">
                            <textarea type="text" class="form-control" id="code" readonly>{{ $data->code }}</textarea>
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button"
                                        data-id="code"
                                        onclick="copyText(this);"
                                >
                                    Copy
                                </button>
                            </div>
                        </div>
                    </th>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>

<script type="text/javascript">
    function buyAccount() {
        modal.close();
        callAjax('{!! asset('account/buy/'.$account->id) !!}').then(res => {
            if (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Mua tài khoản thành công',
                    text: 'Click OK để xem tài khoản, Click Lịch sử để xem thông tin tài khoản và mật khẩu',
                    footer: '<a href="{!! asset('user/tai-khoan-da-mua') !!}" class="btn btn-success" style="color: white;">Lịch sử</a>'
                });
            }
        });
    }
</script>
