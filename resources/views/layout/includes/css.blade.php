<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="/assets/frontend/css/junoo.css" rel="stylesheet" type="text/css"/>
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=all' rel='stylesheet' type='text/css'>
<link href="/assets/frontend/theme/assets/plugins/socicon/socicon.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/bootstrap-social/bootstrap-social.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/animate/animate.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN: BASE PLUGINS  -->
<link href="/assets/frontend/theme/assets/global/plugins/magnific/magnific.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/cubeportfolio/css/cubeportfolio.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/owl-carousel/assets/owl.carousel.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
<!-- END: BASE PLUGINS -->
<!-- BEGIN: PAGE STYLES -->
<link href="/assets/frontend/theme/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<!-- END: PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="/assets/frontend/theme/assets/demos/default/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/demos/default/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="/assets/frontend/theme/assets/demos/default/css/themes/default.css" rel="stylesheet" id="style_theme" type="text/css"/>
<link href="/assets/frontend/theme/assets/demos/default/css/custom.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" href="/assets/frontend/plugins/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="/assets/frontend/plugins/owl-carousel/owl.theme.css">
<link rel="stylesheet" href="/assets/frontend/plugins/owl-carousel/owl.transitions.css">
<link href="/assets/frontend/css/style.css?v={{ rand(1, 9999) }}" rel="stylesheet" type="text/css"/>
<link href="/assets/css/style.css?v={{ rand(1, 9999) }}" rel="stylesheet" type="text/css"/>
@if(isset($config['theme']) && $config['theme'] == 'dark')
<link href="/assets/css/style_dark.css?v={{ rand(1, 9999) }}" rel="stylesheet" type="text/css"/>
@endif
<!-- END THEME STYLES -->
<style>
    .ui-autocomplete {
        max-height: 500px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .input-group-addon {
        background-color: #FAFAFA;
    }

    .input-group .input-group-btn > .btn, .input-group .input-group-addon {
        background-color: #FAFAFA;
    }

    .modal {
        text-align: center;
    }

    @media  screen and (min-width: 768px) {
        .modal:before {
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .c-layout-header-fixed.c-layout-header-topbar .c-layout-page {
            margin-top: 245px;
        }
    }

    @media  screen and (max-width: 767px) {
        .modal-dialog:before {
            margin-top: 75px;
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }

        .modal-dialog {
            width: 100%;

        }

        .modal-content {
            margin-right: 20px;
        }
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;


    }

    .mfp-wrap {
        z-index: 20000 !important;
    }

    .c-content-overlay .c-overlay-wrapper {
        z-index: 6;
    }

    .z7 {
        z-index: 7 !important;
    }
</style>
<link href="/assets/frontend/theme/assets/global/plugins/magnific/magnific.css" rel="stylesheet" type="text/css"/>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css'>
