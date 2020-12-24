<div class="form-group row">
    <div class="col-sm-12 col-md-4 row">
        <label for="thumbnail" class="col-sm-3 col-form-label col-form-label-sm">Ảnh thu nhỏ</label>
    </div>
    <div class="col-sm-12 col-md-4">
        <img id="view-thumbnail" src="{{ $item['thumbnail'] ? $item['thumbnail'] : 'https://via.placeholder.com/700x300' }}" alt="{{ $item['thumbnail'] ? $item['thumbnail'] : 'https://via.placeholder.com/700x300' }}">
        <input type="hidden" class="form-control-file form-control-sm" id="thumbnail" name="thumbnail" value="{{ $item['thumbnail'] ? $item['thumbnail'] : 'https://via.placeholder.com/700x300' }}"/>
    </div>
    <div class="col-sm-12 col-md-4">
        <div id="upload_thumbnail" action="" class="dropzone">
            <div class="fallback">
                <input name="file" type="file"/>
            </div>
            <div class="dz-message">
                Click để tải file hoặc kéo thả ảnh thu nhỏ vào đây !!
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#upload_thumbnail").dropzone({
                    url: '{!! asset('admin/upload/image') !!}',
                    method: 'post',
                    parallelUploads: 1,
                    sending: function (file, xhr, formData) {
                        formData.append('_token', '{!! csrf_token() !!}');
                    },
                    success: function (file, res) {
                        if (res.status == 'success') {
                            updateThumbnail(res.url);
                        }
                    }
                });
            });
            function updateThumbnail(url) {
                $('#view-thumbnail').attr('src', url);
                $('#thumbnail').val(url);
            }
        </script>
    </div>
</div>
