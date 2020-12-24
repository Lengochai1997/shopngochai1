<div class="form-group row">
    <label for="category_id" class="col-sm-3 col-form-label col-form-label-sm">Danh mục</label>
    <div class="col-sm-9">
        <select class="form-control form-control-sm" id="category_id" name="category_id">
            <option disabled selected>Chọn danh mục</option>
            <option value="0">Khác</option>
            @foreach($categories as $key => $value)
                <option value="{{ $key }}" {{ ($mode === 'edit' && $key == $item['category_id']) ? "selected" : "" }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>
<input type="hidden" id="type_id" name="type_id" value="{{ $type }}">
<hr>
@include('admin.account.partials.thumbnail')
<hr>
<div id="account">
    <div id="info-general" class="info-general row">
        <div class="col-sm-12 col-md-4">
            <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label col-form-label-sm">Tài khoản</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Tài khoản" value="{{ $item['username'] }}">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label col-form-label-sm">Mật khẩu</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="password" name="password" placeholder="Mật khẩu" value="{{ $item['password'] }}">
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group row">
                <label for="price" class="col-sm-3 col-form-label col-form-label-sm">Giá tiền</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control form-control-sm" id="price" name="price" placeholder="Giá tiền" value="{{ $item['price'] }}">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <!-- begin: info-account -->
    <div id="info-account" class="info-account row">
        @include('admin.account.types.'.$type, [
            'item' => $item,
            'mode' => $mode
        ])
    </div>
    <!-- end: info-account -->
    <hr>
    @include('admin.account.partials.images')
</div>
<hr>
<div class="form-group row">
    <label for="description" class="col-sm-3 col-form-label col-form-label-sm">Ghi chú</label>
    <div class="col-sm-9">
        <textarea class="form-control form-control-sm text-editor" name="description" id="description" rows="3" placeholder="Mô tả">
            {!! $item['description'] !!}
        </textarea>
    </div>
</div>
