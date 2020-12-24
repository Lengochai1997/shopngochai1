@if($mode == 'create' || $mode == 'edit')
<div class="form-group row">
    <div class="col-sm-12 row">
        <label for="name" class="col-sm-3 col-form-label">Tên</label>
        <div class="form-group col-sm-9">
            <input type="text" class="form-control" id="name" name="name" value="{{ $item['name'] }}"/>
        </div>
    </div>
</div>
@endif
<div class="form-group row">
    <div class="col-sm-12 row">
        <label for="username" class="col-sm-3 col-form-label">Tên đăng nhập</label>
        <div class="form-group col-sm-9">
            <input type="text" class="form-control" id="username" name="username" value="{{ $item['username'] }}" @if($mode == 'edit' || $mode == 'change_pass') disabled @endif/>
        </div>
    </div>
</div>
@if($mode == 'create')
<div class="form-group row">
    <div class="col-sm-12 row">
        <label for="password" class="col-sm-3 col-form-label">Mật khẩu</label>
        <div class="form-group col-sm-9">
            <input type="password" class="form-control" id="password" name="password" />
        </div>
    </div>
</div>
@endif

@if($mode == 'create' || $mode == 'edit')
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-9">
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="is_super" name="is_super" value="1" {{ $item['is_super'] == true ? 'checked' : '' }}>
            <label class="form-check-label" for="is_super">Super Admin</label>
        </div>
    </div>
</div>
@endif

@if($mode == 'change_pass')
<div class="form-group row">
    <div class="col-sm-12 row">
        <label for="password" class="col-sm-3 col-form-label">Mật khẩu</label>
        <div class="form-group col-sm-9">
            <input type="password" class="form-control" id="password" name="password" />
        </div>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-12 row">
        <label for="passwordConfirm" class="col-sm-3 col-form-label">Nhập lại mật khẩu</label>
        <div class="form-group col-sm-9">
            <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" />
        </div>
    </div>
</div>
@endif
<hr>
