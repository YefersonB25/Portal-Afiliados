@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="row g-2">
                        <h3 class="card-title">Fitros</h3>
                        <form class="form-horizontal" method="post" action="{{route('user.filtros')}}" novalidate>
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md">
                                    <label for="estado" class="form-label">Filtrar por estado</label>
                                    <select type="text" name="estado" id="estado" class="form-select" tabindex="3"
                                        value="{{ old('estado') }}" autofocus onInput="validarInput()">
                                        <option selected>Todos</option>
                                        {{-- @foreach ($estados as $estado)
                                        <option value="{{$estado->id}}">{{$estado->descripcion}}</option>
                                        @endforeach --}}
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

            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h3 class="card-title">Tabla de solicitudes</h3>
                            {{-- <a class="btn btn-warning" href="{{ route('usuarios.create') }}">Nuevo</a> --}}
                        </div>

                        <div class="card-body">
                            <div class="table-responsive export-table">
                                <table id="file-datatable"
                                    class="table table-bordered text-nowrap key-buttons border-bottom w-100 tt">
                                    <thead>
                                        <tr>
                                            <th class="border-bottom-0">Parentesco</th>
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
                                            <td>
                                                {{$usuario->parent_id}}
                                                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                    @if ($usuario->parent_id != 0)
                                                    <path fill="currentColor"
                                                        d="M9,5A4,4 0 0,1 13,9A4,4 0 0,1 9,13A4,4 0 0,1 5,9A4,4 0 0,1 9,5M9,15C11.67,15 17,16.34 17,19V21H1V19C1,16.34 6.33,15 9,15M16.76,5.36C18.78,7.56 18.78,10.61 16.76,12.63L15.08,10.94C15.92,9.76 15.92,8.23 15.08,7.05L16.76,5.36M20.07,2C24,6.05 23.97,12.11 20.07,16L18.44,14.37C21.21,11.19 21.21,6.65 18.44,3.63L20.07,2Z" />
                                                    @else
                                                    <path fill="currentColor"
                                                        d="M2,3.27L3.28,2L22,20.72L20.73,22L16.73,18C16.9,18.31 17,18.64 17,19V21H1V19C1,16.34 6.33,15 9,15C10.77,15 13.72,15.59 15.5,16.77L11.12,12.39C10.5,12.78 9.78,13 9,13A4,4 0 0,1 5,9C5,8.22 5.22,7.5 5.61,6.88L2,3.27M9,5A4,4 0 0,1 13,9V9.17L8.83,5H9M16.76,5.36C18.78,7.56 18.78,10.61 16.76,12.63L15.08,10.94C15.92,9.76 15.92,8.23 15.08,7.05L16.76,5.36M20.07,2C24,6.05 23.97,12.11 20.07,16L18.44,14.37C21.21,11.19 21.21,6.65 18.44,3.63L20.07,2Z" />
                                                    @endif
                                                </svg>
                                            </td>
                                            <td>
                                                @if (!empty($usuario->photo))
                                                <span>
                                                    {{-- {{ Storage::get("$usuario->photo") }} --}}
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                        class="aImg">
                                                        <img src="{{asset(" $usuario->photo")}}" class="avatar
                                                        profile-user brround cover-image">
                                                    </a>
                                                </span>
                                                @else
                                                <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M12,19.2C9.5,19.2 7.29,17.92 6,16C6.03,14 10,12.9 12,12.9C14,12.9 17.97,14 18,16C16.71,17.92 14.5,19.2 12,19.2M12,5A3,3 0 0,1 15,8A3,3 0 0,1 12,11A3,3 0 0,1 9,8A3,3 0 0,1 12,5M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z" />
                                                </svg>
                                                @endif
                                            </td>
                                            <td>{{ $usuario->name }}</td>
                                            <td>{{ $usuario->phone }}</td>
                                            <td>{{ $usuario->number_id }}</td>
                                            <td>
                                                @if (!empty($usuario->photo_id))
                                                <span>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModalPdf"
                                                        class="aPdf">
                                                        <i src="{{asset(" $usuario->photo_id")}}"></i>
                                                        <svg style="width:34px;height:34px" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3M9.5 11.5C9.5 12.3 8.8 13 8 13H7V15H5.5V9H8C8.8 9 9.5 9.7 9.5 10.5V11.5M14.5 13.5C14.5 14.3 13.8 15 13 15H10.5V9H13C13.8 9 14.5 9.7 14.5 10.5V13.5M18.5 10.5H17V11.5H18.5V13H17V15H15.5V9H18.5V10.5M12 10.5H13V13.5H12V10.5M7 10.5H8V11.5H7V10.5Z" />
                                                        </svg>
                                                    </a>
                                                </span>
                                                @else
                                                <svg style="width:30px;height:30px" viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M2,3H22C23.05,3 24,3.95 24,5V19C24,20.05 23.05,21 22,21H2C0.95,21 0,20.05 0,19V5C0,3.95 0.95,3 2,3M14,6V7H22V6H14M14,8V9H21.5L22,9V8H14M14,10V11H21V10H14M8,13.91C6,13.91 2,15 2,17V18H14V17C14,15 10,13.91 8,13.91M8,6A3,3 0 0,0 5,9A3,3 0 0,0 8,12A3,3 0 0,0 11,9A3,3 0 0,0 8,6Z" />
                                                </svg>
                                                @endif
                                            </td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill bg-{{$usuario->badges($usuario->status)}}">
                                                    {{$usuario->status}}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($usuario->estado != 'ASOCIADO')
                                                <a href="{{ route('consultar.afiliado',[$usuario->id]) }}"
                                                    class="btn btn-info openBtn" id="consultaOTM">
                                                    <i class="fa fa-weibo" aria-hidden="true"></i>
                                                </a>
                                                {{-- <a class="btn btn-primary"
                                                    href="{{ route('consultar.afiliado',[$number_id,$document_type]) }}">aprobar</a>
                                                --}}
                                                @endif
                                                @if ($usuario->estado == 'NUEVO')
                                                <a href="{{ route('usuario.estado', ['usuario' => $usuario, 'estado' => 'aprobado']) }}"
                                                    class="btn btn-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                                    </svg>
                                                </a>

                                                <a href="{{ route('usuario.estado', ['usuario' => $usuario, 'estado' => 'rechazado']) }}"
                                                    class="btn btn-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                                        <path
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                                    </svg>
                                                </a>
                                                @endif
                                                @if ($usuario->estado == 'Asociado')
                                                <a href="" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalProveedor" data-bs-whatever="@mdo"
                                                    class="btn btn-primary proveedor"><svg
                                                        style="width:24px;height:24px" viewBox="0 0 24 24">
                                                        <path fill="currentColor"
                                                            d="M11 10V12H9V14H7V12H5.8C5.4 13.2 4.3 14 3 14C1.3 14 0 12.7 0 11S1.3 8 3 8C4.3 8 5.4 8.8 5.8 10H11M3 10C2.4 10 2 10.4 2 11S2.4 12 3 12 4 11.6 4 11 3.6 10 3 10M16 14C18.7 14 24 15.3 24 18V20H8V18C8 15.3 13.3 14 16 14M16 12C13.8 12 12 10.2 12 8S13.8 4 16 4 20 5.8 20 8 18.2 12 16 12Z" />
                                                    </svg></a>
                                                @endif
                                                {!! Form::open(['method' => 'DELETE','route' =>
                                                ['usuario.eliminar', $usuario->id],'style'=>'display:inline'])
                                                !!}
                                                {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    {{ $usuarios->links() }}
                                </table>
                            </div>
                        </div>
                        <!-- Modal imagen -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Foto Perfil</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <embed id="foto" src="" width="100%" height="100%">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal pdf -->
                        <div class="modal fade" id="exampleModalPdf" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Copia de documento
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <embed id="pdfdoc" src="" type="application/pdf" width="100%" height="500"
                                            alt="pdf"
                                            pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- modal-content proveedoer -->
                        <div class="modal fade" id="exampleModalProveedor" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Proveedor Acargo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" id="dataProveedor">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
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
@if (Session::has('message'))
<script>
    Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'No se encontro registro en OTM con el numero de identificacion del proveedor seleccionado!',
            })
</script>
@endif
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

        $(document).on("click", ".proveedor", function (e) {
            e.preventDefault()
            if($(this).parents("tr").hasClass('child')){ //vemos si el actual row es child row
                var idUsu = $(this).parents("tr").prev().find('td:eq(0)').text(); //si es asi, nos regresamos al row anterior, es decir, al padre y obtenemos el id
            } else {
                var idUsu = $(this).closest("tr").find('td:eq(0)').text(); //si no lo es, seguimos capturando el id del actual row
            }

            plantillaBody = '';

            $.ajax({
                type: 'POST',
                url: "{{ route('proveedor.encargado')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "userId": idUsu
                },
                success: function(response) {
                    let data = response.data;
                    console.log(data);
                    if(response.success == true){
                        $('#dataProveedor').html('')
                        plantillaBody = `
                        <form>
                            <div class="float-left">
                                <h6 class="mb-0 p-2"> <b>Nombre Completo:</b> ${data.name}</h6>
                                <h6 class="mb-0 p-2"> <b>Numero Identificacion:</b> ${data.identification}</h6>
                                <h6 class="mb-0 p-2"> <b>Correo:</b> ${data.email}</h6>
                                <h6 class="mb-0 p-2"> <b>Telefono:</b> ${data.telefono}</h6>
                            </div>
                        </form>

                        `
                        $('#dataProveedor').append(plantillaBody)
                    }
                    if(response.success == false){
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data,
                        })
                    }
                }

            });
        });

</script>

@endsection