<div class="modal fade" id="exampleModalTransporte" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="modal-content">
                        <div class="card">
                            <div class="card-body invoice-head">
                                <div class="row gy-2 align-items-center" id="date_1">

                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                            <div class="card-body" id="body">
                                <div class="row p-2">
                                    <div class="col-lg-12">
                                        <h5 class="bg-primary col-lg-12 mt-0 p-2 text-center text-white d-sm-inline-block">
                                            Propietario</h5>
                                        <div class="table-responsive project-invoice">
                                            <table class="table table-bordered table-sm align-middle mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Documento</th>
                                                        <th>Nombre</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="row1_1"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-lg-12">
                                        <h5 class="bg-info col-lg-12 mt-0 p-2 text-center text-white d-sm-inline-block">
                                            Conductor</h5>
                                        <div class="table-responsive project-invoice">
                                            <table class="table table-bordered table-sm align-middle mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Documento</th>
                                                        <th>Nombre</th>
                                                        <th>Teléfono</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="row2_2"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-lg-12">
                                        <h5 class="bg-warning col-lg-12 mt-0 p-2 text-center text-white d-sm-inline-block">
                                            Resumen</h5>
                                        <div class="table-responsive project-invoice">
                                            <table class="table table-bordered table-sm align-middle mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Tipo de Operación</th>
                                                        <th>Estado Envío</th>
                                                        <th>Estado Anticipo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="row3_3"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-lg-12">
                                        <h5 class="bg-secondary col-lg-12 mt-0 p-2 text-center text-white d-sm-inline-block">
                                            Ruta</h5>
                                        <div class="table-responsive project-invoice">
                                            <table class="table table-bordered table-sm align-middle mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Ciudad Origen</th>
                                                        <th>Provincia Origen</th>
                                                        <th>Dirección Origen</th>
                                                        <th>Ruta</th>
                                                        <th>Vía</th>
                                                        <th>Ciudad Destino</th>
                                                        <th>Provincia Destino</th>
                                                        <th>Dirección Destino</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="row4_4"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-lg-12">
                                        <h5 class="bg-success col-lg-12 mt-0 p-2 text-center text-white d-sm-inline-block">
                                            Información del Vehículo</h5>
                                        <div class="table-responsive project-invoice">
                                            <table class="table table-bordered table-sm align-middle mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Matrícula</th>
                                                        <th>Marca</th>
                                                        <th>Color</th>
                                                        <th>Modelo</th>
                                                        <th>Número Trailer</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="row5_5"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->


                                {{-- <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <h5 class="mt-4"><i
                                                class="fas fa-divide mr-2 text-info font-16"></i>@lang('locale.Installments')
                                            :</h5>
                                    </div>
                                    <!--end col-->
                                </div> --}}
                                <!--end row-->
                                <div class="row d-flex justify-content-center">
                                    <div class="col-lg-12 col-xl-4 ml-auto align-self-center">
                                        <div class="text-center"><small class="font-12">Tractocar
                                                Logistics SAS.</small>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closet-modal" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cerrar</button>
                        </div>

                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
    </div>
</div>