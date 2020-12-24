<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="list-slots">Danh sách quà</label>
            <ul class="list-slots" id="list-slots">
                @foreach($slots as $slot)
                    <li class="_1slot">
                        <img src="{{ $slot['img'] }}" alt="{{ $slot['img'] }}" />
                        <input type="hidden" name="slots[]" value="{{ $slot['img'] }}">
                        <div class="slot-info">
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <input type="text" class="form-control" value="{{ $slot['title'] }}" disabled/>
                            </div>
                            <div class="form-group">
                                <label>Số coin</label>
                                <input type="number" class="form-control" value="{{ $slot['coin'] }}" disabled/>
                            </div>
                            <div class="form-group">
                                <label>Tỉ lệ</label>
                                <input type="number" class="form-control" name="value[]" value="{{ isset($item['value'][$loop->index]) ? $item['value'][$loop->index] : 0 }}" />
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
