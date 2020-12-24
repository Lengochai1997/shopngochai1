<div class="form-group">
    <label for="exampleFormControlSelect1">Cổng thanh toán</label>
    <select class="form-control" id="gate_id" name="gate_id">
        @foreach(config('payment.gate') as $key => $gate)
            <option value="{{ $key }}">{{ $gate }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleFormControlSelect1">Loại</label>
    <select class="form-control" id="type_id" name="type_id">
        @foreach(config('payment.type') as $key => $type)
            <option value="{{ $key }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="title">Nhà mạng</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="Nhà mạng">
</div>
<div class="form-group">
    <label for="key">Key</label>
    <input type="text" class="form-control" id="key" name="key" placeholder="Key">
</div>
<div class="form-group">
    <label for="key">Tỉ lệ</label>
    <input type="number" class="form-control" id="percent" name="percent" value="100" placeholder="Tỉ lệ">
</div>
<div class="form-group">
    <label for="status">Trạng thái</label>
    <select class="form-control" id="status" name="status">
        @foreach(config('payment.status') as $key => $status)
            <option value="{{ $key }}">{{ $status }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="description">Mô tả</label>
    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
</div>
