@extends('layout.index')

@section('title', 'Lật thẻ bài')

@section('content')
    <div class="c-layout-page content-dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex justify-content-center">
                    <h3 class="slot-machine-title">{{ $item['title'] }}</h3>
                    <div class="border-bottom-title"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="list-card">
                        @foreach($item['slots'] as $slot)
                        <div class="_1card flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <img src="{{ $slot['img'] }}" alt="{{ $slot['img'] }}">
                                </div>
                                <div class="flip-card-back">
                                    <img src="{{ asset('assets/images/flip/card.png') }}" alt="{{ asset('assets/images/flip/card.png') }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="action text-center mb-20">
                        <button type="button" class="btn btn-primary" id="hiddenValue" onclick="hiddenValue(this);">Úp thẻ</button>
                        <button type="button" class="btn btn-primary" id="showValue" onclick="showValue(this);" style="display: none;">Lật thẻ</button>
                        <button type="button" class="btn btn-primary" id="newGame" onclick="newGame(this);" style="display: none;">Chơi tiếp</button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 slot-machine-info">
                    <p class="slot-machine-price">Giá: {{ $item['price'] }} đ / 1 lượt chơi</p>
                    <div class="buttons">
                        <button class="button-action" onclick="rule();">Thể lệ</button>
                        <button class="button-action" data-url="{{ $item['type'] == 'kimcuong' ? asset('user/rut-kim-cuong') : asset('user/rut-quan-huy') }}" onclick="withoutCoin(this);">Rút quà</button>
                        <button class="button-action" onclick="historyUser();">Lịch sử quay</button>
                    </div>
                    <script type="text/javascript">
                        let click = true;
                        let isHidden = false;
                        $(document).ready(function () {
                            $('.list-card ._1card').on('click', async function () {
                                // check clicked;
                                if (click == false || isHidden == false) {
                                    return;
                                }
                                let $card = $(this);
                                // call ajax, get result
                                $.ajax({
                                    method: 'GET',
                                    url: '{!! asset('flip-card/result/'.$item['id']) !!}',
                                    dataType: 'json',
                                    data: {},
                                    beforeSend: function () {
                                        showLoading();
                                    },
                                    success: function (res) {
                                        if (res.status == 'success') {
                                            // show image your chose
                                            $card.find('.flip-card-front').html(`<img src="${res.image}" alt="${res.image}"/>`);
                                            $card.find('.flip-card-inner').css('border-color', '#d62828');
                                            // flip this
                                            $card.find('.flip-card-inner').css({
                                                'transform': 'rotateY(0deg)'
                                            });
                                            // set click => false
                                            click = false;
                                            // append list images
                                            appendImages(res.images);
                                            // show button show image
                                            $('#showValue').show();
                                        }
                                    },
                                    error: function (err) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi !',
                                            text: 'Xin thử lại, '+err.responseJSON.message,
                                        });
                                    },
                                    complete: function () {
                                        hideLoading();
                                    }
                                });
                            });
                        });

                        function hiddenValue(elem) {
                            $('.list-card ._1card').each(function () {
                                $(this).children('.flip-card-inner').css({
                                    'transform': 'rotateY(180deg)'
                                });
                                $(this).find('.flip-card-front').html('');
                            });
                            $(elem).hide();
                            isHidden = true;
                        }

                        function showValue(elem) {
                            $('.list-card ._1card').each(function () {
                                $(this).children('.flip-card-inner').css({
                                    'transform': 'rotateY(0deg)'
                                });
                            });
                            $(elem).hide();
                            $('#newGame').show();
                        }

                        function newGame(elem) {
                            click = true;
                            isHidden = false;
                            $('.list-card ._1card').each(function () {
                                $(this).children('.flip-card-inner').css({
                                    'transform': 'rotateY(0deg)'
                                });
                                $(this).find('.flip-card-inner').css('border-color', 'transparent');
                            });
                            $(elem).hide();
                            $('#hiddenValue').show();
                        }

                        function appendImages(slots) {
                            let i = 0;
                            $('.list-card ._1card').each(function () {
                                let slot = slots[i];
                                if ($(this).find('.flip-card-front').html() == '') {
                                    $(this).find('.flip-card-front').html(`<img src="${slot.img}" alt="${slot.img}"/>`);
                                    i++;
                                }
                            });
                        }

                        function rule() {
                            modal.open('{!! asset('flip-card/rule/'.$item['id']) !!}');
                        }
                        function history() {
                            modal.open('{!! asset('flip-card/history/'.$item['id']) !!}');
                        }
                        function withoutCoin(elem) {
                            let url = $(elem).data('url');
                            window.location.href = url;
                        }
                        function historyUser() {
                            window.location.href = '{!! asset('user/lat-the-bai') !!}';
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .login-box, .register-box {
            width: 400px;
            margin: 7% auto;

            padding: 20px;;
        }
        @media (max-width: 767px){
            .login-box, .register-box {
                width: 100%;
            }

        }
        .login-box-msg, .register-box-msg {
            margin: 0;
            text-align: center;
            padding: 0 20px 20px 20px;
            text-align: center;
            font-size: 20px;;
            font-weight: bold;
        }
        .error {
            color: red;
            font-size: 15px;
        }
        .box-custom{
            border: 1px solid #cccccc;
            padding: 20px;

            color: #666;
        }
    </style>
    <link rel="stylesheet" href="/admin_asset/css/style_slot_machine.css" />
    <link rel="stylesheet" href="/assets/vendor/slot_machine/jquery.slotmachine.min.css" />
@endsection

@section('js')
    <script type="text/javascript" src="/assets/vendor/slot_machine/slotmachine.min.js"></script>
    <script type="text/javascript" src="/assets/vendor/slot_machine/jquery.slotmachine.min.js"></script>
    <script type="text/javascript" src="/admin_asset/vendor/jquery-validate/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@endsection
