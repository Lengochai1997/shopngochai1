<div class="col-md-4"></div>
<div class="col-sm-12 col-md-4">
    <div class="form-group">
        <label for="">Background</label>
        <img src="{{ isset($item->background) ? $item->background : 'https://via.placeholder.com/500x400' }}" id="view-background" alt="Backgound" />
        <input type="hidden" id="background" name="background" value="{{ isset($item->background) ? $item->background : 'https://via.placeholder.com/500x400' }}">
    </div>
</div>
<div class="col-sm-12 col-md-4">
    <div id="upload_background" class="dropzone">
        <div class="fallback">
            <input name="file" type="file"/>
        </div>
        <div class="dz-message">
            Click để tải file hoặc kéo thả ảnh bìa vào đây !!
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#upload_background").dropzone({
                url: '{!! asset('admin/upload/image') !!}',
                method: 'post',
                parallelUploads: 1,
                sending: function (file, xhr, formData) {
                    formData.append('_token', '{!! csrf_token() !!}');
                },
                success: function (file, res) {
                    if (res.status == 'success') {
                        updateBackground(res.url);
                    }
                }
            });
        });
        function updateBackground(url) {
            $('#view-background').attr('src', url);
            $('#background').val(url);
        }
    </script>
</div>
