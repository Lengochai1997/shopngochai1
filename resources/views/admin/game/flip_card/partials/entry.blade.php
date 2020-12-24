<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="type">Loại</label>
            <select class="form-control" id="type" name="type">
                <option selected disabled>Chọn loại</option>
                @foreach(config('coin.type') as $key => $value)
                    <option value="{{ $key }}" @if($key == $item->type) () selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @include('admin.game.slot_machine.partials.image')
</div>
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label for="title">Tiêu đề</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Tiêu đề" value="{{ isset($item->title) ? $item->title : '' }}">
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
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label for="url">Url</label>
            <input type="text" class="form-control" name="url" id="url" placeholder="Url" value="{{ isset($item->url) ? $item->url : '' }}">
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="status">Trạng thái</label>
            <select class="form-control" id="status" name="status">
                @foreach(config('slot_machine.status') as $key => $status)
                    <option value="{{ $key }}" {{ isset($item->status) && $item->status === $key ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
@include('admin.game.slot_machine.partials.slots')
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="rules">Luật chơi</label>
            <textarea class="form-control text-editor" id="rules" name="rules" rows="3" placeholder="Luật chơi">{!! isset($item->rules) ? $item->rules : '' !!}</textarea>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control text-editor" id="description" name="description" rows="3" placeholder="Mô tả">{!! isset($item->description) ? $item->description : '' !!}</textarea>
        </div>
    </div>
</div>
