<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">Xác nhận mua tài khoản #{{ $account->id }}</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
                @if($account->type_id == 1)
                    <tbody>
                        <tr>
                            <td>ID:</td>
                            <th class="text-danger">#{{ isset($account->id) ? $account->id : 0 }}</th>
                        </tr>
                        <tr>
                            <td>Số Tướng:</td>
                            <th class="text-danger">{{ isset($account->data->count_hero) ? $account->data->count_hero : 0 }}</th>
                        </tr>
                        <tr>
                            <td>Skin:</td>
                            <th class="text-danger">{{ isset($account->data->count_skin) ? $account->data->count_skin : 0 }}</th>
                        </tr>
                        <tr>
                            <td>Rank:</td>
                            <th class="text-danger">{{ isset($account->data->rank) && isset(config('account.arena_valor.rank')[$account->data->rank]) ? config('account.arena_valor.rank')[$account->data->rank] : config('account.arena_valor.rank')[1] }}</th>
                        </tr>
                        <tr>
                            <td>Bậc ngọc:</td>
                            <th class="text-danger">{{ isset($account->data->gem_level) ? $account->data->gem_level : 0 }}</th>
                        </tr>
                        <tr>
                            <td>Giá tiền:</td>
                            <th class="text-info">{{ isset($account->price) ? number_format($account->price) : 0 }} đ</th>
                        </tr>
                    </tbody>
                @elseif($account->type_id == 2)
                    <tbody>
                    <tr>
                        <td>ID:</td>
                        <th class="text-danger">#{{ isset($account->id) ? $account->id : 0 }}</th>
                    </tr>
                    <tr>
                        <td>Rank:</td>
                        <th class="text-danger">{{ $account->data->rank ? $account->data->rank : '' }}</th>
                    </tr>
                    <tr>
                        <td>Pet:</td>
                        <th class="text-danger">{{ $account->data->pet ? $account->data->pet : '' }}</th>
                    </tr>
                    <tr>
                        <td>Đăng ký:</td>
                        <th class="text-danger">{{ $account->data->register ? $account->data->register : '' }}</th>
                    </tr>
                    <tr>
                        <td>Giá tiền:</td>
                        <th class="text-info">{{ isset($account->price) ? number_format($account->price) : 0 }} đ</th>
                    </tr>
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            @if(!Auth::check())
                <label class="col-md-12 form-control-label text-danger" style="text-align: center;margin: 10px 0; ">
                    Bạn chưa đăng nhập, hãy đăng nhập để mua tài khoản.
                </label>
            @else
                @if(Auth::user()->total_money < $account->price)
                    <label class="col-md-12 form-control-label text-danger" style="text-align: center;margin: 10px 0; ">
                        Bạn không đủ tiền mua tài khoản này, xin nạp thêm tiền để mua.
                    </label>
                @endif
            @endif
        </div>
    </div>
</div>
<div class="modal-footer">
    @if(Auth::check())
        @if(Auth::user()->total_money < $account->price)
            <a class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold" href="{{ asset('user/nap-the') }}">Nạp thẻ cào</a>
            <a class="btn c-bg-green-4 c-font-white c-btn-square c-btn-uppercase c-btn-bold load-modal" rel="{{ asset('user/nap-atm') }}">Nạp từ ATM - Ví điện tử</a>
        @else
            <button type="submit" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" onclick="buyAccount();">Quất luôn</button>
        @endif
    @else
        <a class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold" href="{{ asset('login') }}" id="d3">Đăng nhập</a>
    @endif
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
