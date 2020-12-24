<div class="c-content-box c-size-md">
    <div class="container">
        @if($agent->isMobile())
            <div class="row" style="padding: 8px 10px;background-color: #dd4b39;">
                <div class="col-lg-7 col-sm-12 video-youtube">
                    @include('home.partial.slider')
                </div>
                <div class="col-lg-5 col-sm-12" style="padding: 0px;">
                    <div class="box box-danger collapsed-box box-solid" style="padding: 0px; margin: 0px;">
                        <div class="box-header with-border">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a data-toggle="tab" href="#charge" aria-expanded="true">
                                        <h3 class="box-title title-top">NẠP THẺ</h3>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#top10" aria-expanded="true">
                                        <h3 class="box-title title-top">TOP NẠP THẺ</h3>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body top-charge">
                            <div class="tab-content">
                                <div id="top10" class="tab-pane fade in">
                                    @include('home.partial.list_top_charge')
                                </div>
                                <div id="charge" class="tab-pane fade active in">
                                    @include('home.partial.fast_charge')
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        @else
            <div class="row" style="padding: 8px 10px;background-color: #dd4b39; display: flex; align-items: center;">
                <div class="col-lg-5 col-sm-12" style="padding: 0px;">
                    <div class="box box-danger collapsed-box box-solid" style="padding: 0px; margin: 0px;">
                        <div class="box-header with-border">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a data-toggle="tab" href="#charge" aria-expanded="true">
                                        <h3 class="box-title title-top">NẠP THẺ</h3>
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#top10" aria-expanded="true">
                                        <h3 class="box-title title-top">TOP NẠP THẺ</h3>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body top-charge">
                            <div class="tab-content">
                                <div id="top10" class="tab-pane fade in">
                                    @include('home.partial.list_top_charge')
                                </div>
                                <div id="charge" class="tab-pane fade active in">
                                    @include('home.partial.fast_charge')
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-7 col-sm-12 video-youtube">
                    @include('home.partial.slider')
                </div>
            </div>
        @endif
    </div>
</div>
