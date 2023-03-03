let LoadData = function (TableName) {
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
            defaultContent: "<button type='button' class='ver btn btn-success' width='25px'><i class='fa fa-eye' aria-hidden='true'></i></button>"
        },
        // {title: "ID Factura", data: "InvoiceId" },
        {
            title: "Numero Factura",
            data: "InvoiceNumber"
        },

        {
            title: "Valor Factura",
            data: function (d) {

                const formatterDolar = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })

                return formatterDolar.format(d.InvoiceAmount);
            }
        },

        {
            title: "Saldo",
            data: function (d) {

                const formatterDolar = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })

                return formatterDolar.format(d.invoiceInstallments[0]["UnpaidAmount"]);
            }
        },

        {
            title: "Monto Pagado",
            data: function (d) {
                const formatterDolar = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })

                return formatterDolar.format(d.AmountPaid);

            }
        },

        {
            title: "Estado Pago",
            data: function (d) {

                // create a new `Date` object
                var today = new Date();

                // `getDate()` returns the day of the month (from 1 to 31)
                var day = today.getDate();

                // `getMonth()` returns the month (from 0 to 11)
                var month = today.getMonth() + 1;

                // `getFullYear()` returns the full year
                var year = today.getFullYear();

                var date1 = new Date(d.invoiceInstallments[0]["DueDate"]);
                var date2 = new Date(`${year}-${month}-${day}`);
                var dateDefined = date1 - date2;
                var dias = dateDefined / (1000 * 60 * 60 * 24);
                if (dias <= 0 && d.PaidStatus != 'Pagadas') {
                    return 'dentro de la programacion de pago';
                }
                if (d.PaidStatus == 'Pagadas') {
                    return 'Pagada';
                }
                var Ndias = Math.trunc(dias)
                return ('El pago se le generara dentro de ' + Ndias + ' Dias');
            }
        },

        {
            title: "Fecha Factura",
            data: "InvoiceDate"
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
            // { responsivePriority: 1, targets: 6 },
        ],

    });
}
