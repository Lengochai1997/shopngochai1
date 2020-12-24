<div class="container">
    <div class="c-shop-product-details-4">
        <div class="row">
            <div class="col-md-4 m-b-20">
                <div class="c-product-header">
                    <div class="c-content-title-1">
                        <h3 class="c-font-uppercase c-font-bold">#{{ $account->id }}</h3>
                        <span class="c-font-red c-font-bold">
                            <i class="fa fa-tag"></i>
                            <a href="{{ $config['domain'] }}">{{ $config['domain'] }}</a> - {{ $account->category->title }}
                        </span>
                    </div>
                </div>
            </div>
            @php
                $data = json_decode($account->data);
            @endphp
            <div class="col-md-4">
                <div class="c-product-meta">
                    <div class="c-product-price c-theme-font" style="float: none;text-align: center">
                        {{ number_format(roundPrice($account->price)) }} ATM/TCSR <br>
                        {{ number_format($account->price) }} CARD
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="c-product-header">
                    <div class="c-content-title-1">
                        <a class="btn btn-lg c-btn-green c-font-uppercase c-font-bold c-btn-circle  m-t-20 btnCheckAccount load-modal" onclick="showModalBuyAccount();">
                            <i class="fa fa-cart-arrow-down"></i> Mua ngay
                        </a>
                        <a href="{{ asset('user/nap-atm') }}" class="btn btn-md c-btn-red c-font-uppercase c-font-bold c-btn-circle m-t-20 btnCheckAccount load-modal">
                            <i class="fa fa-university"></i> ATM - Ví điện tử
                        </a>
                        <a href="{{ asset('user/nap-the') }}" class="btn btn-md c-btn-red c-font-uppercase c-font-bold c-btn-border-1x m-t-20">
                            <i class="fa fa-cc-paypal"></i> Nạp thẻ cào
                        </a>
                        <a href="{{ asset('') }}" class="btn btn-md c-btn-green c-font-uppercase c-font-bold c-btn-border-1x m-t-20">
                            <i class="fa fa-home"></i> Trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="c-product-meta">
            <div class="c-content-divider c-icon-bg c-theme-bg">
                <i class="icon-graph c-rounded c-theme-bg c-font-white"></i>
            </div>
            @if($type == 1)
                <div class="row">
                    <div class="col-sm-3 col-xs-6 c-product-variant">
                        <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                            <i class="fa fa-server"></i> Rank : <span class="c-font-red">{{ isset($data->rank) && isset(config('account.arena_valor.rank')[$data->rank]) ? config('account.arena_valor.rank')[$data->rank] : config('account.arena_valor.rank')[1] }}</span>
                        </p>
                    </div>
                    <div class="col-sm-3 col-xs-6 c-product-variant">
                        <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                            <i class="fa fa-drupal"></i> Tướng: <span class="c-font-red">{{ isset($data->count_hero) ? $data->count_hero : 0 }}</span>
                        </p>
                    </div>
                    <div class="col-sm-3 col-xs-6 c-product-variant">
                        <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                            <i class="fa fa-list-alt"></i> Skin : <span class="c-font-red">{{ isset($data->count_skin) ? $data->count_skin : 0 }}</span>
                        </p>
                    </div>
                    <div class="col-sm-3 col-xs-6 c-product-variant">
                        <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                            <i class="fa fa-list-alt"></i> Bậc ngọc : <span class="c-font-red">{{ isset($data->gem_level) ? $data->gem_level : 0 }}</span>
                        </p>
                    </div>
                </div>
            @elseif($type == 2)
                <div class="row">
                    <div class="col-sm-3 col-xs-6 c-product-variant">
                        <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                            <i class="fa fa-server"></i> Rank : <span class="c-font-red">{{ $data->rank }}</span>
                        </p>
                    </div>
                    <div class="col-sm-3 col-xs-6 c-product-variant">
                        <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                            <i class="fa fa-server"></i> Pet : <span class="c-font-red">{{ $data->pet }}</span>
                        </p>
                    </div>
                    <div class="col-sm-3 col-xs-6 c-product-variant">
                        <p class="c-product-meta-label c-product-margin-1 c-font-uppercase c-font-bold">
                            <i class="fa fa-server"></i> Đăng ký : <span class="c-font-red">{{ $data->register }}</span>
                        </p>
                    </div>

                </div>
            @endif
            <div class="c-content-divider c-icon-bg c-theme-bg">
                <i class="icon-graph c-rounded c-theme-bg c-font-white"></i>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function showModalBuyAccount() {
        modal.open('{!! asset('account/check/'.$account->id) !!}');
    }
</script>
