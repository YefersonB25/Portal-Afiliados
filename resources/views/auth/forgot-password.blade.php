@extends('layouts.auth_app')
@section('title')
    Forgot Password
@endsection
@section('content')
    <body class="ltr login-img">
        <div class="container-login100">
            <div class="wrap-login100 p-0">
                <div class="card-body">
                    <div class="card card-primary">
                        <div class="card-header"><h4>Has olvidado tu contraseña</h4></div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" class="login100-form validate-form" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email" tabindex="1" value="{{ old('email') }}" autofocus required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                    @error("email")
                                        <span class="red-text text-darken-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Solicitar Cambio
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            ¿Recordó su información de inicio de sesión? <a href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
