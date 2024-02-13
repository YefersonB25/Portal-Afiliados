@extends('layouts.app')

@section('content')

    <body class="ltr app sidebar-mini light-mode">
        @can('/usuario.index')
            <div class="app-content main-content mt-0">
            @endcan
            <div class="side-app">
                <div class="main-container container-fluid">
                        <div class="page-header">
                            <div>
                                <h1 class="page-title">Perfil</h1>
                            </div>
                            <div class="ms-auto pageheader-btn">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Perfil</li>
                                </ol>
                            </div>
                        </div>
                    <div class="row" id="user-profile">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 col-md-12 col-xl-6">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div class="profile-img-main rounded">
                                                    <!-- Elemento img o div, según corresponda -->
                                                    <div id="profile-image-container">
                                                        <img id="profile-image" alt="avatar" class="avatar avatar-xl rounded">
                                                    </div>
                                                </div>
                                                <div class="ms-4">
                                                    <h4>{{ $user->name }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($user->status != 'ASOCIADO')
                                            <div class="col-lg-12 col-md-12 col-xl-6">
                                                <div class="d-md-flex flex-wrap justify-content-lg-end">
                                                    <div class="media m-3">
                                                        <div class="media-icon bg-info me-3 mt-1">
                                                            <i class="fe fe-users  fs-20 text-white"></i>
                                                        </div>
                                                        <div class="media-body">
                                                            <span class="text-muted">Usuarios asociados</span>
                                                            <div class="fw-semibold fs-25">
                                                                {{ count($user_relation) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
                                                        @if ($user->status != 'ASOCIADO')
                                                            <li><a href="#friends" data-bs-toggle="tab">Usuarios Asociados</a>
                                                            </li>
                                                            <li><a href="#accountSettings" data-bs-toggle="tab">Registrar
                                                                    Usuario</a>
                                                            </li>
                                                        @endif
                                                    @endcan
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
                                                <h3 class="card-title">Informacion personal</h3>
                                                <table class="table row table-borderless">
                                                    <tbody class="col-lg-12 col-xl-6 p-0">
                                                        <tr>
                                                            <td><strong>Nombre :</strong>{{ $user->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Email :</strong> {{ $user->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Phone :</strong>
                                                                {{ empty($user->phone) ? '0000000000' : $user->phone }}
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="editProfile">
                                    <div class="row">
                                        <div class="card col-xs-12 col-sm-12 col-md-5">
                                            <div class="card-body border-0">
                                                <div class="card-header font-weight-bold">
                                                    {{ __('Cambiar foto de perfil') }}

                                                </div>

                                                <form id="photo-profile-form" method="POST" action="{{ route('photo-profile.updatePhoto') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="input-group mb-3">
                                                                <input type="file" class="form-control" name="profile_image" aria-describedby="inputGroupFileAddon01">
                                                        </div>
                                                    </div>

                                                    <div class="card-footer">
                                                        <button type="button" class="btn btn-primary" id="photo-profile-button">Subir imagen de perfil</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-xs-1 col-sm-1 col-md-1"></div>
                                        <div class="card col-xs-12 col-sm-12 col-md-6">
                                            <div class="card-body border-0">
                                                <div class="card-header">{{ __('Informacion General') }}</div>

                                                <form class="form-horizontal" method="post"
                                                    action="{{ route('profile.update') }}" novalidate>
                                                    @csrf
                                                    <div class="card-body">
                                                        {{ method_field('PUT') }}
                                                        <div class="row mb-4">
                                                            <div class="col-md-12 col-lg-12 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="email" class="form-label">email</label>
                                                                    <input type="text" name="pfEmail" id="pfEmail"
                                                                        class="form-control" tabindex="3"
                                                                        value="{{ $user->email }}" disabled
                                                                        onInput="validarInput()">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-xl-6">
                                                                <div class="form-group">
                                                                    <label for="phone" class="form-label">Phone</label>
                                                                    <input type="text" name="pfTelefono" id="pfTelefono"
                                                                        class="form-control" tabindex="3"
                                                                        value="{{ $user->phone }}" onInput="validarInput()">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-xl-6">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary"
                                                            id="btnPrEditSave">Guardar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-body border-0">
                                                <div class="card-header">{{ __('Cambiar la contraseña') }}</div>

                                                <form id="change-password-form" action="{{ route('change-password.update') }}" method="POST">
                                                    @csrf
                                                    <div class="card-body">

                                                            <div id="errors-container" class="alert alert-danger" role="alert" style="display: none">
                                                            </div>

                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                                <label for="oldPasswordInput" class="form-label">Contraseña anterior</label>
                                                                <input name="old_password" type="password"
                                                                    class="form-control @error('old_password') is-invalid @enderror"
                                                                    id="oldPasswordInput" placeholder="Contraseña anterior">
                                                                @error('old_password')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                                <label for="newPasswordInput" class="form-label">Nueva contraseña</label>
                                                                <input name="new_password" type="password"
                                                                    class="form-control @error('new_password') is-invalid @enderror"
                                                                    id="newPasswordInput" placeholder="Nueva contraseña">
                                                                @error('new_password')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                                <label for="confirmNewPasswordInput"
                                                                    class="form-label">Confirmar nueva contraseña</label>
                                                                <input name="new_password_confirmation" type="password"
                                                                    class="form-control" id="confirmNewPasswordInput"
                                                                    placeholder="Confirmar nueva contraseña">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="card-footer">
                                                        <button type="button" id="change-password-button" class="btn btn-primary">Cambiar Contraseña</button>
                                                    </div>

                                                </form>
                                            </div>

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
                                                        <h3 class="card-title"> {{ $asociado->name }}</h3>
                                                        <div class="card-options">
                                                            <div class="dropdown text-end">
                                                                @if ($asociado->deleted_at == null)
                                                                    <a href="#" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="true">
                                                                        <i class="fe fe-more-vertical text-muted"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right shadow">
                                                                        <a class="dropdown-item clickDeleted"
                                                                            id="{{ $asociado->deleted_status }}"
                                                                            href="{{ url("profile/userAsociado/{$asociado->id}") }}">
                                                                            <i class="fe fe-trash-2 me-2"></i> Delete
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                                @if ($asociado->deleted_at != null)
                                                                    <a href="#" data-bs-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="true">
                                                                        <i class="fe fe-more-vertical text-muted"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right shadow">
                                                                        <a class="dropdown-item"
                                                                            href="{{ url("profile/userAsociadoRestore/{$asociado->id}") }}">
                                                                            <i class="fa fa-retweet"
                                                                                aria-hidden="true"></i>
                                                                            Reasignar
                                                                        </a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="card-alert alert alert-{{ $asociado->deleted_at == null ? 'success' : 'danger' }} mb-0">
                                                        {{ $asociado->deleted_at == null
                                                            ? 'Usuario vigente'
                                                            : 'Usuario
                                                                                                                                                                                                                    inabilitado' }}
                                                    </div>
                                                    <div class="card-body text-center">
                                                        <a href="#">
                                                            <div
                                                                class="avatar avatar-md bg-{{ $user->otherColors(rand(2, 9)) }} text-white rounded-circle">
                                                                {{ substr($asociado->email, 0, 2) }}
                                                            </div>
                                                            <h4 class="fs-16 mb-0 mt-3 text-dark fw-semibold">
                                                                {{ $asociado->name }}</h4>
                                                            <span class="text-muted">{{ $asociado->phone }}</span>
                                                            <br>
                                                            <span class="text-muted">{{ $asociado->email }}</span>
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
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div><br />
                                            @endif
                                            {{-- <div class="alert alert-success" id="alert" style="display: none;">&nbsp;
                                        </div> --}}
                                            <form method="POST" id="rgisterform"
                                                action="{{ route('userAsociado.create') }}" enctype="multipart/form-data"
                                                class="form-horizontal validate-form" data-select2-id="11">
                                                <div class="mb-4 main-content-label">Account</div>
                                                @csrf
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName" class="form-label">Full Name</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="firstName" type="text"
                                                                class="form-control input100{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                                name="name" tabindex="1"
                                                                placeholder="Nombre Completo" value="{{ old('name') }}"
                                                                autofocus required>
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
                                                                class="form-control input100{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                                placeholder="Enter Email address" name="email"
                                                                tabindex="1" value="{{ old('email') }}" required
                                                                autofocus>
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
                                                                class="form-control input100{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
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
                                                            <label for="userName" class="form-label">Tipo
                                                                documento</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="wrap-input100 validate-input">
                                                                <select class="form-control" name="document_type"
                                                                    aria-label=".form-select-sm example" required>
                                                                    <option selected value="">Seleccione tipo
                                                                        Documento
                                                                    </option>
                                                                    <option value="NIT">NIT</option>
                                                                    <option value="CC">Cedula de
                                                                        Ciudadania</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first('document_type') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName"
                                                                class="form-label">Identification</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="identification" type="number"
                                                                class="form-control input100{{ $errors->has('identification') ? ' is-invalid' : '' }}"
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
                                                                class="form-control input100{{ $errors->has('password') ? ' is-invalid' : '' }}"
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
                                                            <button type="submit"
                                                                class="btn btn-primary btn-lg btn-block" tabindex="4">
                                                                Register
                                                            </button>
                                                        </div>
                                                    </div>
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
        </div>
    </body>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script src={{ asset('views/js/profile/profile-modifications.js') }}></script>

    <script>
        $(document).ready(function() {
            // Verificar si el usuario tiene una imagen de perfil
            var profileImage = '{{ asset('storage/' . Auth::user()->photo) }}';

            if (profileImage !== '{{ asset('storage/') }}') {
                // Si tiene una imagen, mostrarla en el elemento img
                $('#profile-image').attr('src', profileImage);
            } else {
                // Si no tiene una imagen, mostrar el div con las iniciales
                var initials = '{{ strtoupper(substr(Auth::user()->email, 0, 2)) }}';
                var backgroundColor = 'bg-' + '{{ Auth::user()->otherColors(rand(2, 9)) }}';
                var divContent = '<div class="avatar avatar-xl ' + backgroundColor + ' text-white rounded-circle">' + initials + '</div>';
                $('#profile-image-container').html(divContent);
            }
        });

        $(document).on("submit", "#rgisterform", function(e) {
            e.preventDefault(); //detemos el formluario
            $("#rgisterform").validate();
            $.ajax({
                type: $('#rgisterform').attr('method'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $('#rgisterform').attr('action'),
                data: $('#rgisterform').serialize(),
                success: function(response) {
                    if (response.success == true) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Usuario registrado correctamente',
                            showConfirmButton: false,
                            timer: 2500
                        })
                        $("#rgisterform")[0].reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Solo puede registrar como máximo 4 Usuario, para más información comuníquese con el Administrador!',
                        })
                        $("#rgisterform")[0].reset();
                    }
                }
            });
        });

        // $('.clickDeleted').on('click', function(e) {
        //     e.preventDefault();
        //     let status = this.id
        //     console.log(status);
        //     if (status == "RESIGNED") {
        //         const swalWithBootstrapButtons = Swal.mixin({
        //         customClass: {
        //             confirmButton: 'btn btn-success',
        //             cancelButton: 'btn btn-danger'
        //         },
        //         buttonsStyling: false
        //         })

        //         swalWithBootstrapButtons.fire({
        //         title: 'Advertencia!',
        //         text: "El usuario ha sido eliminado y reasignado anteriormente, tenga en cuenta que si lo vuelve a eliminar no podrá volver a ser reasignado!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Si, eliminar!',
        //         cancelButtonText: 'No, cancelar!',
        //         reverseButtons: true
        //         }).then((result) => {
        //         if (result.isConfirmed) {

        //             swalWithBootstrapButtons.fire(
        //             'Eliminado!',
        //             'El usuario eliminado correctamente',
        //             'success'
        //             )
        //         } else if (
        //             /* Read more about handling dismissals below */
        //             result.dismiss === Swal.DismissReason.cancel
        //         ) {
        //             swalWithBootstrapButtons.fire(
        //             'Cancelado',
        //             'Tu usuario está a salvo :)',
        //             'error'
        //             )
        //         }
        //         })
        //     }
        // })

        let urlChangePassword = "{{ route('change-password.update') }}"
        changePassword(urlChangePassword);

        let urlupdatePhoto = "{{ route('photo-profile.updatePhoto') }}"
        updatePhoto(urlupdatePhoto);
    </script>

    @if (session('message'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El usuario no puede ser eliminado, ya que anteriormente fue eliminado y reasignado, por tal motivo no se puede proceder con la eliminación!',
            })
        </script>
    @endif


@endsection
