@extends('layouts.auth_app')
@section('title')
    Register
@endsection
@section('content')
    <body class="ltr login-img">
        <div class="page">
            <div>
                <!-- CONTAINER OPEN -->
                <div class="col col-login mx-auto text-center">
                    <a href="index.html">
                        {{-- <img src={{asset('assets/images/brand/logo.png')}} class="header-brand-img" alt=""> --}}
                    </a>
                </div>
                <div class="container-login100">
                    <div class="wrap-login100 p-0">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                        @endif
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" class="login100-form validate-form" enctype="multipart/form-data">
                                <span class="login100-form-title">
                                    Registrarse
                                </span>
                                @csrf
                                <div class="wrap-input100 validate-input">
                                    <input id="firstName" type="text"
                                        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} input100"
                                        name="name"
                                        tabindex="1" placeholder="Nombre Completo" value="{{ old('name') }}"
                                        autofocus required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="mdi mdi-account" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <input id="email" type="email"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} input100"
                                        placeholder="Email" name="email" tabindex="1"
                                        value="{{ old('email') }}"
                                        required autofocus>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-email" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <input id="phone" type="number"
                                        class="form-control input100{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                        name="phone"
                                        tabindex="1" placeholder="phone" value="{{ old('phone') }}"
                                        autofocus required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <select class="form-select input100" name="document_type" aria-label=".form-select-sm example" autofocus value="{{ old('document_type') }}" required>
                                        <option selected value="">Seleccione tipo Documento</option>
                                        <option value="NIT">NIT</option>
                                        <option value="CC">Cedula de Ciudadania</option>
                                      </select>
                                      <div class="invalid-feedback">
                                        {{ $errors->first('document_type') }}
                                    </div>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <input id="number_id"
                                        type="number"
                                        class="form-control input100{{ $errors->has('number_id') ? ' is-invalid' : '' }}"
                                        name="number_id"
                                        tabindex="1" placeholder="Numero Identificacion" value="{{ old('number_id') }}"
                                        autofocus required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('number_id') }}
                                    </div>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-address-card" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <label for="formFile" class="form-label">Copia del documento de identidad extension requerida(.PDF)</label>
                                    <input id="photo_id"
                                        accept=".pdf"
                                        type="file"
                                        class="form-control"
                                        name="photo_id"
                                        tabindex="1" placeholder="Enter Identification" value="{{ old('photo_id') }}"
                                        autofocus>
                                </div>

                                <label for="formFile" class="form-label">Foto Perfil</label>
                                <div class="wrap-input100 validate-input">
                                    <input id="photo"
                                            accept="image/jpeg,image/jpg,image/png"
                                            type="file"
                                            class="form-control"
                                            name="photo"
                                            tabindex="1" placeholder="Enter Photo" value="{{ old('name') }}"
                                            autofocus>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <input id="password" type="password"
                                        class="form-control input100{{ $errors->has('password') ? ' is-invalid': '' }}"
                                        placeholder="Contraseña" name="password" tabindex="2" minlength="8" required>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password') }}
                                    </div>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="wrap-input100 validate-input">
                                    <input id="password_confirmation" type="password" placeholder="Confirmar Contraseña"
                                        class="form-control input100{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                        name="password_confirmation" minlength="8" tabindex="2">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                                    </span>
                                </div>

                                <div class="form-group mt-3 mb-3">
                                    <div class="captcha">
                                        <span>{!! captcha_img() !!}</span>
                                        <button type="button" class="btn btn-danger" class="refresh-captcha" id="refresh-captcha">
                                            &#x21bb;
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('captcha') }}
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Registrarse
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-5 text-muted text-center">
                                    Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('scripts')
<script>

    $('#refresh-captcha').click(function () {
        $.ajax({
            type: 'GET',
            url: "{{route('refresh.captcha')}}",
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });

</script>
@endsection
