@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini light-mode">
    <div class="page">
        <div class="page-main">
            <div class="app-content main-content mt-0">
                <div class="side-app">
                    <div id="global-loader2" style="display: none">
                        <img src={{asset('assets/images/loader.svg')}} class="loader-img" alt="Loader">
                    </div>
                    <!-- CONTAINER -->
                    <body class="ltr app sidebar-mini light-mode">
                        <div class="row row-sm">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- CONTAINER -->
                                        <div class="main-container container-fluid">
                                            <div>
                                                <button class="btn btn-primary mb-3" target="" id="pagadas">
                                                    Facturas pagadas
                                                </button>
                                                <button class="btn btn-success mb-3" target="" id="por-pagar">
                                                    Facturas parcialmente pagadas
                                                </button>
                                                <button class="btn btn-warning mb-3" target="" id="pagadas-con-novedad">
                                                    Facturas con saldo pendinte
                                                </button>
                                                <button class="btn btn-danger mb-3" target="" id="canceladas">
                                                    Facturas Anuladas
                                                </button>
                                            </div>


                                            <div class="card" id="oculto-pagadas" style="display: none">
                                                <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                    PAGADAS</h3>
                                                <div class="card-header border-bottom">
                                                    <div class="row g-2">
                                                        <h3 class="card-title">Fitros</h3>
                                                        <div class="form-horizontal">
                                                            <div class="row mb-2">
                                                                <div class="col-md">
                                                                    <label for="tipoFactura" class="form-label">Filtrar por tipo de factura</label>
                                                                    <select type="text" name="tipoFactura" id="tipoFactura" class="form-select" tabindex="3" value="{{ old('tipoFactura') }}" autofocus>
                                                                        <option selected value="">Todos</option>
                                                                        <option value="Prepayment">Anticipo</option>
                                                                        <option value="Standard">Estandar</option>
                                                                        <option value="Credit memo">Nota Credito</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md">
                                                                    <label for="startDate" class="form-label">Fecha Inicio</label>
                                                                    <input type="date" name="startDate" id="startDate" class="form-select" tabindex="3" value="{{ old('startDate') }}" autofocus>
                                                                </div>
                                                                <div class="col-md">
                                                                    <label for="endDate" class="form-label">Fecha Fin</label>
                                                                    <input type="date" name="endDate" id="endDate" class="form-select" tabindex="3" value="{{ old('endDate') }}" autofocus>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" id="btnPrFiltr">Filtrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row row-sm">
                                                        <div class="col-lg-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="TablePagadas"
                                                                            class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
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
                                                <div class="card-header border-bottom">
                                                    <div class="row g-2">
                                                        <h3 class="card-title">Fitros</h3>
                                                        <div class="form-horizontal">
                                                            <div class="row mb-2">
                                                                <div class="col-md">
                                                                    <label for="tipoFactura" class="form-label">Filtrar por tipo de factura</label>
                                                                    <select type="text" name="tipoFactura" id="tipoFactura1" class="form-select" tabindex="3" value="{{ old('tipoFactura') }}" autofocus>
                                                                        <option selected value="">Todos</option>
                                                                        <option value="Prepayment">Anticipo</option>
                                                                        <option value="Standard">Estandar</option>
                                                                        <option value="Credit memo">Nota Credito</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" id="btnPrFiltr1">Filtrar</button>
                                                        </div>
                                                    </div>
                                                </div>
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
                                                <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                    PAGADAS CON NOVEDAD</h3>
                                                <div class="card-header border-bottom">
                                                    <div class="row g-2">
                                                        <h3 class="card-title">Fitros</h3>
                                                        <div class="form-horizontal">
                                                            <div class="row mb-2">
                                                                <div class="col-md">
                                                                    <label for="tipoFactura" class="form-label">Filtrar por tipo de factura</label>
                                                                    <select type="text" name="tipoFactura" id="tipoFactura2" class="form-select" tabindex="3" value="{{ old('tipoFactura') }}" autofocus>
                                                                        <option selected value="">Todos</option>
                                                                        <option value="Prepayment">Anticipo</option>
                                                                        <option value="Standard">Estandar</option>
                                                                        <option value="Credit memo">Nota Credito</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" id="btnPrFiltr2">Filtrar</button>
                                                        </div>
                                                    </div>
                                                </div>
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
                                            <div class="card" id="oculto-canceladas" style="display: none">
                                                <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                CANCELADAS</h3>
                                                <div class="card-header border-bottom">
                                                    <div class="row g-2">
                                                        <h3 class="card-title">Fitros</h3>
                                                        <div class="form-horizontal">
                                                            <div class="row mb-2">
                                                                <div class="col-md">
                                                                    <label for="tipoFactura" class="form-label">Filtrar por tipo de factura</label>
                                                                    <select type="text" name="tipoFactura" id="tipoFactura3" class="form-select" tabindex="3" value="{{ old('tipoFactura') }}" autofocus>
                                                                        <option selected value="">Todos</option>
                                                                        <option value="Prepayment">Anticipo</option>
                                                                        <option value="Standard">Estandar</option>
                                                                        <option value="Credit memo">Nota Credito</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary" id="btnPrFiltr3">Filtrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row row-sm">
                                                        <div class="col-lg-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table id="TableCanceladas"
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
                        <div class="modal fade" id="exampleModalToggle" aria-hidden="true"
                            aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                            <div id="global-loader1">
                                <img src={{asset('assets/images/loader.svg')}} class="loader-img" alt="Loader">
                            </div>
                            <div class="modal-dialog modal-xl">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-lg-12 mx-auto">
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
                                                    <hr>
                                                    {{-- <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="table-responsive project-invoice">
                                                                <table class="table table-bordered mb-0">
                                                                    <thead class="thead-light">
                                                                        <tr>
                                                                            <th>@lang('locale.Payment Method')
                                                                                /@lang('locale.Bank Account') </th>
                                                                            <th>@lang('locale.Due Date')</th>
                                                                            <th>@lang('locale.Unpaid Amount')</th>
                                                                            <th>@lang('locale.Gross Amount')</th>
                                                                        </tr>
                                                                        <!--end tr-->
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($payable_installments as $installment)
                                                                        <tr>
                                                                            <td>
                                                                                <h5 class="mt-0 mb-1">{{
                                                                                    $installment->PaymentMethod }}</h5>
                                                                                <p class="mb-0 text-muted">{{
                                                                                    $installment->BankAccount }}.</p>
                                                                            </td>
                                                                            <td>{{ $installment->DueDate }}</td>
                                                                            <td>$ {{
                                                                                number_format($installment->UnpaidAmount,
                                                                                2) }}</td>
                                                                            <td>$ {{
                                                                                number_format($installment->GrossAmount,
                                                                                2) }}</td>
                                                                        </tr>
                                                                        <!--end tr-->
                                                                        @endforeach

                                                                    </tbody>
                                                                </table>
                                                                <!--end table-->
                                                            </div>
                                                            <!--end /div-->
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                    <!--end row--> --}}

                                                    <hr>
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
                                            <!--end card-->
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
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

    let LoadData = function(PaidStatus, FlagStatus, TableName, InvoiceType, Card, startDate, endDate ) {
        tblColectionData =  $(TableName).DataTable({
            // "autoWidth": false,
            "ordering": true,
            retrieve: true,
            processing: true,
            searchDelay: 500,
            responsive: true,
            info: true,
            columns: [
                {title: "Accion", data: null, defaultContent: "<button type='button' class='ver btn btn-success' data-bs-toggle='modal' href='#exampleModalToggle' width='25px'><i class='fa fa-eye' aria-hidden='true'></i></button>"},
                {title: "ID Factura", data: "InvoiceId" },
                {title: "Descripción", data: "Description" },
                {title: "Valor Factura", data: "InvoiceAmount" },
                {title: "Monto Pagado", data: "AmountPaid" },
                {title: "Tipo de Factura", data: "InvoiceType" },
                {title: "Fecha Factura", data: "InvoiceDate" },

            ],
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 1, targets: 3 },
                { responsivePriority: 1, targets: 4 },
                { responsivePriority: 1, targets: 5 },
                { responsivePriority: 1, targets: 6 },
            ],
            // responsive: {
            //     details: 'false',
            // },
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('falturas.pagadas') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                SupplierNumber: {{$SupplierNumber}},
                FlagStatus: FlagStatus,
                PaidStatus: PaidStatus,
                InvoiceType: InvoiceType,
                startDate: startDate,
                endDate: endDate
            },
            success: function(response) {
                let datos = response.data;
                if (response.success == true) {
                    tblColectionData.clear().draw();
                    tblColectionData.rows.add(datos).draw();

                    if (Card == "#oculto-pagadas" ) {
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
                    else if(Card == "#oculto-por-pagar")  {

                        if( $("#oculto-por-pagar").css("display") == 'none' )
                        $("#oculto-por-pagar").show("slow");
                        else
                        $("#oculto-por-pagar").hide("slow");

                        // validamos que no se muestren todas al tiempo
                        if($("#oculto-pagadas").css("display") != 'none')
                        $("#oculto-pagadas").hide("slow");

                        if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                        $("#oculto-pagadas-con-novedad").hide("slow");

                        if($("#oculto-canceladas").css("display") != 'none')
                        $("#oculto-canceladas").hide("slow");
                    }
                    else if (Card == "#oculto-pagadas-con-novedad") {

                        if( $("#oculto-pagadas-con-novedad").css("display") == 'none' )
                        $("#oculto-pagadas-con-novedad").show("slow");
                        else
                        $("#oculto-pagadas-con-novedad").hide("slow");

                        // validamos que no se muestren todas al tiempo
                        if($("#oculto-pagadas").css("display") != 'none')
                        $("#oculto-pagadas").hide("slow");

                        if($("#oculto-canceladas").css("display") != 'none')
                        $("#oculto-canceladas").hide("slow");

                        if($("#oculto-por-pagar").css("display") != 'none')
                        $("#oculto-por-pagar").hide("slow");
                    }
                    else if(Card == "#oculto-canceladas"){

                        if( $("#oculto-canceladas").css("display") == 'none' )
                        $("#oculto-canceladas").show("slow");
                        else
                        $("#oculto-canceladas").hide("slow");

                        // validamos que no se muestren todas al tiempo
                        if($("#oculto-pagadas").css("display") != 'none')
                        $("#oculto-pagadas").hide("slow");

                        if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                        $("#oculto-pagadas-con-novedad").hide("slow");

                        if($("#oculto-por-pagar").css("display") != 'none')
                        $("#oculto-por-pagar").hide("slow");
                    }

                }else {
                   Loader();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: datos,
                    })
                }
            },
            error: function(error){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo fallo con la respuesta!',
                })
                console.error(error);
            }
        })
    }

    let Loader = function(){
        let $yourUl = $("#global-loader2");
        $yourUl.css("display", $yourUl.css("display") === 'none' ? '' : 'none');
    }

    $('#btnPrFiltr').on('click', function(e){
        var InvoiceType = document.getElementById("tipoFactura").value;
        var startDate = document.getElementById("startDate").value;
        var endDate = document.getElementById("endDate").value;
        tblColectionData.clear().draw();
        LoadData("Paid", "false", "#TablePagadas",InvoiceType,"",startDate,endDate);
        obtener_data("#TablePagadas tbody", tblColectionData);
    });
    $('#btnPrFiltr1').on('click', function(e){
        var InvoiceType = document.getElementById("tipoFactura1").value;
        tblColectionData.clear().draw();
        LoadData("Unpaid", "false", "#TablePorPagar",InvoiceType,"");
        obtener_data("#TablePorPagar tbody", tblColectionData);
    });
    $('#btnPrFiltr2').on('click', function(e){
        var InvoiceType = document.getElementById("tipoFactura2").value;
        tblColectionData.clear().draw();
        LoadData("Partially paid", "false", "#TablePagadasNovedad",InvoiceType,"");
        obtener_data("#TablePagadasNovedad tbody", tblColectionData);
    });
    $('#btnPrFiltr3').on('click', function(e){
        e.preventDefault();
        var InvoiceType = document.getElementById("tipoFactura3").value;
        tblColectionData.clear().draw();
        LoadData("", "true", "#TableCanceladas",InvoiceType,"");
        obtener_data("#TableCanceladas tbody", tblColectionData);
    })


    $('#pagadas').on('click', function(e){
        e.preventDefault();
        Loader();
        LoadData("Paid", "false", "#TablePagadas","","#oculto-pagadas");
        obtener_data("#TablePagadas tbody", tblColectionData);

    });

    $("#por-pagar").click(function(e) {
        e.preventDefault();
        Loader();
        LoadData("Unpaid", "false", "#TablePorPagar","","#oculto-por-pagar");
        obtener_data("#TablePorPagar tbody", tblColectionData);
    });

    $("#pagadas-con-novedad").click(function(e) {
        e.preventDefault();
        Loader();
        LoadData("Partially paid", "false", "#TablePagadasNovedad","","#oculto-pagadas-con-novedad");
        obtener_data("#TablePagadasNovedad tbody", tblColectionData);

    });

    $("#canceladas").click(function(e) {
        e.preventDefault();
        Loader();
        LoadData("", "true", "#TableCanceladas","","#oculto-canceladas");
        obtener_data("#TableCanceladas tbody", tblColectionData);
    });

    let obtener_data = function(tbody, table){
        $(tbody).on("click", "button.ver", function(){
            window.addEventListener("load", function (e) {
                $("#global-loader1").fadeOut("slow");
            })
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
                    let invoice = response.data.invoiceData
                    let lines = response.data.invoiceLines

                    if (response.success == true) {
                        // console.log(invoice.PaidStatus);
                        $('#date').html('')
                        plantillaDate = `
                            <div class="col-md-4 align-self-center">
                                <img src="{{asset('assets/images/logos-tractocar/negative-blue-small.png')}}" alt="logo-small" class="logo-sm mr-2" height="56">
                                {{-- <img src="{{asset('assets/images/logos-tractocar/negative-blue-tiny.png')}}" alt="logo-large" class="logo-lg logo-light" height="16"> --}}
                                <p class="mt-2 mb-0 text-muted">@lang('locale.Description') : ${ invoice.Description }.</p>                                                             </div><!--end col-->
                            </div><!--end col-->
                            <div class="col-md-4 ms-auto">
                                <ul class="list-inline mb-0 contact-detail float-right" >
                                    <li class="list-inline-item">
                                        <div class="pl-3">
                                            <h6 class="mb-0"><b>@lang('locale.Invoice Date') : ${invoice.InvoiceDate}</b> </h6>
                                            <h6><b>@lang('locale.Invoice Number'):</b> # ${invoice.InvoiceId}</h6>
                                        </div>
                                    </li>
                                    <li class="list-inline-item">
                                        <div class="pl-3">
                                            <h5><i class="mdi mdi-cash-multiple"></i><b> :</b> $${invoice.InvoiceAmount}</h5>
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
                                        ${ invoice.Supplier }<br>
                                        ${ invoice.SupplierSite }<br>
                                    </address>
                                    <address class="font-13">
                                        <strong class="font-14">@lang('locale.Third-party sites'):</strong><br>
                                        ${ invoice.Party }<br>
                                        ${ invoice.PartySite }<br>
                                    </address>
                                </div>
                            </div><!--end col-->

                            <div class="col-md-4">
                                <div class="float-left">
                                    <h6><b>@lang('locale.Invoice Type') :</b> "${invoice.InvoiceType}"</h6>
                                    <h6 class="mb-0"><b>@lang('locale.Payment status') : </b>
                                        ${invoice.PaidStatus}
                                    </h6>

                                    <h6><b>@lang('locale.Validation Status') :</b>
                                        ${invoice.ValidationStatus}
                                    </h6>
                                </div>
                            </div><!--end col-->

                            <div class="col-md-4">
                                <div class="text-left bg-light p-3 mb-3">
                                    <h5 class="bg-info mt-0 p-2 text-white d-sm-inline-block">@lang('locale.Additional Information')</h5>
                                    <h6 class="font-13">@lang('locale.Accounting Date') : ${ invoice.AccountingDate }</h6>
                                    <h6 class="font-13">@lang('locale.Document Category') : ${invoice.DocumentCategory}</h6>
                                    <h6 class="font-13">@lang('locale.Document Sequence') : ${ invoice.DocumentSequence }</h6>
                                </div>
                            </div><!--end col-->
                        `
                        $('#row1').append(plantillarow1)

                        $('#row2').html('')
                        lines.forEach(line => {
                            plantillarow2 = `
                                <tr>
                                    <td >
                                        <h5 class="mt-0 mb-1">${ line.LineType }</h5>
                                        <p class="mb-0 text-muted">${ line.Description }.</p>
                                    </td>
                                    <td>$ ${ line.LineAmount }</td>
                                </tr><!--end tr-->
                            `
                            $('#row2').append(plantillarow2)
                        });

                    }
                },
                error: function(error){
                console.error(error);
            }

            });

        });
    }

</script>

@endsection
@endsection
