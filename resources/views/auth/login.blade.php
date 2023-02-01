@extends('layouts.auth_app')
@section('title')
     Login
@endsection
@section('content')
    <body class="ltr login-img">
        <!-- CONTAINER OPEN -->
        <div class="col col-login mx-auto text-center">
            <a href="" class="text-center">
                {{-- <img src={{ asset('assets/images/brand/positive-blue-xxlarge-horizontal.png') }} class="header-brand-img" alt=""> --}}
            </a>
        </div>
        <div class="container-login100">
            <div class="wrap-login100 p-0">
                <div class="card-body">
                    <span class="login100-form-title">
                        @lang('locale.Login')
                    </span>
                    <form method="POST" class="login100-form validate-form" action="{{ route('login') }}">
                        @csrf
                        <div class="wrap-input100 validate-input">
                            <input aria-describedby="emailHelpBlock" id="email" type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} input100" name="email"
                                    placeholder="@lang('locale.Email')" tabindex="1"
                                    value="{{ (Cookie::get('email') !== null) ? Cookie::get('email') : old('email') }}" autofocus
                                    required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="zmdi zmdi-email" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input aria-describedby="passwordHelpBlock" id="password" type="password"
                                    value="{{ (Cookie::get('password') !== null) ? Cookie::get('password') : null }}"
                                    placeholder="@lang('locale.Password')"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid': '' }} input100" name="password"
                                    tabindex="2" required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                            </span>
                        </div>
                        <div class="text-end pt-1">
                            <p class="mb-0"><a href="{{ route('forgot-password') }}" class="text-primary ms-1">Has olvidado tu contraseña?</a></p>
                        </div>
                        <div class="container-login100-form-btn">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                @lang('locale.Login')
                            </button>
                        </div>
                        <div class="text-center pt-3">
                            @if (Route::has('register'))
                                <p class="text-dark mb-0">Ya tienes una cuenta?<a href="{{ route('register') }}" class="text-primary ms-1">@lang('locale.Create an Account')</a></p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- CONTAINER CLOSED -->
    </body>
@endsection
@section('scripts')
 @if(session("error"))
    <script>
        Swal.fire('Espere a que se verifique su información, esto podría tardar unos minutos, al correo registrado le estará llegando la confirmación.')
    </script>
@endif

{{-- @if(session("mantenimiento"))
<script>
    Swal.fire('Los sistemas ERP y OTM en este momento estan fuera de servicio, reeintentelo mas tarde.')
</script> --}}
@endif
@endsection
