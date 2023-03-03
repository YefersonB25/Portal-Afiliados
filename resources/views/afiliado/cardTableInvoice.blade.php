<div class="collapse" id="FacturasGenerales" style="display: none">

    <body class="ltr app sidebar-mini">
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- CONTAINER -->
                        <div class="main-container container-fluid">
                            <div class="card" id="facturas-all">
                                <h3 class="text-center" style="text-decoration: underline">
                                    FACTURAS
                                </h3>
                                <div class="card-header border-bottom">
                                    <div class="row g-2">
                                        <h3 class="card-title">Fitros</h3>
                                        <div class="form-horizontal">
                                            <form class="form-horizontal" id="filter"
                                                action="{{ route('falturas.pagadas') }}" method="post" novalidate>
                                                @csrf
                                                <div class="row mb-2">
                                                    <div class="col-md-3">
                                                        <label for="InvoiceLimit" class="form-label">#
                                                            Factoras que desea visualizar</label>
                                                        <select type="text" name="InvoiceLimit" id="InvoiceLimit"
                                                            class="form-control" tabindex="3"
                                                            value="{{ old('InvoiceLimit') }}" autofocus>
                                                            <option selected value="20">20</option>
                                                            <option value="40">40</option>
                                                            <option value="60">60</option>
                                                            <option value="80">80</option>
                                                            <option value="100">100</option>
                                                            <option value="200">200</option>
                                                            <option value="350">350</option>
                                                            <option value="500">500</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="tipoFactura" class="form-label">Tipo
                                                            de
                                                            factura</label>
                                                        <select type="text" name="tipoFactura" id="tipoFactura"
                                                            class="form-select" tabindex="3"
                                                            value="{{ old('tipoFactura') }}" autofocus>
                                                            <option selected value="">Todos
                                                            </option>
                                                            <option value="Pago por adelantado">
                                                                Anticipo</option>
                                                            <option value="Estándar">Estándar
                                                            </option>
                                                            <option value="Nota de crédito">Nota
                                                                Crédito</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="ValidationStatus" class="form-label">Estado
                                                            Validación</label>
                                                        <select type="text" name="ValidationStatus"
                                                            id="ValidationStatus" class="form-select" tabindex="3"
                                                            value="{{ old('ValidationStatus') }}" autofocus>
                                                            <option selected value="">Todos
                                                            </option>
                                                            <option value="Cancelada">Cancelada
                                                            </option>
                                                            <option value="Validada">Validada
                                                            </option>
                                                            <option value="Necesita revalidación">
                                                                Necesita revalidación</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="PaidStatus" class="form-label">Estado Pago</label>
                                                        <select type="text" name="PaidStatus" id="PaidStatus"
                                                            class="form-select" tabindex="3"
                                                            value="{{ old('PaidStatus') }}" autofocus>
                                                            <option selected value="">Todos
                                                            </option>
                                                            <option value="Pagadas">Pagadas</option>
                                                            <option value="Impagado">Impagado
                                                            </option>
                                                            <option value="Pagada parcialmente">
                                                                parsialmente pagada</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md">
                                                        <label for="CanceledFlag" class="form-label">Canceladas</label>
                                                        <select type="text" name="CanceledFlag" id="CanceledFlag"
                                                            class="form-select" tabindex="3"
                                                            value="{{ old('CanceledFlag') }}" autofocus>
                                                            <option selected value="false">No
                                                            </option>
                                                            <option value="true">Si</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="title" class="form-label">Fecha
                                                            Inicio y
                                                            Fecha Fin</label>
                                                        <div class="input-group">
                                                            <input name="startDate" id="startDate" class="form-control"
                                                                placeholder="YYYY-MM-DD" data-mask="yyyy-mm-dd"
                                                                tabindex="3" value="{{ old('startDate') }}"
                                                                onKeyUp="ValidarFecha('startDate','btnPrFiltr');"
                                                                autofocus>
                                                            <input name="endDate" id="endDate" placeholder="YYYY-MM-DD"
                                                                data-mask="yyyy-mm-dd" class="form-control" tabindex="3"
                                                                onKeyUp="ValidarFecha('endDate','btnPrFiltr');"
                                                                value="{{ old('endDate') }}" autofocus>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary"
                                                    id="btnPrFiltr">Filtrar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row row-sm">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="TablaFacturasAll"
                                                            class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
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
</div>

<div class="card" id="oculto-por-pagar" style="display: none">

    <h3 class="text-center" style="text-decoration: underline">FACTURAS
        POR PAGAR </h3>
    <div class="card-body">
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="TablePorPagar"
                                class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" id="oculto-pagadas-con-novedad" style="display: none">
    <h3 class="text-center" style="text-decoration: underline">FACTURAS PARCIALMENTE PAGADAS
    </h3>
    <div class="card-body">
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="TablePagadasNovedad"
                                class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" id="facturas-en-transporte" style="display: none">
    <h3 class="text-center" style="text-decoration: underline">FACTURAS EN TRANSPORTE</h3>
    <div class="card-body">
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="row g-2">
                            <h3 class="card-title">Fitros</h3>
                            <div class="form-horizontal">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <label for="" class="form-label"># Factoras que
                                            desea visualizar</label>
                                        <select type="text" name="ShipmentsLimit" id="ShipmentsLimit"
                                            class="form-control" tabindex="3" value="{{ old('ShipmentsLimit') }}"
                                            autofocus>
                                            <option selected value="20">20</option>
                                            <option value="40">40</option>
                                            <option value="60">60</option>
                                            <option value="80">80</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="350">350</option>
                                            <option value="500">500</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="btnFiltr">Filtrar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="TableEnTransporte"
                                class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>