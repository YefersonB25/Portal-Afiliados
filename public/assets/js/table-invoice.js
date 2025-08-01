let LoadData = function(PaidStatus, FlagStatus, TableName, InvoiceType,ValidationStatus, Card, startDate, endDate, InvoiceLimit,  SupplierNumber) {
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

            {title: "Estado Pago",
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
                    var dias = dateDefined/(1000*60*60*24);
                    if ( dias <= 0 && d.PaidStatus != 'Pagadas') {
                        return 'Pendiente de pago';
                    }
                    if(d.PaidStatus == 'Pagadas'){
                        return 'Pagada';
                    }
                    var Ndias = Math.trunc(dias)
                    return ('El pago se le generara dentro de ' + Ndias + ' Dias');
                }
            },

            {title: "Fecha Factura",  data: "InvoiceDate" },

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
    // e.preventDefault();//detemos el formluario
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
        confirmButtonText: 'Sí, Entiendo',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                Load(InvoiceLimit);

                $.ajax({
                    type: 'POST',
                    url: "falturas/pagadas",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        SupplierNumber: SupplierNumber,
                        FlagStatus: FlagStatus,
                        PaidStatus: PaidStatus,
                        InvoiceType: InvoiceType,
                        InvoiceLimit: InvoiceLimit,
                        core: "=",
                        ValidationStatus: ValidationStatus,
                        startDate: startDate,
                        endDate: endDate,


                    },
                    success: function(response) {
                        let datos =  response.data;
                        if (response.success == true) {

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
                            text: 'Algo fallo con la respuesta y no fue posible completar la operación!',
                        })
                        console.error(error);
                    }
                })

            }else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Consulta Cancelada'
                )
            }
        })
    } else if(InvoiceLimit == 20) {
        $.ajax({
            type: 'POST',
            url: "falturas/pagadas",
            data: {
                "_token": "{{ csrf_token() }}",
                SupplierNumber: SupplierNumber,
                FlagStatus: FlagStatus,
                PaidStatus: PaidStatus,
                InvoiceType: InvoiceType,
                InvoiceLimit: 20,
                core: "=",
                ValidationStatus: ValidationStatus,
                startDate: startDate,
                endDate: endDate


            },
            success: function(response) {
                let datos =  response.data;
                if (response.success == true) {

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
                    text: 'Algo fallo con la respuesta y no fue posible completar la operación!',
                })
                console.error(error);
            }
        })
    }
    if (InvoiceLimit == '') {
        $.ajax({
            type: 'POST',
            url: "falturas/pagadas",
            data: {
                "_token": "{{ csrf_token() }}",
                SupplierNumber: SupplierNumber,
                FlagStatus: FlagStatus,
                PaidStatus: PaidStatus,
                InvoiceType: InvoiceType,
                InvoiceLimit: 20,
                core: "=",
                ValidationStatus: ValidationStatus,
                startDate: startDate,
                endDate: endDate


            },
            success: function(response) {
                let datos =  response.data;
                if (response.success == true) {

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
                    text: 'Algo fallo con la respuesta y no fue posible completar la operación!',
                })
                console.error(error);
            }
        })
    }

}

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
