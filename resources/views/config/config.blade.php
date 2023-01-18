@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <div class="main-container container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-toolbar mb-3" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-2" role="group" aria-label="First group">
                                <a type="button" class="btn btn-primary" href="{{route('setting.create')}}">Crear</a>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                <thead>
                                    <tr>
                                        <th class="wd-15p border-bottom-0">Acciones</th>
                                        <th class="wd-15p border-bottom-0">Nombre</th>
                                        <th class="wd-15p border-bottom-0">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($setting as $settin)
                                    <tr>
                                        <td>
                                            <a class="btn btn-icon btn-info-light me-2" data-bs-toggle="tooltip"
                                                data-bs-original-title="Editar" id="edit" name="{{$settin->name .'-'. $settin->isEncrypt}}">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </td>
                                        <td>{{$settin->name}}</td>
                                        @if ($settin->isEncrypt == 1)
                                        <td>*********</td>
                                        @else
                                        <td>{{$settin->val}}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modificar variable de entorno</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form-edit">

                            </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="Guardar" class="btn btn-primary">Understood</button>
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
        let closeModal = function() {
            var myModalEl = document.getElementById('staticBackdrop');
            var modal = bootstrap.Modal.getInstance(myModalEl)
            modal.hide();
        }
        $(document).on('click', '#edit', function(e) {
            let plantillaForm = ''
            let valores = this.name
            let resultado = valores.split("-");

            $.ajax({
                type: "POST",
                url: "{{ url('portal/setting/date') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: resultado[0]
                },
                success : function(response) {
                    let data = response.data
                    $('#form-edit').html('')
                    plantillaForm = `
                        <div class="mb-3">
                            <label for="recipient-name" id="recipient-name" class="col-form-label">${resultado[0]}</label>
                            <input type="text" value="${data}" class="form-control" id="recipient-val">
                        </div>
                    `
                    $("#form-edit").append(plantillaForm)

                    $('#staticBackdrop').modal('show');
                }
            });

                $(document).on('click', '#Guardar', function(e) {
                    let labelName = document.getElementById('recipient-name').innerHTML;
                    let inputVal = document.getElementById('recipient-val').value;

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('setting.update') }}",
                        data:{
                            "_token": "{{ csrf_token() }}",
                            name: labelName,
                            val: inputVal,
                            isEncrypt: resultado[1]
                        },
                        success : function(response) {
                            let data = response.data
                            closeModal();
                             if (data == 1) {

                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Dato actualizado correctamente',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                location.reload();
                             }
                        }
                    });


                })
        });
    </script>
@endsection
