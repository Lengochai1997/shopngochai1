<div id="evenstop10" style="color: #505050;">
    @if(isset($topCharge) && count($topCharge) > 0)
        @foreach($topCharge as $charge)
            <div class="row">
                <div class="col-xs-8" style="padding-right: 0px;">
                    <label class="control-label">
                        <span class="fa-stack">
                            <span class="fa fa-circle fa-stack-2x color color_1"></span>
                            <strong class="fa-stack-1x" style="color:white;">{{ $loop->index + 1 }}</strong>
                        </span>
                        {{ $charge->user->name ? $charge->user->name : $charge->user->username }}
                    </label>
                </div>
                <div class="col-xs-4" style="text-align: right;">
                    <label class="control-label">
                        <button type="button" class="btn btn-danger tops" style="padding: 5px;">{{ number_format($charge->total) }}</button>
                    </label>
                </div>
            </div>
        @endforeach
    @endif
</div>
