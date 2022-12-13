@extends('layouts.app')
@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="page">
        <div class="page-main">
            <div class="app-content main-content mt-0">
                <div class="side-app">
                    <div class="main-container container-fluid">
                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>¡Revise los campos!</strong>
                                            @foreach ($errors->all() as $error)
                                            <span class="badge badge-danger">{{ $error }}</span>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif


                                        {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="">Nombre del Rol:</label>
                                                    {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="">Permisos para este Rol:</label>
                                                    <br />
                                                    @foreach($permission as $value)
                                                    <label>{{ Form::checkbox('permission[]', $value->id, false,
                                                        array('class' => 'name')) }}
                                                        {{ $value->name }}</label>
                                                    <br />
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        {!! Form::close() !!}
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
