<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Thêm loại thẻ</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <form id="edit-payment" method="post">
            @include('admin.payment.partials.entry')
            @csrf
            @method('put')
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Thêm</button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#edit-payment').validate({
            rules: {
                title: 'required',
                key: 'required',
                order: 'required',

            },
            messages: {
                title: 'Nhà mạng chưa được nhập',
                key: 'Key chưa được nhập',
                order: 'Vị trí chưa được nhập',
            },
            submitHandler: function(form) {
                let params = $(form).serializeArray();
                let formData = new FormData();
                $.each(params, function (i, val) {
                    formData.append(val.name, val.value);
                });
                callAjax('{!! asset('admin/payment/payment') !!}', 'POST', formData).then(res => {
                    let message = res.message;
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành Công !',
                        text: message
                    });
                    $(form).trigger("reset");
                });
            }
        });
    });
</script>
