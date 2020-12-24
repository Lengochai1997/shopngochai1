<div class="col-sm-12 col-md-4">
    <div class="form-group">
        <label for="">Ảnh bìa</label>
        <img src="{{ isset($item->image) ? $item->image : 'https://via.placeholder.com/500x400' }}" id="view-image" alt="Ảnh bìa" />
        <input type="hidden" id="image" name="image" value="{{ isset($item->image) ? $item->image : 'https://via.placeholder.com/500x400' }}">
    </div>
</div>
<div class="col-sm-12 col-md-4">
    <div id="upload_image" action="" class="dropzone">
        <div class="fallback">
            <input name="file" type="file"/>
        </div>
        <div class="dz-message">
            Click để tải file hoặc kéo thả ảnh bìa vào đây !!
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#upload_image").dropzone({
                url: '{!! asset('admin/upload/image') !!}',
                method: 'post',
                parallelUploads: 1,
                sending: function (file, xhr, formData) {
                    formData.append('_token', '{!! csrf_token() !!}');
                },
                success: function (file, res) {
                    if (res.status == 'success') {
                        updateImage(res.url);
                    }
                }
            });
        });
        function updateImage(url) {
            $('#view-image').attr('src', url);
            $('#image').val(url);
        }
    </script>
</div>
