@extends('layout.index')

@section('title', 'Vòng quay '.$spin->title)

@section('content')
    <div class="c-content-box">
        <div class="c-content-box c-size-md c-bg-white content-dark">
            <div class="container wheel">
                <div class="row">
                    <div class="sl-sebox">
                        <div class="clearfix">
                            <div class="col-sm-12">
                                <h1 class="wheel-title text-center" style="font-size: 33px; text-transform: uppercase;">{{ $spin->title }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row content">
                    <div class="col-sm-12 col-md-7 wheel-spin">
                        <div class="rotation">
                            <div class="play-spin">
                                <a>
                                    <img class="btn-play" src="{{ asset('assets/images/spin/button.png') }}" alt="Xoay" data-id="{{ $spin->id }}" onclick="randomResult(this);">
                                </a>
                                <img id="spin" class="spin" src="{{ asset($spin->image) }}" alt="{{ $spin->title }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <img class="gold" src="{{ asset('assets/images/spin/huvang.png') }}">
                                <h3 class="gold-count">Trong Hũ Có <span>{{ number_format($spin->total) }} đ</span></h3>
                            </div>
                            <div class="col-sm-12 history-gold">
                                <h1 class="history-gold-title">Lịch sử nổ hũ </h1>
                                <div class="sa-ls-table table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>TÊN</th>
                                            <th>SỐ TIỀN</th>
                                            <th>THỜI GIAN</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($spin->history_total) !== 0)
                                            @foreach($spin->history_total as $history)
                                                @if ($loop->index >= 3)
                                                    @break
                                                @endif
                                            <tr>
                                                <td>{{ $history->user->name ? hiddenUsername($history->user->name) : hiddenUsername($history->user->username) }}</td>
                                                <td>{{ number_format($history->total) }}</td>
                                                <td>{{ $history->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">CHƯA CÓ AI NỔ HŨ !</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row history-rules">
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            @if(Auth::check())
                                <li class="nav-item active">
                                    <a class="nav-link" data-toggle="tab" href="#rules">Thể lệ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#history">Phần thường</a>
                                </li>
                            @else
                                <li class="nav-item active">
                                    <a class="nav-link" data-toggle="tab" href="#rules">Thể lệ</a>
                                </li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="rules">
                                {!! $spin->rules !!}
                            </div>
                            <div class="tab-pane container fade" id="history">
                                <table class="table table-dark">
                                    <thead>
                                    <tr>
                                        <td scope="col" style="width: 60px;">UID</td>
                                        <td scope="col">NGƯỜI CHƠI</td>
                                        <td scope="col">PHẦN THƯỞNG</td>
                                        <td scope="col">THỜI GIAN</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($histories) > 0)
                                        @foreach($histories as $history)
                                            <tr>
                                                <td>{{ $history->id }}</td>
                                                <td>{{ $history->user->name ? hiddenUsername($history->user->name) : hiddenUsername($history->user->username) }}</td>
                                                <td>{{ $history->result }}</td>
                                                <td>{{ $history->created_at->format('H:i:s d/m/Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            Không có dữ liệu
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function randomResult(elem) {
            if ($(elem).attr('data-spin') === '1') {
                return false;
            }
            $(elem).attr('data-spin', '1');
            let id = $(elem).attr('data-id');
            callAjax('{!! asset('spin/get-result') !!}/'+id, 'GET', {}, false).then(res => {
                if (res.ratio) {
                    rotate(parseInt(res.ratio), res.message, elem);
                }
                if (res.status === 'not_money') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tài khoản không đủ tiền !',
                        text: 'Vui lòng nạp thêm tiền để quay.',
                        footer: '<a href="{!! asset('user/nap-the') !!}" class="btn btn-success" style="color: white;">Nạp tiền</a>'
                    });
                }
            });
        }
        function rotate(deg = 270, message = '', elem = null) {
            deg = 5400 - deg;
            $({deg: 0}).animate({deg}, {
                duration: 10000,
                easeOutBounce: 'cubic-bezier(0.33, 0.01, 0.5, 1)',
                step: function(now) {
                    $('#spin').css({
                        transform: 'rotate(' + now + 'deg)'
                    });
                },
                done: function () {
                    swal.fire({
                        title: 'Chúc mừng',
                        text: message,
                        icon: 'success',
                        footer: '<a href="{!! asset('user/tai-khoan-vong-quay') !!}" class="btn btn-success" style="color: white;">Xem phần thưởng</a>'
                    });
                    $(elem).removeAttr('data-spin');
                    return false;
                }
            });
        }
    </script>
@endsection

@section('css')
    <style>
        .color{
            color: #000
        }
        .color_1{
            color: red
        }
        .color_2{
            color: #07840d
        }
        .color_3{
            color: #fc9605
        }
    </style>
@endsection

