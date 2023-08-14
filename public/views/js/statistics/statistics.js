

function ValidarFecha(id, btn) {
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
}




