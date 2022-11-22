@extends('layouts.auth_app')
@section('title')
    Reset Password
@endsection
@section('content')
<body class="ltr logo_img">
    <div class="container-login100">
        <div class="wrap-login100 p-0">
            <div class="card-body">
                <div class="card card-primary">
                    <div class="card-header"><h4>Establecer una nueva contraseña</h4></div>
                    <div class="card-body">
                        <form method="POST" action="{{ url('/password/reset') }}">
                            @csrf
                            @if ($errors->any())
                                <div class="alert alert-danger p-0">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email" tabindex="1" value="{{ old('email') }}" autofocus>
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                                @error("email")
                                <span class="red-text text-darken-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}" name="password"
                                    tabindex="2">
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="control-label">Confirm Password</label>
                                <input id="password_confirmation" type="password"
                                    class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                    name="password_confirmation" tabindex="2">
                                <div class="invalid-feedback">
                                    {{ $errors->first('password_confirmation') }}
                                </div>
                                @error("password_confirmation")
                                <span class="red-text text-darken-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Establecer contraseña
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
