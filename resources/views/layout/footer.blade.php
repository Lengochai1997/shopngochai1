<!-- END: PAGE CONTAINER -->
<footer class="c-layout-footer c-layout-footer-3 c-bg-dark">
    <div class="c-prefooter">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="c-container c-first">
                        <p>
                            <span style="color:#16a085">
                                <span style="font-size:22px">
                                    <strong>{{ $config['domain'] }}</strong>
                                </span>
                            </span>
                            </a>
                        </p>
                        <ul>
                            <li><a href="{{ $config['admin_facebook'] }}">FB Admin</a></li>
                            <li>Số tài khoản đã bán: 1990</li>
                            <li>Số tài khoản đang còn: 10000</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="c-container c-last">
                        <div class="c-content-title-1">
                            <h3 class="c-font-uppercase c-font-bold c-font-white">Chúng tôi ở đây</h3>
                            <div class="c-line-left hide"></div>
                            <p>Chúng tôi làm việc một cách chuyên nghiệp, uy tín, nhanh chóng và luôn đặt quyền lợi của bạn lên hàng đầu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="c-container c-last">
                        <ul class="c-socials">                            
							<script src="https://apis.google.com/js/platform.js"></script>
						<div class="g-ytsubscribe" data-channelid="UC5UYpnzmtSgZZU8_QRZ8DVQ" data-layout="full" data-count="default">
						</div>
                        </ul>
                        <ul class="c-address">
                            <li><i class="icon-pointer c-theme-font"></i> Việt Nam</li>
                            <li><i class="icon-call-end c-theme-font"></i> <a href="tel:" class="c-font-regular"></a> (8h-22h)</li>
                            <li><i class="icon-clock c-theme-font"></i><span class="c-font-regular">8h-11h30 & 13h30-22h</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="c-postfooter" style="margin-top: -70px">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 c-col">
                    <p class="c-copyright c-font-grey">2019 &copy; Vận hành bởi {{ $config['domain'] }}
                    <span class="c-font-grey-3"></span>
                </div>
            </div>
        </div>
    </div>
</footer>
@if(isset($alert))
@include('layout.partials.alert')
@endif
<div class="c-layout-go2top">
    <i class="icon-arrow-up"></i>
</div><!-- END: LAYOUT/FOOTERS/GO2TOP -->
<!-- BEGIN: LAYOUT/BASE/BOTTOM -->
<!-- BEGIN: CORE PLUGINS -->
<script src="/assets/frontend/theme/assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/jquery.easing.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/reveal-animate/wow.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/demos/default/js/scripts/reveal-animate/reveal-animate.js" type="text/javascript"></script>
<!-- END: CORE PLUGINS -->
<!-- BEGIN: LAYOUT PLUGINS -->
<script src="/assets/frontend/theme/assets/global/plugins/magnific/magnific.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/smooth-scroll/jquery.smooth-scroll.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/js-cookie/js.cookie.js" type="text/javascript"></script>
<!-- END: LAYOUT PLUGINS -->
<!-- BEGIN: THEME SCRIPTS -->
<script src="/assets/frontend/theme/assets/base/js/components.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/base/js/app.js" type="text/javascript"></script>

<script src="/assets/frontend/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        App.init(); // init core
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    $(".menu-main-mobile a").click(function() {
        if( $(this).closest("li").hasClass("c-open")){
            $(this).closest("li").removeClass("c-open");
        }
        else{
            $(this).closest("li").addClass("c-open");
        }
    });
</script>
<!-- END: THEME SCRIPTS -->
<!-- BEGIN: PAGE SCRIPTS -->
<script src="/assets/frontend/theme/assets/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="/assets/frontend/theme/assets/demos/default/js/scripts/pages/datepicker.js" type="text/javascript"></script>
<script src="/assets/frontend/plugins/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js" type="text/javascript"></script>
<script src="/assets/frontend/js/common.js" type="text/javascript"></script>
<!-- END: LAYOUT/BASE/BOTTOM -->


<style type="text/css">
    #bonus{
        position: fixed;
        bottom: 15px;
        left: 15px;
        width: 13%;
        z-index: 1000;
        cursor: pointer;
    }
    #bonus img{
        width: 100%;
    }
	#bonus_login{
		display:block;
        position: fixed;
        bottom: 15px;
        left: 15px;
        width: 13%;
        z-index: 1000;
        cursor: pointer;
    }
    #bonus_login img{
        width: 100%;
    }
    .mobile{
        width: 30%!important;
    }
	@media  only screen and (max-width: 640px) {
		#bonus_login{width: 50%!important;!important;}
		#bonus{width: 50%!important;!important;}
	}
	#bonusModal .modal-body p,#bonusModal .modal-body b{display:inline;color:#000}
</style>
