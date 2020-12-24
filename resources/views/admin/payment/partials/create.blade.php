<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary" id="title-create-payment">Thêm mới loại thẻ</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <form id="create-payment" method="post" action="{{ asset('admin/payment/payment') }}">
            @include('admin.payment.partials.entry')
            @method('post')
            @csrf
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $('#create-payment').validate({
        rules: {
            key: 'required',
            order: 'required',
            percent: 'required',
        },
        messages: {
            title: 'Nhà mạng chưa được nhập',
            key: 'Key chưa được nhập',
            order: 'Vị trí chưa được nhập',
            percent: 'Tỉ lệ chưa được điền'
        },
        submitHandler: function(form) {
            let action = $(form).attr('action');
            let params = $(form).serializeArray();
            let formData = new FormData();
            $.each(params, function (i, val) {
                formData.append(val.name, val.value);
            });
            callAjax(action, 'POST', formData).then(res => {
                let message = res.message;
                Swal.fire({
                    icon: 'success',
                    title: 'Thành Công !',
                    text: message
                });
                clearForm();
            });
        }
    });
});
</script>
