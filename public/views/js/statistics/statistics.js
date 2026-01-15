// ========================================
// FUNCIONES PARA ESTADÍSTICAS
// ========================================

/**
 * Inicializa Select2 para búsqueda de afiliados
 * @param {string} url - URL del endpoint para buscar usuarios
 */
let listAffiliate = function (url) {
    console.log('=== INICIANDO listAffiliate ===');
    console.log('URL:', url);
    console.log('Elemento #customerCode existe:', $('#customerCode').length > 0);
    console.log('jQuery disponible:', typeof $ !== 'undefined');
    console.log('Select2 disponible:', typeof $.fn.select2 !== 'undefined');
    
    // Destruir Select2 si ya existe
    if ($('#customerCode').hasClass('select2-hidden-accessible')) {
        console.log('Destruyendo Select2 existente...');
        $('#customerCode').select2('destroy');
    }
    
    try {
        $('#customerCode').prop('disabled', false).select2({
            placeholder: "Escribe para buscar un afiliado...",
            minimumInputLength: 0,
            allowClear: true,
            width: '100%',
            dropdownParent: $('#user'),
            language: {
                inputTooShort: function() {
                    return 'Escribe para buscar';
                },
                searching: function() {
                    return 'Buscando...';
                },
                noResults: function() {
                    return 'No se encontraron resultados';
                },
                loadingMore: function() {
                    return 'Cargando más resultados...';
                }
            },
            ajax: {
                url: url,
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    console.log('=== DATOS ENVIADOS ===');
                    console.log('Término de búsqueda:', params.term);
                    return {
                        q: (params.term || '').trim()
                    };
                },
                processResults: function (data) {
                    console.log('=== DATOS RECIBIDOS DEL SERVIDOR ===');
                    console.log('Data:', data);
                    console.log('Tipo:', typeof data);
                    console.log('Es array:', Array.isArray(data));
                    
                    if (!data || !Array.isArray(data)) {
                        console.error('Los datos no son un array válido');
                        return { results: [] };
                    }
                    
                    const results = data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name + ' - ' + item.number_id
                        };
                    });
                    
                    console.log('=== RESULTADOS PROCESADOS ===');
                    console.log('Cantidad de resultados:', results.length);
                    console.log('Resultados:', results);
                    
                    return {
                        results: results
                    };
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.error('=== ERROR EN AJAX ===');
                    console.error('Status:', textStatus);
                    console.error('Error:', errorThrown);
                    console.error('Response:', xhr.responseText);
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al buscar afiliados: ' + errorThrown,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });
                },
                cache: false
            }
        });
        
        console.log('=== SELECT2 INICIALIZADO CORRECTAMENTE ===');
        
        // Agregar evento para debug
        $('#customerCode').on('select2:open', function() {
            console.log('Select2 abierto');
        });
        
        $('#customerCode').on('select2:close', function() {
            console.log('Select2 cerrado');
        });
        
        $('#customerCode').on('select2:select', function(e) {
            console.log('Usuario seleccionado:', e.params.data);
        });
        
    } catch (error) {
        console.error('=== ERROR AL INICIALIZAR SELECT2 ===');
        console.error(error);
    }
};

/**
 * Carga estadísticas de login (usado en página de estadísticas)
 * @param {string} url - URL del endpoint de estadísticas
 */
let ajaxCountLogin = function (url) {
    $.ajax({
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        success: function (response) {
            if (response.success == true && response.data) {
                let datos = response.data;
                
                // Actualizar tarjetas de resumen
                $('#totalLogins').text(datos.totalLogins || 0);
                $('#activeUsers').text(datos.activeUsers || 0);
                $('#invoiceConsultations').text(datos.invoiceConsultations || 0);
                
                // Preparar datos para la gráfica
                if (datos.loginStats) {
                    updateLoginChart(datos.loginStats);
                }
            }
        },
        error: function (error) {
            console.error('Error al cargar estadísticas:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudieron cargar las estadísticas',
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false
            });
        }
    });
};
