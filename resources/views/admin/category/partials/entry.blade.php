<div class="form-group row">
    <label for="title" class="col-sm-3 col-form-label col-form-label-sm">Tiêu đề</label>
    <div class="col-sm-9">
        <input type="text" class="form-control form-control-sm" id="title" name="title" value="{{ $item->title }}" placeholder="tên danh mục"/>
    </div>
</div>
<div class="form-group row">
    <label for="key" class="col-sm-3 col-form-label col-form-label-sm">Đường dẫn</label>
    <div class="col-sm-9">
        <input type="text" class="form-control form-control-sm" id="key" name="key" value="{{ $item->key }}" placeholder="đường dẫn"/>
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-sm-3 col-form-label col-form-label-sm">Mô tả</label>
    <div class="col-sm-9">
        <textarea class="form-control form-control-sm" id="description" name="description" rows="3" placeholder="mô tả">{{ $item->description }}</textarea>
    </div>
</div>

<div class="form-group row">
    <label for="images" class="col-sm-3 col-form-label col-form-label-sm">Ảnh đại diện</label>
    <div class="col-sm-4">
        <input type="file" class="form-control-file form-control-sm" id="images" name="images">
    </div>
    @if(isset($mode) && $mode === 'edit')
        <div class="col-sm-5">
            <img class="img-responsive" src="{{ asset($item->images) }}" alt="{{ $item->images }}">
        </div>
    @endif
</div>
