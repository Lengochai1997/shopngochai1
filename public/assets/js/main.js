$(document).ready(function () {
    $('#loading').hide();
    $('#LoadModal').on('hidden.bs.modal', function () {
        $('#LoadModal .modal-content').html('')
    });
});

const modal = {
    'open': function (url) {
        $('#LoadModal').modal('show');
        showLoading();
        $('#LoadModal .modal-content').load(url, function () {
            hideLoading();
        });
    },
    'close': function () {
        $('#LoadModal').modal('hide');
    }
};

function showLoading() {
    $('#loading').show();
}

function hideLoading() {
    $('#loading').hide();
}

function callAjax(url, method = 'GET', data = [], loading = true) {
    return new Promise(resolve => {
        $.ajax({
            method: method,
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false,
            beforeSend: function () {
                if (loading === true) {
                    showLoading();
                }
            },
            success: function (res) {
                resolve(res);
            },
            error: function (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi !',
                    text: err.responseJSON.message || ''
                });
            },
            complete: function () {
                if (loading === true) {
                    hideLoading();
                }
            }
        });
    });
}

function viewItem(elem) {
    let url = $(elem).data('url');
    modal.open(url);
}

function copyText(elem) {
    let id = $(elem).data('id');
    let copyText = $('#'+id).select();
    copyText.select();
    document.execCommand("copy");
    alert('Đã sao chép');
}
