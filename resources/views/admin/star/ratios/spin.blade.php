@for($i = 1; $i <= 8; $i++)
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="ratio_{{ $i }}">Tỉ lệ {{ $i }} (Góc {{ 45*$i }})</label>
                <input type="number" class="form-control" name="value[{{ $i }}]" id="ratio_{{ $i }}" placeholder="Tỉ lệ {{ $i }}" value="{{ isset($item['value'][$i]) ? $item['value'][$i] : 0 }}">
            </div>
        </div>
    </div>
@endfor
