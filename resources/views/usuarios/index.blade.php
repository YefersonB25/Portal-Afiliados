@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="card">
                <div class="card-header border-bottom">
                    <div class="row g-2">
                        <h3 class="card-title">Fitros</h3>
                        <form class="form-horizontal" id="filter" action="{{ route('user.filtros') }}" method="post"
                            novalidate>
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md">
                                    <label for="estado" class="form-label">Filtrar por estado</label>
                                    <select type="text" name="estado" id="estado" class="form-control" tabindex="3"
                                        value="{{ old('estado') }}" autofocus>
                                        <option selected>Todos</option>
                                        <option value="NUEVO">NUEVO</option>
                                        <option value="CONFIRMADO">CONFIRMADO</option>
                                        <option value="RECHAZADO">RECHAZADO</option>
                                        <option value="ASOCIADO">ASOCIADO</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ $errors->first('estado') }}
                                    </div>
                                </div>
                                <div class="col-md">
                                    <label for="number_id" class="form-label">Numero de Identificacion</label>
                                    <input type="text" name="number_id" id="number_id" class="form-control" tabindex="3"
                                        value="{{ old('number_id') }}" autofocus>
                                </div>
                            </div>
                            <button type="submit" id="btnFilter" class="btn btn-primary">Filtrar</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ROW OPEN -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="file-datatable"
                                    class="table table-bordered text-nowrap key-buttons border-bottom w-100 tt">
                                    <thead>
                                        <tr>
                                            <th class="wd-2">Foto</th>
                                            <th>Nombre</th>
                                            <th>Telefono</th>
                                            <th># Doc</th>
                                            <th>PDF Doc</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usuarios as $usuario)
                                        <tr>
                                            <td class="text-center">
                                                <div
                                                    class="avatar avatar-md bg-{{$usuario->otherColors(rand(2,9))}} text-white rounded-circle">
                                                    {{substr($usuario->email,0,2)}}
                                                </div>
                                            </td>
                                            <td>
                                                <p class="tx-14 font-weight-semibold text-dark mb-1">{{$usuario->name}}
                                                </p>
                                                <p class="tx-13 text-muted mb-0"><a
                                                        href="mailto:{{$usuario->email}}">{{$usuario->email}} </a></p>
                                            </td>
                                            <td>
                                                <span class="text-muted tx-13">{{$usuario->phone}}</span>
                                            </td>
                                            <td>
                                                <span class="text-muted tx-13">{{$usuario->number_id}}</span>
                                            </td>
                                            <td class="text-center">
                                                @if (!empty($usuario->photo_id))
                                                <span>
                                                    <a href="" data-bs-toggle="modal" data-bs-target="#exampleModalPdf"
                                                        class="aPdf">
                                                        <i src="{{asset(" $usuario->photo_id")}}"></i>
                                                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V4C4,2.89 4.89,2 6,2M15,18V16H6V18H15M18,14V12H6V14H18Z" />
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
                                            <td>
                                                {{ !empty($usuario->rol->rol_nombre['name']) ?
                                                $usuario->rol->rol_nombre['name'] : '' }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge font-weight-semibold bg-{{$usuario->badges($usuario->status)}}-transparent text-{{$usuario->badges($usuario->status)}} tx-11">
                                                    {{$usuario->status}}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('consultar.afiliado',[$usuario->id]) }}"
                                                    class="btn btn-icon btn-info-light me-2" id="consultAfiliado"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-original-title="Validar Informacion">
                                                    <i class="fa fa-user"></i>
                                                </a>
                                                @switch($usuario->status)
                                                @case('ASOCIADO')
                                                <a data-bs-whatever="@mdo" id="{{$usuario->id}}"
                                                    class="proveedor btn btn-icon btn-success-light me-2"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Consultar Padre">
                                                    <i class="fa fa-users"></i>
                                                </a>

                                                @break
                                                @case('NUEVO')
                                                <a href="{{ route('usuario.estado', ['usuario' => $usuario, 'estado' => 'aprobado']) }}"
                                                    class="btn btn-icon btn-primary-light me-2" data-bs-toggle="tooltip"
                                                    data-bs-original-title="Aceptar">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <a href="{{ route('usuario.estado', ['usuario' => $usuario, 'estado' => 'rechazado']) }}"
                                                    class="btn btn-icon btn-warning-light me-2" data-bs-toggle="tooltip"
                                                    data-bs-original-title="Rechazar">
                                                    <i class="fa fa-user-times"></i>
                                                </a>
                                                @break
                                                @default
                                                @break
                                                @endswitch
                                                <a href="{{ route('edit', [$usuario->id]) }}"
                                                    class="btn btn-icon btn-warning-light me-2" data-bs-toggle="tooltip"
                                                    data-bs-original-title="Editar">
                                                    <i class="fa fa-pencil-square"></i>
                                                </a>
                                                <a href="" id="{{$usuario->id}}"
                                                    class="deletedUser btn btn-icon btn-danger-light me-2"
                                                    data-bs-toggle="tooltip" data-bs-original-title="Eliminar">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $usuarios->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROW CLOSED -->
            <!-- Modal imagen -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Foto Perfil</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed id="foto" src="" width="100%" height="100%">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <embed id="pdfdoc" src="" type="application/pdf" width="100%" height="500" alt="pdf"
                                pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- modal-content proveedoer -->
            <div class="modal fade" id="exampleModalProveedor" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Proveedor Acargo</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="dataProveedor">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    window.onload = function () {
        swal.close();

    }

    // load
        let Loader = function(){
            Swal.fire({
            title: 'Espere un momento, estamos consultando la información!',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
            },
            })
        }
    // Fin

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

        $(document).on("click", ".deletedUser", function (e){
            e.preventDefault()
            let id = this.id
            const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
            title:'¿Estás seguro que deseas eliminar este usuario?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminarlo',
            cancelButtonText: 'No, Cancelar!',
            reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('usuario.eliminar')}}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "userId": id
                    },
                    success: function(response) {
                        console.log(response.data);
                        if(response.success == true){
                            swalWithBootstrapButtons.fire(
                            '¡Eliminado!',
                            'El usuario ha sido eliminado',
                            'success'
                            )
                        }
                        window.location.reload();
                    }
                });

            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                'Cancelado',
                'El usuario está seguro :)',
                'error'
                )
            }
            })
        });

        $(document).on("click", ".proveedor", function (e) {
            e.preventDefault()
            let id = this.id

            plantillaBody = '';

            $.ajax({
                type: 'POST',
                url: "{{ route('proveedor.encargado')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "userId": id
                },
                success: function(response) {
                    let data = response.data;
                    if(response.success == true){
                        $('#dataProveedor').html('')
                        plantillaBody = `
                        <form>
                            <div class="float-left">
                                <h6 class="mb-0 p-2"> <b>Nombre Completo:</b> ${data.name}</h6>
                                <h6 class="mb-0 p-2"> <b>Numero Identificacion:</b> ${data.number_id}</h6>
                                <h6 class="mb-0 p-2"> <b>Correo:</b> ${data.email}</h6>
                                <h6 class="mb-0 p-2"> <b>Telefono:</b> ${data.phone}</h6>
                            </div>
                        </form>

                        `
                        $('#dataProveedor').append(plantillaBody)

                            $('#exampleModalProveedor').modal('show');
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

        $(document).on("submit","#filter",function(e){
            e.preventDefault();//detemos el formluario
                $.ajax({
                    type: $('#filter').attr('method'),
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    url: $('#filter').attr('action'),
                    data: $('#filter').serialize(),
                    success: function (res) {
                        console.log(res.data);
                    }
                });

                // })
        });

        $(document).on('click', "#consultAfiliado", function (e) {
            Loader();
        });

        $(document).on("click", "#consultFacturas", function (e) {
            Loader();
        });


</script>

@endsection
