@extends('layouts.app')

@section('content')

    <body class="ltr app sidebar-mini light-mode">
        <div class="page">
            <div class="page-main">
                <div class="app-content main-content mt-0">
                    <div class="side-app">
                        <!-- CONTAINER -->
                            <div class="card">
                                <div class="card-header border-bottom">
                                    <div class="row g-2">
                                        <h3 class="card-title">Fitros</h3>
                                            <form class="form-horizontal" method="post" action="{{route('user.filtros')}}" novalidate>
                                                @csrf
                                                <div class="row mb-2">
                                                    <div class="col-md">
                                                        <label for="estado" class="form-label">Filtrar por estado</label>
                                                        <select type="text" name="estado" id="estado" class="form-select" tabindex="3" value="{{ old('estado') }}" autofocus onInput="validarInput()">
                                                            <option selected>Todos</option>
                                                            @foreach ($estados as $estado)
                                                                <option value="{{$estado->id}}">{{$estado->descripcion}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('estado') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary" id="btnPrEditSave">Filtrar</button>
                                            </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header border-bottom">
                                            <h3 class="card-title">Tabla de solicitudes</h3>
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
                                                        @foreach ($usuarios as $usuario)
                                                            <tr>
                                                                {{-- <img src="{{Storage::get("$usuario->photo")}}" class="avatar profile-user brround cover-image"> --}}
                                                                <td>
                                                                    @if (!empty($usuario->photo))
                                                                        <span>
                                                                            {{-- {{ Storage::get("$usuario->photo") }} --}}
                                                                            <a href=""  data-bs-toggle="modal" data-bs-target="#exampleModal" class="aImg">
                                                                                <img src="{{asset("$usuario->photo")}}" class="avatar profile-user brround cover-image">
                                                                            </a>
                                                                        </span>
                                                                    @else
                                                                        <i class="fa fa-user-circle-o" width="30" height="30" aria-hidden="true"></i>
                                                                    @endif
                                                                </td>
                                                                {{-- {{$usuario->getRoleNames()}} --}}
                                                                <td>{{ $usuario->name }}</td>
                                                                <td>{{ $usuario->telefono }}</td>
                                                                <td>{{ $usuario->identification }}</td>

                                                                <td>
                                                                    @if (!empty($usuario->identificationPhoto))
                                                                    <span>
                                                                        {{-- {{ Storage::get("$usuario->photo") }} --}}
                                                                        <a href=""  data-bs-toggle="modal" data-bs-target="#exampleModalPdf" class="aPdf">
                                                                            <i src="{{asset("$usuario->identificationPhoto")}}" class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                                        </a>
                                                                    </span>
                                                                    @else
                                                                        <i class="fa fa-address-card" aria-hidden="true"></i>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $usuario->email }}</td>
                                                                <td>
                                                                    {{empty($usuario->estadoname->descripcion) ? 'No definido' : $usuario->estadoname->descripcion}}
                                                                </td>
                                                                {{-- <td>
                                                                @if(!empty($usuario->getRoleNames()))
                                                                    @foreach($usuario->getRoleNames() as $rolNombre)
                                                                    <h5><span class="badge badge-dark">{{ $rolNombre }}</span></h5>
                                                                    @endforeach
                                                                @endif
                                                                </td> --}}
                                                                <td>
                                                                    @php
                                                                        $identificacion = Crypt::encryptString($usuario->identification);
                                                                        $seleccion_nit  = Crypt::encryptString($usuario->seleccion_nit);
                                                                    @endphp
                                                                    <a href="consultaOTM/afiliado/{{$identificacion}}/{{$seleccion_nit}}" class="btn btn-info openBtn" id="consultaOTM">
                                                                        <i class="fa fa-weibo" aria-hidden="true"></i>
                                                                    </a>
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
                                                                    {{-- <a class="btn btn-info" href="{{ route('confirmar',$usuario->id) }}">Confirmar</a> --}}
                                                                    {{-- <a class="btn btn-info op" href="{{ route('usuarios.edit',$usuario->id) }}">
                                                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                    </a> --}}

                                                                    {!! Form::open(['method' => 'DELETE','route' => ['usuario.eliminar', $usuario->id],'style'=>'display:inline']) !!}
                                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}

                                                                    {!! Form::close() !!}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Modal imagen -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Foto Perfil</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed id="foto" src="" width="100%" height="100%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal pdf -->
                                        <div class="modal fade" id="exampleModalPdf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Copia de documento</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed id="pdfdoc" src="" type="application/pdf" width="100%" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                                                    </div>
                                                </div>
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

@endsection
@section('scripts')
@if (Session::has('message'))
   <script>
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'No se encontro registro en OTM con el numero de identificacion del proveedor seleccionado!',
        })
   </script>
@endif

        {{-- <script>
            // $('#myModal').modal(options)
            $('#exampleModal').on('shown.bs.modal', function () {
            $('#exampleModal').trigger('focus')
            })

        </script> --}}

    <script>
        //? cargamos la imagen en el modal
        let alinks = document.getElementsByClassName('aImg')

        for (const alink of alinks) {
            alink.addEventListener('click', function(e){
                e.preventDefault()
                let url = this.children[0].attributes[0].nodeValue
                document.getElementById('foto').attributes[1].nodeValue = url
            })
        }

        let alinksPdf = document.getElementsByClassName('aPdf')

        for (const alinkPdf of alinksPdf) {
            alinkPdf.addEventListener('click', function(e){
                e.preventDefault()
                let url = this.children[0].attributes[0].nodeValue
                document.getElementById('pdfdoc').attributes[1].nodeValue = url
            })
        }


        // //? Cargamos los datos que traemos de OTM al modal en el controlador
        // $('.openBtn').on('click',function(){
        //     $('.modal-body').load('UsuarioController.php?identifAfiliado=2',function(){
        //         $('#myModal').modal({show:true});
        //     });
        // });
    </script>

@endsection

