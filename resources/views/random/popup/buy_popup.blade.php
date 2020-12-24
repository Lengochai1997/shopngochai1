<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">Xác nhận mua {{ $random->title }}</h4>
</div>
<div class="modal-body">
    <table class="table table-striped">
        <tbody>
        <tr>
            <th colspan="2">Xác Nhận mua tài khoản #{{ $account->id }}</th>
        </tr>
        <tr>
            <td>Loại Nick:</td>
            <th class="text-danger">{{ $random->title }}</th>
        </tr>
        <tr>
            <td>Giá tiền:</td>
            <th class="text-info">{{ number_format($random->price) }}đ</th>
        </tr>
        </tbody>
    </table>
    @if(Auth::check())
        @if(Auth::user()->total_money < $random->price)
            <b class="text-primary">Bạn không đủ tiền mua tài khoản này. Bạn hãy click vào Nạp thẻ để nạp tiền.</b>
        @endif
    @else
        <b class="text-danger">Bạn Chưa đăng nhập. Bạn hãy click vào nút Đăng nhập để mua tài khoản.</b>
    @endif
</div>
<div class="modal-footer">
    @if(Auth::check())
        @if(Auth::user()->total_money < $random->price)
            <a class="btn c-bg-green-4 c-font-white c-btn-square c-btn-uppercase c-btn-bold load-modal" href="{{ asset('user/nap-atm') }}">Nạp từ ATM - Ví điện tử</a>
            <a class="btn c-theme-btn c-btn-square c-btn-uppercase c-btn-bold" href="{{ asset('user/nap-the') }}">Nạp thẻ cào</a>
        @else
            <button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-id="{{ $account->id }}" onclick="buyAccount(this);">Quất luôn</button>
        @endif

    @else
        <button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" onclick="window.location.replace('{!! asset('login') !!}')">Đăng nhập</button>
    @endif
    <button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>

<script type="text/javascript">
    function buyAccount(elem) {
        modal.close();
        let id = $(elem).attr('data-id');
        let formData = new FormData();
        formData.append('_token', '{!! csrf_token() !!}');
        formData.append('id', id);
        callAjax('{!! asset('random/buy') !!}', 'POST', formData).then(res => {
            if (res.message && res.status) {
                swal.fire({
                    'icon': 'success',
                    'title': 'Thành Công',
                    'message': res.message
                });
                window.location.href = '{!! asset('user/tai-khoan-random') !!}';
            }
        });
    }
</script>
