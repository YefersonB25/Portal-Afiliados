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
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                            </ol>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <a href="{{ url('portal/usuarios/create') }}" class="btn btn-primary">
                                    Crear Usuario
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="row">
                            <button class="btn btn-info dropdown-toggle" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Filtros
                            </button>
                        </div>
                    </div>
                </div>


                <div class="collapse" id="collapseExample">
                    <div class="row row-sm">
                        <div class="col-lg-12">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <form class="form-horizontal" id="filter" action="{{ route('user.filtros') }}"
                                        method="post" novalidate>
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label for="estado" class="form-label">Filtrar por estado</label>
                                                <select type="text" name="estado" id="estado" class="form-control"
                                                    tabindex="3" value="{{ old('estado') }}" autofocus>
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
                                            <div class="col-lg-3">
                                                <label for="number_id" class="form-label">Numero de Identificacion</label>
                                                <input type="text" name="number_id" id="number_id" class="form-control"
                                                    tabindex="3" value="{{ old('number_id') }}" autofocus>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="limit" class="form-label">Limite de Usuarios</label>
                                                {{-- <input type="text" name="limit" id="limit" class="form-control" tabindex="3"
                                                    value="{{ old('limit') }}" autofocus> --}}
                                                <select name="limit" id="limit-input" class="form-control" tabindex="3"
                                                    value="{{ old('limit') }}" autofocus>
                                                    <option value="50" selected>50</option>
                                                    <option value="100">100</option>
                                                    <option value="200">200</option>
                                                    <option value="">Todos</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" id="btnFilter" class="btn btn-primary">Filtrar</button>
                                    </form>
                                </div>
                            </div>
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
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($usuarios as $usuario)
                                                <tr>
                                                    <td class="text-center">
                                                        @if ($usuario->photo == '')
                                                            <div class="avatar avatar-md bg-{{ $usuario->otherColors(rand(2, 9)) }} text-white rounded-circle">
                                                                {{ substr($usuario->email, 0, 2) }}
                                                            </div>
                                                        @else
                                                        <div class="avatar avatar-md text-white rounded-circle" style="overflow: hidden;">
                                                            <img src="{{ asset('storage/' . $usuario->photo) }}" alt="" style="width: 100%; height: auto;"/>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p class="tx-14 font-weight-semibold text-dark mb-1">
                                                            {{ $usuario->name }}
                                                        </p>
                                                        <p class="tx-13 text-muted mb-0"><a
                                                                href="mailto:{{ $usuario->email }}">{{ $usuario->email }}
                                                            </a></p>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted tx-13">{{ $usuario->phone }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted tx-13">{{ $usuario->number_id }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        @if (!empty($usuario->photo_id))
                                                            <span>
                                                                <a href="" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModalPdf" class="aPdf">
                                                                    <i src="{{ asset('storage/' . $usuario->photo_id) }}"></i>
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
                                                        @if (!empty($usuario->rol->rol_nombre['name']))
                                                            {{ $usuario->rol->rol_nombre['name'] == 'ClienteHijo' ? 'Cliente Hijo' : $usuario->rol->rol_nombre['name'] }}
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge font-weight-semibold bg-{{ $usuario->badges($usuario->status) }}-transparent text-{{ $usuario->badges($usuario->status) }} tx-11">
                                                            {{ $usuario->status }}
                                                        </span>
                                                    </td>
                                                    <td>


                                                        <a href="{{ route('consultar.afiliado', [$usuario->id]) }}"
                                                            class="btn btn-icon btn-info-light me-2" id="consultAfiliado"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="Validar Informacion">
                                                            <i class="fa fa-user"></i>
                                                        </a>

                                                        @switch($usuario->status)
                                                            @case('ASOCIADO')
                                                                <a data-bs-whatever="@mdo" id="{{ $usuario->id }}"
                                                                    class="proveedor btn btn-icon btn-success-light me-2"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-original-title="Consultar Padre">
                                                                    <i class="fa fa-users"></i>
                                                                </a>
                                                            @break

                                                            @case('NUEVO')
                                                                <a href="{{ route('usuario.estado', ['usuario' => $usuario, 'estado' => 'aprobado']) }}"
                                                                    class="btn btn-icon btn-primary-light me-2"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Aceptar">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                                <a href="{{ route('usuario.estado', ['usuario' => $usuario, 'estado' => 'rechazado']) }}"
                                                                    class="btn btn-icon btn-warning-light me-2"
                                                                    data-bs-toggle="tooltip" data-bs-original-title="Rechazar">
                                                                    <i class="fa fa-user-times"></i>
                                                                </a>
                                                            @break

                                                            @default
                                                            @break
                                                        @endswitch

                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-original-title="Ver Más">
                                                                <i class="fa fa-share-alt" aria-hidden="true"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item">
                                                                    <a href="{{ route('edit', [$usuario->id]) }}"
                                                                        class="btn btn-icon btn-warning-light me-2"
                                                                        data-bs-toggle="tooltip" data-bs-original-title="Editar">
                                                                        <i class="fa fa-pencil-square"></i>
                                                                    </a>
                                                                    <a id="{{ $usuario->id }}"
                                                                        class="btn btn-icon btn-info-light me-2 btnEnviarContrasena"
                                                                        data-bs-toggle="tooltip" data-bs-original-title="Generer Contraseña">
                                                                        {{-- <i class="fa fa-pencil-square"></i> --}}
                                                                        <i class="fa fa-envelope-square" aria-hidden="true"></i>
                                                                    </a>
                                                                    <a href="" id="{{ $usuario->id }}"
                                                                        class="deletedUser btn btn-icon btn-danger-light me-2"
                                                                        data-bs-toggle="tooltip" data-bs-original-title="Eliminar">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <embed id="foto" src="" width="100%" height="100%">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                                <embed id="pdfdoc" src="" type="application/pdf" width="100%"
                                    height="500" alt="pdf"
                                    pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="dataProveedor">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
        window.onload = function() {
            swal.close();
        }

        // load
        let Loader = function() {
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

        $(document).on("click", ".btnEnviarContrasena", function(e) {
            e.preventDefault()

            let id = this.id

            // Realizar la solicitud Ajax
            $.ajax({
                url: '{{ route('enviar-contrasena') }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'user_id': id
                },
                success: function(response) {
                    // Mostrar mensaje de éxito (o hacer cualquier otra acción después de enviar la contraseña)

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
                        title: response[1]
                    })
                },
                error: function(error) {
                    // Mostrar mensaje de error (en caso de que ocurra algún problema)
                    alert('Error al enviar la contraseña.');
                }
            });
        });

        //? cargamos la imagen en el modal
        let alinks = document.getElementsByClassName('aImg')

        for (const alink of alinks) {
            alink.addEventListener('click', function(e) {
                e.preventDefault()
                let url = this.children[0].attributes[0].nodeValue
                document.getElementById('foto').attributes[1].nodeValue = url
            })
        }

        let alinksPdf = document.getElementsByClassName('aPdf')

        for (const alinkPdf of alinksPdf) {
            alinkPdf.addEventListener('click', function(e) {
                e.preventDefault()
                let url = this.children[0].attributes[0].nodeValue
                document.getElementById('pdfdoc').attributes[1].nodeValue = url
            })
        }

        $(document).on("click", ".deletedUser", function(e) {
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
                title: '¿Estás seguro que deseas eliminar este usuario?',
                text: "¡No podrás revertir esto, ten en cuenta que los usuarios asociados a este igulmente serán eliminados!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Eliminarlo',
                cancelButtonText: 'No, Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('usuario.eliminar') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "userId": id
                        },
                        success: function(response) {
                            console.log(response.data);
                            if (response.success == true) {
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

        $(document).on("click", ".proveedor", function(e) {
            e.preventDefault()
            let id = this.id

            plantillaBody = '';

            $.ajax({
                type: 'POST',
                url: "{{ route('proveedor.encargado') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "userId": id
                },
                success: function(response) {
                    let data = response.data;
                    if (response.success == true) {
                        if (data != null) {
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
                        } else if (data == null) {
                            Swal.fire({
                                title: 'Advertencia!',
                                text: "El usuario no se ecuentra asignado a ningun proveedor, desea asignarlo a un proveedor!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, Asignar!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    (async () => {
                                        const {
                                            value: number
                                        } = await Swal.fire({
                                            title: 'Ingrese numero de identificacion del proveedor',
                                            input: 'text',
                                            inputLabel: 'Proveedor a asignar',
                                            inputPlaceholder: 'Ingrese identificacion'
                                        })

                                        $.ajax({
                                            type: 'GET',
                                            url: "{{ route('consultar.proveedorLocal') }}",
                                            data: {
                                                "_token": "{{ csrf_token() }}",
                                                "number_id": number,
                                                id: id
                                            },
                                            success: function(response) {
                                                let data = response.data;

                                                if (response.success ==
                                                    true) {
                                                    Swal.fire(
                                                        `Usuario asociado al proveedor: ${data[0].name}`
                                                        )
                                                }
                                                if (response.success ==
                                                    false) {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        text: data,
                                                    })
                                                }
                                            }
                                        })

                                        // if (number) {
                                        // Swal.fire(`Entered email: ${number}`)
                                        // }
                                    })()
                                }
                            })
                        }
                    }
                    if (response.success == false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data,
                        })
                    }
                }

            });
        });


        $(document).on('click', "#consultAfiliado", function(e) {
            Loader();
        });

        $(document).on("click", "#consultFacturas", function(e) {
            Loader();
        });
    </script>
@endsection
