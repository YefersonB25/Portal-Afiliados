<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href={{asset('assets/images/brand/logo-1.png')}} />

    <!-- BOOTSTRAP CSS -->
    <link id="style" href={{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}} rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href={{asset('assets/css/style.css')}} rel="stylesheet" />
    <link href={{asset('assets/css/skin-modes.css')}} rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href={{asset('assets/css/icons.css')}} rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <style>
        .logo_img{
            background-image: url("{{asset('assets/images/brand/full-color-xxlarge.jpg')}}");
            background-size: cover;
            background-repeat:no-repeat;
            background-position: center center;
        }
    </style>
</head>

<body>
<div id="app">

    <!-- /GLOABAL LOADER -->
		<div class="page">
            <div>
                @yield('content')
            </div>
        </div>

</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

<!-- REPLY JS-->
<script src={{ asset('assets/js/reply.js') }}></script>

<!-- PERFECT SCROLLBAR JS-->
<script src={{ asset('assets/plugins/p-scroll/perfect-scrollbar.js') }}></script>
{{-- <script src={{ asset('assets/plugins/p-scroll/pscroll.js') }}></script> --}}

<!-- STICKY JS -->
{{-- <script src={{ asset('assets/js/sticky.js') }}></script> --}}

    <!-- COLOR THEME JS -->
    <script src={{ asset('assets/js/themeColors.js') }}></script>

	<!-- CUSTOM JS -->
	{{-- <script src={{ asset('assets/js/custom.js') }}></script> --}}

    @yield('scripts')
</html>



