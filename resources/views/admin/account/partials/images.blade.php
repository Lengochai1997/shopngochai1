<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="upload_image">Upload ảnh</label>
            <div id="upload_image" action="" class="dropzone">
                <div class="fallback">
                    <input name="file" type="file"/>
                </div>
                <div class="dz-message">
                    Click để tải file hoặc kéo thả ảnh vào đây !!
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="list-image">Danh sách ảnh</label>
            <div id="list-image" class="list-image">
                @if(is_array($item['images']) && count($item['images']) > 0)
                @foreach($item['images'] as $image)
                <div class="_1image">
                    <input type="hidden" name="images[]" value="{{ $image }}" />
                    <img src="{{ $image }}" alt="{{ $image }}" />
                    <button type="button" class="btn btn-outline-danger" onclick="deleteImage(this);">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#upload_image").dropzone({
            url: '{!! asset('admin/upload/image') !!}',
            method: 'post',
            parallelUploads: 3,
            sending: function (file, xhr, formData) {
                formData.append('_token', '{!! csrf_token() !!}');
            },
            success: function (file, res) {
                if (res.status == 'success') {
                    $('#list-image').append(createDomImage(res.url));
                }
            }
        });
    });
    function createDomImage(url) {
        return `<div class="_1image">
                    <input type="hidden" name="images[]" value="${url}" />
                    <img src="${url}" alt="${url}" />
                    <button type="button" class="btn btn-outline-danger" onclick="deleteImage(this);">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>`;
    }
    function deleteImage(elem) {
        Swal.fire({
            title: 'Xóa ảnh ?',
            text: "Sẽ tiến hành xóa khi bấm Đồng ý",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.value) {
                $(elem).parents('._1image').remove();
            }
        });
        return false;
    }
</script>
