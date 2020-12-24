<div class="col-sm-6 col-md-3">
    <div class="classWithPad">
        <div class="image">
            <a>
                <img src="{{ strpos($gift->image, 'upload/images_del') !== false ? asset('') . $gift->image : $gift->image }}">
                <span class="ms">MS: {{ $box->id }}</span>
            </a>
        </div>
        <div class="description">
            {!! $gift->description !!}
        </div>
        <div class="attribute_info">
            <div class="row">
                <div class="col-xs-6 a_att">
                    Tỷ lệ trúng: <b>{{ $gift->ratio }}</b>
                </div>
                <div class="col-xs-6 a_att">
                    Thể loại: <b>{{ $gift->category }}</b>
                </div>
            </div>
        </div>
        <div class="a-more">
            <div class="row">
                <div class="col-xs-6">
                    <div class="price_item">
                        {{ number_format($gift->price) }} đ
                    </div>
                </div>
                <div class="col-xs-6 ">
                    <div class="view">
                        <a data-id="{{ $box->id }}" onclick="openBox(this)">Mở hòm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
