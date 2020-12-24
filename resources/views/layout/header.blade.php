<header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile dark" data-minimize-offset="80">
    <div class="c-navbar">
        <div class="container">
            <!-- BEGIN: BRAND -->
            <div class="c-navbar-wrapper clearfix">
                <div class="c-brand c-pull-left">
                    <a href="{{ asset('') }}" class="c-logo">
                        @if($agent->isMobile())
                            <img width="90" src="{{ $logo }}" alt="" class="c-mobile-logo">
                        @else
                            <img width="200" src="{{ $logo }}" alt="" class="c-desktop-logo-inverse" style="display: block;">
                        @endif
                    </a>
                    @if(Auth::check())
                        <a href="{{ asset('user/profile') }}" class="button-login-xs c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold ">{{ Auth::user()->name ? Auth::user()->name : Auth::user()->username }} - $ {{ number_format(Auth::user()->total_money) }}</a>
                    @else
                        <a href="{{ asset('login') }}" class="button-login-xs c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold "><i class="icon-login"></i> Đăng Nhập</a>
                    @endif
                    <button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                    </button>
                    <button class="c-topbar-toggler" type="button">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                </div>
                <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
                    <ul class="nav navbar-nav c-theme-nav">
                        <li class="c-menu-type-classic">
                            <a class="c-link dropdown-toggle" href="{{ asset('') }}">Trang Chủ</a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a class="c-link dropdown-toggle" href="{{ isset($config['admin_facebook']) ? $config['admin_facebook'] : '' }}">HỖ TRỢ</a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="{{ asset('user/nap-the') }}" class="c-link dropdown-toggle">Nạp Thẻ Tự Động</a>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="{{ asset('user/nap-atm') }}" class="c-link dropdown-toggle">Nạp ATM</a>
                        </li>
                        @if(Auth::check())
                            <!-- logined -->
                            <li>
                                <a href="{{ asset('user/profile') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                    <i class="icon-user"></i> {{ Auth::user()->name ? Auth::user()->name : Auth::user()->username }} - $ {{ number_format(Auth::user()->total_money) }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ asset('logout') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold"><i class="icon-logout"></i> Đăng xuất</a>
                            </li>
                        @else
                            <!-- login -->
                            <li>
                                <a href="{{ asset('login') }}" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold "><i class="icon-login"></i> Đăng Nhập</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
