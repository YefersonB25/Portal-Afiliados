@extends('layouts.app')

@section('content')

<body class="ltr app sidebar-mini">
    <div class="page">
        <div class="page-main">
            <div class="side-app">
                <div class="main-container container-fluid">
                    <div class="page-header">
                        <div>
                            <h1 class="page-title">Consultar Facturas</h1>
                        </div>
                    </div>
                    <div id="global-loader2">
                        <img src={{ asset('assets/images/loader.svg') }} class="loader-img" alt="Loader">
                    </div>

                    {{-- Card de valor/cantidad de facturas --}}
                    @include('afiliado.cardValueAndQuantityOfInvoices')
                    {{-- Fin --}}

                    {{-- Botones facturas --}}
                    @include('afiliado.buttonsInvoices')
                    {{-- Fin --}}


                    {{-- Card de tablas de facturas --}}
                    @include('afiliado.cardTableInvoice')
                    {{-- Fin --}}

                    {{-- Modal de visualizacionde facturas --}}
                    @include('afiliado.modalVisualizationInvoices')
                    {{-- Fin --}}

                    {{-- Modal de visualizacionde facturas en trasnporte --}}
                    @include('afiliado.modalVisualizationOfTransportInvoices')
                    {{-- Fin --}}

                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('scripts')

@endsection