<div class="c-layout-sidebar-menu c-theme ">
    <div class="row">
        <div class="col-md-12 col-sm-6 col-xs-6 m-t-15 m-b-20">
            <div class="c-content-title-3 c-title-md c-theme-border">
                <h3 class="c-left c-font-uppercase">Menu tài khoản</h3>
                <div class="c-line c-dot c-dot-left "></div>
            </div>
            <div class="c-content-ver-nav">
                <ul class="c-menu c-arrow-dot c-square c-theme">
                    <li><a href="{{ asset('user/profile') }}" class="{{ $active === 1 ? 'active' : '' }}">Thông tin tài khoản</a></li>
                    <li><a href="{{ asset('user/change-password') }}" class="{{ $active === 2 ? 'active' : '' }}">Đổi mật khẩu</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-12 col-sm-6 col-xs-6 m-t-15">
            <div class="c-content-title-3 c-title-md c-theme-border">
                <h3 class="c-left c-font-uppercase">Menu giao dịch</h3>
                <div class="c-line c-dot c-dot-left "></div>
            </div>
            <div class="c-content-ver-nav m-b-20">
                <ul class="c-menu c-arrow-dot c-square c-theme">
                    <li><a href="{{ asset('user/nap-the') }}" class="{{ $active === 4 ? 'active' : '' }}">Nạp tự động</a></li>
                    <li><a href="{{ asset('user/the-da-nap') }}" class="{{ $active === 5 ? 'active' : '' }}">Thẻ cào đã nạp</a></li>
                    <li><a href="{{ asset('user/nap-atm') }}" class="{{ $active === 6 ? 'active' : '' }}">Nạp tiền từ ATM/Ví</a></li>
                    <li><a href="{{ asset('user/rut-kim-cuong') }}" class="{{ $active === 10 ? 'active' : '' }}">Rút Kim cương</a></li>
                    <li><a href="{{ asset('user/rut-quan-huy') }}" class="{{ $active === 11 ? 'active' : '' }}">Rút Quân huy</a></li>
                    <li><a href="{{ asset('user/tai-khoan-da-mua') }}" class="{{ $active === 7 ? 'active' : '' }}">Tài khoản đã mua</a></li>
                    <li><a href="{{ asset('user/tai-khoan-vong-quay') }}" class="{{ $active === 8 ? 'active' : '' }}">Tài khoản vòng quay</a></li>
                    <li><a href="{{ asset('user/tai-khoan-random') }}" class="{{ $active === 9 ? 'active' : '' }}">Tài khoản Random</a></li>
                    <li><a href="{{ asset('user/mo-hom') }}" class="{{ $active === 12 ? 'active' : '' }}">Hòm quà đã mở</a></li>
                    <li><a href="{{ asset('user/quay-xeng') }}" class="{{ $active === 13 ? 'active' : '' }}">Lịch sử Quay xèng</a></li>
                    <li><a href="{{ asset('user/lat-the-bai') }}" class="{{ $active === 14 ? 'active' : '' }}">Lịch sử Lật thẻ bài</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
