@extends('layouts.app')

@section('content')

    <body class="ltr app sidebar-mini light-mode">
        <div class="page">
            <div class="page-main">
                <div class="app-content main-content mt-0">
					<div class="side-app">
						<!-- CONTAINER -->
                        <body class="ltr app sidebar-mini light-mode">
                            <div class="row row-sm">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <!-- CONTAINER -->
                                            <div class="main-container container-fluid">
                                                {{$SupplierNumber}}
                                                <div>
                                                    <button class="btn btn-primary mb-3" target="" id="pagadas">
                                                        Facturas pagadas
                                                    </button>
                                                    <button class="btn btn-success mb-3" target="" id="por-pagar">
                                                        Facturas por pagar
                                                    </button>
                                                    <button class="btn btn-warning mb-3" target="" id="pagadas-con-novedad">
                                                        Facturas pagadas con novedad
                                                    </button>
                                                    <button class="btn btn-danger mb-3" target="" id="canceladas">
                                                        Facturas canceladas
                                                    </button>
                                                </div>

                                                <div class="card" id="oculto-pagadas" style="display: none">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                        PAGADAS</h3>
                                                    <div class="card-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table id="TablePagadas" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card" id="oculto-por-pagar" style="display: none">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS POR
                                                        PAGAR</h3>
                                                    <div class="card-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table id="TablePorPagar" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card" id="oculto-pagadas-con-novedad" style="display: none">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                        PAGADAS CON NOVEDAD</h3>
                                                    <div class="card-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table id="TablePagadasNovedad" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card" id="oculto-canceladas" style="display: none">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                        CANCELADAS</h3>
                                                    <div class="card-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table id="TableCanceladas" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
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
                </div>
            </div>
        </div>
    </div>
</body>


@section('scripts')
<script>
    $('#pagadas').on('click', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('falturas.pagadas') }}",
            data: {
                SupplierNumber: {{$SupplierNumber}},
                PaidStatus: 'Paid',
                FlagStatus: 'false'
            },

            success: function(response) {
                var datos = response.data;
                if (response.success == true) {

                    $('#TablePagadas').DataTable({
                        // serverSide: true,
                        processing: true,
                        searchDelay: 500,
                        responsive: true,
                        info: true,
                        data: datos,
                        columns: [
                            { title: "Nombre",  data: "AmountPaid" },
                            { title: "Usuario", data: "Description" },
                            { title: "Correo",  data: "InvoiceAmount" },
                            { title: "InvoiceDate",  data: "InvoiceDate" },
                            { title: "InvoiceType",  data: "InvoiceType" },
                            { title: "Supplier",  data: "Supplier" }

                        ],
                        columnDefs: [
                            { responsivePriority: 1, targets: 0 },
                            { responsivePriority: 1, targets: 1 },
                            { responsivePriority: 1, targets: 3 },
                            { responsivePriority: 1, targets: 4 },
                            { responsivePriority: 1, targets: 5 },

                        ],
                        responsive: {
                            details: 'false',
                        },

                    });

                    if( $("#oculto-pagadas").css("display") == 'none' )
                    $("#oculto-pagadas").show("slow");
                    else
                    $("#oculto-pagadas").hide("slow");

                    // validamos que no se muestren todas al tiempo
                    if($("#oculto-canceladas").css("display") != 'none')
                    $("#oculto-canceladas").hide("slow");

                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");
                }
            },
            error: function(error){
                console.error(error);
            }
        })
    });

    $("#por-pagar").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('falturas.pagadas') }}",
            data: {
                SupplierNumber: {{$SupplierNumber}},
                PaidStatus: 'Unpaid',
                FlagStatus: 'false'
            },

            success: function(response) {
                var datos = response.data;
                if (response.success == true) {

                    $('#TablePorPagar').DataTable({
                        // serverSide: true,
                        processing: true,
                        searchDelay: 500,
                        responsive: true,
                        info: true,
                        data: datos,
                        columns: [
                            { title: "Nombre",  data: "AmountPaid" },
                            { title: "Usuario", data: "Description" },
                            { title: "Correo",  data: "InvoiceAmount" },
                            { title: "InvoiceDate",  data: "InvoiceDate" },
                            { title: "InvoiceType",  data: "InvoiceType" },
                            { title: "Supplier",  data: "Supplier" }

                        ],
                        columnDefs: [
                            { responsivePriority: 1, targets: 0 },
                            { responsivePriority: 1, targets: 1 },
                            { responsivePriority: 1, targets: 3 },
                            { responsivePriority: 1, targets: 4 },
                            { responsivePriority: 1, targets: 5 },

                        ],
                        responsive: {
                            details: 'false',
                        },
                    });

                    if( $("#oculto-por-pagar").css("display") == 'none' )
                    $("#oculto-por-pagar").show("slow");
                    else
                    $("#oculto-por-pagar").hide("slow");

                    // validamos que no se muestren todat al tiempo
                    if($("#oculto-pagadas").css("display") != 'none')
                    $("#oculto-pagadas").hide("slow");

                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#oculto-canceladas").css("display") != 'none')
                    $("#oculto-canceladas").hide("slow");

                }
            },
            error: function(error){
                console.error(error);
            }
        })
    });

    $("#pagadas-con-novedad").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('falturas.por_pagar') }}",
            data: {
                SupplierNumber: {{$SupplierNumber}},
                PaidStatus: 'Partially paid',
                FlagStatus: 'false'
            },

            success: function(response) {
                var datos = response.data;

                if (response.success == true) {

                    $('#TablePagadasNovedad').DataTable({
                        // serverSide: true,
                        processing: true,
                        searchDelay: 500,
                        responsive: true,
                        info: true,
                        data: datos,
                        columns: [
                            { title: "Nombre",  data: "AmountPaid" },
                            { title: "Usuario", data: "Description" },
                            { title: "Correo",  data: "InvoiceAmount" },
                            { title: "InvoiceDate",  data: "InvoiceDate" },
                            { title: "InvoiceType",  data: "InvoiceType" },
                            { title: "Supplier",  data: "Supplier" }

                        ],
                        columnDefs: [
                            { responsivePriority: 1, targets: 0 },
                            { responsivePriority: 1, targets: 1 },
                            { responsivePriority: 1, targets: 3 },
                            { responsivePriority: 1, targets: 4 },
                            { responsivePriority: 1, targets: 5 },

                        ],
                        responsive: {
                            details: 'false',
                        },
                    });

                    if( $("#oculto-pagadas-con-novedad").css("display") == 'none' )
                    $("#oculto-pagadas-con-novedad").show("slow");
                    else
                    $("#oculto-pagadas-con-novedad").hide("slow");

                        // validamos que no se muestren todat al tiempo
                        if($("#oculto-pagadas").css("display") != 'none')
                    $("#oculto-pagadas").hide("slow");

                    if($("#oculto-canceladas").css("display") != 'none')
                    $("#oculto-canceladas").hide("slow");

                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");

                }else{
                    Swal.fire(datos)
                }

            },
            error: function(error){
                console.error(error);
            }
        })
    });

    $("#canceladas").click(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{ route('falturas.por_pagar') }}",
            data: {
                SupplierNumber: {{$SupplierNumber}},
                FlagStatus: 'true'
            },

            success: function(response) {
                var datos = response.data;

                if (response.success == true) {

                    $('#TableCanceladas').DataTable({
                        // serverSide: true,
                        processing: true,
                        searchDelay: 500,
                        responsive: true,
                        info: true,
                        data: datos,
                        columns: [
                            { title: "Nombre",  data: "AmountPaid" },
                            { title: "Usuario", data: "Description" },
                            { title: "Correo",  data: "InvoiceAmount" },
                            { title: "InvoiceDate",  data: "InvoiceDate" },
                            { title: "InvoiceType",  data: "InvoiceType" },
                            { title: "Supplier",  data: "Supplier" }

                        ],
                        columnDefs: [
                            { responsivePriority: 1, targets: 0 },
                            { responsivePriority: 1, targets: 1 },
                            { responsivePriority: 1, targets: 3 },
                            { responsivePriority: 1, targets: 4 },
                            { responsivePriority: 1, targets: 5 },

                        ],
                        responsive: {
                            details: 'false',
                        },
                    });

                    if( $("#oculto-canceladas").css("display") == 'none' )
                    $("#oculto-canceladas").show("slow");
                    else
                    $("#oculto-canceladas").hide("slow");

                    // validamos que no se muestren todat al tiempo
                    if($("#oculto-pagadas").css("display") != 'none')
                    $("#oculto-pagadas").hide("slow");

                    if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                    $("#oculto-pagadas-con-novedad").hide("slow");

                    if($("#oculto-por-pagar").css("display") != 'none')
                    $("#oculto-por-pagar").hide("slow");

                }else{
                    Swal.fire(datos)
                }

            },
            error: function(error){
                console.error(error);
            }
        })

    });

</script>

@endsection
@endsection
