<div class="box-body" style="color: #505050;padding:0px;min-height: 0px;line-height: 2;">
    <form id="charge-fast" action="{{ asset('user/do-charge') }}" method="POST">
        @csrf
        @method('post')
        <div class="form-group">
            <select name="payment_id" id="payment_id" class="form-control c-square c-theme">
                <option value="" disabled selected>Chọn loại thẻ</option>
                @foreach($payments as $payment)
                    <option value="{{ $payment['id'] }}">{{ $payment['title'] }} - ({{ config('payment.type')[$payment['type_id']] }}) - ({{ config('payment.gate')[$payment['gate_id']] }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <select class="form-control c-square c-theme" id="amount" name="amount">
                <option value="" disabled selected>Chọn mệnh giá thẻ</option>
                @foreach(config('payment.amount') as $key => $amount)
                    <option value="{{ $key }}">{{ $amount }} - 100%</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input class="form-control c-square c-theme" type="number" id="serial" name="serial" placeholder="Nhập số serial">
        </div>
        <div class="form-group">
            <input class="form-control c-square c-theme" type="number" id="pin" name="pin" placeholder="Nhập mã thẻ">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-submit c-theme-btn c-btn-square c-btn-uppercase c-btn-bold btn-block" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Nạp thẻ</button>
        </div>
    </form>
    <script type="text/javascript" src="/admin_asset/vendor/jquery-validate/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#charge-fast').validate({
                rules: {
                    payment_id: 'required',
                    amount: 'required',
                    serial: {
                        required: true,
                        minlength: 10,
                        maxlength: 18,
                    },
                    pin: {
                        required: true,
                        minlength: 10,
                        maxlength: 18,
                    },
                },
                messages: {
                    payment_id: 'Loại thẻ chưa được chọn.',
                    amount: 'Mệnh giá chưa được chọn.',
                    serial: {
                        required: 'Số serial chưa được nhập.',
                        minlength: 'Số serial phải từ 10 đến 18 ký tự',
                        maxlength: 'Số serial phải từ 10 đến 18 ký tự',
                    },
                    pin: {
                        required: 'Mã số thẻ chưa được nhập.',
                        minlength: 'Mã số thẻ phải từ 10 đến 18 ký tự',
                        maxlength: 'Mã số thẻ phải từ 10 đến 18 ký tự',
                    },
                },
                submitHandler: function(form) {
                    let url = $(form).attr('action')+'?type=json';
                    let method = $(form).attr('method');
                    let params = $(form).serializeArray();
                    let formData = new FormData();
                    $.each(params, function (i, val) {
                        formData.append(val.name, val.value);
                    });
                    callAjax(url, method, formData).then(res => {
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành Công !',
                                text: res.message || ''
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi !',
                                text: res.message || ''
                            });
                        }
                    });
                    $(form).trigger("reset");
                    return false;
                }
            });
        });
    </script>
</div>
