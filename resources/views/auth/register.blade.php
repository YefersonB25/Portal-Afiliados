@extends('layouts.auth_app')
@section('title')
    Register
@endsection
@section('content')
    <body class="ltr logo_img">
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
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" class="login100-form validate-form" enctype="multipart/form-data">
                                <span class="login100-form-title">
                                    Registrarse
                                </span>
                                @csrf
                                <div class="wrap-input100 validate-input">
                                    <input id="firstName" type="text"
                                        class="input100{{ $errors->has('name') ? ' is-invalid' : '' }}"
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
                                        class="input100{{ $errors->has('email') ? ' is-invalid' : '' }}"
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
                                        class="input100{{ $errors->has('phone') ? ' is-invalid' : '' }}"
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
                                    <input id="number_id"
                                        type="number"
                                        class="input100{{ $errors->has('number_id') ? ' is-invalid' : '' }}"
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
s
                                <div class="wrap-input100 validate-input">
                                    <select class="form-select form-select-sm" name="document-type" aria-label=".form-select-sm example">
                                        <option selected>Seleccione tipo Documento</option>
                                        <option value="NIT">NIT</option>
                                        <option value="Cedula de Ciudadania">Cedula de Ciudadania</option>
                                      </select>
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
                                        class="input100{{ $errors->has('password') ? ' is-invalid': '' }}"
                                        placeholder="Contraseña" name="password" tabindex="2" required>
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
                                        class="input100{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                        name="password_confirmation" tabindex="2">
                                    <div class="invalid-feedback">
                                        {{ $errors->first('password_confirmation') }}
                                    </div>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                                    </span>
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
{{-- <script>
    $(document).on('change','input[type="file"]',function(){
            // this.files[0].size recupera el tamaño del archivo
            // alert(this.files[0].size);

            var fileName = this.files[0].name;
            var fileSize = this.files[0].size;

            if(fileSize > 30){
                alert('El archivo no debe superar los 3MB');
                this.value = '';
                this.files[0].name = '';
            }else{
                // recuperamos la extensión del archivo
                var ext = fileName.split('.').pop();

                // Convertimos en minúscula porque
                // la extensión del archivo puede estar en mayúscula
                ext = ext.toLowerCase();

                // console.log(ext);
                switch (ext) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'pdf': break;
                    default:
                        alert('El archivo no tiene la extensión adecuada');
                        this.value = ''; // reset del valor
                        this.files[0].name = '';
                }
            }
        });
</script>

    //Carga archivo, determina propiedades y valida tamano.
    var _URL = window.URL || window.webkitURL;
    $("#file").change(function(e) {
            var image, file;

        if ((file = this.files[0])) {

        var sizeByte = this.files[0].size;
        var sizekiloBytes = parseInt(sizeByte / 1024);

            image = new Image();

            image.onload = function() {
                document.getElementById("data").innerHTML = 'Datos imagen: tamano = ' + sizekiloBytes  + ' KB , ancho (width) = ' + this.width + ' , altura (height) = ' + this.height;

            if(sizekiloBytes > $('#file').attr('size')){
                alert('El tamaño supera el limite permitido!');
            $(this).val('');
            }else{
            alert('El tamaño es permitido (menor a ' + $('#file').attr('size') + ' KB)');
            }


            };

            image.src = _URL.createObjectURL(file);

        }

});

--}}



@endsection

    {{-- @section('scripts') --}}

        {{-- <script>
            $(document).on('change','input[type="file"]',function(){
                // this.files[0].size recupera el tamaño del archivo
                // alert(this.files[0].size);
                dd(this.files[0].size);

                var fileName = this.files[0].name;
                var fileSize = this.files[0].size;

                if(fileSize > 3000000){
                    alert('El archivo no debe superar los 3MB');
                    this.value = '';
                    this.files[0].name = '';
                }else{
                    // recuperamos la extensión del archivo
                    var ext = fileName.split('.').pop();

                    // Convertimos en minúscula porque
                    // la extensión del archivo puede estar en mayúscula
                    ext = ext.toLowerCase();

                    // console.log(ext);
                    switch (ext) {
                        case 'jpg':
                        case 'jpeg':
                        case 'png':
                        case 'pdf': break;
                        default:
                            alert('El archivo no tiene la extensión adecuada');
                            this.value = ''; // reset del valor
                            this.files[0].name = '';
                    }
                }
            });
        </script> --}}
    {{-- @endsection --}}
