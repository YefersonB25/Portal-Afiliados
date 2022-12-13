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
                                                        <a href="" id="{{$role->id}}" class="deletedRol btn btn-danger">
                                                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                                                <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                                            </svg>
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
