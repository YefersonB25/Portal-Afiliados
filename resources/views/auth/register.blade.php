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
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-header border-bottom">
                                        <h3 class="card-title">Registrarse</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-row">
                                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-3">
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
                                                </div>
                                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-3">
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
                                                </div>
                                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-3">
                                                    <div class="wrap-input100 validate-input">
                                                        <input id="phone" type="text" inputmode="numeric" pattern="[0-9]{7,11}" maxlength="11"
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
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                                                    <label for="validationDefault01"></label>
                                                    <div class="wrap-input100 validate-input">
                                                        <select class="form-select input100" name="document_type" aria-label=".form-select-sm example" autofocus value="{{ old('document_type') }}" required>
                                                            <option selected value="">Seleccione tipo Documento</option>
                                                            <option value="NIT" {{ old('document_type') == 'NIT' ? 'selected' : '' }}>NIT</option>
                                                            <option value="CC" {{ old('document_type') == 'CC' ? 'selected' : '' }}>Cedula de Ciudadania</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                            {{ $errors->first('document_type') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                                                    <label for="validationDefault01"></label>
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
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                                                    <label for="validationDefault01">Copia del documento extension requerida(.PDF)</label>
                                                    <div class="wrap-input100 validate-input">
                                                        <input id="photo_id"
                                                            accept=".pdf"
                                                            type="file"
                                                            class="form-control"
                                                            name="photo_id"
                                                            tabindex="1" placeholder="Enter Identification" value="{{ old('photo_id') }}"
                                                            autofocus>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                                                    <label for="validationDefault01">Foto Perfil</label>
                                                    <div class="wrap-input100 validate-input">
                                                        <input id="photo"
                                                                accept="image/jpeg,image/jpg,image/png"
                                                                type="file"
                                                                class="form-control"
                                                                name="photo"
                                                                tabindex="1" placeholder="Enter Photo" value="{{ old('photo') }}"
                                                                autofocus>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                                                    <label for="validationDefault01"></label>
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
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                                                    <label for="validationDefault01"></label>
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
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="captcha">
                                                    <span>{!! captcha_img('flat') !!}</span>
                                                    <button type="button" class="btn btn-danger refresh-captcha" id="refresh-captcha">
                                                        &#x21bb;
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                                    <div class="form-group mb-4">
                                                        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('captcha') }}
                                                        </div>
                                                    </div>

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
                </div>
            </div>
        </div>
    </body>
@endsection

@section('scripts')
<script>

    $(document).ready(function () {
        refreshCaptcha(); // Refresca el captcha al cargar la vista

        $('#refresh-captcha').click(function () {
            refreshCaptcha(); // Refresca el captcha al hacer clic
        });

        setInterval(refreshCaptcha, 120000);

    function refreshCaptcha() {
        $.ajax({
            type: 'GET',
            url: "{{ route('refresh.captcha') }}",
            success: function (data) {
                $(".captcha span").html(data.captcha);
            },
            error: function () {
                alert('Error al refrescar el captcha.');
            }
        });
    }
});


</script>
@endsection
