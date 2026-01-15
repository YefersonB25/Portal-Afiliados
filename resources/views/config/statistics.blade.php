{{-- @extends('layouts.app')

@section('content')

    <body class="ltr app sidebar-mini light-mode">
        <div class="app-content main-content mt-0">
            <div class="side-app">
                <div class="main-container container-fluid">
                    <div class="page-header">
                        <div>
                            <h1 class="page-title">Estadisticas</h1>
                        </div>
                        <div class="ms-auto pageheader-btn">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Estadisticas</li>
                            </ol>
                        </div>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-secondary" id="btnInformacionGeneral">Información General</button>
                        <button type="button" class="btn btn-secondary" id="btnSeguimientoUsuario">Seguimiento por Usuario</button>
                    </div>
                    <div class="card">
                        <div class="card-body" id="informacionGeneral">
                            <!-- Contenido de la sección "Información General" -->
                            <div class="card-body">
                                <form class="form-horizontal" id="filterCountLoginDay"
                                    action="{{ route('setting.statistics.countLogin') }}" method="GET" novalidate>
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for="title" class="form-label">Fecha Inicio y
                                                Fecha Fin</label>
                                            <div class="input-group">
                                                <input name="startDate" id="startDate1" class="form-control"
                                                    placeholder="YYYY-MM-DD" data-mask="yyyy-mm-dd" tabindex="3"
                                                    value="{{ old('startDate') }}"
                                                    onKeyUp="ValidarFecha('startDate1','btnPr');" autofocus>
                                                <input name="endDate" id="endDate1" placeholder="YYYY-MM-DD"
                                                    data-mask="yyyy-mm-dd" class="form-control" tabindex="3"
                                                    onKeyUp="ValidarFecha('endDate1','btnPr');" value="{{ old('endDate') }}"
                                                    autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="numberId" class="form-label">Año</label>
                                                <select class="form-control" name="year" id="yearSelect"></select>
                                            </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="btnPr">Filtrar</button>
                                </form>
                            </div>

                            <div class="card-body" id="count">
                            </div>

                            <div class="card-body">
                                <h4 class="heading" style="text-align: center;">Numero de inicio de sesion por mes</h4>
                                <div id="containerActionHome"></div>
                            </div>
                        </div>

                        <div class="card-body" id="seguimientoUsuario" style="display: none;">
                            <!-- Contenido de la sección "Seguimiento por Usuario" -->
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form name="filtroAfiliado" class="form-horizontal" id="filter" action="{{ route('setting.statistics.filter') }}"
                                    method="GET" novalidate>
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for="numberId" class="form-label">Nombre Afiliado</label>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" id="customerCode" name="numberId" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="title" class="form-label">Fecha Inicio y
                                                Fecha Fin</label>
                                            <div class="input-group">
                                                <input name="startDate" id="startDate" class="form-control"
                                                    placeholder="YYYY-MM-DD" data-mask="yyyy-mm-dd" tabindex="3"
                                                    value="{{ old('startDate') }}"
                                                    onKeyUp="ValidarFecha('startDate','btnPrFiltr');" autofocus>
                                                <input name="endDate" id="endDate" placeholder="YYYY-MM-DD"
                                                    data-mask="yyyy-mm-dd" class="form-control" tabindex="3"
                                                    onKeyUp="ValidarFecha('endDate','btnPrFiltr');" value="{{ old('endDate') }}"
                                                    autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="btnPrFiltr">Filtrar</button>
                                </form>
                            </div>

                            <div class="card-body">
                                <h4 class="heading" style="text-align: center;">Seguimiento por usuario</h4>
                                <div id="container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>
@section('scripts')
    <script src={{ asset('anychart-package-8.11.0/js/anychart-bundle.min.js') }}></script>
    <script src={{ asset('anychart-package-8.11.0/js/anychart-base.min.js') }}></script>
    <script src={{ asset('anychart-package-8.11.0/js/anychart-exports.min.js') }}></script>
    <script src={{ asset('anychart-package-8.11.0/js/anychart-ui.min.js') }}></script>
    <script src={{ asset('views/js/statistics/statistics.js') }}></script>

    <script>

        let url = "{{ route('setting.affiliate') }}"
        listAffiliate(url);

        let urlCountLogin = "{{ route('setting.statistics.countLogin') }}"
        ajaxCountLogin(urlCountLogin);

        // let urlConsultedActions = "{{ route('setting.statistics.actionHome') }}"
        // ajaxMostConsultedActions(urlConsultedActions);
    </script>
@endsection
@endsection --}}


@extends('layouts.app')

@section('content')
    <body class="ltr app sidebar-mini light-mode">
        <div class="app-content main-content mt-0">
            <div class="side-app">
                <div class="main-container container-fluid">
                    <div class="page-header">
                        <div>
                            <h1 class="page-title">Estadísticas</h1>
                            <p class="text-muted">Visualización de datos de uso del sistema</p>
                        </div>
                        <div class="ms-auto pageheader-btn">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Estadísticas</li>
                            </ol>
                        </div>
                    </div>
                    
                    <!-- Pestañas de navegación -->
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="statsTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab">Información General</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="user-tab" data-bs-toggle="tab" href="#user" role="tab">Seguimiento por Usuario</a>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="card-body">
                            <div class="tab-content" id="statsTabsContent">
                                <!-- Pestaña Información General -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel">
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <form class="form-horizontal" id="filterCountLoginDay" method="GET" novalidate>
                                                @csrf
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Fecha Inicio</label>
                                                        <input name="startDate" id="startDate1" class="form-control datepicker" 
                                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Fecha Fin</label>
                                                        <input name="endDate" id="endDate1" class="form-control datepicker" 
                                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">Año</label>
                                                        <select class="form-select" name="year" id="yearSelect"></select>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fe fe-filter"></i> Filtrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Tarjetas resumen -->
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="card card-body bg-primary text-white">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h3 class="mb-1 fw-semibold" id="totalLogins">0</h3>
                                                        <p class="mb-0">Total Inicios de Sesión</p>
                                                    </div>
                                                    <i class="fe fe-users fs-1 opacity-50"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card card-body bg-info text-white">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h3 class="mb-1 fw-semibold" id="activeUsers">0</h3>
                                                        <p class="mb-0">Usuarios Activos</p>
                                                    </div>
                                                    <i class="fe fe-activity fs-1 opacity-50"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card card-body bg-success text-white">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h3 class="mb-1 fw-semibold" id="invoiceConsultations">0</h3>
                                                        <p class="mb-0">Consultas de Facturas</p>
                                                    </div>
                                                    <i class="fe fe-file-text fs-1 opacity-50"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Gráficos -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Inicios de Sesión por Mes</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div id="loginChart" style="height: 400px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Pestaña Seguimiento por Usuario -->
                                <div class="tab-pane fade" id="user" role="tabpanel">
                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                            <form class="form-horizontal" id="userTrackingForm" method="GET" novalidate>
                                                @csrf
                                                <div class="row g-3 align-items-end">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Usuario</label>
                                                        {{-- <input type="hidden" class="form-control" id="customerCode" name="numberId"> --}}
                                                                    <select id="customerCode" name="numberId" class="form-control" style="width: 100%;"></select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Rango de Fechas</label>
                                                        <input type="text" class="form-control daterange" name="dateRange" 
                                                            placeholder="Seleccione rango">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="fe fe-filter"></i> Filtrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Actividad del Usuario</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div id="userActivityChart" style="height: 400px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4 class="card-title">Últimas Acciones</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover" id="userActionsTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Fecha</th>
                                                                    <th>Acción</th>
                                                                    <th>Detalle</th>
                                                                    <th>IP</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- Datos se cargarán via AJAX -->
                                                            </tbody>
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
@endsection

@section('scripts')
    <!-- Librerías para gráficos -->
    {{-- <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script> --}}

    <script src={{ asset('anychart-package-8.11.0/js/anychart-bundle.min.js') }}></script>
    <script src={{ asset('anychart-package-8.11.0/js/anychart-base.min.js') }}></script>
    <script src={{ asset('anychart-package-8.11.0/js/anychart-exports.min.js') }}></script>
    <script src={{ asset('anychart-package-8.11.0/js/anychart-ui.min.js') }}></script>
    <script src={{ asset('views/js/statistics/statistics.js') }}></script>
    <script>
        $(document).ready(function() {
            // Inicializar controles
            /* $('.select2').select2();
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });*/

            /*  $('.daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                }
            });  */

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
            
            // Cargar datos iniciales
            loadGeneralStats();
            loadUserList();
            
            // Manejar cambio de pestañas
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                if (e.target.id === 'user-tab') {
                    initUserActivityChart();
                }
            });
            
            // Manejar envío de formularios
            $('#filterCountLoginDay').submit(function(e) {
                e.preventDefault();
                loadGeneralStats();
            });
            
            $('#userTrackingForm').submit(function(e) {
                e.preventDefault();
                loadUserActivity();
            });
            listAffiliate("{{ route('setting.affiliate') }}");
        });

        

    function loadGeneralStats() {
        $.ajax({
            url: "{{ route('setting.statistics.countLogin') }}",
            type: "GET",
            data: $('#filterCountLoginDay').serialize(),
            success: function(response) {
                
                if (response.success) {
                    // Actualizar tarjetas
                    $('#totalLogins').text(response.data.totalLogins);
                    $('#activeUsers').text(response.data.activeUsers);
                    $('#invoiceConsultations').text(response.data.invoiceConsultations);
                    
                    // Actualizar gráfico
                    updateLoginChart(response.data.loginStats);
                }
            }
        });
    }

    function loadUserList() {
        $.ajax({
            url: "{{ route('setting.affiliate') }}",
            type: "GET",
            success: function(response) {
                var options = '<option value="">Seleccione un usuario</option>';
                $.each(response, function(index, user) {
                    options += '<option value="'+user.id+'">'+user.name+'</option>';
                });
                $('#userSelect').html(options);
            }
        });
    }

    function loadUserActivity() {
        
        $.ajax({
            url: "{{ route('setting.statistics.filter') }}",
            type: "GET",
            data: $('#userTrackingForm').serialize(),
            success: function(response) {
                if (response.success) {
                    updateUserActivityChart(response.data.activityStats);
                    updateUserActionsTable(response.data.recentActions);
                }
            }
        });
    }

    function updateLoginChart(data) {
        // Implementar gráfico con ApexCharts
        var options = {
            series: [{
                name: 'Inicios de Sesión',
                data: data.monthlyCounts
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: data.months,
            },
            colors: ['#467fcf']
        };
        
        var chart = new ApexCharts(document.querySelector("#loginChart"), options);
        chart.render();
    }

    function initUserActivityChart() {
        // Similar a updateLoginChart pero para actividad de usuario
    }

    function updateUserActivityChart(data) {
        // Actualizar gráfico de actividad de usuario
    }

    function updateUserActionsTable(data) {
        // Actualizar tabla de acciones recientes
        var rows = '';
        $.each(data, function(index, action) {
            rows += '<tr>'+
                '<td>'+action.date+'</td>'+
                '<td>'+action.type+'</td>'+
                '<td>'+action.detail+'</td>'+
                '<td>'+action.ip+'</td>'+
            '</tr>';
        });
        $('#userActionsTable tbody').html(rows);
    }
    </script>
@endsection
