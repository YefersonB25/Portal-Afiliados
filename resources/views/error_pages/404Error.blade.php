@extends('layouts.auth_app')

@section('content')
    <body class="ltr error-bg">

        {{-- <!-- GLOBAL-LOADER -->
        <div id="global-loader">
            <img src="../assets/images/loader.svg" class="loader-img" alt="Loader">
        </div>
        <!-- End GLOBAL-LOADER --> --}}

        <!-- PAGE -->
        <div class="page">
        <!-- PAGE-CONTENT OPEN -->
            <div class="page-content error-page error2">
                <div class="container text-center">
                    <div class="error-template">
                        <h2 class="text-white mb-2">401<span class="fs-20">error</span></h2>
                        <h5 class="error-details text-white">
							Oops! Se ha producido un error, no se ha encontrado la página solicitada, ya que el afilidado no se encuentra registrado en ninguno de nuestros sistemas de gestion de facturas.
                        </h5>
                        <div class="text-center">
                            <a href="{{ url('logout') }}" class="btn btn-primary mt-5 mb-5"
                            onclick="event.preventDefault(); localStorage.clear();  document.getElementById('logout-form').submit();"> <i class="fa fa-long-arrow-left"></i> Back to Login </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PAGE-CONTENT OPEN CLOSED -->
        </div>
        <!-- End PAGE -->
    </body>
@endsection
