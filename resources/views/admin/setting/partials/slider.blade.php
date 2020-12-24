<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Thêm hình ảnh Slide</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body">
        <form id="config-slider" action="{!! asset('admin/setting/config-slider') !!}" method="post">
            @method('post')
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="upload_image_1">Upload ảnh slider</label>
                        <div id="upload_image_1" action="" class="dropzone">
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
                    <div id="list-slider">
                        @if(is_array($slider))
                            @foreach($slider as $s)
                                <div class="_1slider">
                                    <input type="hidden" name="slider[]" value="{{ $s }}" />
                                    <img src="{{ $s }}" alt="{{ $s }}" />
                                    <button type="button" class="btn btn-danger" onclick="deleteSlider(this);">
                                        <i class="fas fa-trash"></i>
                                        Xóa
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Cấu hình</button>
            </div>
        </form>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#upload_image_1").dropzone({
                    url: '{!! asset('admin/upload/image') !!}',
                    method: 'post',
                    parallelUploads: 3,
                    sending: function (file, xhr, formData) {
                        formData.append('_token', '{!! csrf_token() !!}');
                    },
                    success: function (file, res) {
                        if (res.status == 'success') {
                            $('#list-slider').append(createDomSlider(res.url));
                        }
                    }
                });
            });
            function createDomSlider(url) {
                return `
                    <div class="_1slider">
                        <input type="hidden" name="slider[]" value="${url}" />
                        <img src="${url}" alt="${url}" />
                        <button type="button" class="btn btn-danger" onclick="deleteSlider(this);">
                            <i class="fas fa-trash"></i>
                            Xóa
                        </button>
                    </div>
                `;
            }

            function deleteSlider(elem) {
                $(elem).parents('._1slider').remove();
            }
        </script>
    </div>
</div>
