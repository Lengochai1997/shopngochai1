@php
    $data = json_decode($account->data);
@endphp
<div class="col-sm-6 col-md-3">
    <div class="classWithPad">
        <div class="image">
            <a href="{{ asset('tai-khoan/'.$account->id) }}">
                <img src="{{ strpos($account->thumbnail, 'upload/images_del') !== false ? asset('') . $account->thumbnail : $account->thumbnail }}">
                <span class="ms">MS: {{ $account->id }}</span>
            </a>
        </div>
        <div class="description">
            {!! $account->description !!}
        </div>
        <div class="attribute_info">
            @if($account->type_id == 1)
            <div class="row">
                <div class="col-xs-6 a_att">
                    Tướng: <b>{{ isset($data->count_hero) ? $data->count_hero : 0 }}</b>
                </div>
                <div class="col-xs-6 a_att">
                    Skin: <b>{{ isset($data->count_skin) ? $data->count_skin : 0 }}</b>
                </div>

                <div class="col-xs-6 a_att">
                    Rank: <b>{{ isset($data->rank) && isset(config('account.arena_valor.rank')[$data->rank]) ? config('account.arena_valor.rank')[$data->rank] : config('account.arena_valor.rank')[1] }}</b>
                </div>
                <div class="col-xs-6 a_att">
                    Bậc Ngọc: <b>{{ isset($data->gem_level) ? $data->gem_level : 0 }}</b>
                </div>
            </div>
            @elseif($account->type_id == 2)
                <div class="row">
                    <div class="col-xs-6 a_att">
                        Rank: <b>{{ isset($data->rank) ? $data->rank : '' }}</b>
                    </div>
                    <div class="col-xs-6 a_att">
                        Pet: <b>{{ isset($data->pet) ? $data->pet : '' }}</b>
                    </div>
                    <div class="col-xs-6 a_att">
                        Đăng ký: <b>{{ isset($data->register) ? $data->register : '' }}</b>
                    </div>
                </div>
            @endif
        </div>
        <div class="a-more">
            <div class="row">
                <div class="col-xs-6">
                    <div class="price_item">
                        {{ number_format($account->price) }} đ
                    </div>
                </div>
                <div class="col-xs-6 ">
                    <div class="view">
                        <a href="{{ asset('tai-khoan/'.$account->id) }}">Chi tiết</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
