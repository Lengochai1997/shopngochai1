<div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label col-form-label-sm">Tên người dùng</label>
    <div class="col-sm-9">
        <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $item->name }}" placeholder="tên người dùng"/>
    </div>
</div>
<div class="form-group row">
    <label for="username" class="col-sm-3 col-form-label col-form-label-sm">Tên đăng nhập</label>
    <div class="col-sm-9">
        <input type="text" class="form-control form-control-sm" id="username" name="username" value="{{ $item->username }}" placeholder="tên đăng nhập"/>
    </div>
</div>
<div class="form-group row">
    <label for="email" class="col-sm-3 col-form-label col-form-label-sm">Email</label>
    <div class="col-sm-9">
        <input type="text" class="form-control form-control-sm" id="email" name="email" value="{{ $item->email }}" placeholder="email"/>
    </div>
</div>
<div class="form-group row">
    <label for="tel" class="col-sm-3 col-form-label col-form-label-sm">Số điện thoại</label>
    <div class="col-sm-9">
        <input type="text" class="form-control form-control-sm" id="tel" name="tel" value="{{ $item->tel }}" placeholder="số điện thoại"/>
    </div>
</div>
@if(isset($mode) && $mode === 'edit')
<div class="form-group row">
    <label for="total_money" class="col-sm-3 col-form-label col-form-label-sm">Tổng tiền</label>
    <div class="col-sm-9">
        <input type="number" class="form-control form-control-sm" id="total_money" name="total_money" value="{{ $item->total_money }}" placeholder="Tổng tiền"/>
    </div>
</div>
<div class="form-group row">
    <label for="kimcuong" class="col-sm-3 col-form-label col-form-label-sm">Kim cương</label>
    <div class="col-sm-9">
        <input type="number" class="form-control form-control-sm" id="kimcuong" name="kimcuong" value="{{ isset($wallet->kimcuong) ? $wallet->kimcuong : 0 }}" placeholder="Kim cương"/>
    </div>
</div>
<div class="form-group row">
    <label for="quanhuy" class="col-sm-3 col-form-label col-form-label-sm">Quân huy</label>
    <div class="col-sm-9">
        <input type="number" class="form-control form-control-sm" id="quanhuy" name="quanhuy" value="{{ isset($wallet->quanhuy) ? $wallet->quanhuy : 0 }}" placeholder="Quân huy"/>
    </div>
</div>
@endif

<div class="row">
    <div class="col-sm-3">
    </div>
    <div class="col-sm-9">
        <div class="form-group form-check">
            <input type="hidden" class="form-check-input" name="is_admin" value="0">
            <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" {{ isset($item->is_admin) && intval($item->is_admin) === 1 ? "checked" : "" }}>
            <label class="form-check-label" for="is_admin">Admin</label>
        </div>
    </div>
</div>
