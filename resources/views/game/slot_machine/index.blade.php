@extends('layout.index')

@section('title', $item->title)

@section('content')
    <div class="c-layout-page content-dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="slot-machine-title">{{ $item->title }}</h3>
                    <div class="border-bottom-title"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <div class="slot-machine">
                        <div class="slots">
                            <div id="machine_1" class="slot_1">
                                @foreach($item->slots as $slot)
                                    <div><img src="{{ $slot->img }}" alt="{{ $slot->img }}"></div>
                                @endforeach
                            </div>
                            <div id="machine_2" class="slot_3">
                                @foreach($item->slots as $slot)
                                    <div><img src="{{ $slot->img }}" alt="{{ $slot->img }}"></div>
                                @endforeach
                            </div>
                            <div id="machine_3" class="slot_2">
                                @foreach($item->slots as $slot)
                                    <div><img src="{{ $slot->img }}" alt="{{ $slot->img }}"></div>
                                @endforeach
                            </div>
                        </div>
                        <div class="get-result">
                            <img id="get-result" src="https://i.ibb.co/MDq1HQF/963c1736362e.gif" alt="" />
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            const el1 = document.querySelector('#machine_1');
                            const el2 = document.querySelector('#machine_2');
                            const el3 = document.querySelector('#machine_3');
                            const machine1 = new SlotMachine(el1, {
                                active: 0,
                            });
                            const machine2 = new SlotMachine(el2, {
                                active: 1,
                            });
                            const machine3 = new SlotMachine(el3, {
                                active: 2,
                            });
                            $('#get-result').on('click', function () {
                                $.ajax({
                                    method: 'GET',
                                    url: '{!! asset('slot-machine/result/'.$item->id) !!}',
                                    dataType: 'json',
                                    data: {},
                                    beforeSend: function () {
                                        showLoading();
                                    },
                                    success: function (res) {
                                        if (res.status == 'success') {
                                            let result = res.result;
                                            machine1.randomize = () => result[0];
                                            machine2.randomize = () => result[1];
                                            machine3.randomize = () => result[2];

                                            machine1.shuffle(999);
                                            setTimeout(() => {
                                                machine2.shuffle(999);
                                            }, 500);
                                            setTimeout(() => {
                                                machine3.shuffle(999);
                                            }, 1000);

                                            setTimeout(() => {
                                                machine1.stop();
                                            }, 1300);
                                            setTimeout(() => {

                                                machine2.stop();
                                            }, 1600);
                                            setTimeout(() => {
                                                machine3.stop();
                                            }, 1900);
                                            setTimeout(() => {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Chúc mừng bạn !',
                                                    text: res.message,
                                                });
                                            }, 2000);
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

                                return false;
                            });
                        });
                    </script>
                </div>
                <div class="col-sm-12 col-md-4 slot-machine-info">
                    <p class="slot-machine-price">Giá: {{ $item->price }} đ / 1 lượt chơi</p>
                    <div class="buttons">
                        <button class="button-action" onclick="rule();">Thể lệ</button>
                        <button class="button-action" onclick="history();">Lượt quay gần đây</button>
                        <button class="button-action" data-url="{{ $item->type == 'kimcuong' ? asset('user/rut-kim-cuong') : asset('user/rut-quan-huy') }}" onclick="withoutCoin(this);">Rút quà</button>
                        <button class="button-action" onclick="historyUser();">Lịch sử quay</button>
                    </div>
                    <script type="text/javascript">
                        function rule() {
                            modal.open('{!! asset('slot-machine/rule/'.$item->id) !!}');
                        }
                        function history() {
                            modal.open('{!! asset('slot-machine/history/'.$item->id) !!}');
                        }
                        function withoutCoin(elem) {
                            let url = $(elem).data('url');
                            window.location.href = url;
                        }
                        function historyUser() {
                            window.location.href = '{!! asset('user/quay-xeng') !!}';
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
