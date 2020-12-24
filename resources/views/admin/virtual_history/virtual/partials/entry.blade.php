<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="type">Loại</label>
            <select class="form-control" id="type" name="type" readonly>
                <option selected disabled>Chọn loại</option>
                @foreach(config('history_virtual.type') as $key => $value)
                    <option value="{{ $key }}" @if($key == $type) () selected @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="type">Vòng quay</label>
            <select class="form-control" id="ref_id" name="ref_id" @if($mode == 'edit') readonly @endif>
                <option selected disabled>Chọn vòng quay</option>
                @foreach($spins as $spin)
                    <option value="{{ $spin->id }}" @if($spin['id'] == $item->ref_id) selected @endif>{{ $spin->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="name">Người quay</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Người quay" value="{{ isset($item->name) ? $item->name : '' }}">
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="result">Kết quả</label>
            <input type="text" class="form-control" id="result" name="result" placeholder="Kết quả" value="{{ isset($item->result) ? $item->result : '' }}">
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label for="time">Thời gian</label>
            <input type="text" class="form-control" id="time" name="time" placeholder="Thời gian" value="{{ isset($item->time) ? $item->time : '' }}">
        </div>
    </div>
</div>
