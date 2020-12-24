@extends('layout.index')

@section('title', 'Danh sách tài khoản random '.$random->title)

@section('content')
    <div class="c-content-box content-dark">
        <div class="c-content-box c-size-md c-bg-white">
            <div class="container content-gray">
                <div class="c-content-title-4">
                    <h3 class="c-font-uppercase c-center c-font-bold c-line-strike"><span class="c-bg-grey-1">{{ $random->title }}</span></h3>
                    <div class="text-center alert alert-success c-font-20" role="alert">
                        <p><b>Chúc bạn may mắn!</b></p>
                    </div>
                </div>
                <div class="c-margin-t-30"></div>
                <div class="c-margin-t-20"></div>
                <div class="row">
                    @foreach($randomAccounts as $randomAccount)
                    <div class="col-md-3 col-sm-6 c-margin-b-20">
                        <div class="c-content-product-2 c-bg-white">
                            <div class="c-content-overlay">
                                <div class="c-label c-theme-bg c-font-uppercase c-font-white c-font-13 c-font-bold">Acc RanDom</div>
                                @if(isset($random->description) || $random->description != null || $random->description != '')
                                <div class="c-label c-theme-bg c-font-uppercase c-font-white c-font-13 c-font-bold" style="bottom: 0px;width: 100%; text-align: center;margin:0px;">{!! $random->description !!}</div>
                                @endif
                                <div class="c-bg-img-center c-overlay-object" data-height="height" media="(min-width: 768px)" style="height: 230px; background-image: url('{!! asset($random->thumbnail) !!}')"></div>
                            </div>
                            <div class="c-info">
                                <p class="c-title c-font-18 c-font-slim"><span aria-hidden="true" class="icon-question"></span> Tài khoản <span class="c-font-red c-font-uppercase">#{{ $randomAccount->id }}</span></p>
                                <p class="c-price c-font-16 c-font-slim"><span class="icon-rocket"></span> Giá tiền - CARD:
                                    <span class="c-font-16 c-font-red">{{ number_format($random->price) }}đ</span>
                                </p>
                            </div>
                            <div class="btn-group btn-group-justified" role="group">
                                <div class="btn-group c-border-left c-border-top" role="group">
                                    <a class="btn btn-lg c-btn-green c-font-uppercase c-font-bold c-btn-circle  m-t-20 btnCheckAccount" data-url="{{ asset('random/buy/'.$randomAccount->id) }}" onclick="openModalBuy(this)">
                                        <i class="fa fa-cart-arrow-down"></i> Mua ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        {{ $randomAccounts->links() }}
                    </div>
                </div>
                <script type="text/javascript">
                    function openModalBuy(elem) {
                        let url = $(elem).attr('data-url');
                        modal.open(url);
                    }
                </script>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .color{
            color: #000
        }
        .color_1{
            color: red
        }
        .color_2{
            color: #07840d
        }
        .color_3{
            color: #fc9605
        }
        p {
            margin: 0px;
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript">

    </script>
@endsection
