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
                                                {{-- <a href="{{ route('admin.log') }}" class="btn btn-info mb-3"><i class="fas fa-file-alt"></i> Log</a> --}}
                                                <div class="card" id="oculto-pagadas" style="display: none">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS PAGADAS</h3>
                                                    <div class="card-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg-12">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <div class="table-responsive">
                                                                            <table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th class="border-bottom-0">AmountPaid</th>
                                                                                        <th class="border-bottom-0">Description</th>
                                                                                        <th class="border-bottom-0">InvoiceAmount</th>
                                                                                        <th class="border-bottom-0">InvoiceDate</th>
                                                                                        <th class="border-bottom-0">InvoiceType</th>
                                                                                        <th class="border-bottom-0">Supplier</th>
                                                                                        <th class="border-bottom-0">SupplierNumber</th>

                                                                                    </tr>
                                                                                </thead>
                                                                                {{-- <tbody id="tablaCustomers">
                                                                                </tbody> --}}
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card" id="oculto-por-pagar" style="display: none">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS POR PAGAR</h3>
                                                    <div class="card-body">
                                                        {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profesores colegio</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profesores universidades</a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content mt-3" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                                <form  method="post" action="{{ route('import.profesorC') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="mb-3 col-md-3">
                                                                        <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" required>
                                                                        <div class="invalid-feedback">
                                                                            Seleccione un documento excel
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <button type="submit" id="btnImportar" class="btn btn-success">
                                                                            Importar
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                                <form  method="post" action="{{ route('import.profesorU') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="mb-3 col-md-3">
                                                                        <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" required>
                                                                        <div class="invalid-feedback">
                                                                            Seleccione un documento excel
                                                                        </div>
                                                                        <div id="progressbar" class="progress mt-3" hidden>
                                                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <button type="submit" id="btnImportar" class="btn btn-success">
                                                                            Importar
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div> --}}

                                                    </div>
                                                </div>

                                                <div class="card" id="oculto-pagadas-con-novedad" style="display: none">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS PAGADAS CON NOVEDAD</h3>
                                                    <div class="card-body">
                                                        {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profesores colegio</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profesores universidades</a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content mt-3" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                                <form  method="post" action="{{ route('import.profesorC') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="mb-3 col-md-3">
                                                                        <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" required>
                                                                        <div class="invalid-feedback">
                                                                            Seleccione un documento excel
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <button type="submit" id="btnImportar" class="btn btn-success">
                                                                            Importar
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                                                <form  method="post" action="{{ route('import.profesorU') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="mb-3 col-md-3">
                                                                        <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" required>
                                                                        <div class="invalid-feedback">
                                                                            Seleccione un documento excel
                                                                        </div>
                                                                        <div id="progressbar" class="progress mt-3" hidden>
                                                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <button type="submit" id="btnImportar" class="btn btn-success">
                                                                            Importar
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div> --}}

                                                    </div>
                                                </div>

                                                <div class="card" id="oculto-canceladas" style="display: none">
                                                    <h3 class="text-center" style="text-decoration: underline">FACTURAS CANCELADAS</h3>
                                                    <div class="card-body">
                                                        <div class="tab-content mt-3" id="myTabContent">
                                                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                                <div class="card-body">
                                                                    {{-- <form  method="post" action="{{route('profesores.store')}}" class="row g-3 needs-validation" novalidate>
                                                                        @csrf
                                                                        <div class="col-md-4">
                                                                            <label for="validationCustom01" class="form-label">Nombre</label>
                                                                            <input type="text" placeholder="nombre..." name="name" class="form-control" id="validationCustom01" value="" required onkeyup="mayus(this);">
                                                                            <div class="invalid-feedback">
                                                                                Ingrese nombre.
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="validationCustom03" class="form-label">N° de documento</label>
                                                                            <input type="text" placeholder="0000000000" name="numdoc" class="form-control" id="validationCustom03" required>
                                                                            <div class="invalid-feedback">
                                                                                Ingrese N° de documento.
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="validationCustom05" class="form-label">Empresa</label>
                                                                            <select name="empresa" class="form-control tipo_destinon" id="validationCustom01" value="" required>
                                                                                <option value="">Seleccione...</option>
                                                                                <option value="1">Colegio</option>
                                                                                <option value="2">Universidad</option>
                                                                            </select>
                                                                            <div class="invalid-feedback">
                                                                                Seleccione empresa.
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6" style="margin-top:20px">
                                                                            <label for="validationCustom01" class="form-label nn">Establecimiento</label>
                                                                            <select name="" class="form-control n0" id="validationCustom01" value="" required>
                                                                                <option value="" placeholder="seleccione..."></option>
                                                                            </select>

                                                                            <select name="dane_empresa" style="display: none" class="form-control n1" id="validationCustom04" value="" required>
                                                                                <option value="">Seleccione...</option>
                                                                                @foreach ($colegios as $col)
                                                                                    <option value="{{$col->col_dane_colegio}}">{{$col->col_nombre}}</option>
                                                                                @endforeach
                                                                            </select>

                                                                            <select name="dane_empresa" style="display: none" class="form-control n2" id="validationCustom05" value="" required>
                                                                                <option value="">Seleccione...</option>
                                                                                @foreach ($universidades as $uni)
                                                                                    <option value="{{$uni->uni_codigo}}">{{$uni->uni_nombre}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="col-md-12">
                                                                            <br>
                                                                            <button class="btn btn-success" type="submit">Guardar<i class="fas fa-save"></i></button>
                                                                        </div>
                                                                    </form> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    <!-- Row -->
                                                    {{-- <div class="row row-sm">
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
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <table id="tablaAfiliados"
                                                                        class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
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
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <!-- End Row -->

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
    </body>
    {{-- $.ajax({
        url: "facturas/pagadas",
        // data:  ,
        method: 'get',
        success: (response) => {
            if (response.statusCode == 200) {
                console.log('response');
            }
            if( $("#oculto-pagadas").css("display") == 'none' )
            $("#oculto-pagadas").show("slow");
            else
            $("#oculto-pagadas").hide("slow");

            // validamos que no se muestren todat al tiempo
            if($("#oculto-canceladas").css("display") != 'none')
            $("#oculto-canceladas").hide("slow");

            if($("#oculto-pagadas-con-novedad").css("display") != 'none')
            $("#oculto-pagadas-con-novedad").hide("slow");

            if($("#oculto-por-pagar").css("display") != 'none')
            $("#oculto-por-pagar").hide("slow");

            // let responseData = response.responseData
            // plantillaTablaAfiliados =
            // `
            // <tr>
            //     <td>${ responseData.firstName } ${ responseData.lastName}</td>
            //     <td>${ responseData.contactXid }</td>
            //     <td>${ responseData.emailAddress }</td>
            //     <td>${ responseData.phone1 }</td>
            // </tr>
            // `

            // /** insertamos el html dentro de la etiqueta */
            // $('#tablaAfiliados').append(plantillaTablaAfiliados)
        },
        error: function (data) {
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'No se encontro ningun registro en OTM con el numero de identificacion ingresado!',
        })
    }) --}}

    @section('scripts')
    <script>
        $('#pagadas').on('click', function(e){
            e.preventDefault();
            let plantillaTablaCustomers = ''
            //console.log({{$SupplierNumber}});
            $.ajax({
                type: 'POST',
                url: "{{ route('falturas.pagadas') }}",
                data: {
                    SupplierNumber: {{$SupplierNumber}},
                    PaidStatus: 'Paid'
                },
                success: (response) => {
                    let invoices = response.data
                    let invoice = invoices[0]
                    // const obj = Object.assign([], invoices);

                    // console.log(obj);

                    $('#file-datatable').dataTable( {
                        data : invoice,
                        columns: [
                            {"data" : "invoice.AmountPaid"},
                            {"data" : "invoice.Description"},
                            {"data" : "invoice.InvoiceAmount"},
                            {"data" : "invoice.InvoiceDate"},
                            {"data" : "invoice.InvoiceType"},
                            {"data" : "invoice.Supplier"},
                            {"data" : "invoice.SupplierNumber"},
                        ],
                    });

                    // invoices.forEach(invoice => {
                    //     console.log(invoice.AmountPaid);

                    //      plantillaTablaCustomers =
                    //      `
                    //      <tr>
                    //          <td>${ invoice.AmountPaid }</td>
                    //          <td>${ invoice.Description }</td>
                    //          <td>${ invoice.InvoiceAmount }</td>
                    //          <td>${ invoice.InvoiceDate }</td>
                    //          <td>${ invoice.InvoiceType }</td>
                    //          <td>${ invoice.Supplier }</td>
                    //          <td>${ invoice.SupplierNumber }</td>
                    //      </tr>
                    //      `

                    //      /** insertamos el html dentro de la etiqueta */
                    //      $('#tablaCustomers').append(plantillaTablaCustomers)
                    // });

                    if (response.success == true) {
                        if( $("#oculto-pagadas").css("display") == 'none' )
                        $("#oculto-pagadas").show("slow");
                        else
                        $("#oculto-pagadas").hide("slow");

                        // validamos que no se muestren todat al tiempo
                        if($("#oculto-canceladas").css("display") != 'none')
                        $("#oculto-canceladas").hide("slow");

                        if($("#oculto-pagadas-con-novedad").css("display") != 'none')
                        $("#oculto-pagadas-con-novedad").hide("slow");

                        if($("#oculto-por-pagar").css("display") != 'none')
                        $("#oculto-por-pagar").hide("slow");
                    }
                }
            })
        });

        $("#por-pagar").click(function() {
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


        });

        $("#pagadas-con-novedad").click(function() {
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
        });

        $("#canceladas").click(function() {
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
        });

    </script>
    {{-- <script>
        // $('#myModal').modal(options)
        $('#exampleModal').on('shown.bs.modal', function () {
        $('#exampleModal').trigger('focus')
        })

    </script> --}}
    @endsection
@endsection

