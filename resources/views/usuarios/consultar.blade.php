@extends('layouts.app')

@section('content')

    <body class="ltr app sidebar-mini light-mode">
        <div class="page">

            <div class="page-main">
                <div class="app-content main-content mt-0">
                    <div class="side-app">
                        <!-- CONTAINER -->
                        {{-- <form method="get" action="{{route('afiliado.consulta')}}"> --}}


                        {{-- </form> --}}
                        <div class="main-container container-fluid">
                            <!-- Row -->
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">

                                        <div class="card-header border-bottom">
                                            <h3 class="card-title">Consultar afiliado en OTM</h3>
                                            {{-- <a class="btn btn-warning" href="{{ route('usuarios.create') }}">Nuevo</a> --}}
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <div class="col-md-6">
                                                    <div class="input-group mb-3">
                                                        <button class="btn btn-outline-secondary" type="submit" id="disparador-consultar">Button</button>
                                                        <input type="text" class="form-control" name="numeroIdentificacion" id="numeroIdentificacion" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                                    </div>
                                                    <div class="spinner-border text-warning" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                      </div>
                                                </div>
                                                <table id="tablaAfiliados" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">Nombre</th>
                                                            <th class="border-bottom-0">Identificacion</th>
                                                            <th class="border-bottom-0">E-mail</th>
                                                            <th class="border-bottom-0">Telefono</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

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

@endsection
@section('scripts')

    <script>

        $("#disparador-consultar").click(function() {

            let inputValue = document.querySelector("#numeroIdentificacion").value;
            let plantillaTablaUniversitarios = ''

            if(inputValue != '')
            {
                $.ajax({
                    url: "{{route('afiliado.consulta')}}",
                    data: {inputValue},
                    method: 'post',
                    success: (response) => {
                        let responseData = response.responseData
                        plantillaTablaAfiliados =
                        `
                        <tr>
                            <td>${ responseData.firstName } ${ responseData.lastName}</td>
                            <td>${ responseData.contactXid }</td>
                            <td>${ responseData.emailAddress }</td>
                            <td>${ responseData.phone1 }</td>
                        </tr>
                        `

                        /** insertamos el html dentro de la etiqueta */
                        $('#tablaAfiliados').append(plantillaTablaAfiliados)

                    },
                    error: function (data) {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No se encontro ningun registro en OTM con el numero de identificacion ingresado!',
                        })
                  }
                })
            }
            else
            {
                $('#tablaAfiliados').html('')
            }
            // document.querySelector("#valueInput").innerHTML = `First input value: ${inputValue1}`;
            // console.log(inputValue);
        });

  </script>

@endsection

