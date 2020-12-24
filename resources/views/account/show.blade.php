@extends('layout.index')

@section('title', 'Thông tin Tài khoản #'.$account->id)

@section('content')
    <div class="c-layout-page content-dark">
        <div class="m-t-20 visible-sm visible-xs"></div>
        <div class="c-content-box c-size-lg c-overflow-hide c-bg-white">
            @include('account.partials.data', ['type' => $account->type_id])
            @include('account.partials.images')
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

@endsection
