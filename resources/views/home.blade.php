@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini">
    <div class="page">
        <div class="page-main">
            @can('/usuario.index')
            <div class="app-content main-content mt-0">
            @endcan
                <div class="side-app">
                    <div class="main-container container-fluid">
                        <div class="page-header">
                            <div>
                                <h1 class="page-title">Dashboard</h1>
                            </div>
                            <div class="ms-auto pageheader-btn">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                                </ol>
                            </div>
                        </div>
                        @can('/usuario.index')
                        <div class="row">
                            @php
                            $counter = 0;
                            $items = [
                            0 => ['color'=>'indigo', 'icon'=> 'fa fa-user'],
                            1 => ['color'=>'primary','icon'=> 'fa fa-ra'],
                            2 => ['color'=>'info','icon'=> 'fa fa-minus'],
                            3 => ['color'=>'cyan','icon'=> 'fa fa-info']
                            ];
                            @endphp
                            @foreach ($request_status as $key => $statu)
                            <div style="display: none">
                                {{$counter = $counter + $statu->count }}
                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 class="mb-2 fw-semibold">{{$statu->count}}</h3>
                                                <p class="text-muted fs-13 mb-0">{{$statu->status}}</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div
                                                    class="counter-icon bg-{{$items[$key]['color']}} dash ms-auto box-shadow-primary">
                                                    <i class="{{$items[$key]['icon']}}"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 class="mb-2 fw-semibold">{{$counter}}</h3>
                                                <p class="text-muted fs-13 mb-0">TOTAL AFILIADOS</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div class="counter-icon bg-gray dash ms-auto box-shadow-primary">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                        @can('/facturas')
                        <div id="global-loader2">
                            <img src={{asset('assets/images/loader.svg')}} class="loader-img" alt="Loader">
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-md-6 col-xl-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 id="mtPorPagar" class="mb-2 fw-semibold"></h3>
                                                <p class="text-muted fs-13 mb-0">Monto de Facturas por Pagar</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div
                                                    class="counter-icon bg-secondary dash ms-auto box-shadow-secondary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                                        <path
                                                            d="M19.5,7H16V5.9169922c0-2.2091064-1.7908325-4-4-4s-4,1.7908936-4,4V7H4.5C4.4998169,7,4.4996338,7,4.4993896,7C4.2234497,7.0001831,3.9998169,7.223999,4,7.5V19c0.0018311,1.6561279,1.3438721,2.9981689,3,3h10c1.6561279-0.0018311,2.9981689-1.3438721,3-3V7.5c0-0.0001831,0-0.0003662,0-0.0006104C19.9998169,7.2234497,19.776001,6.9998169,19.5,7z M9,5.9169922c0-1.6568604,1.3431396-3,3-3s3,1.3431396,3,3V7H9V5.9169922z M19,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2H7c-1.1040039-0.0014038-1.9985962-0.8959961-2-2V8h3v2.5C8,10.776123,8.223877,11,8.5,11S9,10.776123,9,10.5V8h6v2.5c0,0.0001831,0,0.0003662,0,0.0005493C15.0001831,10.7765503,15.223999,11.0001831,15.5,11c0.0001831,0,0.0003662,0,0.0006104,0C15.7765503,10.9998169,16.0001831,10.776001,16,10.5V8h3V19z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="" class="col-lg-6 col-sm-12 col-md-6 col-xl-6">
                                <div class="card overflow-hidden">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">
                                                <h3 id="totalFt" class="mb-2 fw-semibold"></h3>
                                                <p class="text-muted fs-13 mb-0">Facturas por Pagar</p>
                                            </div>
                                            <div class="col col-auto top-icn dash">
                                                <div class="counter-icon bg-warning dash ms-auto box-shadow-warning">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                        enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                                        <path
                                                            d="M9,10h2.5c0.276123,0,0.5-0.223877,0.5-0.5S11.776123,9,11.5,9H10V8c0-0.276123-0.223877-0.5-0.5-0.5S9,7.723877,9,8v1c-1.1045532,0-2,0.8954468-2,2s0.8954468,2,2,2h1c0.5523071,0,1,0.4476929,1,1s-0.4476929,1-1,1H7.5C7.223877,15,7,15.223877,7,15.5S7.223877,16,7.5,16H9v1.0005493C9.0001831,17.2765503,9.223999,17.5001831,9.5,17.5h0.0006104C9.7765503,17.4998169,10.0001831,17.276001,10,17v-1c1.1045532,0,2-0.8954468,2-2s-0.8954468-2-2-2H9c-0.5523071,0-1-0.4476929-1-1S8.4476929,10,9,10z M21.5,12H17V2.5c0.000061-0.0875244-0.0228882-0.1735229-0.0665283-0.2493896c-0.1375732-0.2393188-0.4431152-0.3217773-0.6824951-0.1842041l-3.2460327,1.8603516L9.7481079,2.0654297c-0.1536865-0.0878906-0.3424072-0.0878906-0.4960938,0l-3.256897,1.8613281L2.7490234,2.0664062C2.6731567,2.0227661,2.5871582,1.9998779,2.4996338,1.9998779C2.2235718,2.000061,1.9998779,2.223938,2,2.5v17c0.0012817,1.380188,1.119812,2.4987183,2.5,2.5H19c1.6561279-0.0018311,2.9981689-1.3438721,3-3v-6.5006104C21.9998169,12.2234497,21.776001,11.9998169,21.5,12z M4.5,21c-0.828064-0.0009155-1.4990845-0.671936-1.5-1.5V3.3623047l2.7412109,1.5712891c0.1575928,0.0872192,0.348877,0.0875854,0.5068359,0.0009766L9.5,3.0761719l3.2519531,1.8583984c0.157959,0.0866089,0.3492432,0.0862427,0.5068359-0.0009766L16,3.3623047V19c0.0008545,0.7719116,0.3010864,1.4684448,0.7803345,2H4.5z M21,19c0,1.1045532-0.8954468,2-2,2s-2-0.8954468-2-2v-6h4V19z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <a id="facturas-all" class="card text-center btn btn-icon btn-primary-light me-2" data-bs-toggle="tooltip"
                                            style="width: 16rem; height: 18rem;" data-bs-original-title="Todas las facturas">
                                            <div class="card-body">
                                                <img class="card-img-top" src="{{asset('assets/images/invoiceIcon/factura.png')}}">
                                            </div>
                                        <h5 class="card-title">Todas las facturas</h5>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="card text-center btn btn-icon btn-primary-light me-2" data-bs-toggle="tooltip" style="width: 16rem; height: 18rem;" data-bs-original-title="Listas para pago">
                                            <div class="card-body">
                                                <img class="card-img-top" src="{{asset('assets/images/invoiceIcon/factura-proceso-pago-modulo-1.png')}}">
                                            </div>
                                            <h5 class="card-title">Facturas Modulo 1</h5>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="card text-center btn btn-icon btn-primary-light me-2" data-bs-toggle="tooltip" style="width: 16rem; height: 18rem;" data-bs-original-title="En ruta">
                                            <div class="card-body">
                                                <img class="card-img-top" src="{{asset('assets/images/invoiceIcon/factura-en-viaje-modulo-2.png')}}">
                                            </div>
                                            <h5 class="card-title">Facturas Modulo 2</h5>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="card text-center btn btn-icon btn-primary-light me-2" data-bs-toggle="tooltip" style="width: 16rem; height: 18rem;" data-bs-original-title="Bloqueadad">
                                            <div class="card-body">
                                                <img class="card-img-top" src="{{asset('assets/images/invoiceIcon/facturas-bloqueadas-modulo-3.png')}}">
                                            </div>
                                            <h5 class="card-title">Facturas Modulo 3</h5>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a id="facturas-lotes" class="card text-center btn btn-icon btn-primary-light me-2" data-bs-toggle="tooltip"
                                        style="width: 16rem; height: 18rem;">
                                            <div class="card-body">
                                                <img class="card-img-top" src="{{asset('assets/images/invoiceIcon/factura-filtradas.png')}}">
                                            </div>
                                            <h5 class="card-title">Facturas filtradas</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                                                            <label for="tipoFactura" class="form-label">tipo de factura</label>
                                                                            <select type="text" name="tipoFactura" id="tipoFactura" class="form-select" tabindex="3" value="{{ old('tipoFactura') }}" autofocus>
                                                                                <option selected value="">Todos</option>
                                                                                <option value="Pago por adelantado">Anticipo</option>
                                                                                <option value="Estándar">Estandar</option>
                                                                                <option value="Nota de crédito">Nota Credito</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md">
                                                                            <label for="ValidationStatus" class="form-label">Estado</label>
                                                                            <select type="text" name="ValidationStatus" id="ValidationStatus" class="form-select" tabindex="3" value="{{ old('tipoFactura') }}" autofocus>
                                                                                <option selected value="">Todos</option>
                                                                                <option value="Cancelada">Cancelada</option>
                                                                                <option value="Validada">Validada</option>
                                                                                <option value="Necesita revalidación">Necesita revalidación</option>
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
                        <div class="collapse" id="FacturasDivididas" style="display: none">
                            <body class="ltr app sidebar-mini light-mode">
                                <div class="row row-sm">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- CONTAINER -->
                                                <div class="main-container container-fluid">
                                                    <!-- Botones de Consulta -->
                                                    <div class="text-center">
                                                        <button class="btn btn-primary mb-3" target="" id="pagadas">
                                                            Facturas pagadas
                                                        </button>
                                                        <button class="btn btn-success mb-3" target="" id="por-pagar">
                                                            Facturas por pagar
                                                        </button>
                                                        <button class="btn btn-secondary mb-3" target="" id="pagadas-con-novedad">
                                                            Facturas parcialmente pagadas
                                                        </button>
                                                        <button class="btn btn-warning mb-3" target="" id="descuentos">
                                                            Facturas nota credito aplicadas
                                                        </button>
                                                        <button class="btn btn-danger mb-3" target="" id="descuentos-pendientes">
                                                            Facturas nota credito por aplicar
                                                        </button>
                                                        {{-- <button class="btn btn-dark mb-3" target="" id="canceladas">
                                                            Facturas canceladas
                                                        </button> --}}
                                                    </div>
                                                    <!-- Fin -->

                                                    <div class="card" id="oculto-pagadas" style="display: none">
                                                        <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                            PAGADAS</h3>
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
                                                    {{-- <div class="card" id="oculto-canceladas" style="display: none">
                                                        <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                        CANCELADAS</h3>
                                                        <div class="card-body">
                                                            <div class="row row-sm">
                                                                <div class="col-lg-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="table-responsive">
                                                                                <table id="TableCanceladas"
                                                                                    class="table table-bordered text-nowrap key-buttons border-bottom w-100">
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="card" id="oculto-descuentos" style="display: none">
                                                        <h3 class="text-center" style="text-decoration: underline">FACTURAS PAGADAS
                                                        CON DESCUENTO</h3>
                                                        <div class="card-body">
                                                            <div class="row row-sm">
                                                                <div class="col-lg-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="table-responsive">
                                                                                <table id="TableDescuento"
                                                                                    class="table table-bordered text-nowrap key-buttons border-bottom w-100">
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card" id="oculto-descuentos-pendientes" style="display: none">
                                                        <h3 class="text-center" style="text-decoration: underline">FACTURAS
                                                        CON DESCUENTOS PENDIENTES</h3>
                                                        <div class="card-body">
                                                            <div class="row row-sm">
                                                                <div class="col-lg-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="table-responsive">
                                                                                <table id="TableDescuentoPendiente"
                                                                                    class="table table-bordered text-nowrap key-buttons border-bottom w-100">
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
                        <div class="modal fade" id="exampleModalToggle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                    <button type="button" id="closet-modal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        @endcan
                    </div>
                </div>
            @can('/usuario.index')
            </div>
            @endcan
        </div>
    </div>
</body>
@endsection
@section('scripts')
<script src="http://momentjs.com/downloads/moment.min.js"></script>

    @if (Session::has('message'))
        <script>
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{Session::get('message')}}',
            })
        </script>
    @endif

    <script>
        let Loader1 = function(){
            let $yourUl = $("#global-loader2");
            $yourUl.css("display", $yourUl.css("display") === 'none' ? '' : 'none');
        }
        window.onload = function() {
            $.ajax({
                type: "POST",
                url: "{{ route('supplier.number') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: "{{ Auth::user()->id}}"},
                success: function(response) {
                    let data = response.data;
                    if(response.success == true)
                    {
                        let = plantillaMtPagadas = ''
                        let = plantillaMtPorPagar = ''
                        let = plantillaMtPagadasConNovedad = ''
                        let = plantillaTotalFt = ''

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('total') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                SupplierNumber:data,
                                PaidStatus: ['Impagado'],
                                FlagStatus: 'false'
                            },

                            success: function(response) {
                                let datos = response.data;
                                if (response.success == true) {
                                    let dollarUSLocale = Intl.NumberFormat('en-US');
                                    // let mtPagadas = dollarUSLocale.format(datos[2]['Pagadas']);
                                    let mtPorPagar = dollarUSLocale.format(datos[0]['Impagado']);
                                    // let mtPagadasConNovedad = dollarUSLocale.format(datos[0]['Parcialmente pagado']);
                                    let totalFt = datos[0]['count Impagado'];

                                    // plantillaMtPagadas =
                                    // `
                                    // <h3 class="mb-2 fw-semibold">$${mtPagadas}</h3>
                                    // `
                                    // $('#mtPagadas').append(plantillaMtPagadas)

                                    plantillaMtPorPagar =
                                    `
                                    <h3 class="mb-2 fw-semibold">$${mtPorPagar}</h3>
                                    `
                                    $('#mtPorPagar').append(plantillaMtPorPagar)

                                    // plantillaMtPagadasConNovedad =
                                    // `
                                    // <h3 class="mb-2 fw-semibold">$${mtPagadasConNovedad}</h3>
                                    // `
                                    // $('#mtPagadasConNovedad').append(plantillaMtPagadasConNovedad)

                                    plantillaTotalFt =
                                    `
                                    <h3 class="mb-2 fw-semibold">${totalFt}</h3>
                                    `
                                    $('#totalFt').append(plantillaTotalFt)
                                    Loader1();
                                    // console.log(datos[2]['Paid']);
                                }
                            },
                            error: function(error){
                                console.error(error);
                            }
                        })
                    }
                }
            })
        }

    </script>

    @can('/facturas')
        <script>
            // Datatable
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
                                    return 'dentro de la programacion de pago';
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

                        if($("#oculto-descuentos").css("display") != 'none')
                        $("#oculto-descuentos").hide("slow");

                        if($("#oculto-descuentos-pendientes").css("display") != 'none')
                        $("#oculto-descuentos-pendientes").hide("slow");

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

                        if($("#oculto-descuentos").css("display") != 'none')
                        $("#oculto-descuentos").hide("slow");

                        if($("#oculto-descuentos-pendientes").css("display") != 'none')
                        $("#oculto-descuentos-pendientes").hide("slow");
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

                        if($("#oculto-descuentos").css("display") != 'none')
                        $("#oculto-descuentos").hide("slow");

                        if($("#oculto-descuentos-pendientes").css("display") != 'none')
                        $("#oculto-descuentos-pendientes").hide("slow");
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

                        if($("#oculto-descuentos").css("display") != 'none')
                        $("#oculto-descuentos").hide("slow");

                        if($("#oculto-por-pagar").css("display") != 'none')
                        $("#oculto-por-pagar").hide("slow");

                        if($("#oculto-descuentos-pendientes").css("display") != 'none')
                        $("#oculto-descuentos-pendientes").hide("slow");
                    }
                    else if(Card == "#oculto-descuentos"){

                        if( $("#oculto-descuentos").css("display") == 'none' )
                        $("#oculto-descuentos").show("slow");
                        else
                        $("#oculto-descuentos").hide("slow");

                        // validamos que no se muestren todas al tiempo
                        if($("#oculto-pagadas").css("display") != 'none')
                        $("#oculto-pagadas").hide("slow");

                        if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                        $("#oculto-pagadas-con-novedad").hide("slow");

                        if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                        $("#oculto-pagadas-con-novedad").hide("slow");

                        if($("#oculto-por-pagar").css("display") != 'none')
                        $("#oculto-por-pagar").hide("slow");

                        if($("#oculto-canceladas").css("display") != 'none')
                        $("#oculto-canceladas").hide("slow");

                        if($("#oculto-descuentos-pendientes").css("display") != 'none')
                        $("#oculto-descuentos-pendientes").hide("slow");
                    }
                    else if(Card == "#oculto-descuentos-pendientes"){
                        if( $("#oculto-descuentos-pendientes").css("display") == 'none' )
                        $("#oculto-descuentos-pendientes").show("slow");
                        else
                        $("#oculto-descuentos-pendientes").hide("slow");

                        // validamos que no se muestren todas al tiempo
                        if($("#oculto-pagadas").css("display") != 'none')
                        $("#oculto-pagadas").hide("slow");

                        if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                        $("#oculto-pagadas-con-novedad").hide("slow");

                        if($("#oculto-por-pagar").css("display") != 'none')
                        $("#oculto-por-pagar").hide("slow");

                        if($("#oculto-canceladas").css("display") != 'none')
                        $("#oculto-canceladas").hide("slow");

                        if($("#oculto-descuentos").css("display") != 'none')
                        $("#oculto-descuentos").hide("slow");
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
            // load inicial, se visualiza al seleccionar un opcion de las facturas
            let Loader = function(){
                Swal.fire({
                title: 'Cargando Facturas!',
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                },
                })
            }
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

            // Filtros
            $('#btnPrFiltr').on('click', function(e){
                var InvoiceType = document.getElementById("tipoFactura").value;
                var ValidationStatus = document.getElementById("ValidationStatus").value;
                var startDate = document.getElementById("startDate").value;
                var endDate = document.getElementById("endDate").value;
                tblColectionData.clear().draw();
                Loader();
                LoadData("", "false", "#TablaFacturasAll",InvoiceType,ValidationStatus,"",startDate,endDate);
                obtener_data("#TablaFacturasAll tbody", tblColectionData);
            });
            // Fin

            // Botones de consultar las facturas Divididas
            $('#pagadas').on('click', function(e){
                e.preventDefault();
                Loader();
                LoadData("Pagadas", "false", "#TablePagadas","Estándar","","#oculto-pagadas","","");
                obtener_data("#TablePagadas tbody", tblColectionData);

            });

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

            $("#descuentos").click(function(e) {
                e.preventDefault();
                Loader();
                LoadData("Pagadas", "false", "#TableDescuento","Nota de crédito","","#oculto-descuentos","","");
                obtener_data("#TableDescuento tbody", tblColectionData);
            });

            $("#descuentos-pendientes").click(function(e) {
                e.preventDefault();
                Loader();
                LoadData("Impagado", "true", "#TableDescuentoPendiente","Nota de crédito","","#oculto-descuentos-pendientes","","");
                obtener_data("#TableDescuentoPendiente tbody", tblColectionData);
            });

            // $("#canceladas").click(function(e) {
            //     e.preventDefault();
            //     Loader();
            //     LoadData("", "true", "#TableCanceladas","","","#oculto-canceladas","","");
            //     obtener_data("#TableCanceladas tbody", tblColectionData);
            // });
            // Fin

            // Botones Principales
            $("#facturas-all").click(function(e) {
                e.preventDefault();
                console.log('ff');
                Loader();
                LoadData("", "false", "#TablaFacturasAll","","","","","");
                obtener_data("#TablaFacturasAll tbody", tblColectionData);

                if( $("#FacturasGenerales").css("display") == 'none' )
                $("#FacturasGenerales").show("slow");
                else
                $("#FacturasGenerales").hide("slow");

                // validamos que no se muestren todas al tiempo
                if($("#FacturasDivididas").css("display") != 'none')
                $("#FacturasDivididas").hide("slow");

            });

            $("#facturas-lotes").click(function(e) {
                e.preventDefault();
                if( $("#FacturasDivididas").css("display") == 'none' )
                $("#FacturasDivididas").show("slow");
                else
                $("#FacturasDivididas").hide("slow");

                // validamos que no se muestren todas al tiempo
                if($("#FacturasGenerales").css("display") != 'none')
                $("#FacturasGenerales").hide("slow");

            });
            // Fin


            $("#closet-modal").click(function(e) {
                // document.getElementById("global-loader3").style.display = "none";
                $("#global-loader3").modal('hide');//ocultamos el modal

            });

            // visualizar facturas individuales
            let obtener_data = function(tbody, table){
                $(tbody).on("click", "button.ver", function(){
                    // Activar el spiner de cargar al momento de visualizar la factura
                    // document.getElementById("global-loader3").style.display = "";
                    LoaderView();
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
                                            <h6><b>@lang('locale.Invoice Type') :</b>
                                                ${
                                                    invoice.InvoiceType
                                                }
                                            </h6>
                                            <h6 class="mb-0"><b>@lang('locale.Payment status') : </b>
                                                ${  invoice.PaidStatus
                                                }
                                            </h6>
                                            <h6><b>@lang('locale.Validation Status') :</b>
                                                ${
                                                    invoice.ValidationStatus
                                                }
                                            </h6>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-md-4">
                                        <div class="text-left bg-light p-3 mb-3">
                                            <h5 class="bg-info mt-0 p-2 text-white d-sm-inline-block">@lang('locale.Additional Information')</h5>
                                            <h6 class="font-13">@lang('locale.Accounting Date') : ${ invoice.AccountingDate }</h6>
                                            <h6 class="font-13">@lang('locale.Document Category') :
                                                ${
                                                    invoice.DocumentCategory = "Prepayment Invoices" ? 'Facturas de anticipo' : 'Facturas Estandar'
                                                }
                                                </h6>
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
                            swal.close();
                            $('#exampleModalToggle').modal('show');
                        },
                        error: function(error){
                        console.error(error);
                    }
                    //Fin
                    });

                });
            }

        </script>
    @endcan


@endsection
