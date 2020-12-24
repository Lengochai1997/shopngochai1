$(document).ready(function () {
    $('#loading').hide();
    $('.text-editor').summernote();
});


const modal = {
    'openModal': function (url) {
        console.log(url);
        $('#adminModal').modal('show');
        showLoading();
        $('#adminModal .modal-content').load(url, function () {
            hideLoading();
        });
    },
    'closeModal': function () {
        $('#adminModal').modal('hide');
    }
}

function showLoading() {
    $('#loading').show();
}

function hideLoading() {
    $('#loading').hide();
}

function callAjax(url, method = 'GET', formData = []) {
    return new Promise(resolve => {
        $.ajax({
            url: url,
            type: method,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                showLoading();
            },
            success: function(res) {
                resolve(res);
            },
            error: function (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi !',
                    text: 'Xin thử lại, '+err.message,
                });
            },
            complete: function () {
                hideLoading();
            }
        });
    })
}
