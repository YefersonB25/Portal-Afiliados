<div class="modal fade" id="exampleModalToggle" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="modal-content">
                        <div class="card">
                            <div class="card-body invoice-head">
                                <div class="row" id="date">

                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                            <div class="card-body" id="body">
                                <div class="row p-2">
                                    <div class="col-lg-12">
                                        {{-- <h5 class="btn btn-outline-primary" for="btn-check-outlined"> Detalles
                                        </h5> --}}
                                        <h5 class="bg-info col-lg-12 mt-0 p-2 text-center text-white d-sm-inline-block">
                                            Resumen</h5>
                                        <div class="table-responsive project-invoice">
                                            <table class="table table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Tipo de factura</th>
                                                        <th>Estado de pago</th>
                                                        <th>Estado de validación</th>
                                                        <th>Numero de cuenta</th>
                                                        {{-- <th>Categoría de documento</th>
                                                        <th>Secuencia de documento</th> --}}
                                                        <th>Fecha Contable</th>
                                                        <th>Fecha de Vencimiento</th>
                                                        <th>Fecha Pago</th>
                                                    </tr>
                                                    <!--end tr-->
                                                </thead>
                                                <tbody id="row1">


                                                </tbody>
                                            </table>
                                            <!--end table-->
                                        </div>
                                        <!--end /div-->
                                    </div>
                                    <!--end col-->
                                </div>


                                <div class="row p-2">
                                    <div class="col-lg-12">
                                        <h5
                                            class="bg-success col-lg-12 mt-0 p-2 text-center text-white d-sm-inline-block">
                                            Descripción </h5>

                                        <div class="table-responsive project-invoice">
                                            <table class="table table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>@lang('locale.Description')</th>
                                                        <th>@lang('locale.Amount')</th>
                                                    </tr>
                                                    <!--end tr-->
                                                </thead>
                                                <tbody id="row2">


                                                </tbody>
                                            </table>
                                            <!--end table-->
                                        </div>
                                        <!--end /div-->
                                    </div>
                                    <!--end col-->

                                </div>
                                <!--end row-->
                                <div class="row p-2">
                                    <div class="col-lg-12">
                                        <h5
                                            class="bg-danger col-lg-12 mt-0 p-2 text-center text-white d-sm-inline-block">
                                            Bloqueos </h5>

                                        <div class="table-responsive project-invoice">
                                            <table class="table table-bordered mb-0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Nombre Retencion</th>
                                                        <th>Razón Retencion</th>
                                                        <th>Retenida Por</th>
                                                        <th>Fecha Retencion</th>
                                                    </tr>
                                                    <!--end tr-->
                                                </thead>
                                                <tbody id="row3">


                                                </tbody>
                                            </table>
                                            <!--end table-->
                                        </div>
                                        <!--end /div-->
                                    </div>
                                    <!--end col-->

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