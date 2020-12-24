<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="exampleFormControlSelect1">Loại</label>
            <select class="form-control" id="type" name="type">
                <option selected disabled>Chọn loại</option>
                @foreach(config('coin.type') as $key => $value)
                <option value="{{ $key }}" @if($key == $item->type) () selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label for="title">Tiêu đề loại hòm quà random</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Tiêu đề loại hòm quà random" value="{{ isset($item->title) ? $item->title : '' }}">
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="price">Giá quay</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Giá quay" value="{{ isset($item->price) ? $item->price : 0 }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        @if(isset($mode) && $mode === 'edit')
            <img class="img-responsive" src="{{ asset($item->image) }}" alt="{{ $item->image }}" style="width: 100%">
        @endif
        <div class="form-group">
            <label for="thumbnail">Ảnh thu nhỏ</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="count_account">Tổng quà</label>
            <input type="number" class="form-control" id="boxes" name="boxes" placeholder="Tổng quá" value="{{ isset($item->boxes) ? $item->boxes : 0 }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="count_selled">Đã bán</label>
            <input type="number" class="form-control" id="sold" name="sold" placeholder="Đã bán" value="{{ isset($item->sold) ? $item->sold : 0 }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                @foreach(config('gift.status') as $key => $status)
                    <option value="{{ $key }}" {{ isset($item->status) && $item->status === $key ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label for="title">Tỷ lệ trúng</label>
            <input type="text" class="form-control" name="ratio" id="ratio" placeholder="Tỷ lệ trúng" value="{{ isset($item->ratio) ? $item->ratio : '' }}">
        </div>
    </div>
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label for="title">Thể loại</label>
            <input type="text" class="form-control" name="category" id="category" placeholder="Thể loại" value="{{ isset($item->category) ? $item->category : '' }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="alert">Thông báo</label>
            <textarea class="form-control text-editor" id="message" name="message" rows="3" placeholder="Thông báo">{{ isset($item->message) ? $item->message : '' }}</textarea>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control text-editor" id="description" name="description" rows="3" placeholder="Mô tả">{{ isset($item->description) ? $item->description : '' }}</textarea>
        </div>
    </div>
</div>
