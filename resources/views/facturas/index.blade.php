@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="page">
        <div class="page-main">
            <div class="app-content main-content mt-0">
                <div class="side-app">
                    <!-- CONTAINER -->

                    {{-- Botones facturas --}}
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <a id="por-pagar" class="card text-center btn btn-icon btn-primary-light me-2"
                                        data-bs-toggle="tooltip" style="width: 16rem; height: 18rem;"
                                        data-bs-original-title="Facturas por pagar">
                                        <div class="card-body">
                                            <img class="card-img-top"
                                                src="{{asset('assets/images/invoiceIcon/factura-proceso-pago-modulo-1.png')}}">
                                        </div>
                                        <h5 class="card-title">Facturas por pagar</h5>
                                    </a>
                                </div>
                                <div class="col">
                                    <a id="en-transporte" class="card text-center btn btn-icon btn-primary-light me-2"
                                        data-bs-toggle="tooltip" style="width: 16rem; height: 18rem;"
                                        data-bs-original-title="Facturas en transporte">
                                        <div class="card-body">
                                            <img class="card-img-top"
                                                src="{{asset('assets/images/invoiceIcon/factura-en-viaje-modulo-2.png')}}">
                                        </div>
                                        <h5 class="card-title">Facturas en transporte</h5>
                                    </a>
                                </div>
                                <div class="col">
                                    <a id="pagadas-con-novedad"
                                        class="card text-center btn btn-icon btn-primary-light me-2"
                                        data-bs-toggle="tooltip" style="width: 16rem; height: 18rem;"
                                        data-bs-original-title="Facturas con novedad">
                                        <div class="card-body">
                                            <img class="card-img-top"
                                                src="{{asset('assets/images/invoiceIcon/facturas-bloqueadas-modulo-3.png')}}">
                                        </div>
                                        <h5 class="card-title">Facturas con novedad</h5>
                                    </a>
                                </div>
                                <div class="col">
                                    <a id="facturas-all" class="card text-center btn btn-icon btn-primary-light me-2"
                                        data-bs-toggle="tooltip" style="width: 16rem; height: 18rem;"
                                        data-bs-original-title="Todas las facturas">
                                        <div class="card-body">
                                            <img class="card-img-top"
                                                src="{{asset('assets/images/invoiceIcon/factura.png')}}">
                                        </div>
                                        <h5 class="card-title">Todas las facturas</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fin --}}

                    {{-- Card de tablas de facturas --}}
                    <div class="collapse" id="FacturasGenerales" style="display: none">

                        <body class="ltr app sidebar-mini light-mode">
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- CONTAINER -->
                                            <div class="main-container container-fluid">
                                                <div class="card" id="facturas-all">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                    </h3>
                                                    <div class="card-header border-bottom">
                                                        <div class="row g-2">
                                                            <h3 class="card-title">Fitros</h3>
                                                            <div class="form-horizontal">
                                                                <div class="row mb-2">
                                                                    <div class="col-md">
                                                                        <label for="tipoFactura" class="form-label">tipo
                                                                            de factura</label>
                                                                        <select type="text" name="tipoFactura"
                                                                            id="tipoFactura" class="form-select"
                                                                            tabindex="3"
                                                                            value="{{ old('tipoFactura') }}" autofocus>
                                                                            <option selected value="">Todos</option>
                                                                            <option value="Pago por adelantado">Anticipo
                                                                            </option>
                                                                            <option value="Estándar">Estandar</option>
                                                                            <option value="Nota de crédito">Nota Credito
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <label for="ValidationStatus"
                                                                            class="form-label">Estado</label>
                                                                        <select type="text" name="ValidationStatus"
                                                                            id="ValidationStatus" class="form-select"
                                                                            tabindex="3"
                                                                            value="{{ old('ValidationStatus') }}"
                                                                            autofocus>
                                                                            <option selected value="">Todos</option>
                                                                            <option value="Cancelada">Cancelada</option>
                                                                            <option value="Validada">Validada</option>
                                                                            <option value="Necesita revalidación">
                                                                                Necesita revalidación</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <label for="PaidStatus"
                                                                            class="form-label">Estado Pago</label>
                                                                        <select type="text" name="PaidStatus"
                                                                            id="PaidStatus" class="form-select"
                                                                            tabindex="3" value="{{ old('PaidStatus') }}"
                                                                            autofocus>
                                                                            <option selected value="">Todos</option>
                                                                            <option value="Pagadas">Pagadas</option>
                                                                            <option value="Impagado">Impagado</option>
                                                                            <option value="parsialmente pagada">
                                                                                parsialmente pagada</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <label for="CanceledFlag"
                                                                            class="form-label">Bandera cancelada</label>
                                                                        <select type="text" name="CanceledFlag"
                                                                            id="CanceledFlag" class="form-select"
                                                                            tabindex="3"
                                                                            value="{{ old('CanceledFlag') }}" autofocus>
                                                                            <option selected value="false">No</option>
                                                                            <option value="true">Si</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <label for="startDate" class="form-label">Fecha
                                                                            Inicio</label>
                                                                        <input type="date" name="startDate"
                                                                            id="startDate" class="form-select"
                                                                            tabindex="3" value="{{ old('startDate') }}"
                                                                            autofocus>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <label for="endDate" class="form-label">Fecha
                                                                            Fin</label>
                                                                        <input type="date" name="endDate" id="endDate"
                                                                            class="form-select" tabindex="3"
                                                                            value="{{ old('endDate') }}" autofocus>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary"
                                                                    id="btnPrFiltr">Filtrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table id="TablaFacturasAll"
                                                                                class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
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
                                    </div>
                                </div>
                            </div>
                        </body>
                    </div>

                    <div class="card" id="oculto-por-pagar" style="display: none">
                        <h3 class="text-center" style="text-decoration: underline">FACTURAS
                            POR PAGAR </h3>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="TablePorPagar"
                                                    class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="oculto-pagadas-con-novedad" style="display: none">
                        <h3 class="text-center" style="text-decoration: underline">FACTURAS PARCIALMENTE PAGADAS</h3>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="TablePagadasNovedad"
                                                    class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card" id="facturas-en-transporte" style="display: none">
                        <h3 class="text-center" style="text-decoration: underline">FACTURAS EN TRANSPORTE</h3>
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="TableEnTransporte"
                                                    class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Fin --}}

                    {{-- Modal de visualizacionde facturas --}}
                    <div class="modal fade" id="exampleModalToggle" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 mx-auto">
                                        <div class="modal-content">
                                            <div class="card">
                                                <div class="card-body invoice-head">
                                                    <div class="row" id="date">

                                                    </div>
                                                    <!--end row-->
                                                </div>
                                                <!--end card-body-->
                                                <div class="card-body" id="body">
                                                    <div class="row" id="row1">
                                                    </div>
                                                    <!--end row-->
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="table-responsive project-invoice">
                                                                <table class="table table-bordered mb-0">
                                                                    <thead class="thead-light">
                                                                        <tr>
                                                                            <th>@lang('locale.Description')</th>
                                                                            <th>@lang('locale.Amount')</th>
                                                                        </tr>
                                                                        <!--end tr-->
                                                                    </thead>
                                                                    <tbody id="row2">


                                                                    </tbody>
                                                                </table>
                                                                <!--end table-->
                                                            </div>
                                                            <!--end /div-->
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row-->


                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-12">
                                                            <h5 class="mt-4"><i
                                                                    class="fas fa-divide mr-2 text-info font-16"></i>@lang('locale.Installments')
                                                                :</h5>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row-->
                                                    <div class="row d-flex justify-content-center">
                                                        <div class="col-lg-12 col-xl-4 ml-auto align-self-center">
                                                            <div class="text-center"><small class="font-12">Tractocar
                                                                    Logistics SAS.</small>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row-->
                                                </div>
                                                <!--end card-body-->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="closet-modal" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                        <!--end card-->
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                        </div>
                    </div>
                    {{-- Fin --}}
                </div>
            </div>
        </div>
    </div>
</body>

@section('scripts')

<script src="https://momentjs.com/downloads/moment.min.js"></script>
<script>
    // Funccion de consulta validaciones y carga de datos Datatable
        let LoadData = function(PaidStatus, FlagStatus, TableName, InvoiceType,ValidationStatus, Card, startDate, endDate ) {
            // let start = performance.now();
            tblColectionData =  $(TableName).DataTable({

                retrieve: true,

                dom: 'Bfrtip',
                "buttons": [
                    {
                        extend: 'collection',
                        text: 'Exportar',
                        buttons: [
                            {
                                extend: 'excel',
                                className: 'btn',
                                text: "Excel",
                                exportOptions: {
                                columns: ":not(.no-exportar)"
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn',
                                text: "CSV",
                                exportOptions: {
                                    columns: ":not(.no-exportar)"
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn',
                                text: "PDF",
                                exportOptions: {
                                columns: ":not(.no-exportar)"
                                }
                            },
                            {
                                extend: 'print',
                                className: 'btn',
                                text: "Imprimir",
                                exportOptions: {
                                columns: ":not(.no-exportar)"
                                }
                            },
                        ],
                    }
                ],

                language: {
                    "sProcessing": "Procesando...",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",

                    "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                    },

                    "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }

                },

                columns: [
                    {title: "Accion", data: null, defaultContent: "<button type='button' class='ver btn btn-success' width='25px'><i class='fa fa-eye' aria-hidden='true'></i></button>"},
                    // {title: "ID Factura", data: "InvoiceId" },
                    {title: "Numero Factura", data: "InvoiceNumber" },
                    // {title: "Fecha Factura",  data: "InvoiceDate" },
                    // {title: "Descripción", data: "Description" },
                    {title: "Saldo",
                        data: function ( d ) {

                            const formatterDolar = new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            return formatterDolar.format( d.invoiceInstallments[0]["UnpaidAmount"] );
                        }
                    },
                    // {title: "ValidationStatus", data: "ValidationStatus"},
                    {title: "Valor Factura",
                        data: function ( d ) {

                            const formatterDolar = new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            return formatterDolar.format(d.InvoiceAmount);
                        }
                    },
                    {title: "Monto Pagado",
                        data: function ( d ) {
                            const formatterDolar = new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'USD',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            return formatterDolar.format(d.AmountPaid);

                        }
                    },
                    // {title: "Cuenta bancaria",
                    //     data: function ( d ) {
                    //         return d.invoiceInstallments[0]["BankAccount"]}
                    // },
                    {title: "Fecha Vencimiento",
                        data: function ( d ) {

                            // create a new `Date` object
                            var today = new Date();

                            // `getDate()` returns the day of the month (from 1 to 31)
                            var day = today.getDate();

                            // `getMonth()` returns the month (from 0 to 11)
                            var month = today.getMonth() + 1;

                            // `getFullYear()` returns the full year
                            var year = today.getFullYear();

                            var date1 = new Date(d.invoiceInstallments[0]["DueDate"]);
                            var date2 = new Date (`${year}-${month}-${day}`);
                            var dateDefined = date1 - date2;
                            var dias =  dateDefined/(1000*60*60*24);
                            if ( dias < 0 && d.PaidStatus != 'Pagadas') {
                                return 'Pendiente de pago';
                            }
                            if(d.PaidStatus == 'Pagadas'){
                                return 'Pagada';
                            }
                            return ('El pago se le generara dentro de ' + dias + ' Dias');
                        }
                    },
                    // {title: "Tipo de Factura", data: "InvoiceType" },
                    // {title: "Pago realizado", data: "AccountingDate" }



                ],

                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 1, targets: 1 },
                    { responsivePriority: 1, targets: 2 },
                    { responsivePriority: 1, targets: 3 },
                    { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: 5 },
                    // { responsivePriority: 1, targets: 6 },
                ],

            });
            let validacionButton = function (Card) {
                if(Card == "#oculto-por-pagar")  {

                    if( $("#oculto-por-pagar").css("display") == 'none' )
                    $("#oculto-por-pagar").show("slow");
                    else
                    $("#oculto-por-pagar").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#facturas-en-transporte").css("display") != 'none')
                    $("#facturas-en-transporte").hide("slow");

                    if($("#FacturasGenerales").css("display") != 'none')
                    $("#FacturasGenerales").hide("slow");
                }
                else if (Card == "#oculto-pagadas-con-novedad") {

                    if( $("#oculto-pagadas-con-novedad").css("display") == 'none' )
                    $("#oculto-pagadas-con-novedad").show("slow");
                    else
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");

                    if($("#facturas-en-transporte").css("display") != 'none')
                    $("#facturas-en-transporte").hide("slow");

                    if($("#FacturasGenerales").css("display") != 'none')
                    $("#FacturasGenerales").hide("slow");
                }
                else if (Card == "#FacturasGenerales" ) {
                    if( $("#FacturasGenerales").css("display") == 'none' )
                    $("#FacturasGenerales").show("slow");
                    else
                    $("#FacturasGenerales").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");

                    if($("#facturas-en-transporte").css("display") != 'none')
                    $("#facturas-en-transporte").hide("slow");

                }
                else if (Card == "#facturas-en-transporte" ) {
                    if( $("#facturas-en-transporte").css("display") == 'none' )
                    $("#facturas-en-transporte").show("slow");
                    else
                    $("#facturas-en-transporte").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#FacturasGenerales").css("display") != 'none')
                    $("#FacturasGenerales").hide("slow");

                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");

                }
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('falturas.pagadas') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    SupplierNumber: {{$SupplierNumber}},
                    FlagStatus: FlagStatus,
                    PaidStatus: PaidStatus,
                    InvoiceType: InvoiceType,
                    ValidationStatus: ValidationStatus,
                    startDate: startDate,
                    endDate: endDate

                },
                success: function(response) {
                    let datos =  response.data;
                    // var invoiceInstallments = datos[0].invoiceInstallments;
                    if (response.success == true) {
                        // console.log(datos);
                        tblColectionData.clear().draw();
                        tblColectionData.rows.add(datos).draw();

                        validacionButton(Card);

                        swal.close();
                    }else {
                        swal.close();
                        Loader();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: datos,
                        })
                    }
                },
                error: function(error){
                    swal.close();
                    Loader();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo fallo con la respuesta!',
                    })
                    console.error(error);
                }
            })

        }

        let LoadDataShipment = function(TableName, Card ) {
            // let start = performance.now();
            tblColectionData =  $(TableName).DataTable({

                retrieve: true,

                dom: 'Bfrtip',
                "buttons": [
                    {
                        extend: 'collection',
                        text: 'Exportar',
                        buttons: [
                            {
                                extend: 'excel',
                                className: 'btn',
                                text: "Excel",
                                exportOptions: {
                                columns: ":not(.no-exportar)"
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn',
                                text: "CSV",
                                exportOptions: {
                                    columns: ":not(.no-exportar)"
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn',
                                text: "PDF",
                                exportOptions: {
                                columns: ":not(.no-exportar)"
                                }
                            },
                            {
                                extend: 'print',
                                className: 'btn',
                                text: "Imprimir",
                                exportOptions: {
                                columns: ":not(.no-exportar)"
                                }
                            },
                        ],
                    }
                ],

                language: {
                    "sProcessing": "Procesando...",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",

                    "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                    },

                    "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }

                },

                columns: [
                    // {title: "Accion", data: null, defaultContent: "<button type='button' class='ver btn btn-success' width='25px'><i class='fa fa-eye' aria-hidden='true'></i></button>"},
                    // {title: "ID Factura", data: "InvoiceId" },
                    {title: "ID", data: "shipmentXid" },
                    {title: "Numero identificacion proveedor",  data: "attribute9" },
                    {title: "Placa", data: "attribute10" },
                    {title: "Placa Trailer", data: "attribute11" },
                    {title: "Costo Total",
                        data: function ( d ) {

                            const formatterDolar = new Intl.NumberFormat('en-US', {
                                style: 'currency',
                                currency: 'COP',
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            return formatterDolar.format( d.totalActualCost['value'] );
                        }
                    },
                    {title: "Numero de paradas", data: "numStops" },

                ],

                columnDefs: [
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 1, targets: 1 },
                    { responsivePriority: 1, targets: 2 },
                    { responsivePriority: 1, targets: 3 },
                    { responsivePriority: 1, targets: 4 },
                    { responsivePriority: 1, targets: 5 },
                    // { responsivePriority: 1, targets: 6 },
                ],

            });
            let validacionButton = function (Card) {
                if(Card == "#oculto-por-pagar")  {

                    if( $("#oculto-por-pagar").css("display") == 'none' )
                    $("#oculto-por-pagar").show("slow");
                    else
                    $("#oculto-por-pagar").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#facturas-en-transporte").css("display") != 'none')
                    $("#facturas-en-transporte").hide("slow");

                    if($("#FacturasGenerales").css("display") != 'none')
                    $("#FacturasGenerales").hide("slow");
                }
                else if (Card == "#oculto-pagadas-con-novedad") {

                    if( $("#oculto-pagadas-con-novedad").css("display") == 'none' )
                    $("#oculto-pagadas-con-novedad").show("slow");
                    else
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");

                    if($("#facturas-en-transporte").css("display") != 'none')
                    $("#facturas-en-transporte").hide("slow");

                    if($("#FacturasGenerales").css("display") != 'none')
                    $("#FacturasGenerales").hide("slow");
                }
                else if (Card == "#FacturasGenerales" ) {
                    if( $("#FacturasGenerales").css("display") == 'none' )
                    $("#FacturasGenerales").show("slow");
                    else
                    $("#FacturasGenerales").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");

                    if($("#facturas-en-transporte").css("display") != 'none')
                    $("#facturas-en-transporte").hide("slow");

                }
                else if (Card == "#facturas-en-transporte" ) {
                    if( $("#facturas-en-transporte").css("display") == 'none' )
                    $("#facturas-en-transporte").show("slow");
                    else
                    $("#facturas-en-transporte").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#FacturasGenerales").css("display") != 'none')
                    $("#FacturasGenerales").hide("slow");

                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");

                }
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('falturas.transporte') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    number_id: {{$number_id}},

                },
                success: function(response) {
                    let datos =  response.data;
                    // var invoiceInstallments = datos[0].invoiceInstallments;
                    if (response.success == true) {
                        console.log(datos);
                        tblColectionData.clear().draw();
                        tblColectionData.rows.add(datos).draw();

                        validacionButton(Card);

                        swal.close();
                    }else {
                        swal.close();
                        Loader();
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: datos,
                        })
                    }
                },
                error: function(error){
                    swal.close();
                    Loader();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Algo fallo con la respuesta!',
                    })
                    console.error(error);
                }
            })

        }
    // Fin

    // load inicial, se visualiza al seleccionar un opcion de las facturas
        let Loader = function(){
            Swal.fire({
            title: 'Cargando las 20 facturas mas recientes!',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
            },
            })
        }
    // Fin

    // load secundario, se visualiza al momento pasas de una opcion de facturas a otro siempre y cuando se estan visualizando la tabla de facturas
        let LoaderView = function(){
            Swal.fire({
            title: 'Cargando visualización de la factura!',
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
            },
            })
        }
    // Fin

    // Filtros
        $('#btnPrFiltr').on('click', function(e){
            var InvoiceType = document.getElementById("tipoFactura").value;
            var ValidationStatus = document.getElementById("ValidationStatus").value;
            var PaidStatus = document.getElementById("PaidStatus").value;
            var CanceledFlag = document.getElementById("CanceledFlag").value;
            var startDate = document.getElementById("startDate").value;
            var endDate = document.getElementById("endDate").value;
            tblColectionData.clear().draw();
            Loader();
            LoadData(PaidStatus, CanceledFlag, "#TablaFacturasAll",InvoiceType,ValidationStatus,"",startDate,endDate);
            obtener_data("#TablaFacturasAll tbody", tblColectionData);
        });
    // Fin

    // Acciones botones principales
        $("#por-pagar").click(function(e) {
            e.preventDefault();
            Loader();
            LoadData("Impagado", "false", "#TablePorPagar","","","#oculto-por-pagar","","");
            obtener_data("#TablePorPagar tbody", tblColectionData);
        });

        $("#pagadas-con-novedad").click(function(e) {
            e.preventDefault();
            Loader();
            LoadData("parsialmente pagada", "true", "#TablePagadasNovedad","","","#oculto-pagadas-con-novedad","","");
            obtener_data("#TablePagadasNovedad tbody", tblColectionData);

        });

        $("#facturas-all").click(function(e) {
            e.preventDefault();

            Loader();
            LoadData("", "false", "#TablaFacturasAll","","","#FacturasGenerales","","");
            obtener_data("#TablaFacturasAll tbody", tblColectionData);

        });

        $('#en-transporte').on('click', function(e) {
            e.preventDefault();

            Loader();
            LoadDataShipment("#TableEnTransporte","#facturas-en-transporte");
            obtener_data("#TableEnTransporte tbody", tblColectionData);
        })
    // Fin

    // Cerrar modal
        $("#closet-modal").click(function(e) {
            $("#global-loader3").modal('hide');//ocultamos el modal
        });
    // Fin

    // consulta y carga de visualizar de facturas individuales
        let obtener_data = function(tbody, table){
            $(tbody).on("click", "button.ver", function(){
                // Activar el spiner de cargar al momento de visualizar la factura
                // document.getElementById("global-loader3").style.display = "";
                InvoiceHelpers.setInvoiceModalLoading();
                swal.close();
                $('#exampleModalToggle').modal('show');
                //Fin

                // Cargamos los datos de la factura al modal
                let invoice = table.row($(this).parents("tr") ).data();
                plantillaDate = '';
                plantiilabody = '';
                plantillarow1 = '';
                plantillarow2 = '';
                $.ajax({
                    type: "POST",
                    url: "{{ route('invoice.lines') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        invoice: invoice
                    },
                    success : function(response) {
                        InvoiceHelpers.removeInvoiceLoading();
                        let invoice = response.data.invoiceData
                        let lines = response.data.invoiceLines

                        if (response.success == true) {
                            // console.log(lines);
                            $('#date').html('')
                            plantillaDate = `
                                <div class="col-md-4 align-self-center">
                                    <img src="{{asset('assets/images/logos-tractocar/negative-blue-small.png')}}" alt="logo-small" class="logo-sm mr-2" height="56">
                                    {{-- <img src="{{asset('assets/images/logos-tractocar/negative-blue-tiny.png')}}" alt="logo-large" class="logo-lg logo-light" height="16"> --}}
                                    <p class="mt-2 mb-0 text-muted">@lang('locale.Description') : ${ InvoiceHelpers.safeText(invoice.Description) }.</p>                                                             </div><!--end col-->
                                </div><!--end col-->
                                <div class="col-md-4 ms-auto">
                                    <ul class="list-inline mb-0 contact-detail float-right" >
                                        <li class="list-inline-item">
                                            <div class="pl-3">
                                                <h6 class="mb-0"><b>@lang('locale.Invoice Date') : ${InvoiceHelpers.formatDateValue(invoice.InvoiceDate)}</b> </h6>
                                                <h6><b>@lang('locale.Invoice Number'):</b> # ${InvoiceHelpers.safeText(invoice.InvoiceId)}</h6>
                                            </div>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="pl-3">
                                                <h5><i class="mdi mdi-cash-multiple"></i><b> :</b> ${InvoiceHelpers.formatCurrency(invoice.InvoiceAmount, 'USD')}</h5>
                                            </div>
                                        </li>
                                    </ul>
                                </div><!--end col-->

                            `
                            $('#date').append(plantillaDate)

                            if (invoice.CanceledFlag == 1) {
                                $('#body').html('')
                                plantiilabody = `
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>@lang('locale.Canceled')!</strong> @lang('locale.The invoice has been canceled').
                                        </div>
                                `
                                $('#body').append(plantiilabody)
                            }

                            $('#row1').html('')
                            plantillarow1 = `
                                <div class="col-md-4">
                                    <div class="float-left">
                                        <address class="font-13">
                                            <strong class="font-14"> @lang('locale.Supplier') :</strong><br>
                                            ${ InvoiceHelpers.safeText(invoice.Supplier) }<br>
                                            ${ InvoiceHelpers.safeText(invoice.SupplierSite) }<br>
                                        </address>
                                        <address class="font-13">
                                            <strong class="font-14">@lang('locale.Third-party sites'):</strong><br>
                                            ${ InvoiceHelpers.safeText(invoice.Party) }<br>
                                            ${ InvoiceHelpers.safeText(invoice.PartySite) }<br>
                                        </address>
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-4">
                                    <div class="float-left">
                                        <h6><b>@lang('locale.Invoice Type') :</b>
                                            ${
                                                InvoiceHelpers.safeText(invoice.InvoiceType)
                                            }
                                        </h6>
                                        <h6 class="mb-0"><b>@lang('locale.Payment status') : </b>
                                            ${  InvoiceHelpers.safeText(invoice.PaidStatus)
                                            }
                                        </h6>
                                        <h6><b>@lang('locale.Validation Status') :</b>
                                            ${
                                                InvoiceHelpers.safeText(invoice.ValidationStatus)
                                            }
                                        </h6>
                                    </div>
                                </div><!--end col-->

                                <div class="col-md-4">
                                    <div class="text-left bg-light p-3 mb-3">
                                        <h5 class="bg-info mt-0 p-2 text-white d-sm-inline-block">@lang('locale.Additional Information')</h5>
                                        <h6 class="font-13">@lang('locale.Accounting Date') : ${ InvoiceHelpers.formatDateValue(invoice.AccountingDate) }</h6>
                                        <h6 class="font-13">@lang('locale.Document Category') :
                                            ${
                                                invoice.DocumentCategory = "Prepayment Invoices" ? 'Facturas de anticipo' : 'Facturas Estandar'
                                            }
                                            </h6>
                                        <h6 class="font-13">@lang('locale.Document Sequence') : ${ InvoiceHelpers.safeText(invoice.DocumentSequence) }</h6>
                                    </div>
                                </div><!--end col-->
                            `
                            $('#row1').append(plantillarow1)

                            $('#row2').html('')
                            let hasLines = false;
                            lines.forEach(line => {
                                hasLines = true;
                                plantillarow2 = `
                                    <tr>
                                        <td >
                                            <h5 class="mt-0 mb-1">${ InvoiceHelpers.safeText(line.LineType) }</h5>
                                            <p class="mb-0 text-muted">${ InvoiceHelpers.safeText(line.Description) }.</p>
                                        </td>
                                        <td>${ InvoiceHelpers.formatCurrency(line.LineAmount, 'USD') }</td>
                                    </tr><!--end tr-->
                                `
                                $('#row2').append(plantillarow2)
                            });

                            if (!hasLines) {
                                $('#row2').append(`
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Sin detalles de la factura.</td>
                                    </tr>
                                `)
                            }

                        }
                        swal.close();
                        $('#exampleModalToggle').modal('show');
                    },
                    error: function(error){
                    InvoiceHelpers.removeInvoiceLoading();
                    console.error(error);
                }
                //Fin
                });

            });
        }
    // Fin

</script>

@endsection
@endsection
