// Funccion de consulta validaciones y carga de datos Datatable
let LoadData = function (PaidStatus, CanceledFlag, TableName, InvoiceType, ValidationStatus, Card, startDate,
    endDate, InvoiceLimit) {
    // let start = performance.now();
    $.ajax({
        type: 'POST',
        url: "{{ route('falturas.pagadas') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            SupplierNumber: {{ $SupplierNumber }},
    CanceledFlag: CanceledFlag,
    PaidStatus: PaidStatus,
    InvoiceType: InvoiceType,
    InvoiceLimit: InvoiceLimit,
    core: "=",
    ValidationStatus: ValidationStatus,
    startDate: startDate,
    endDate: endDate

                    },
success: function(response) {
    let datos = response.data;
    if (response.success == true) {

        tblColectionData.clear().draw();
        tblColectionData.rows.add(datos).draw();

        validacionButton(Card);

        swal.close();
    } else {
        swal.close();
        Loader();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: datos,
        })
    }
},
error: function(error) {
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

let LoadDataShipment = function (TableName, Card, ShipmentsLimit) {
    // let start = performance.now();
    tblColectionData = $(TableName).DataTable({

        retrieve: true,

        dom: 'Bfrtip',
        "buttons": [{
            extend: 'collection',
            text: 'Exportar',
            buttons: [{
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
        }],

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

        columns: [{
            title: "Accion",
            data: null,
            defaultContent: "<button type='button' class='verT btn btn-success' width='25px'><i class='fa fa-eye' aria-hidden='true'></i></button>"
        },
        {
            title: "ID",
            data: "shipmentXid"
        },
        {
            title: "Numero identificacion proveedor",
            data: function (d) {

                if (typeof d.attribute9 != "undefined") {
                    let pieces = d.attribute9.split(".");
                    return pieces[1];

                } else {
                    return 'Numero identificacion proveedor no definida';
                }

            }
        },
        {
            title: "Placa",
            data: function (d) {

                if (typeof d.attribute10 != "undefined") {
                    let pieces = d.attribute10.split(".");
                    return pieces[1];
                } else {
                    return 'Placa no definida';
                }


            }
        },
        {
            title: "Placa Trailer",
            data: function (d) {
                // console.log(typeof d.attribute11);
                if (typeof d.attribute11 != "undefined") {
                    let pieces = d.attribute11.split(".");
                    return pieces[1];
                } else {
                    return 'Placa de trailer no definida';
                }
            }
        },
        {
            title: "Costo Total",
            data: function (d) {

                const formatterDolar = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'COP',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })

                return formatterDolar.format(d.totalActualCost['value']);
            }
        },
        {
            title: "Numero de paradas",
            data: "numStops"
        },

        ],

        columnDefs: [{
            responsivePriority: 1,
            targets: 0
        },
        {
            responsivePriority: 1,
            targets: 1
        },
        {
            responsivePriority: 1,
            targets: 2
        },
        {
            responsivePriority: 1,
            targets: 3
        },
        {
            responsivePriority: 1,
            targets: 4
        },
        {
            responsivePriority: 1,
            targets: 5
        },
        ],

    });
    let validacionButton = function (Card) {
        if (Card == "#oculto-por-pagar") {

            if ($("#oculto-por-pagar").css("display") == 'none')
                $("#oculto-por-pagar").show("slow");
            else
                $("#oculto-por-pagar").hide("slow");

            // validamos que no se muestren todas al tiempo
            if ($("#oculto-pagadas-con-novedad").css("display") != 'none')
                $("#oculto-pagadas-con-novedad").hide("slow");

            if ($("#facturas-en-transporte").css("display") != 'none')
                $("#facturas-en-transporte").hide("slow");

            if ($("#FacturasGenerales").css("display") != 'none')
                $("#FacturasGenerales").hide("slow");
        } else if (Card == "#oculto-pagadas-con-novedad") {

            if ($("#oculto-pagadas-con-novedad").css("display") == 'none')
                $("#oculto-pagadas-con-novedad").show("slow");
            else
                $("#oculto-pagadas-con-novedad").hide("slow");

            // validamos que no se muestren todas al tiempo
            if ($("#oculto-por-pagar").css("display") != 'none')
                $("#oculto-por-pagar").hide("slow");

            if ($("#facturas-en-transporte").css("display") != 'none')
                $("#facturas-en-transporte").hide("slow");

            if ($("#FacturasGenerales").css("display") != 'none')
                $("#FacturasGenerales").hide("slow");
        } else if (Card == "#FacturasGenerales") {
            if ($("#FacturasGenerales").css("display") == 'none')
                $("#FacturasGenerales").show("slow");
            else
                $("#FacturasGenerales").hide("slow");

            // validamos que no se muestren todas al tiempo
            if ($("#oculto-pagadas-con-novedad").css("display") != 'none')
                $("#oculto-pagadas-con-novedad").hide("slow");

            if ($("#oculto-por-pagar").css("display") != 'none')
                $("#oculto-por-pagar").hide("slow");

            if ($("#facturas-en-transporte").css("display") != 'none')
                $("#facturas-en-transporte").hide("slow");

        } else if (Card == "#facturas-en-transporte") {
            if ($("#facturas-en-transporte").css("display") == 'none')
                $("#facturas-en-transporte").show("slow");
            else
                $("#facturas-en-transporte").hide("slow");

            // validamos que no se muestren todas al tiempo
            if ($("#oculto-pagadas-con-novedad").css("display") != 'none')
                $("#oculto-pagadas-con-novedad").hide("slow");

            if ($("#FacturasGenerales").css("display") != 'none')
                $("#FacturasGenerales").hide("slow");

            if ($("#oculto-por-pagar").css("display") != 'none')
                $("#oculto-por-pagar").hide("slow");

        }
    }
    $.ajax({
        type: 'POST',
        url: "{{ route('falturas.transporte') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            number_id: {{ $number_id }},
    ShipmentsLimit: ShipmentsLimit,

                    },
success: function(response) {
    let datos = response.data;
    if (response.success == true) {

        tblColectionData.clear().draw();
        tblColectionData.rows.add(datos).draw();

        validacionButton(Card);

        swal.close();
    } else {
        swal.close();
        Loader();
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: datos,
        })

    }
},
error: function(error) {
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
let Loader = function () {
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

// load inicial, se visualiza al seleccionar un opcion de las facturas
let Load = function (cant) {
    Swal.fire({
        title: 'Cargando las ' + cant + ' facturas mas recientes!',
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
        },
    })
}
// Fin

// load secundario, se visualiza al momento pasas de una opcion de facturas a otro siempre y cuando se estan visualizando la tabla de facturas
let LoaderView = function () {
    Swal.fire({
        title: 'Cargando visualización!',
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
        },
    })
}
// Fin

// Filtros facturas OTM transporte
$('#btnFiltr').on('click', function (e) {
    e.preventDefault(); //detemos el formluario
    var ShipmentsLimit = document.getElementById("ShipmentsLimit").value;
    tblColectionData.clear().draw();
    // Loader();
    if (ShipmentsLimit > 20) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Advertencia',
            text: "Tenga en cuanta que al aumentar el rango de carga de facturas la respuesta demorara un poco más.!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, Entiendo',
            cancelButtonText: 'Mmm... mejor no',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Load(ShipmentsLimit);
                LoadDataShipment("#TableEnTransporte", "", ShipmentsLimit);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Consulta Cancelada'
                )
            }
        });

    } else if (ShipmentsLimit == 20) {

        Load(ShipmentsLimit);
        LoadDataShipment("#TableEnTransporte", "", ShipmentsLimit);
    }
});
// Fin

// Filtros facturas ERP
$('#btnPrFiltr').on('click', function (e) {
    var InvoiceLimit = document.getElementById("InvoiceLimit").value;
    var InvoiceType = document.getElementById("tipoFactura").value;
    var ValidationStatus = document.getElementById("ValidationStatus").value;
    var PaidStatus = document.getElementById("PaidStatus").value;
    var CanceledFlag = document.getElementById("CanceledFlag").value;
    var startDate = document.getElementById("startDate").value;
    var endDate = document.getElementById("endDate").value;
    tblColectionData.clear().draw();
    // Loader();
    if (InvoiceLimit > 20) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Advertencia',
            text: "Tenga en cuanta que al aumentar el rango de carga de facturas la respuesta demorara un poco más.!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Sí, Entiendo',
            cancelButtonText: 'Mmm... mejor no',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Load(InvoiceLimit);
                LoadData(PaidStatus, CanceledFlag, "#TablaFacturasAll", InvoiceType,
                    ValidationStatus, "", startDate, endDate, InvoiceLimit);

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Consulta Cancelada'
                )
            }
        });

    } else if (InvoiceLimit == 20) {

        Load(InvoiceLimit);
        LoadData(PaidStatus, CanceledFlag, "#TablaFacturasAll", InvoiceType, ValidationStatus, "",
            startDate, endDate, InvoiceLimit);
    }
    obtener_data("#TablaFacturasAll tbody", tblColectionData);
});
// Fin

// Acciones botones principales
$("#por-pagar").click(function (e) {
    e.preventDefault();
    Loader();
    LoadData("Impagado", "false", "#TablePorPagar", "", "", "#oculto-por-pagar", "", "", "");
    obtener_data("#TablePorPagar tbody", tblColectionData);
});

$("#pagadas-con-novedad").click(function (e) {
    e.preventDefault();
    Loader();
    LoadData("Pagada parcialmente", "true", "#TablePagadasNovedad", "", "", "#oculto-pagadas-con-novedad",
        "", "", "");
    obtener_data("#TablePagadasNovedad tbody", tblColectionData);

});


$("#Fullfacturas-all").click(function (e) {
    e.preventDefault();
    Loader();
    LoadData("", "false", "#TablaFacturasAll", "", "", "#FacturasGenerales", "", "", "");
    obtener_data("#TablaFacturasAll tbody", tblColectionData);

});

$('#en-transporte').on('click', function (e) {
    e.preventDefault();

    Loader();
    LoadDataShipment("#TableEnTransporte", "#facturas-en-transporte", 20);
    obtener_dataTransporte("#TableEnTransporte tbody", tblColectionData);
})
// Fin

// Cerrar modal
$("#closet-modal").click(function (e) {
    $("#global-loader3").modal('hide'); //ocultamos el modal
});
// Fin


// consulta y carga de visualizar de facturas individuales
let obtener_data = function (tbody, table) {
    $(tbody).on("click", "button.ver", function () {
        // Activar el spiner de cargar al momento de visualizar la factura
        // document.getElementById("global-loader3").style.display = "";
        LoaderView();
        //Fin

        // Cargamos los datos de la factura al modal
        let invoice = table.row($(this).parents("tr")).data();
        plantillaDate = '';
        plantiilabody = '';
        plantillarow1 = '';
        plantillarow2 = '';
        plantillarow3 = '';

        $.ajax({
            type: "POST",
            url: "{{ route('invoice.lines') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                InvoiceNumber: invoice.InvoiceNumber
            },
            success: function (response) {
                let invoice = response.data.invoiceData[0]
                let lines = response.data.invoiceLines
                let fPago = response.data.invoiceFechaPago[0].PaymentDate
                let holds = response.data.holds[0]

                const formatterDolar = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })

                let InvoiceAmount = formatterDolar.format(invoice.InvoiceAmount);

                if (response.success == true) {
                    $('#date').html('')
                    plantillaDate = `
                                <div class="col-md-4 align-self-center">
                                    <img src="{{ asset('assets/images/logos-tractocar/negative-blue-small.png') }}" alt="logo-small" class="logo-sm mr-2" height="56">
                                    {{-- <img src="{{asset('assets/images/logos-tractocar/negative-blue-tiny.png')}}" alt="logo-large" class="logo-lg logo-light" height="16"> --}}
                                    <p class="mt-2 mb-0 text-muted">@lang('locale.Description') : ${invoice.Description}.</p>                                                             </div><!--end col-->
                                </div><!--end col-->
                                <div class="col-md-4 ms-auto">
                                    <ul class="list-inline mb-0 contact-detail float-right">
                                        <li class="list-inline-item">
                                            <div class="pl-3">
                                                <h6 class="mb-0"><b>@lang('locale.Supplier') : </b>${invoice.Supplier} </h6>
                                            </div>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="pl-3">
                                                <h6 class="mb-0"><b>@lang('locale.Invoice Number') : </b>${invoice.InvoiceNumber} </h6>
                                            </div>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="pl-3">
                                                <h6 class="mb-0"><b>@lang('locale.Invoice Date') : </b>${invoice.InvoiceDate} </h6>
                                            </div>
                                        </li>
                                        <li class="list-inline-item">
                                            <div class="pl-3">
                                                <h5><i class="mdi mdi-cash-multiple"></i><b> :</b> ${InvoiceAmount}</h5>
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

                                <tr>
                                    <td >
                                        <p class="mb-0 text-muted">${invoice.InvoiceType}</p>
                                    </td>
                                    <td >
                                        <p class="mb-0 text-muted">${invoice.PaidStatus}</p>
                                    </td>
                                    <td >
                                        <p class="mb-0 text-muted">${invoice.ValidationStatus}</p>
                                    </td>
                                    <td >
                                        <p class="mb-0 text-muted">${invoice.invoiceInstallments[0]['BankAccount']}</p>
                                    </td>
                                    <td >
                                        <p class="mb-0 text-muted">${invoice.AccountingDate}</p>
                                    </td>
                                    <td >
                                        <p class="mb-0 text-muted">${invoice.invoiceInstallments[0]['DueDate']}</p>
                                    </td>
                                    <td >
                                        <p class="mb-0 text-muted">${fPago}</p>
                                    </td>
                                </tr><!--end tr-->
                            `
                    $('#row1').append(plantillarow1)

                    $('#row2').html('')
                    lines.forEach(line => {
                        var LineAmount = formatterDolar.format(line.LineAmount);
                        if (line.LineAmount != 0) {
                            plantillarow2 = `
                                        <tr>
                                            <td >
                                                <h5 class="mt-0 mb-1">${line.LineType}</h5>
                                                <p class="mb-0 text-muted">${line.Description}.</p>
                                            </td>
                                            <td> ${LineAmount}</td>
                                        </tr><!--end tr-->
                                    `
                            $('#row2').append(plantillarow2)
                        }
                    });

                    $('#row3').html('')
                    holds.forEach(hold => {
                        const date = hold.HoldDate.split('T')[0];

                        plantillarow3 = `
                                    <tr>
                                        <td >${hold.HoldName}</td>
                                        <td> ${hold.HoldReason}</td>
                                        <td> ${hold.HeldBy}</td>
                                        <td> ${date}</td>
                                    </tr><!--end tr-->
                                `
                        $('#row3').append(plantillarow3)
                    });

                }
                swal.close();
                $('#exampleModalToggle').modal('show');
            },
            error: function (error) {
                console.error(error);
            }
            //Fin
        });

    });
}
// Fin

// consulta y carga de visualizar de facturas en transporte
//consultar campo estado anticipo de momento esta quemado, ya que la consulta solo esta trallendo los que estan en ANTICIPO_COMPL_NUEVO
let obtener_dataTransporte = function (tbody, table) {
    $(tbody).on("click", "button.verT", function () {

        // Activar el spiner de cargar al momento de visualizar la factura
        LoaderView();
        //Fin

        // Cargamos los datos de la factura al modal
        let invoice = table.row($(this).parents("tr")).data();
        plantillaDate = '';
        plantillarow1 = '';
        $.ajax({
            type: "POST",
            url: "{{ route('falturas.transporte.detalle') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                invoice: invoice.shipmentXid
            },
            success: function (response) {
                let invoice = response.data
                // console.log(invoice);
                if (response.success == true) {
                    $('#date_1').html('')
                    plantillaDate = `
                                <div class="col-md-4 align-self-center">
                                    <img src="{{ asset('assets/images/logos-tractocar/negative-blue-small.png') }}" alt="logo-small" class="logo-sm mr-2" height="56">
                                    {{-- <img src="{{asset('assets/images/logos-tractocar/negative-blue-tiny.png')}}" alt="logo-large" class="logo-lg logo-light" height="16"> --}}
                                </div><!--end col-->
                                </div><!--end col-->
                                <div class="col-md-4 ms-auto">
                                    <ul class="list-inline mb-0 contact-detail float-right" >
                                        <li class="list-inline-item">
                                            <div class="pl-3">
                                                <h6 class="mb-0"><b>Fecha de creación del Manifiesto : ${invoice.MANIFEST_CREATE_DATE}</b> </h6>
                                                <h6><b>Numero del Manifiesto:</b> # ${invoice.MANIFEST_ID}</h6>
                                            </div>
                                        </li>
                                    </ul>
                                </div><!--end col-->
                            `
                    $('#date_1').append(plantillaDate)

                    $('#row1_1').html('')
                    plantillarow1 = `
                                <div class="col-md-4">
                                    <div class="float-left">
                                        <address class="font-13">
                                            <strong class="font-14">Informacion del Propietario:</strong><br>
                                            Nombre : ${invoice.OWNER_NAME}<br>
                                            ID : ${invoice.OWNER_ID}<br>
                                            Correo : ${invoice.OWNER_EMAIL}<br>
                                            Telefono : ${invoice.OWNER_PHONE_NUMBER}<br>
                                        </address>

                                        <address class="font-13">
                                            <strong class="font-14">Informacion del Conductor:</strong><br>
                                            Nombre : ${invoice.DRIVER_FIRSTNAME + invoice.DRIVER_LASTNAME}<br>
                                            ID : ${invoice.DRIVER_ID}<br>
                                            Correo : ${invoice.TRANSPORTER_EMAIL}<br>
                                            Telefono : ${invoice.DRIVER_MOBILE_NUMBER}<br>
                                        </address>

                                        <div class="float-left">
                                            <h6><b>Tipo de Operacion :</b>
                                                ${invoice.MANIFEST_OPERATION_TYPE
                        }
                                            </h6>
                                            <h6><b>Estado del Envío : </b>
                                                ${invoice.SHIPMENT_STATUS
                        }
                                            </h6>
                                            <h6> <b>Estado Anticipo : </b>
                                                MANIFIESTO_CUMPLIDO_NUEVO
                                            </h6>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-md-2">

                                </div><!--end col-->

                                <div class="col-md-6">
                                    <div class="text-left bg-light p-3 mb-3">
                                        <h5 class="bg-info mt-0 p-2 text-white d-sm-inline-block">@lang('locale.Additional Information')</h5>
                                        <h6 class="font-13">Ciudad Origen : ${invoice.ORIGIN_CITY}</h6>
                                        <h6 class="font-13">Provincia : ${invoice.ORIGIN_PROVINCE}</h6>
                                        <h6 class="font-13">Direccion Origen : ${invoice.ORIGIN_ADDRESS}</h6>
                                        <h6 class="font-13">Ruta : ${invoice.ROUTE_NAME}</h6>
                                        <h6 class="font-13">Via : ${invoice.ROUTE_VIA}</h6>
                                        <h6 class="font-13">Ciudad Destino : ${invoice.DESTINATION_CITY}</h6>
                                        <h6 class="font-13">Provincia : ${invoice.DESTINATION_PROVINCE}</h6>
                                        <h6 class="font-13">Direccion Destino : ${invoice.DESTINATION_ADDRESS}</h6>

                                    </div>

                                    <div class="text-left bg-light p-3 mb-3">
                                        <h5 class="bg-success mt-0 p-2 text-white d-sm-inline-block">Información del Vehículo</h5>
                                        <h6 class="font-13">Matrícula : ${invoice.VEHICLE_LICENSE_PLATE}</h6>
                                        <h6 class="font-13">Marca : ${invoice.VEHICLE_MAKE}</h6>
                                        <h6 class="font-13">Color : ${invoice.VEHICLE_COLOR}</h6>
                                        <h6 class="font-13">Modelo : ${invoice.VEHICLE_MODEL}</h6>
                                        <h6 class="font-13"> Numero Trailer : ${invoice.VEHICLE_TRAILER_NUMBER}</h6>
                                    </div>
                                </div><!--end col-->
                            `
                    $('#row1_1').append(plantillarow1)

                }
                swal.close();
                $('#exampleModalTransporte').modal('show');
            },
            error: function (error) {
                console.error(error);
            }
            //Fin
        });

    });
}
// Fin
