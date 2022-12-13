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
                                        <select type="text" name="estado" id="estado" class="form-select" tabindex="3" value="{{ old('estado') }}" autofocus onInput="validarInput()">
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
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnPrEditSave">Filtrar</button>
                            </form>
                    </div>
                </div>
            </div>
            <!-- ROW OPEN -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <table id="user-datatable" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="wd-2">Foto</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th># Doc</th>
                                        <th>PDF Doc</th>
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
                                            <p class="tx-13 text-muted mb-0">{{$usuario->email}}</p>
                                        </td>
                                        <td>
                                            <span class="text-muted tx-13">{{$usuario->phone}}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted tx-13">{{$usuario->number_id}}</span>
                                        </td>
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
                                        <td>
                                            <span
                                                class="badge font-weight-semibold bg-{{$usuario->badges($usuario->status)}}-transparent text-{{$usuario->badges($usuario->status)}} tx-11">
                                                {{$usuario->status}}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('consultar.afiliado',[$usuario->id]) }}"
                                                class="btn btn-icon btn-info-light me-2" data-bs-toggle="tooltip"
                                                data-bs-original-title="Consultar">
                                                <i class="fa fa-user"></i>
                                            </a>
                                            @switch($usuario->status)
                                            @case('ASOCIADO')
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModalProveedor"
                                                data-bs-whatever="@mdo" class="btn btn-icon btn-success-light me-2">
                                                <i class="fa fa-users"></i>
                                            </a>
                                            <a href="#" class="btn btn-icon btn-danger-light me-2"
                                                data-bs-toggle="tooltip" data-bs-original-title="Borrar">
                                                <i class="fa fa-trash"></i>
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
                                            {!! Form::open(['method' => 'DELETE','route' =>
                                            ['usuario.eliminar', $usuario->id],'style'=>'display:inline'])
                                            !!}

                                            {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
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
