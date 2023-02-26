function ValidarFecha(id, btn) {
    // Almacenamos el valor digitado en TxtFecha
    var Fecha = document.getElementById(id).value;
    const button = document.getElementById(btn)

    // Si la fecha está completa comenzamos la validación
    if (Fecha.length != 10)
        button.disabled = true
    if (Fecha.length == 10)
        button.disabled = false
    if (Fecha.length == "")
        button.disabled = false
};

let listAffiliate = function (url) {
    $('#customer-code').select2({
        placeholder: "Buscar un afiliado",
        minimumInputLength: 3,
        ajax: {
            url: url,
            dataType: 'json',
            delay: 300,
            data: function (term, page) {
                return {
                    q: term
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
            cache: false
        }
    });
};

let ajaxChartGeneral = function (url) {
    $.ajax({
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        success: function (response) {

            let datos = response.data
            chartGeneral(datos)

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

$('#filterSegmentationDay').submit(function (e) {
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
            chartSegmentationDay(datos)

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

$('#filter').submit(function (e) {
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
            chartFilter(datos)

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

let chartFilter = function (data) {

    // create an object with csv settings
    csvSettings = {
        ignoreFirstRow: true,
        columnsSeparator: ";",
        rowsSeparator: "*"
    };

    // create a data set
    var dataSet = anychart.data.set(data, csvSettings);

    // map the data
    var mapping = dataSet.mapAs({
        x: 0,
        value: 1
    });

    // create a chart
    var chart = anychart.column();

    // create a series and set the data
    var series = chart.column(mapping);

    // set the chart title
    chart.title("Seguimiento por usuario");

    // set the container id
    chart.container("container");

    // initiate drawing the chart
    chart.draw();

};

let chartGeneral = function (data) {

    anychart.onDocumentReady(function () {

        // set chart type
        var chart = anychart.area();

        chart.title("Seguimiento General");

        // set data
        var area = chart.splineArea(data);

        // set container and draw chart
        chart.container("containerGeneral").draw();
    });
}

let chartSegmentationDay = function (data) {

    anychart.onDocumentReady(function () {

        // create an object with csv settings
        csvSettings = {
            ignoreFirstRow: true,
            columnsSeparator: ";",
            rowsSeparator: "*"
        };

        // create a data set
        var dataSet = anychart.data.set(data, csvSettings);

        // map the data
        var mapping = dataSet.mapAs({
            x: 0,
            value: 1
        });

        // create a chart
        var chart = anychart.column();

        // create a series and set the data
        var series = chart.column(mapping);

        // set the chart title
        chart.title("Seguimiento por usuario");

        // set the container id
        chart.container("containerSegmentationDay");

        // initiate drawing the chart
        chart.draw();

    });

}




