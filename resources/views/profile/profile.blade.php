@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="row" id="user-profile">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-lg-12 col-md-12 col-xl-6">
                                        <div class="d-flex flex-wrap align-items-center">
                                            <div class="profile-img-main rounded">
                                                {{-- <img src="{{asset(" $user->photo")}}" alt="avatar" class="avatar
                                                avatar-xl rounded"> --}}
                                                <div
                                                    class="avatar avatar-xl bg-{{$user->otherColors(rand(2,9))}} text-white rounded-circle">
                                                    {{strtoupper(substr($user->email,0,2))}}
                                                </div>
                                            </div>
                                            <div class="ms-4">
                                                <h4>{{$user->name}}</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-xl-6">
                                        <div class="d-md-flex flex-wrap justify-content-lg-end">
                                            <div class="media m-3">
                                                <div class="media-icon bg-info me-3 mt-1">
                                                    <i class="fe fe-users  fs-20 text-white"></i>
                                                </div>
                                                <div class="media-body">
                                                    <span class="text-muted">Usuarios asociados</span>
                                                    <div class="fw-semibold fs-25">
                                                        {{count($user_relation)}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top">
                                <div class="wideget-user-tab">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <ul class="nav">
                                                <li><a href="#profileMain" class="active show"
                                                        data-bs-toggle="tab">Perfil</a></li>
                                                <li><a href="#editProfile" data-bs-toggle="tab">Editar Perfil</a></li>
                                                @can('/facturas')
                                                <li><a href="#friends" data-bs-toggle="tab">Usuarios Asociados</a></li>
                                                <li><a href="#accountSettings" data-bs-toggle="tab">Registrar Usuario</a>
                                                @endcan
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active show" id="profileMain">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="border-top"></div>
                                        <div class="table-responsive p-5">
                                            <h3 class="card-title">Personal Info</h3>
                                            <table class="table row table-borderless">
                                                <tbody class="col-lg-12 col-xl-6 p-0">
                                                    <tr>
                                                        <td><strong>Full Name :</strong>{{$user->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email :</strong> {{$user->email}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Phone :</strong> {{empty($user->phone) ?
                                                            '0000000000' : $user->phone}} </td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="editProfile">
                                <div class="card">
                                    <div class="card-body border-0">
                                        <form class="form-horizontal" method="post"
                                            action="{{route('profile.update', $user->id)}}" novalidate>
                                            @csrf
                                            {{ method_field('PUT') }}
                                            <div class="row mb-4">
                                                <p class="mb-4 text-17">Personal Info</p>
                                                <div class="col-md-12 col-lg-12 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="email" class="form-label">email</label>
                                                        <input type="text" name="pfEmail" id="pfEmail"
                                                            class="form-control" tabindex="3" value="{{$user->email}}"
                                                            disabled onInput="validarInput()">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-12 col-xl-6">
                                                    <div class="form-group">
                                                        <label for="phone" class="form-label">Phone</label>
                                                        <input type="text" name="pfTelefono" id="pfTelefono"
                                                            class="form-control" tabindex="3" value="{{$user->phone}}"
                                                            onInput="validarInput()">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary"
                                                id="btnPrEditSave">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- Lista de Usuarios Asociados --}}
                            <div class="tab-pane" id="friends">
                                <div class="row row-sm">
                                    @foreach ($user_relation as $asociado)
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                        <div class="card">
                                            <div class="card-header border-bottom">
                                                <h3 class="card-title"> {{$asociado->name}}</h3>
                                                <div class="card-options">
                                                    <div class="dropdown text-end">
                                                        @if ($asociado->deleted_at == null)
                                                        <a href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="true">
                                                            <i class="fe fe-more-vertical text-muted"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right shadow">
                                                            <a class="dropdown-item" href="{{url("profile/userAsociado/{$asociado->id}")}}">
                                                                <i class="fe fe-trash-2 me-2"></i> Delete
                                                            </a>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="card-alert alert alert-{{$asociado->deleted_at == null ? 'success' : 'danger'}} mb-0">
                                                {{$asociado->deleted_at == null ? 'Usuario vigente' : 'Usuario
                                                desactivado'}}
                                            </div>
                                            <div class="card-body text-center">
                                                <a href="#">
                                                    <div
                                                        class="avatar avatar-md bg-{{$user->otherColors(rand(2,9))}} text-white rounded-circle">
                                                        {{substr($asociado->email,0,2)}}
                                                    </div>
                                                    <h4 class="fs-16 mb-0 mt-3 text-dark fw-semibold">
                                                        {{$asociado->name}}</h4>
                                                    <span class="text-muted">{{$asociado->phone}}</span>
                                                    <br>
                                                    <span class="text-muted">{{$asociado->email}}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            {{-- Registro de Asociado --}}
                            <div class="tab-pane" id="accountSettings">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="rgisterform" action="{{route('userAsociado.create')}}"
                                            enctype="multipart/form-data" class="form-horizontal" data-select2-id="11">
                                            <div class="mb-4 main-content-label">Account</div>
                                            @csrf
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label for="userName" class="form-label">Full Name</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="firstName" type="text"
                                                            class="input100{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                            name="name" tabindex="1" placeholder="Nombre Completo"
                                                            value="{{ old('name') }}" autofocus required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label for="userName" class="form-label">Email</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="email" type="email"
                                                            class="input100{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                            placeholder="Enter Email address" name="email" tabindex="1"
                                                            value="{{ old('email') }}" required autofocus>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('email') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label for="userName" class="form-label">Phone</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="telefono" type="number"
                                                            class="input100{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                                            name="telefono" tabindex="1" placeholder="Telefono"
                                                            value="{{ old('telefono') }}" autofocus required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('telefono') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label for="userName" class="form-label">Tipo documento</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="wrap-input100 validate-input">
                                                            <select class="form-select" name="document-type" aria-label=".form-select-sm example" required>
                                                                <option selected value="">Seleccione tipo Documento</option>
                                                                <option value="NIT">NIT</option>
                                                                <option value="Cedula de Ciudadania">Cedula de Ciudadania</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                {{ $errors->first('document-type') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label for="userName" class="form-label">Identification</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="identification" type="number"
                                                            class="input100{{ $errors->has('identification') ? ' is-invalid' : '' }}"
                                                            name="identification" tabindex="1"
                                                            placeholder="Numero Identificacion"
                                                            value="{{ old('identification') }}" autofocus required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('identification') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <label for="userName" class="form-label">Password</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input id="password" type="password"
                                                            class="input100{{ $errors->has('password') ? ' is-invalid': '' }}"
                                                            placeholder="Contraseña" name="password" tabindex="2"
                                                            required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('password') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row row-sm">
                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-primary btn-lg btn-block"
                                                            tabindex="4">
                                                            Register
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h3 class="card-title">Default Validation</h3>
                                        </div>
                                        <div class="card-body">
                                            <form>
                                                <div class="form-row">
                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                                        <label for="validationDefault01">First name</label>
                                                        <input type="text" class="form-control" id="validationDefault01" value="Daniel" required>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                                        <label for="validationDefault02">Last name</label>
                                                        <input type="text" class="form-control" id="validationDefault02" value="Obrien" required>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                                        <label for="validationDefault03">City</label>
                                                        <input type="text" class="form-control" id="validationDefault03" required>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                                        <label for="validationDefault04">State</label>
                                                        <select class="form-select select2 form-control" id="validationDefault04" required>
                                                            <option selected disabled value="">Choose...</option>
                                                            <option>...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">
                                                        <label for="validationDefault05">Zip Code</label>
                                                        <input type="number" class="form-control" id="validationDefault05" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="ckbox">
                                                        <input type="checkbox" id="invalidCheck2" required>
                                                        <span class="text-13">I agree terms and conditions</span>
                                                    </label>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Submit form</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('scripts')

@if (Session::has('message'))
<script>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Usuario registrado correctamente',
        showConfirmButton: false,
        timer: 2500
        })
</script>
@endif
@if (Session::has('messageError'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Solo puede registrar como máximo 4 Usuario, para más información comuníquese con el Administrador!',
        })
</script>
@endif
@endsection
