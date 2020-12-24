<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label for="title">Tiêu đề random</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Tiêu đề random" value="{{ isset($item->title) ? $item->title : '' }}">
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
            <img class="img-responsive" src="{{ asset($item->thumbnail) }}" alt="{{ $item->thumbnail }}">
        @endif
        <div class="form-group">
            <label for="thumbnail">Ảnh thu nhỏ</label>
            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="count_account">Tổng Tài khoản</label>
            <input type="number" class="form-control" id="count_account" name="count_account" placeholder="Tổng Tài khoản" value="{{ isset($item->count_account) ? $item->count_account : 0 }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="count_selled">Đã bán</label>
            <input type="number" class="form-control" id="count_selled" name="count_selled" placeholder="Đã bán" value="{{ isset($item->count_selled) ? $item->count_selled : 0 }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                @foreach(config('random.status') as $key => $status)
                    <option value="{{ $key }}" {{ isset($item->status) && $item->status === $key ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="alert">Thông báo</label>
            <textarea class="form-control text-editor" id="alert" name="alert" rows="3" placeholder="Thông báo">{{ isset($item->alert) ? $item->alert : '' }}</textarea>
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
