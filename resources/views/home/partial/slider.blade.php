<div id="sliderTop" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
{{--    <ol class="carousel-indicators">--}}
{{--        <li data-target="#sliderTop" data-slide-to="0" class="active"></li>--}}
{{--        <li data-target="#sliderTop" data-slide-to="1"></li>--}}
{{--    </ol>--}}

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <div class="item active">
            <!-- Đổi link ảnh ở đây nha -->
            @if (is_array($slider))
                @foreach($slider as $s)
                    <img src="{{ $s }}" alt="{{ $s }}">
                @endforeach
            @else
                <img src="https://via.placeholder.com/1000x300" alt="Los Angeles">
            @endif
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#sliderTop" data-slide="prev">
        <span class="fa fa-chevron-left"></span>
        <span class="sr-only">Trước</span>
    </a>
    <a class="right carousel-control" href="#sliderTop" data-slide="next">
        <span class="fa fa-chevron-right"></span>
        <span class="sr-only">Sau</span>
    </a>
</div>
