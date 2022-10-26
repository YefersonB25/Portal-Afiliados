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
                                                                            <table id="TablePagadas"  class="table table-bordered text-nowrap key-buttons border-bottom  w-100">

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
                            <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                <div class="modal-dialog modal-xl">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-12 mx-auto">
                                                <div class="card">
                                                    <div class="card-body invoice-head">
                                                        <div class="row" id="date">

                                                        </div><!--end row-->
                                                    </div><!--end card-body-->
                                                    {{-- <div class="card-body">

                                                        @if($payable->CanceledFlag == 1)
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <strong>@lang('locale.Canceled')!</strong> @lang('locale.The invoice has been canceled').
                                                        </div>
                                                        @endif
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="float-left">
                                                                    <address class="font-13">
                                                                        <strong class="font-14"> @lang('locale.Supplier') :</strong><br>
                                                                        {{ $payable->Supplier }}<br>
                                                                        {{ $payable->SupplierSite }}<br>
                                                                    </address>
                                                                    <address class="font-13">
                                                                        <strong class="font-14">@lang('locale.Third-party sites'):</strong><br>
                                                                        {{ $payable->Party }}<br>
                                                                        {{ $payable->PartySite }}<br>
                                                                    </address>
                                                                </div>
                                                            </div><!--end col-->

                                                            <div class="col-md-4">
                                                                <div class="float-left">
                                                                    <h6><b>@lang('locale.Invoice Type') :</b> {{ __('locale.'.$payable->InvoiceType) }}</h6>
                                                                    <h6 class="mb-0"><b>@lang('locale.Payment status') :</b>
                                                                        @switch($payable->PaidStatus)
                                                                            @case('Paid')
                                                                                <i class="fas fa-hand-holding-usd mr-2 text-success font-16"></i>
                                                                                @break

                                                                            @case('Partially paid')
                                                                                <i class="fas fa-hand-holding-usd mr-2 text-warning font-16"></i>
                                                                                @break

                                                                            @default
                                                                                <i class="fas fa-hand-holding-usd mr-2 text-danger font-16"></i>
                                                                        @endswitch

                                                                        {{ __('locale.'.$payable->PaidStatus) }}</h6>

                                                                    <h6><b>@lang('locale.Validation Status') :</b>
                                                                        @switch($payable->ValidationStatus)
                                                                            @case('Validated')
                                                                                <i class="far fa-check-circle mr-2 text-success font-16"></i>
                                                                                @break

                                                                            @case('Not validated')
                                                                                <i class="far fa-check-circle mr-2 text-warning font-16"></i>
                                                                                @break

                                                                            @default
                                                                                <i class="far fa-check-circle mr-2 text-danger font-16"></i>
                                                                        @endswitch
                                                                        {{ __('locale.'.$payable->ValidationStatus) }}</h6>
                                                                </div>
                                                            </div><!--end col-->

                                                            <div class="col-md-4">
                                                                <div class="text-left bg-light p-3 mb-3">
                                                                    <h5 class="bg-info mt-0 p-2 text-white d-sm-inline-block">@lang('locale.Additional Information')</h5>
                                                                    <h6 class="font-13">@lang('locale.Accounting Date') : {{ $payable->AccountingDate }}</h6>
                                                                    <h6 class="font-13">@lang('locale.Document Category') :  {{ __('locale.'.$payable->DocumentCategory) }}</h6>
                                                                    <h6 class="font-13">@lang('locale.Document Sequence') : {{ $payable->DocumentSequence }}</h6>

                                                                </div>
                                                            </div><!--end col-->
                                                        </div><!--end row-->

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="table-responsive project-invoice">
                                                                    <table class="table table-bordered mb-0">
                                                                        <thead class="thead-light">
                                                                            <tr>
                                                                                <th>@lang('locale.Description')</th>
                                                                                <th>@lang('locale.Amount')</th>
                                                                            </tr><!--end tr-->
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($payable_lines as $line)
                                                                            <tr>
                                                                                <td >
                                                                                    <h5 class="mt-0 mb-1">{{ __('locale.'.$line->LineType) }}</h5>
                                                                                    <p class="mb-0 text-muted">{{ $line->Description }}.</p>
                                                                                </td>
                                                                                <td>$ {{ number_format($line->LineAmount, 2) }}</td>
                                                                            </tr><!--end tr-->
                                                                            @endforeach

                                                                        </tbody>
                                                                    </table><!--end table-->
                                                                </div>  <!--end /div-->
                                                            </div>  <!--end col-->
                                                        </div><!--end row-->


                                                        <div class="row justify-content-center">
                                                            <div class="col-lg-12">
                                                                <h5 class="mt-4"><i class="fas fa-divide mr-2 text-info font-16"></i>@lang('locale.Installments') :</h5>
                                                            </div> <!--end col-->
                                                        </div><!--end row-->
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="table-responsive project-invoice">
                                                                    <table class="table table-bordered mb-0">
                                                                        <thead class="thead-light">
                                                                            <tr>
                                                                                <th>@lang('locale.Payment Method') /@lang('locale.Bank Account') </th>
                                                                                <th>@lang('locale.Due Date')</th>
                                                                                <th>@lang('locale.Unpaid Amount')</th>
                                                                                <th>@lang('locale.Gross Amount')</th>
                                                                            </tr><!--end tr-->
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($payable_installments as $installment)
                                                                            <tr>
                                                                                <td>
                                                                                    <h5 class="mt-0 mb-1">{{ $installment->PaymentMethod }}</h5>
                                                                                    <p class="mb-0 text-muted">{{ $installment->BankAccount }}.</p>
                                                                                </td>
                                                                                <td>{{ $installment->DueDate }}</td>
                                                                                <td>$ {{ number_format($installment->UnpaidAmount, 2) }}</td>
                                                                                <td>$ {{ number_format($installment->GrossAmount, 2) }}</td>
                                                                            </tr><!--end tr-->
                                                                            @endforeach

                                                                        </tbody>
                                                                    </table><!--end table-->
                                                                </div>  <!--end /div-->
                                                            </div>  <!--end col-->
                                                        </div><!--end row-->

                                                        <hr>
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-lg-12 col-xl-4 ml-auto align-self-center">
                                                                <div class="text-center"><small class="font-12">Tractocar Logistics SAS.</small></div>
                                                            </div><!--end col-->
                                                            <div class="col-lg-12 col-xl-4">
                                                                <div class="float-right d-print-none">
                                                                    <a href="#" class="btn btn-gradient-danger">@lang('locale.Close')</a>
                                                                </div>
                                                            </div><!--end col-->
                                                        </div><!--end row-->
                                                    </div><!--end card-body--> --}}
                                                </div><!--end card-->
                                            </div><!--end col-->
                                        </div><!--end row-->
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
        tblColectionData =  $('#TablePagadas').DataTable({
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

                { data: "InvoiceNumber" },
                { data: "CanceledFlag" },
                { data: "Supplier" },
                { data: "SupplierSite" },
                { data: "Party" },
                { data: "PartySite" },
                { data: "PaidStatus" },
                { data: "ValidationStatus" },
                { data: "AccountingDate" },
                { data: "DocumentCategory" },
                { data: "DocumentSequence" }

            ],
            columnDefs: [
                {
                    responsivePriority: 1,
                    targets: 0,
                    visible: false,
                    searchable: false,
                },
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 1, targets: 3 },
                { responsivePriority: 1, targets: 4 },
                { responsivePriority: 1, targets: 5 },
                { responsivePriority: 1, targets: 6 },

                { responsivePriority: 1, targets: 7 },
                { responsivePriority: 1, targets: 8 },
                { responsivePriority: 1, targets: 9 },
                { responsivePriority: 1, targets: 10 },
                { responsivePriority: 1, targets: 11 },
                { responsivePriority: 1, targets: 12 },
                { responsivePriority: 1, targets: 13 },
                { responsivePriority: 1, targets: 14 },
                { responsivePriority: 1, targets: 15 },
                { responsivePriority: 1, targets: 16 },

            ],
            responsive: {
                details: 'false',
            },
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('falturas.pagadas') }}",
            data: {
                SupplierNumber: {{$SupplierNumber}},
                PaidStatus: 'Paid',
                FlagStatus: 'false'
            },

            success: function(response) {
                let datos = response.data;
                if (response.success == true) {
                    console.log(datos);
                    tblColectionData.clear().draw();
                    tblColectionData.rows.add(datos).draw();

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
        obtener_data("#TablePagadas tbody", tblColectionData);
    });

    let obtener_data = function(tbody, table){
        $(tbody).on("click", "button.ver", function(){
            let invoice = table.row($(this).parents("tr") ).data();
            plantillaDate = '';
            $.ajax({
                type: "POST",
                url: "{{ route('invoice.lines') }}",
                data: invoice,
                success : function(response) {
                    let invoice = response.data.invoiceData
                    let lines = response.data.invoiceLines
                    if (response.success == true) {
                        console.log(invoice);
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

                    }
                },
                error: function(error){
                console.error(error);
            }

            });

        });
    }

    $("#por-pagar").click(function(e) {
        e.preventDefault();
        tblColectionData =  $('#TablePorPagar').DataTable({
            "ordering": true,
            retrieve: true,
            paging: false,
            processing: true,
            searchDelay: 500,
            responsive: true,
            info: true,
            columns: [
                {title: "ID Factura", data: "InvoiceId" },
                {title: "Descripción", data: "Description" },
                {title: "Valor Factura", data: "InvoiceAmount" },
                {title: "Monto Pagado", data: "AmountPaid" },
                {title: "Tipo de Factura", data: "InvoiceType" },
                {title: "Fecha Factura", data: "InvoiceDate" }

            ],
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 1, targets: 3 },
                { responsivePriority: 1, targets: 4 },
                { responsivePriority: 1, targets: 5 },

            ],
            responsive: {
                details: 'false',
            },
        });
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

                    tblColectionData.clear().draw();
                    tblColectionData.rows.add(datos).draw();

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
        tblColectionData =  $('#TablePagadasNovedad').DataTable({
            "ordering": true,
            retrieve: true,
            paging: false,
            processing: true,
            searchDelay: 500,
            responsive: true,
            info: true,
            columns: [
                {title: "ID Factura", data: "InvoiceId" },
                {title: "Descripción", data: "Description" },
                {title: "Valor Factura", data: "InvoiceAmount" },
                {title: "Monto Pagado", data: "AmountPaid" },
                {title: "Tipo de Factura", data: "InvoiceType" },
                {title: "Fecha Factura", data: "InvoiceDate" }

            ],
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 1, targets: 3 },
                { responsivePriority: 1, targets: 4 },
                { responsivePriority: 1, targets: 5 },

            ],
            responsive: {
                details: 'false',
            },
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('falturas.pagadas') }}",
            data: {
                SupplierNumber: {{$SupplierNumber}},
                PaidStatus: 'Partially paid',
                FlagStatus: 'false'
            },

            success: function(response) {
                var datos = response.data;

                if (response.success == true) {

                    tblColectionData.clear().draw();
                    tblColectionData.rows.add(datos).draw();

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
        tblColectionData =  $('#TableCanceladas').DataTable({
            "ordering": true,
            retrieve: true,
            processing: true,
            searchDelay: 500,
            responsive: true,
            info: true,
            columns: [
                {title: "ID Factura", data: "InvoiceId" },
                {title: "Descripción", data: "Description" },
                {title: "Valor Factura", data: "InvoiceAmount" },
                {title: "Monto Pagado", data: "AmountPaid" },
                {title: "Tipo de Factura", data: "InvoiceType" },
                {title: "Fecha Factura", data: "InvoiceDate" }

            ],
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 1, targets: 2 },
                { responsivePriority: 1, targets: 3 },
                { responsivePriority: 1, targets: 4 },
                { responsivePriority: 1, targets: 5 },

            ],
            responsive: {
                details: 'false',
            },
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('falturas.pagadas') }}",
            data: {
                SupplierNumber: {{$SupplierNumber}},
                FlagStatus: 'true'
            },

            success: function(response) {
                var datos = response.data;

                if (response.success == true) {

                    tblColectionData.clear().draw();
                    tblColectionData.rows.add(datos).draw();

                    // var sum = $('#TableCanceladas').DataTable().column(2).data().sum();
                    // $('#total').html(sum);
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
