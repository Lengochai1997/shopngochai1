@extends('layout.index')

@section('title', isset($config['title']) ? $config['title'] : 'Trang chủ')

@section('content')
    <div class="c-content-box">
        <div id="slider"
             class="owl-theme section section-cate slideshow_full_width"
             style="background-image: url('@if(isset($background)) {{ $background }} @else {!! asset('assets/images/bg-new.jpg') !!} @endif')!important;"
        >
            @include('home.partial.top_charge')
        </div>
        <div class="c-content-box c-size-md c-bg-white content-dark body1">
            <div class="c-content-box c-size-md c-bg-white">
                <div class="container">
                    <div class="c-content-client-logos-slider-1  c-bordered" data-slider="owl">
                        <!-- Begin: Title 1 component -->
                        <div class="c-content-title-1">
                            <h3 class="c-center c-font-uppercase c-font-bold">Vòng Quay</h3>
                            <div class="c-line-center c-theme-bg"></div>
                        </div>
                        <div class="row row-flex-safari game-list">
                            @foreach($spins as $spin)
                                <div class="col-sm-3 col-xs-6">
                                    <div class="classWithPad">
                                        <div class="news_image">
                                            <a href="{{ asset('vong-quay/'.$spin->id) }}" title="{{ $spin->title }}">
                                                <img src="{{ asset($spin->thumbnail) }}" alt="{{ $spin->title }}">
                                            </a>
                                        </div>
                                        <div class="news_title">
                                            <h2>
                                                <a href="{{ asset('vong-quay/'.$spin->id) }}" title="{{ $spin->title }}">
                                                    <span style="font-size: 17px" width="100">{{ isset($spin->title) ? $spin->title : 'Vòng quay' }}</span>
                                                </a>
                                            </h2>
                                        </div>
                                        <div class="news_description">
										<div class="example1">
												 <span style="color: white; background-color: red; font-size:15px"> <a><strike>{{ $spin->price*2 }}</strike> </a></span>
												</div>												
										<div class="example1"
												 <span style="color: black; background-color: black; font-size:15px"> <a><strong>{{ $spin->price }}</strong></a> </span>
                                                   </div>	
                                            <p>Lượt Quay: {{ $spin->total_turns }}</p>
                                        </div>
																					   
                                        <div class="a-more">
                                            <div class="row">
                                                <div class="col-xs-12">												
                                                    <div class="view">
                                                        <a href="{{ asset('vong-quay/'.$spin->id) }}" title="{{ isset($spin->title) ? $spin->title : 'Vòng quay' }}"><strong>Quay tay</strong></a>
                                                    </div>
																									
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($spin_coins as $spin)
                                <div class="col-sm-3 col-xs-6">
                                    <div class="classWithPad">
                                        <div class="news_image">
                                            <a href="{{ asset('vong-quay-tien/'.$spin->id) }}" title="{{ $spin->title }}">
                                                <img src="{{ asset($spin->thumbnail) }}" alt="{{ $spin->title }}">
                                            </a>
                                        </div>
                                        <div class="news_title">
                                            <h2>
                                                <a href="{{ asset('vong-quay-tien/'.$spin->id) }}" title="{{ $spin->title }}">
                                                    <span style="font-size: 17px" width="100">{{ isset($spin->title) ? $spin->title : 'Vòng quay' }}</span>
                                                </a>
                                            </h2>
                                        </div>
                                        <div class="news_description">		
										<div class="example1">
												 <span style="color: white; background-color: red; font-size:15px"> <a><strike>{{ $spin->price*2 }}</strike> </a></span>
												 </div>
										<div class="example1"
												 <span style="color: black; background-color: black; font-size:15px"> <a><strong>{{ $spin->price }}</strong></a>  </span>
                                                   </div>
                                            <p>Lượt Quay: {{ $spin->count_turn }}</p>											
                                        </div>
										
                                        <div class="a-more">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="view">

                                                        <a href="{{ asset('vong-quay-tien/'.$spin->id) }}" title="{{ isset($spin->title) ? $spin->title : 'Vòng quay' }}"><strong>Quay tay</strong></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if(isset($slotMachines) && count($slotMachines) > 0)
                                @foreach($slotMachines as $slotMachine)
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="classWithPad">
                                            <div class="news_image">
                                                <a href="{{ asset('slot-machine/'.$slotMachine->url) }}" title="{{ $slotMachine->title }}">
                                                    <img class="img-responsive" src="{{ $slotMachine->image }}" alt="{{ $slotMachine->title }}">
                                                </a>
                                            </div>
                                            <div class="news_title">
                                                <h2>
                                                    <a href="{{ asset('slot-machine/'.$slotMachine->url) }}" title="{{ $slotMachine->title }}">{{ $slotMachine->title }}</a>
                                                </h2>
                                            </div>
                                            <div class="news_description">
											<div class="example1">
												 <span style="color: white; background-color: red; font-size:15px"> <a><strike>{{ $slotMachine->price*2 }}</strike> </a></span>
												 </div>
											<div class="example1"
												 <span style="color: black; background-color: black; font-size:15px"> <a><strong>{{ $slotMachine->price }}</strong></a>  </span>
                                                   </div>
                                                <p>Số lượt chơi: {{ count($slotMachine->histories) }}</p>
                                            </div>
											
                                            <div class="a-more">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="view">
                                                            <a href="{{ asset('slot-machine/'.$slotMachine->url) }}" title="{{ $slotMachine->title }}"><strong>Quay tay</strong></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if(isset($flipCards) && count($flipCards) > 0)
                                @foreach($flipCards as $flipCard)
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="classWithPad">
                                            <div class="news_image">
                                                <a href="{{ asset('flip-card/'.$flipCard->url) }}" title="{{ $flipCard->title }}">
                                                    <img class="img-responsive" src="{{ $flipCard->image }}" alt="{{ $flipCard->title }}">
                                                </a>
                                            </div>
                                            <div class="news_title">
                                                <h2>
                                                    <a href="{{ asset('flip-card/'.$flipCard->url) }}" title="{{ $flipCard->title }}">{{ $flipCard->title }}</a>
                                                </h2>
                                            </div>
                                            <div class="news_description">
											<div class="example1">
												 <span style="color: white; background-color: red; font-size:15px"> <a><strike>{{ $flipCard->price*2 }}</strike> </a></span>
												 </div>
												 <div class="example1">
												 <span style="color: black; background-color: black; font-size:15px"> <a><strong>{{ $flipCard->price }}</strong></a> </span>
                                                   </div>
                                                <p>Số lượt chơi: {{ count($flipCard->histories) }}</p>
                                            </div>											
                                            <div class="a-more">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="view">
                                                            <a href="{{ asset('flip-card/'.$flipCard->url) }}" title="{{ $flipCard->title }}"><strong>Quay tay</strong></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="c-content-box c-size-md c-bg-white">
                <div class="container">
                    <!-- Begin: Testimonals 1 component -->
                    <div class="c-content-client-logos-slider-1  c-bordered" data-slider="owl">
                        <!-- Begin: Title 1 component -->

                        <div class="c-content-title-1">
                            <h3 class="c-center c-font-uppercase c-font-bold">Danh mục game</h3>
                            <div class="c-line-center c-theme-bg"></div>
                        </div>
                        <div class="row row-flex-safari game-list">

                            @if(isset($categories) && count($categories) > 0)
                                @foreach($categories as $category)
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="classWithPad">
                                            <div class="news_image">
                                                <a href="{{ asset('danh-muc/'.$category['key']) }}" title="{{ $category['title'] }}">
                                                    <img class="img-responsive" src="{{ asset($category['images']) }}" alt="{{ $category['title'] }}">
                                                </a>
                                            </div>
                                            <div class="news_title">
                                                <h2>
                                                    <a href="{{ asset('danh-muc/'.$category['key']) }}" title="{{ $category['title'] }}" style="text-transform: uppercase;">{{ $category['title'] }}</a>
                                                </h2>
                                            </div>

                                            <div class="news_description">                                                
                                                <p>Đã bán: {{ $category['count_sold'] }}</p>
												</div>
												
											<div class="a-more">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="view">
                                                            <a href="{{ asset('danh-muc/'.$category['key']) }}" title="{{ $flipCard->title }}"><strong>Xem tất cả</strong></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
												
                                            </div>	
											 </div>	
                                                 
                                        
                                   
                                @endforeach
                            @endif

                            @if(isset($gifts) && count($gifts) > 0)
                                @foreach($gifts as $gift)
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="classWithPad">
                                            <div class="news_image">
                                                <a href="{{ asset('gift/'.$gift->id) }}" title="{{ $gift->title }}">
                                                    <img class="img-responsive" src="{{ asset($gift->image) }}" alt="{{ $gift->title }}">
                                                </a>
                                            </div>
                                            <div class="news_title">
                                                <h2>
                                                    <a href="{{ asset('gift/'.$gift->id) }}" title="{{ $gift->title }}">{{ $gift->title }}</a>
                                                </h2>
                                            </div>
                                            <div class="news_description"> 
											<div class="example1"
												 <span style="color: white; background-color: red; font-size:15px"> <a><strike>{{ $gift->price*2 }}</strike> </a></span>
												 </div>
										<div class="example1"
												 <span style="color: black; background-color: black; font-size:15px"> <a><strong>{{ $gift->price }}</strong></a>  </span>
                                                   </div>
                                                <p>Đã bán: {{ $gift->sold }}</p>                                            
											
												   </div>
                                            <div class="a-more">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="view">
                                                            <a href="{{ asset('gift/'.$gift->id) }}" title="{{ $gift->title }}"><strong>Xem tất cả</strong></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            @if(isset($randoms) && count($randoms) > 0)
                                @foreach($randoms as $random)
                                    <div class="col-sm-3 col-xs-6">
                                        <div class="classWithPad">
                                            <div class="news_image">
                                                <a href="{{ asset('random/'.$random->id) }}" title="{{ $random->title }}">
                                                    <img class="img-responsive" src="{{ asset($random->thumbnail) }}" alt="{{ $random->title }}">
                                                </a>
                                            </div>
                                            <div class="news_title">
                                                <h2>
                                                    <a href="{{ asset('random/'.$random->id) }}" title="Random Liên Quân Sơ Cấp">{{ $random->title }}</a>
                                                </h2>
                                            </div>
                                            <div class="news_description">        
												<div class="example1">												 
												 <span style="color: black; background-color: black; font-size:15px"> <a><strong>{{ $random->price }}</strong></a> </span>
                                                   </div>											
                                                <p>Đã bán: {{ $random->count_selled }}</p>
												
                                            </div>											
                                            <div class="a-more">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="view">
                                                            <a href="{{ asset('random/'.$random->id) }}" title="{{ $random->title }}"><strong>Xem tất cả</strong></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <!-- END: PAGE CONTAINER -->
           
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
        .error {
            color: red;
            font-size: 15px;
            padding: 0px;
            margin: 0px;
        }
        .carousel-control .fa {
            position: relative;
            top: 45%;
            z-index: 5;
        }
    </style>
	
@endsection
