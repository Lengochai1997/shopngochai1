<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Chỉnh sửa backgound</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <form id="config-slider" action="{!! asset('admin/setting/config-background') !!}" method="post">
            @method('post')
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="upload_image_2">Upload ảnh slider</label>
                        <div id="upload_image_2" action="" class="dropzone">
                            <div class="fallback">
                                <input name="file" type="file"/>
                            </div>
                            <div class="dz-message">
                                Click để tải file hoặc kéo thả ảnh vào đây !!
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div id="background">
                        <input type="hidden" name="background" value="{{ $background }}" />
                        <img src="{{ $background }}" alt="{{ $background }}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cấu hình</button>
            </div>
        </form>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#upload_image_2").dropzone({
                    url: '{!! asset('admin/upload/image') !!}',
                    method: 'post',
                    parallelUploads: 3,
                    sending: function (file, xhr, formData) {
                        formData.append('_token', '{!! csrf_token() !!}');
                    },
                    success: function (file, res) {
                        if (res.status == 'success') {
                            let url = res.url;
                            $('#background input').val(url);
                            $('#background img').attr('src', url);
                            $('#background img').attr('alt', url);
                        }
                    }
                });
            });

        </script>
    </div>
</div>
