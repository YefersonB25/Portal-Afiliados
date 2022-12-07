@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="card">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <a class="btn btn-warning" href="{{ route('roles.create') }}">Nuevo</a>
                                    {{-- @endcan --}}
                                    <table class="table table-striped mt-2">
                                        <thead style="background-color:#6777ef">
                                            <th style="color:#fff;">Rol</th>
                                            <th style="color:#fff;">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    {{-- @can('editar-rol') --}}
                                                    <a class="btn btn-primary"
                                                        href="{{ route('roles.edit',$role->id) }}">Editar</a>
                                                    {{-- @endcan --}}

                                                    {{-- @can('borrar-rol') --}}
                                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy',
                                                    $role->id],'style'=>'display:inline']) !!}
                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                    {{-- @endcan --}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- Centramos la paginacion a la derecha -->
                                    <div class="pagination justify-content-end">
                                        {!! $roles->links() !!}
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