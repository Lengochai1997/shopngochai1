<!-- count hero -->
<div class="col-sm-6 col-md-3">
    <div class="form-group row">
        <label for="count_hero" class="col-sm-4 col-form-label col-form-label-sm">Số tướng</label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="count_hero" name="count_hero" placeholder="Số tướng" value="{{ $item['count_hero'] }}">
        </div>
    </div>
</div>
<!-- rank -->
<div class="col-sm-6 col-md-3">
    <div class="form-group row">
        <label for="count_skin" class="col-sm-5 col-form-label col-form-label-sm">Số trang phục</label>
        <div class="col-sm-7">
            <input type="number" class="form-control form-control-sm" id="count_skin" name="count_skin" placeholder="Số trang phục" value="{{ $item['count_skin'] }}">
        </div>
    </div>
</div>
<!-- gem level -->
<div class="col-sm-6 col-md-3">
    <div class="form-group row">
        <label for="gem_level" class="col-sm-4 col-form-label col-form-label-sm">Bậc ngọc</label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="gem_level" name="gem_level" placeholder="Bậc ngọc" value="{{ $item['gem_level'] }}">
        </div>
    </div>
</div>
<!-- rank -->
<div class="col-sm-6 col-md-3">
    <div class="form-group row">
        <label for="rank" class="col-sm-3 col-form-label col-form-label-sm">Hạng</label>
        <div class="col-sm-9">
            <select class="form-control form-control-sm" id="rank" name="rank">
                <option disabled selected>Chọn hạng</option>
                @foreach(config('account')['arena_valor']['rank'] as $key => $value)
                    <option value="{{ $key }}" {{ ($mode === 'edit' && $key == $item['rank']) ? "selected" : "" }}>{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
