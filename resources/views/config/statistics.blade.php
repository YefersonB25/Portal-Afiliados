@extends('layouts.app')

@section('content')

    <body class="ltr app sidebar-mini light-mode">
        <div class="app-content main-content mt-0">
            <div class="side-app">
                <div class="main-container container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" id="filterSegmentationDay"
                                action="{{ route('setting.statistics.filter') }}" method="GET" novalidate>
                                @csrf
                                <div class="row mb-2">
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
                                <button type="submit" class="btn btn-primary" id="btnPr">Filtrar</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div id="containerSegmentationDay"></div>
                        </div>

                        <div class="card-body">
                            <div id="containerGeneral"></div>
                        </div>

                        <div class="card-body">
                            <form class="form-horizontal" id="filter" action="{{ route('setting.statistics.filter') }}"
                                method="GET" novalidate>
                                @csrf
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="numberId" class="form-label">Nombre Proveedor</label>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="customer-code" name="numberId" />
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

                            <div id="container"></div>
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

        let urlChart = "{{ route('setting.statistics.filter') }}"
        ajaxChartGeneral(urlChart);
    </script>
@endsection
@endsection
