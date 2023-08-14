@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="page">
        <div class="page-main">
            <div class="app-content main-content mt-0">
                <div class="side-app">
                    <div class="main-container container-fluid">
                        <div class="page-header">
                            <div>
                                <h1 class="page-title">Roles</h1>
                            </div>
                            <div class="ms-auto pageheader-btn">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                                </ol>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                                        Crear rol
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        {{-- @endcan --}}
                                        <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom w-100 tt">
                                        <thead>
                                            <th>Rol</th>
                                            <th>Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    {{-- @can('editar-rol') --}}
                                                    <a class="btn btn-icon btn-warning-light" data-bs-toggle="tooltip" data-bs-original-title="Editar"
                                                        href="{{ route('roles.edit',$role->id) }}">
                                                        <i class="fa fa-pencil-square"></i>
                                                    </a>
                                                    {{-- @endcan --}}

                                                    {{-- @can('borrar-rol') --}}
                                                    <a href="" id="{{$role->id}}" class="deletedRol btn btn-icon btn-danger-light" data-bs-toggle="tooltip" data-bs-original-title="Eliminar">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    {{-- {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy',
                                                    $role->id],'style'=>'display:inline']) !!}
                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!} --}}
                                                    {{-- @endcan --}}
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
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('scripts')
    <script>
        $(document).on("click", ".deletedRol", function (e){
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
            title:'¿Estás seguro que deseas eliminar este rol?',
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
                    url: "{{ route('roles.eliminar') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "rolId": id
                    },
                    success: function(response) {
                        console.log(response.success);
                        if(response.success == true){
                            swalWithBootstrapButtons.fire(
                            '¡Eliminado!',
                            'El rol ha sido eliminado',
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
                'El rol está seguro :)',
                'error'
                )
            }
            })
        });

    </script>
@endsection
