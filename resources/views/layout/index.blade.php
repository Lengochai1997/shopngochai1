<!doctype html>
<html lang="vi">
<head>
    @include('layout.includes.meta')
    <title>@yield('title')</title>
    @include('layout.includes.css')
    @include('layout.includes.js')
    @yield('css')
    @yield('js')
</head>
<body>
@include('layout.header')


<div class="dark">
    @yield('content')
</div>


@include('layout.footer')
@include('layout.modal')


<div id="loading">
    <div id="icon-loading"></div>
</div>
{!! $messenger !!}
</body>
</html>
