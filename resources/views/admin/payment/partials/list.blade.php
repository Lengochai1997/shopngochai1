<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <ul id="list-payments" class="list-payments">
            <li class="payment">
                <i class="fas fa-arrows-alt"></i>
                <i class="fas fa-trash-alt delete"></i>
                <span class="payment-name">Item 1</span>
            </li>
            <li class="payment">
                <i class="fas fa-arrows-alt"></i>
                <i class="fas fa-trash-alt delete"></i>
                <span class="payment-name">Item 2</span>

            </li>
        </ul>
        <div class="buttons">
            <button class="btn btn-success" onclick="loadListPayment();">Cập nhật</button>
            <button class="btn btn-primary" onclick="savePosition();">Lưu vị trí</button>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    loadListPayment();
});

function loadListPayment() {
    callAjax('{!! asset('admin/payment/list?paymentType='.$paymentType) !!}').then(res => {
        let payments = res.payments;
        if (!payments) {
            return false;
        }
        const status = JSON.parse('{!! json_encode(config('payment.status')) !!}');
        const gate = JSON.parse('{!! json_encode(config('payment.gate')) !!}');
        let dom = '';
        for (let i = 0; i < payments.length; i++) {
            let payment = payments[i];
            dom += `<li class="payment" data-id="${payment.id}" onclick="loadPayment(this);">
                <i class="fas fa-trash-alt delete" data-id="${payment.id}" onclick="deletePayment(this);"></i>
                <i class="fas fa-arrows-alt"></i>
                <span class="payment-name">${payment.title} - ${status[payment.status]} - ${gate[payment.gate_id]}</span>
            </li>`;
        }
        $('#list-payments').html(dom).promise().done(function () {
            $('#list-payments').sortable();
            $('#list-payments').disableSelection();
        });
    });
}

function loadPayment(elem) {
    // check has class active then remove class action
    if ($(elem).hasClass('active')) {
        $(elem).removeClass('active');
        clearForm();
        return false;
    }
    // add class active
    $('.list-payments .payment').each(function () {
        if ($(this).addClass('active')) {
            $(this).removeClass('active');
        }
    });
    $(elem).addClass('active');
    let id = $(elem).attr('data-id');
    callAjax('{!! asset('admin/payment/payment') !!}/'+id+'?type=json').then(res => {
        let payment = res.payment;
        appendToForm(payment);
    });
}

function appendToForm(payment) {
    $('#create-payment #gate_id').val(payment.gate_id);
    $('#create-payment #type_id').val(payment.type_id);
    $('#create-payment #title').val(payment.title);
    $('#create-payment #key').val(payment.key);
    $('#create-payment #status').val(payment.status);
    $('#create-payment #percent').val(payment.percent);
    $('#create-payment #description').val(payment.description);
    $('#title-create-payment').text('Sửa loại thẻ');
    $('#create-payment button[type=submit]').text('Cập nhật');
    $('#create-payment').attr('action', '{!! asset('admin/payment/payment') !!}/'+payment.id+'?type=json');
    $('#create-payment input[name=_method]').val('put');
}

function clearForm() {
    $('#create-payment').trigger("reset");
    $('#title-create-payment').text('Thêm mới loại thẻ');
    $('#create-payment button[type=submit]').text('Thêm mới');
    $('#create-payment').attr('action', '{!! asset('admin/payment/payment') !!}');
    $('#create-payment input[name=_method]').val('post');
}

function deletePayment(elem) {
    let id = $(elem).attr('data-id');
    Swal.fire({
        title: 'Bạn có muốn xóa ?',
        text: "Sẽ tiến hành xóa khi bấm Đồng ý",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.value) {
            callAjax('{!! asset('admin/payment/payment') !!}/'+id+'?type=json', 'DELETE', {'_token': '{!! csrf_token() !!}'}).then(res => {
                let message = res.message;
                $('#list-accounts').DataTable().ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công !',
                    text: message
                });
                clearForm();
                loadListPayment();
            });
        }
    })
}

function savePosition() {
    let order = [];
    $('.list-payments .payment').each(function () {
        order.push($(this).attr('data-id'));
    });
    if (order.length === 0) {
        return false;
    }
    let formData = new FormData();
    formData.append('_token', '{!! csrf_token() !!}');
    formData.append('order', order);
    callAjax('{!! asset('admin/payment/save-position') !!}', 'POST', formData).then(res => {
        if (res.status === 'success' && res.message) {
            Swal.fire({
                icon: 'success',
                title: 'Thành Công !',
                text: res.message
            });
        }
    });
}
</script>
