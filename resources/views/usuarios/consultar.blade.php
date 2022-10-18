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
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                    <thead>
                                                        <tr>
                                                            <th class="border-bottom-0">Nombre</th>
                                                            <th class="border-bottom-0">Identificacion</th>
                                                            <th class="border-bottom-0">E-mail</th>
                                                            <th class="border-bottom-0">Telefono</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>{{$arrayResult['firstName'] .' '.$arrayResult['firstName']}}
                                                            </td>
                                                            <td>{{$arrayResult['contactXid']}}</td>
                                                            <td>{{$arrayResult['emailAddress']}}</td>
                                                            <td>{{$arrayResult['phone']}}</td>
                                                            {{-- <td>{{$responseData->firstName}}
                                                                {{$responseData->lastName}}</td>
                                                            <td>{{ $responseData->contactXid }}</td>
                                                            <td>{{$responseData->emailAddress}}</td>
                                                            <td>{{$responseData->phone1}}</td> --}}
                                                        </tr>
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
        // $("#disparador-consultar").click(function() {

            //     let inputValue = document.querySelector("#numeroIdentificacion").value;
            //     let plantillaTablaUniversitarios = ''
            //     if(nIdentificacion != '')
            //     {
            //         $.ajax({
            //             url: "consultaOTM/afiliado?nIdentificacion",
            //             // data: {inputValue},
            //             method: 'post',
            //             success: (response) => {
            //                 let responseData = response.responseData
            //                 plantillaTablaAfiliados =
            //                 `
            //                 <tr>
            //                     <td>${ responseData.firstName } ${ responseData.lastName}</td>
            //                     <td>${ responseData.contactXid }</td>
            //                     <td>${ responseData.emailAddress }</td>
            //                     <td>${ responseData.phone1 }</td>
            //                 </tr>
            //                 `

            //                 /** insertamos el html dentro de la etiqueta */
            //                 $('#tablaAfiliados').append(plantillaTablaAfiliados)

            //             },
            //             error: function (data) {
            //                 Swal.fire({
            //                 icon: 'error',
            //                 title: 'Oops...',
            //                 text: 'No se encontro ningun registro en OTM con el numero de identificacion ingresado!',
            //             })
            //           }
            //         })
            //     }
            //     else
            //     {
            //             Swal.fire({
            //             icon: 'error',
            //             title: 'Oops...',
            //             text: 'Ingrese el numero de Identificacion antes de consultar!',
            //         })
            //     }
            //     // document.querySelector("#valueInput").innerHTML = `First input value: ${inputValue1}`;
            //     // console.log(inputValue);
            // });

    </script>

@endsection
