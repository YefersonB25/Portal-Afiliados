<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Noa – Bootstrap 5 Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href={{asset('assets/images/brand/favicon.ico')}} />

    <!-- TITLE -->
    <title>Dashboard</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href={{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}} rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href={{asset('assets/css/style.css')}} rel="stylesheet" />
    <link href={{asset('assets/css/skin-modes.css')}} rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href={{asset('assets/css/icons.css')}} rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

</head>

<body>
    <!-- GLOBAL-LOADER -->
    <div id="global-loader">
        <img src={{asset('assets/images/loader.svg')}} class="loader-img" alt="Loader">
    </div>
    <div id="app">
        <nav class="">
            @include('layouts.header')
        </nav>

        <div class="">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="">
            @yield('content')
        </div>

        <footer class="">
            @include('layouts.footer')
        </footer>
    </div>

    @include('profile.change_password')
    @include('profile.edit_profile')

</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

<!-- JQUERY JS -->
<script src={{ asset('assets/js/jquery.min.js') }}></script>
<!-- BOOTSTRAP JS -->
<script src={{ asset('assets/plugins/bootstrap/js/popper.min.js') }}></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- SIDE-MENU JS-->
<script src="{{ asset('assets/plugins/sidemenu/sidemenu.js') }}"></script>

<!-- APEXCHART JS -->
<script src="{{ asset('assets/js/apexcharts.js') }}"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>

<!-- DATA TABLE JS-->
<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatable/responsive.bootstrap5.min.js')}}"></script>
<script src="{{asset('assets/js/table-data.js')}}"></script>

<!-- CUSTOM JS -->
<script src={{ asset('assets/js/custom.js') }}></script>
<!-- CHART-CIRCLE JS-->
<script src={{ asset('assets/js/circle-progress.min.js') }}></script>

<!-- INDEX JS -->
<script src={{ asset('assets/js/index1.js') }}></script>

<!-- REPLY JS-->
<script src={{ asset('assets/js/reply.js') }}></script>

<!-- PERFECT SCROLLBAR JS-->
{{-- <script src={{ asset('assets/plugins/p-scroll/perfect-scrollbar.js') }}></script>
<script src={{ asset('assets/plugins/p-scroll/pscroll.js') }}></script> --}}

<!-- STICKY JS -->
<script src={{ asset('assets/js/sticky.js') }}></script>

<!-- COLOR THEME JS -->
<script src={{ asset('assets/js/themeColors.js') }}></script>
{{-- <script src="{{ asset('thema/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"
    type="text/javascript"></script> --}}
@yield('scripts')

</html>
