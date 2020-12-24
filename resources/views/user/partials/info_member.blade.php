<div class="container c-size-md hidden-xs content-gray">
    <div class="col-md-12">
        <div class="text-center" style="margin-top: -128px;">
            <center>
                <img class="img-responsive img-thumbnail hidden-xs" width="256" height="256" src="{{ asset('assets/images/users/avatar.jpg') }}" alt="">
                <h2 class="c-font-bold c-font-28">ID: {{ Auth::user()->id }}</h2>
                <h2 class="c-font-22"></h2>
                <h2 class="c-font-22">{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->username }}</h2>
                <h2 class="c-font-22 c-font-red">{{ isset(Auth::user()->total_money) ? number_format(Auth::user()->total_money) : 0 }} đ</h2>
            </center>
        </div>
    </div>
</div>
