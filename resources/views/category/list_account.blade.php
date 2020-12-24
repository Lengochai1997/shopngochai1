@extends('layout.index')

@section('title', 'Danh sách Nick '.$category->title)

@section('content')
    <div class="c-layout-page content-dark">
        <div class="container">
            <div class="row mt-3">
                <div class="col-sm-12">
                    <div class="alert alert-info" role="alert">
                        <h2 class="alert-heading">{{ $category->title }}</h2>
                        <div class="description">
                            {{ $category->description }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 15px">
                <div class="m-l-10 m-r-10">
                    <div class="col-md-4 col-sm-5 col-xs-12  p-5 field-search">
                        <div class="input-group c-square">
                            <span class="input-group-addon">Giá tiền</span>
                            <select class="form-control c-square c-theme" name="price" id="price">
                                <option value="0">Chọn Khoảng Giá</option>
                                <option value="1" data-up="0" data-down="50000">Giá Dưới 50k</option>
                                <option value="2" data-up="0" data-down="100000">Giá Dưới 100k</option>
                                <option value="3" data-up="0" data-down="500000">Giá Dưới 500k</option>
                                <option value="4" data-up="0" data-down="1000000">Giá Dưới 1000k</option>
                                <option value="5" data-up="100000" data-down="500000">Giá 100k-500k</option>
                                <option value="6" data-up="500000" data-down="1000000">Giá 500k-1000k</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-12  p-5 field-search">
                        <div class="input-group c-square" name="id">
                            <span class="input-group-addon">Tìm kiếm</span>
                            <input type="text" class="form-control c-square c-theme" id="id" name="id" placeholder="Tìm kiếm theo Mã..." autofocus="">
                        </div>
                    </div>
                    <div class="p-5 no-radius">
                        <button class="btn c-square c-theme c-btn-green" onclick="loadAccount();">Tìm kiếm</button>
                    </div>
                </div>
            </div>
            <div id="list-account" class="row row-flex item-list">
                @foreach($accounts as $account)
                    @component('category.partials.account', [
                        'account' => $account
                    ])
                    @endcomponent
                @endforeach
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    {{ $accounts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .login-box, .register-box {
            width: 400px;
            margin: 7% auto;

            padding: 20px;;
        }
        @media (max-width: 767px){
            .login-box, .register-box {
                width: 100%;
            }

        }
        .login-box-msg, .register-box-msg {
            margin: 0;
            text-align: center;
            padding: 0 20px 20px 20px;
            text-align: center;
            font-size: 20px;;
            font-weight: bold;
        }
        .error {
            color: red;
            font-size: 15px;
        }
        .box-custom{
            border: 1px solid #cccccc;
            padding: 20px;

            color: #666;
        }
    </style>
@endsection

@section('js')
    <script type="text/javascript" src="/admin_asset/vendor/jquery-validate/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {

        });

        function loadAccount() {
            let up = $('#price').children("option:selected").attr('data-up');
            let down = $('#price').children("option:selected").attr('data-down');
            let id = $('#id').val();
            console.log(up, down, id);
            window.location.href = '{!! asset('danh-muc/'.$key) !!}/'+up+'/'+down+'/'+'/'+id;
            {{--let idCategory = '{!! $category->id !!}';--}}
            {{--let formData = new FormData();--}}
            {{--formData.append('_token', '{!! csrf_token() !!}');--}}
            {{--formData.append('category_id', idCategory);--}}
            {{--callAjax('{!! asset('get-accounts') !!}', 'POST', formData).then(res => {--}}
            {{--    if (res.status === 'success') {--}}
            {{--        let accounts = res.data;--}}
            {{--        if (accounts.length === 0) {--}}
            {{--            Swal.fire({--}}
            {{--                icon: 'error',--}}
            {{--                title: 'Lỗi !',--}}
            {{--                text: 'Không có tài khoản nào',--}}
            {{--            });--}}
            {{--            return false;--}}
            {{--        }--}}
            {{--        $('#list-account').html('');--}}
            {{--        for (let i = 0; i < accounts.length; i++) {--}}
            {{--            let account = accounts[i];--}}
            {{--            $('#list-account').append(createDomAccount(account));--}}
            {{--        }--}}
            {{--    }--}}
            {{--});--}}
        }

        function createDomAccount(account) {
            let dom = '';
            if (account) {
                let data = JSON.parse(account.data);
                let rank = JSON.parse('{!! json_encode(config('account.arena_valor.rank')) !!}');
                dom = `<div class="col-sm-6 col-md-3">
                    <div class="classWithPad">
                        <div class="image">
                            <a href="/account/${account.id}">
                                <img src="${account.thumbnail || ''}">
                                <span class="ms">MS: ${account.id}</span>
                            </a>
                        </div>
                        <div class="description">
                            ${account.description || ''}
                        </div>
                        <div class="attribute_info">
                            <div class="row">
                                <div class="col-xs-6 a_att">
                                    Tướng: <b>${data.count_hero || 0}</b>
                                </div>
                                <div class="col-xs-6 a_att">
                                    Skin: <b>${data.count_skin || 0}</b>
                                </div>

                                <div class="col-xs-6 a_att">
                                    Rank: <b>${data.rank ? rank[data.rank] : rank[0]}</b>
                                </div>
                                <div class="col-xs-6 a_att">
                                    Đá Quý: <b>0</b>
                                </div>
                            </div>
                        </div>
                        <div class="a-more">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="price_item">
                                        ${account.price || 0} đ
                                    </div>
                                </div>
                                <div class="col-xs-6 ">
                                    <div class="view">
                                        <a href="/account/${account.id}">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            }
            return dom;
        }
    </script>
@endsection
