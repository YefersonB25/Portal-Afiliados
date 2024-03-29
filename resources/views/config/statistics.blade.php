@extends('layouts.app')

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
@endsection
