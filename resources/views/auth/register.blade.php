@extends('layouts.auth_app')
@section('title')
    Register
@endsection
@section('content')
    <div class="card card-primary">
        <div class="card-header"><h4>Register</h4></div>

        <div class="card-body pt-1">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input id="photo"
                                    accept="image/jpeg,image/jpg,image/png"
                                    type="file"
                                    class="form-control"
                                    name="photo"
                                    tabindex="1" placeholder="Enter Photo" value="{{ old('name') }}"
                                    autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">Full Name:</label><span
                                   class="text-danger">*</span>
                                   <input id="firstName" type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                   name="name"
                                   tabindex="1" placeholder="Enter Full Name" value="{{ old('name') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email:</label><span
                                    class="text-danger">*</span>
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   placeholder="Enter Email address" name="email" tabindex="1"
                                   value="{{ old('email') }}"
                                   required autofocus>
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefono_number">phone number:</label><span
                                    class="text-danger">*</span>
                            <input id="telefono" type="number"
                                   class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                   name="telefono"
                                   tabindex="1" placeholder="Enter Telefono" value="{{ old('telefono') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('telefono') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="identification_number">Identification number:</label><span
                                    class="text-danger">*</span>
                            <input id="identification"
                                   type="number"
                                   class="form-control{{ $errors->has('identification') ? ' is-invalid' : '' }}"
                                   name="identification"
                                   tabindex="1" placeholder="Enter Identification" value="{{ old('identification') }}"
                                   autofocus required>
                            <div class="invalid-feedback">
                                {{ $errors->first('identification') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="identification_photo">Copy of identity document(pdf):</label><span
                                   class="text-danger">*</span>
                            <input id="identificationPhoto"
                                   accept=".pdf"
                                   type="file"
                                   class="form-control"
                                   name="identificationPhoto"
                                   tabindex="1" placeholder="Enter Identification" value="{{ old('identificationPhoto') }}"
                                   autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password" class="control-label">Password
                                :</label><span
                                    class="text-danger">*</span>
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid': '' }}"
                                   placeholder="Set account password" name="password" tabindex="2" required>
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation"
                                   class="control-label">Confirm Password:</label><span
                                    class="text-danger">*</span>
                            <input id="password_confirmation" type="password" placeholder="Confirm account password"
                                   class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                   name="password_confirmation" tabindex="2">
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Register
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5 text-muted text-center">
        Already have an account ? <a
            href="{{ route('login') }}">SignIn</a>
    </div>

    <script>
        $(document).on('change','input[type="file"]',function(){
                // this.files[0].size recupera el tamaño del archivo
                // alert(this.files[0].size);
                dd(this.files[0].size);

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
    @endsection
    @section('scripts')
    {{-- <script>
        Swal.fire({
        title: 'Error!',
        text: 'Do you want to continue',
        icon: 'error',
        confirmButtonText: 'Cool'
        })
    </script> --}}
        <script>
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
        </script>
    @endsection
