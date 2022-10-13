@extends('layouts.app')

@section('content')

    <body class="ltr app sidebar-mini light-mode">
        <div class="page">
            <div class="page-main">
                <div class="app-content main-content mt-0">
					<div class="side-app">
						<!-- CONTAINER -->
						<div class="main-container container-fluid">
                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h3 class="card-title">File Export</h3>
                                            {{-- <a class="btn btn-warning" href="{{ route('usuarios.create') }}">Nuevo</a> --}}
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive export-table">
                                                <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">Foto</th>
                                                            <th class="border-bottom-0">Nombre</th>
                                                            <th class="border-bottom-0">Telefono</th>
                                                            <th class="border-bottom-0">Identificacion</th>
                                                            <th class="border-bottom-0">Copia documento</th>
                                                            <th class="border-bottom-0">E-mail</th>
                                                            <th class="border-bottom-0">Estado</th>
                                                            <th class="border-bottom-0">Acciones</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @foreach ($blogs as $factura)
                                                            <tr>
                                                                <td>
                                                                </td>
                                                                <td>{{ $factura->name }}</td>
                                                                <td>{{ $factura->telefono }}</td>
                                                                <td>{{ $usuario->identification }}</td>

                                                                <td>
                                                                    @if (!empty($usuario->identificationPhoto))
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                                                            <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                                                        </svg>
                                                                    @else
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                                                                            <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                                                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                                                        </svg>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $usuario->email }}</td>
                                                                <td>
                                                                    {{empty($usuario->estadoname->descripcion) ? 'No definido' : $usuario->estadoname->descripcion}}
                                                                </td>

                                                                <td>
                                                                    @if ($usuario->estado != 2)
                                                                        <a href="{{ route('usuario.confirmar', ['idUsuario' => $usuario->id]) }}" class="btn btn-primary">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                                                <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                                                            </svg>
                                                                        </a>
                                                                    @endif
                                                                    @if ($usuario->estado == 1)
                                                                        <a href="{{ route('usuario.rechazar', ['idUsuario' => $usuario->id]) }}" class="btn btn-danger">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                            </svg>
                                                                        </a>
                                                                    @endif
                                                                    <a class="btn btn-info" href="{{ route('usuarios.edit',$usuario->id) }}">Editar</a>

                                                                    {!! Form::open(['method' => 'DELETE','route' => ['usuarios.destroy', $usuario->id],'style'=>'display:inline']) !!}
                                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                                    {!! Form::close() !!}
                                                                </td>
                                                            </tr>
                                                        @endforeach --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Row -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>


    @section('scripts')
    {{-- <script>
        // $('#myModal').modal(options)
        $('#exampleModal').on('shown.bs.modal', function () {
        $('#exampleModal').trigger('focus')
        })

    </script> --}}
    @endsection
@endsection

