<!-- begin: rank -->
<div class="col-sm-6 col-md-3">
    <div class="form-group row">
        <label for="rank" class="col-sm-4 col-form-label col-form-label-sm">Rank</label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="rank" name="rank" placeholder="Rank" value="{{ $item['rank'] }}" />
        </div>
    </div>
</div>
<!-- end: rank -->

<!-- begin: pet -->
<div class="col-sm-6 col-md-3">
    <div class="form-group row">
        <label for="pet" class="col-sm-4 col-form-label col-form-label-sm">Pet</label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="pet" name="pet" placeholder="Pet" value="{{ $item['pet'] }}" />
        </div>
    </div>
</div>
<!-- end: pet -->

<!-- begin: code -->
<div class="col-sm-6 col-md-3">
    <div class="form-group row">
        <label for="code" class="col-sm-4 col-form-label col-form-label-sm">Code</label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="code" name="code" placeholder="Code" value="{{ isset($item['code']) ? $item['code'] : '' }}" />
        </div>
    </div>
</div>
<!-- end: code -->

<!-- begin: register -->
<div class="col-sm-6 col-md-3">
    <div class="form-group row">
        <label for="register" class="col-sm-4 col-form-label col-form-label-sm">Đăng ký</label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="register" name="register" placeholder="Đăng ký" value="{{ $item['register'] }}" />
        </div>
    </div>
</div>
<!-- end: register -->

