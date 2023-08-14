
"use strict";

$(function (e) {

	// File-Export Data Table
	var table = $('#file-datatable').DataTable({
		buttons: [
            {
                extend: 'copy',
                text: 'Copiar'
            },
            {
                extend: 'excel',
                text: 'Excel'
            },
            {
                extend: 'pdf',
                text: 'Pdf'
            },
            {
                extend: 'colvis',
                text: 'Columnas visibles'
            }
        ],
        pageLength: 10,
        bLengthChange: false,
		responsive: true,
		language: {
			searchPlaceholder: 'Buscar...',
			sSearch: '',
                decimal:        "",
                emptyTable:     "No hay datos disponibles en la tabla",
                info:           "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                infoEmpty:      "Mostrando 0 a 0 de 0 entradas",
                infoFiltered:   "(filtered from _MAX_ total entries)",
                infoPostFix:    "",
                thousands:      ",",
                lengthMenu:     "Show _MENU_ entries",
                loadingRecords: "Cargando...",
                processing:     "",
                zeroRecords:    "No se encontraron registros coincidentes",
                paginate: {
                    first:      "Primero",
                    last:       "Último",
                    next:       "Siguiente",
                    previous:   "Anterior"
                },
                aria: {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
		}
	});
	table.buttons().container()
		.appendTo('#file-datatable_wrapper .col-md-6:eq(0)');

});
