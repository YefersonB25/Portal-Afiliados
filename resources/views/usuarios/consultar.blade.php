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
                                            <table id="file-datatable"
                                                class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                <thead>
                                                    <tr>
                                                        <th class="border-bottom-0">/</th>
                                                        <th class="border-bottom-0">SISTEMA</th>
                                                        <th class="border-bottom-0">OTM</th>
                                                        <th class="border-bottom-0">ERP</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>CEDULA</td>
                                                        <td></td>
                                                        <td>{{$arrayResultOtm['locationXid']}}</td>
                                                        <td>{{$arrayResultErp['TaxpayerId']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>NOMBRE</td>
                                                        <td></td>
                                                        <td>{{$arrayResultOtm['fullName']}}</td>
                                                        <td>{{$arrayResultErp['fullName']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>EMAIL</td>
                                                        <td></td>
                                                        <td>{{$arrayResultOtm['emailAddress']}}</td>
                                                        <td>{{$arrayResultErp['emailAddress']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TELEFONO</td>
                                                        <td></td>
                                                        <td>{{$arrayResultOtm['phone']}}</td>
                                                        <td>{{$arrayResultErp['phone']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ESTADO</td>
                                                        <td></td>

                                                        <td>
                                                            <span class="badge rounded-pill bg-{{($arrayResultOtm['isActive']) == 1 ? 'success' :
                                                            'danger' }} my-1">{{($arrayResultOtm['isActive']) == 1 ?
                                                                'ACTIVO' :
                                                                'DESACTIVADO'}}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge rounded-pill bg-{{($arrayResultErp['isActive']) == 'ACTIVE' ? 'success' :
                                                            'danger' }} my-1">{{($arrayResultErp['isActive']) ==
                                                                'ACTIVE' ?
                                                                'ACTIVO' :
                                                                'DESACTIVADO'}}
                                                            </span>
                                                        </td>
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