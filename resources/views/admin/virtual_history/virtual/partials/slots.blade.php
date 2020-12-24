<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="image_slot">Ảnh phần thưởng</label>
            <div id="image_slot" action="" class="dropzone">
                <div class="fallback">
                    <input name="file" type="file" multiple/>
                </div>
                <div class="dz-message">
                    Click để tải file hoặc kéo thả file vào đây !!
                </div>
            </div>
            <small id="image_slotHelp" class="form-text text-muted">Chú ý: Phải tải lên đủ 9 ảnh phần thưởng</small>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $("#image_slot").dropzone({
                    url: '{!! asset('admin/upload/image') !!}',
                    method: 'post',
                    parallelUploads: 1,
                    sending: function (file, xhr, formData) {
                        formData.append('_token', '{!! csrf_token() !!}');
                    },
                    success: function (file, res) {
                        if (res.status == 'success') {
                            $('#list-slots').append(createDomSlot(res.url));
                        }
                    }
                });
            });
            function createDomSlot(url) {
                return `<li class="_1slot">
                <img src="${url}" alt="${url}" />
                <input type="hidden" name="slots[]" value="${url}">
                <div class="slot-info">
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input type="text" class="form-control" id="" name="titles[]" value="" />
                    </div>
                    <div class="form-group">
                        <label>Số coin</label>
                        <input type="number" class="form-control" id="" name="coins[]" value="0" />
                    </div>
                    <div class="form-group">
                        <label>Tỉ lệ</label>
                        <input type="number" class="form-control" id="" name="values[]" value="0" />
                    </div>
                </div>
                <div class="action-action">
                    <button type="button" class="btn btn-outline-danger" onclick="remoteSlot(this);">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
            </li>`;
            }
        </script>

    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="list-slots">Danh sách quà</label>
            <ul class="list-slots" id="list-slots">
                @if($mode == 'edit' && count($item->slots) > 0)
                    @foreach($item->slots as $slot)
                        <li class="_1slot">
                            <img src="{{ $slot['img'] }}" alt="{{ $slot['img'] }}" />
                            <input type="hidden" name="slots[]" value="{{ $slot['img'] }}">
                            <div class="slot-info">
                                <div class="form-group">
                                    <label>Tiêu đề</label>
                                    <input type="text" class="form-control" id="" name="titles[]" value="{{ $slot['title'] }}" />
                                </div>
                                <div class="form-group">
                                    <label>Số coin</label>
                                    <input type="number" class="form-control" id="" name="coins[]" value="{{ $slot['coin'] }}" />
                                </div>
                                <div class="form-group">
                                    <label>Tỉ lệ</label>
                                    <input type="number" class="form-control" id="" name="values[]" value="{{ $slot['value'] }}" />
                                </div>
                            </div>
                            <div class="action">
                                <button type="button" class="btn btn-outline-danger" onclick="remoteSlot(this);">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>

        <script type="text/javascript">
            function remoteSlot(elem) {
                Swal.fire({
                    title: 'Xóa ảnh ?',
                    text: "Sẽ tiến hành xóa khi bấm Đồng ý",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Đồng ý',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.value) {
                        $(elem).parents('._1slot').remove();
                    }
                });
                return false;
            }
        </script>
    </div>
</div>
