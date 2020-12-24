<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('') }}">
    <title>Trang quản trị</title>
    <!-- Custom fonts for this template-->
    <link href="/admin_asset/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="/admin_asset/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="/admin_asset/vendor/datatables/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin_asset/vendor/datatables/css/colReorder.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin_asset/vendor/datatables/css/fixedColumns.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin_asset/vendor/datatables/css/fixedHeader.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin_asset/vendor/datatables/css/responsive.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="/admin_asset/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/admin_asset/css/style_setting.css"/>
    <link rel="stylesheet" type="text/css" href="/admin_asset/css/style_star.css"/>
    <link rel="stylesheet" type="text/css" href="/admin_asset/css/style_slot_machine.css"/>
    @yield('css')
    <!-- Jquery -->
    <script src="/admin_asset/vendor/jquery/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="/admin_asset/vendor/jquery/jquery.min.js"></script>
    <script src="/admin_asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="/admin_asset/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="/admin_asset/js/sb-admin-2.min.js"></script>
    <!-- Data Table -->
    <script type="text/javascript" src="/admin_asset/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/admin_asset/vendor/datatables/js/dataTables.colReorder.min.js"></script>
    <script type="text/javascript" src="/admin_asset/vendor/datatables/js/dataTables.fixedColumns.min.js"></script>
    <script type="text/javascript" src="/admin_asset/vendor/datatables/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript" src="/admin_asset/vendor/datatables/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="/admin_asset/js/main.js"></script>
    <script type="text/javascript" src="/admin_asset/vendor/sweetalert/sweetalert2.js"></script>
    <script type="text/javascript" src="/admin_asset/vendor/jquery-validate/jquery.validate.min.js"></script>
    <!-- Load Jquery UI -->
    <link rel="stylesheet" type="text/css" href="/admin_asset/vendor/jquery-ui/jquery-ui.css"/>
    <script type="text/javascript" src="/admin_asset/vendor/jquery-ui/jquery-ui.js"></script>
    <script type="text/javascript" src="/assets/js/moment.min.js"></script>
    <script type="text/javascript" src="/assets/js/numeral.min.js"></script>
    <!-- Summber note -->
    <link rel="stylesheet" type="text/css" href="/admin_asset/vendor/summernote/summernote.css"/>
    <script type="text/javascript" src="/admin_asset/vendor/summernote/summernote.js"></script>
    <!-- Dropzone -->
    <link rel="stylesheet" href="/admin_asset/vendor/dropzone/dropzone.min.css" />
    <script type="text/javascript" src="/admin_asset/vendor/dropzone/dropzone.min.js"></script>
    @yield('js')
</head>

<body id="page-top">
@yield('content')
@include('admin.layouts.components.modal')
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<div id="loading">
    <div id="icon-loading"></div>
</div>
</body>

</html>
