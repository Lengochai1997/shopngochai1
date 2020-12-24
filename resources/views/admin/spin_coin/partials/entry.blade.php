@if(isset($mode) && $mode === 'create')
    <input type="hidden" name="type" value="{{ $type }}" />
@endif
@if(isset($mode) && $mode === 'edit')
    <input type="hidden" name="type" value="{{ $item->type }}" />
@endif
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="title">Tiêu đề vòng quay</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Tiêu đề vòng quay" value="{{ isset($item->title) ? $item->title : '' }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="thumbnail">Ảnh thu nhỏ</label>
            <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        @if(isset($mode) && $mode === 'edit')
            <img class="img-responsive" src="{{ asset($item->thumbnail) }}" alt="{{ $item->thumbnail }}">
        @endif
    </div>
</div>
@for($i = 1; $i <= 8; $i++)
    <div class="row">
        <div class="col-sm-9">
            <div class="form-group">
                <label for="key_{{ $i }}">Số quân huy {{ $i }}</label>
                <input type="number" class="form-control" name="key_{{ $i }}" id="key_{{ $i }}" placeholder="Số quân huy {{ $i }}" value="{{ isset($item->properties[$i]) ? $item->properties[$i] : '' }}">
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="ratio_{{ $i }}">Tỉ lệ {{ $i }} (Góc {{ 45*$i }})</label>
                <input type="number" class="form-control" name="ratio_{{ $i }}" id="ratio_{{ $i }}" placeholder="Tỉ lệ {{ $i }}" value="{{ isset($item->ratio[$i]) ? $item->ratio[$i] : 0 }}">
            </div>
        </div>
    </div>
@endfor
<div class="row">
    <div class="col-md-3">
        @if(isset($mode) && $mode === 'create')
            <div class="form-group">
                <label for="image">Ảnh vòng quay</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
        @endif
        @if(isset($mode) && $mode === 'edit')
            <img class="img-responsive" src="{{ asset($item->image) }}" alt="{{ $item->image }}">
            <div class="form-group">
                <label for="image">Ảnh vòng quay</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
        @endif
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="total">Nổ hũ</label>
            <input type="number" class="form-control" id="total" name="total" placeholder="Nổ hũ" value="{{ isset($item->total) ? $item->total : '' }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="price">Giá quay</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Giá quay" value="{{ isset($item->price) ? $item->price : '' }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                @foreach(config('spin.status') as $key => $status)
                    <option value="{{ $key }}" {{ isset($item->status) && $item->status === $key ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="pro_total">Nổ hũ</label>
            <select class="form-control" id="pro_total" name="pro_total">
                <option value="0" selected>Không có</option>
                @for($i = 0; $i <= 8; $i++)
                    <option value="{{ $i }}" {{ (isset($item->pro_total) && intval($item->pro_total) === $i) ? 'selected' : '' }}>Thuộc tính {{ $i }}</option>
                @endfor
            </select>
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

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="description">Luật chơi</label>
            <textarea class="form-control text-editor" id="rules" name="rules" rows="3" placeholder="Mô tả">{{ isset($item->rules) ? $item->rules : '' }}</textarea>
        </div>
    </div>
</div>
