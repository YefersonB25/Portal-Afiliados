

/* function ValidarFecha(id, btn) {
    // Almacenamos el valor digitado en TxtFecha
    var Fecha = document.getElementById(id).value;
    const button = document.getElementById(btn)
    if (id === 'startDate1' && id === 'endDate1') {

        console.log(id);
    }
    // Si la fecha está completa comenzamos la validación
    if (Fecha.length != 10)
        button.disabled = true
    if (Fecha.length == 10)
        button.disabled = false
    if (Fecha.length == "")
        button.disabled = false
};

window.onload = function() {
    // Obtener el elemento del input
    let startDate = document.getElementById("startDate");
    let endDate = document.getElementById("endDate");
    let startDate1 = document.getElementById("startDate1");
    let endDate1 = document.getElementById("endDate1");
    let customerCode = document.getElementById("customerCode");

    // Limpiar el valor del input
    startDate.value = "";
    endDate.value = "";
    startDate1.value = "";
    endDate1.value = "";
    customerCode.value = "";

}
const select = document.getElementById('yearSelect');
const currentYear = new Date().getFullYear();

for (let year = 2023; year <= currentYear; year++) {
    const option = document.createElement('option');
    option.value = year;
    option.text = year;
    if (year === currentYear) {
        option.selected = true;
    }
    select.appendChild(option);
}

const btnInformacionGeneral = document.getElementById("btnInformacionGeneral");
const btnSeguimientoUsuario = document.getElementById("btnSeguimientoUsuario");
const informacionGeneral = document.getElementById("informacionGeneral");
const seguimientoUsuario = document.getElementById("seguimientoUsuario");

btnInformacionGeneral.addEventListener("click", function () {
    informacionGeneral.style.display = "block";
    seguimientoUsuario.style.display = "none";
});

btnSeguimientoUsuario.addEventListener("click", function () {
    informacionGeneral.style.display = "none";
    seguimientoUsuario.style.display = "block";
});

// cunsulta de usuarios select2
let listAffiliate = function (url) {
    $('#customerCode').select2({
        placeholder: "Buscar un afiliado",
        minimumInputLength: 3,
        ajax: {
            url: url,
            dataType: 'json',
            delay: 300,
            data: function (term, page) {
                return {
                    q:  encodeURIComponent(term)
                };
            },
            results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log('Error en la consulta AJAX: ' + errorThrown);
                // Mostrar un mensaje de error al usuario, por ejemplo, en un div de error
                $('#error-message').text('Error en la consulta. Intente nuevamente más tarde.');
            },
            cache: false
        }
    });
};

// cantidad de usuarios registrado
let ajaxCountLogin = function (url) {
    plantilla = ''
    $.ajax({
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        success: function (response) {

            let datos = response.data
            if (response.success == true) {

                $('#count').html('')
                plantilla = `
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-2 fw-semibold">${datos}</h3>
                                    <p class="text-muted fs-13 mb-0">TOTAL INICIO SESSION</p>
                                </div>
                                <div class="col col-auto top-icn dash">
                                    <div class="counter-icon bg-danger-gradient box-shadow-danger">
                                                                <i class="fe fe-trending-up text-white"></i>
                                                            </div>
                                </div>
                            </div>

                                `
                $('#count').append(plantilla)
            }
            chartMostConsultedActions(response.login_per_day)
        },
        error: function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo fallo con la respuesta!',
            })
            console.error(error);
        }
    })
};

// filtro de cantidad de inicio de session por usuario
let ajaxMostConsultedActions = function (url) {
    plantilla = ''
    $.ajax({
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        success: function (response) {

            let datos = response.data
            if (response.success == true) {
                chartMostConsultedActions(datos)
            }

        },
        error: function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo fallo con la respuesta!',
            })
            console.error(error);
        }
    })
};

// filtro de cantidia de usuarios registrado por fecha
$('#filterCountLoginDay').submit(function (e) {
    e.preventDefault(); //detemos el formluario
    let form = $(this);

    $.ajax({
        type: $(form).attr('method'),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $(form).attr('action'),
        data: $(form).serialize(),
        success: function (response) {

            let datos = response.data

            if (response.success == true) {

                $('#count').html('')
                plantilla = `
                                <div class="row">
                                    <div class="col">
                                        <h3 class="mb-2 fw-semibold">${datos}</h3>
                                        <p class="text-muted fs-13 mb-0">TOTAL INICIO SESSION</p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-danger-gradient box-shadow-danger">
                                            <i class="fe fe-trending-up text-white"></i>
                                        </div>
                                    </div>
                                </div>

                                `
                $('#count').append(plantilla)
            }
            chartMostConsultedActions(response.login_per_day)

        },
        error: function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo fallo con la respuesta!',
            })
            console.error(error);
        }
    })
});

// accion filtro de cantidad de inicio de sesion por usuario y por fecha
$('#filter').submit(function (e) {
    e.preventDefault(); //detemos el formluario

    let form = $(this);
    // console.log(form[0][2]);
    $.ajax({
        type: $(form).attr('method'),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $(form).attr('action'),
        data: $(form).serialize(),
        success: function (response) {

            let login_per_day = response.login_per_day

          if (login_per_day.length != 0) {
            chartFilter(response.login_per_day)
          }

        },
        error: function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Algo fallo con la respuesta!',
            })
            // console.error(error);
        }
    })
});

// filtro de cantidad de inicio de session por usuario y por fecha
let chartFilter = function (login_per_day) {

    anychart.onDocumentReady(function () {
        // create data set on our data
        document.getElementById('container').innerHTML = '';

        const formattedData = login_per_day.map(item => [item.month, item.total]);

        var chartData = {
            // title: 'Seguimiento por usuario',
            rows: formattedData
        };

        // create column chart
        var chart = anychart.column();

        // set chart data
        chart.data(chartData);

        // turn on chart animation
        chart.animation(true);

        chart.yAxis().labels().format('{%Value}{groupsSeparator: }');

        // set titles for Y-axis
        chart.yAxis().title('Revenue');

        chart
            .labels()
            .enabled(true)
            .position('center')
            .anchor('center-bottom')
            .format('{%Value}{groupsSeparator: }');
        chart.hovered().labels(false);


        // interactivity settings and tooltip position
        chart.interactivity().hoverMode('single');

        chart
            .tooltip()
            .positionMode('point')
            .position('center-top')
            .anchor('center-bottom')
            .offsetX(0)
            .offsetY(5)
            .titleFormat('{%X}')
            .format('{%SeriesName} : {%Value}{groupsSeparator: }');

        // set container id for the chart
        chart.container('container');

        // initiate chart drawing
        chart.draw();
    });

};

let chartMostConsultedActions = function (login_per_day) {
    anychart.onDocumentReady(function() {

        document.getElementById('containerActionHome').innerHTML = '';

        const formattedData = login_per_day.map(item => [item.month, item.total]);

        var chartData = {
            // title: 'Numero de inicio de sesion por mes',
            rows: formattedData
          };

          // create column chart
          var chart = anychart.column();

          // set chart data
          chart.data(chartData);

          // turn on chart animation
          chart.animation(true);

          chart.yAxis().labels().format('{%Value}{groupsSeparator: }');

          // set titles for Y-axis
        //   chart.yAxis().title('Revenue');

          chart
            .labels()
            .enabled(true)
            .position('center')
            .anchor('center-bottom')
            .format('{%Value}{groupsSeparator: }');
          chart.hovered().labels(false);

          // interactivity settings and tooltip position
          chart.interactivity().hoverMode('single');

          chart
            .tooltip()
            .positionMode('point')
            .position('center-top')
            .anchor('center-bottom')
            .offsetX(0)
            .offsetY(5)
            .titleFormat('{%X}')
            .format('{%SeriesName} : {%Value}{groupsSeparator: }');

          // set container id for the chart
          chart.container('containerActionHome');

          // initiate chart drawing
          chart.draw();

      });
} */



// Reemplazar el archivo statistics.js con este código mejorado

let listAffiliate = function (url) {
    $('#customerCode').select2({
        placeholder: "Buscar un afiliado",
        minimumInputLength: 3,
        ajax: {
            url: url,
            dataType: 'json',
            delay: 300,
            data: function (term, page) {
                return {
                    q:  encodeURIComponent(term)
                };
            },
            results: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log('Error en la consulta AJAX: ' + errorThrown);
                // Mostrar un mensaje de error al usuario, por ejemplo, en un div de error
                $('#error-message').text('Error en la consulta. Intente nuevamente más tarde.');
            },
            cache: false
        }
    });
};
class StatisticsDashboard {
    constructor() {
        this.initDatePickers();
        this.initCharts();
        this.bindEvents();
        this.loadInitialData();
    }
    
    initDatePickers() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
        
        $('.daterange').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            },
            opens: 'right',
            autoUpdateInput: false
        });
        
        $('.daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });
    }
    
    initCharts() {
        this.loginChart = new ApexCharts(document.querySelector("#loginChart"), this.getLoginChartOptions());
        this.loginChart.render();
        
        this.userActivityChart = new ApexCharts(document.querySelector("#userActivityChart"), this.getActivityChartOptions());
        this.userActivityChart.render();
    }
    
    getLoginChartOptions() {
        return {
            series: [{
                name: 'Inicios de Sesión',
                data: []
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true
                    }
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '55%',
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: [],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Cantidad'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " inicios"
                    }
                }
            },
            colors: ['#467fcf']
        };
    }
    
    getActivityChartOptions() {
        return {
            series: [{
                name: 'Acciones',
                data: []
            }],
            chart: {
                type: 'radar',
                height: 350,
                toolbar: {
                    show: true
                }
            },
            xaxis: {
                categories: []
            },
            yaxis: {
                show: false
            },
            markers: {
                size: 5,
                hover: {
                    size: 7
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " acciones";
                    }
                }
            },
            colors: ['#5eba00']
        };
    }
    
    bindEvents() {
        // Filtrar estadísticas generales
        $('#filterCountLoginDay').submit(e => {
            e.preventDefault();
            this.loadGeneralStatistics();
        });
        
        // Filtrar actividad de usuario
        $('#userTrackingForm').submit(e => {
            e.preventDefault();
            this.loadUserActivity();
        });
        
        // Cambio de pestaña
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', e => {
            if (e.target.id === 'user-tab') {
                this.userActivityChart.updateOptions({
                    series: [{
                        data: []
                    }],
                    xaxis: {
                        categories: []
                    }
                });
            }
        });
    }
    
    loadInitialData() {
        this.loadGeneralStatistics();
    }
    
    loadGeneralStatistics() {
        const formData = $('#filterCountLoginDay').serialize();
        
        $.ajax({
            url: "{{ route('setting.statistics.countLogin') }}",
            type: "GET",
            data: formData,
            beforeSend: () => {
                $('#loginChart').addClass('chart-loading');
            },
            success: response => {
                if (response.success) {
                    this.updateGeneralStatistics(response.data);
                }
            },
            complete: () => {
                $('#loginChart').removeClass('chart-loading');
            },
            error: (xhr, status, error) => {
                console.error(error);
                Swal.fire('Error', 'No se pudieron cargar las estadísticas', 'error');
            }
        });
    }
    
    updateGeneralStatistics(data) {
        // Actualizar tarjetas
        $('#totalLogins').text(data.totalLogins.toLocaleString());
        $('#activeUsers').text(data.activeUsers.toLocaleString());
        $('#invoiceConsultations').text(data.invoiceConsultations.toLocaleString());
        
        // Actualizar gráfico
        this.loginChart.updateOptions({
            series: [{
                name: 'Inicios de Sesión',
                data: data.loginStats.monthlyCounts
            }],
            xaxis: {
                categories: data.loginStats.months
            }
        });
    }
    
    loadUserActivity() {
        const formData = $('#userTrackingForm').serialize();
        
        $.ajax({
            url: "{{ route('setting.statistics.filter') }}",
            type: "GET",
            data: formData,
            beforeSend: () => {
                $('#userActivityChart').addClass('chart-loading');
            $('#userActionsTable tbody').html('<tr><td colspan="4" class="text-center">Cargando...</td></tr>');
            },
            success: response => {
                if (response.success) {
                    this.updateUserActivity(response.data);
                }
            },
            complete: () => {
                $('#userActivityChart').removeClass('chart-loading');
            },
            error: (xhr, status, error) => {
                console.error(error);
                Swal.fire('Error', 'No se pudo cargar la actividad del usuario', 'error');
            }
        });
    }
    
    updateUserActivity(data) {
        // Actualizar gráfico de actividad
        this.userActivityChart.updateOptions({
            series: [{
                data: data.activityStats.data
            }],
            xaxis: {
                categories: data.activityStats.labels
            }
        });
        
        // Actualizar tabla de acciones
        let rows = '';
        if (data.recentActions.length > 0) {
            data.recentActions.forEach(action => {
                rows += `
                    <tr>
                        <td>${action.date}</td>
                        <td>${action.type}</td>
                        <td>${action.detail || 'N/A'}</td>
                        <td>${action.ip}</td>
                    </tr>
                `;
            });
        } else {
            rows = '<tr><td colspan="4" class="text-center">No se encontraron acciones</td></tr>';
        }
        
        $('#userActionsTable tbody').html(rows);
    }
}

// Inicializar dashboard cuando el DOM esté listo
$(document).ready(() => {
    new StatisticsDashboard();
});
