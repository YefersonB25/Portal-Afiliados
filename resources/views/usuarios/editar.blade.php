@extends('layouts.app')

@section('content')

    <body class="ltr app sidebar-mini light-mode">
        <div class="app-content main-content mt-0">
            <div class="side-app">
                <div class="main-container container-fluid">
                    <div class="page-header">
                        <div>
                            <h1 class="page-title">Usuarios</h1>
                        </div>
                        <div class="ms-auto pageheader-btn">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('usuario.index') }}">Usuario</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Editar</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        @if ($errors->any())
                                            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                                <strong>¡Revise los campos!</strong>
                                                @foreach ($errors->all() as $error)
                                                    <span class="badge badge-danger">{{ $error }}</span>
                                                @endforeach
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        @endif

                                        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['usuarios.update', $user->id]]) !!}
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Nombre</label>
                                                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="email">E-mail</label>
                                                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="phone">Celular</label>
                                                    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="document_type">Tipo identificacion</label>
                                                    {!! Form::select('document_type', ['NIT' => 'NIT', 'CC' => 'Cedula de Ciudadania'], null, [
                                                        'class' => 'form-control',
                                                    ]) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="number_id">Numero identificacion</label>
                                                    {!! Form::text('number_id', null, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="status">Estado</label>
                                                    {!! Form::select(
                                                        'status',
                                                        ['NUEVO' => 'NUEVO', 'CONFIRMADO' => 'CONFIRMADO', 'RECHAZADO' => 'RECHAZADO', 'ASOCIADO' => 'ASOCIADO'],
                                                        null,
                                                        ['class' => 'form-control'],
                                                    ) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="">Roles</label>
                                                    {!! Form::select('roles[]', $roles, $userRole, ['class' => 'form-control']) !!}
                                                </div>
                                            </div>

                                            <button class="btn btn-warning" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseExample" aria-expanded="false"
                                                aria-controls="collapseExample">
                                                Cambiar Contraseña
                                            </button>

                                            <div class="form-group">
                                                <div class="collapse" id="collapseExample">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="password">Password</label>
                                                                {!! Form::password('password', ['class' => 'form-control']) !!}
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                                            <div class="form-group">
                                                                <label for="confirm-password">Confirmar Password</label>
                                                                {!! Form::password('confirm-password', ['class' => 'form-control']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Guardar</button>

                                        </div>
                                        {!! Form::close() !!}
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
    @if (Session::has('message'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El estado del usuario no concuerda con el rol asignado o viceversa!',
            })
        </script>
    @endif
    @if (Session::has('message1'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Los datos se guardaron correctamente'
            })
        </script>
    @endif
@endsection
