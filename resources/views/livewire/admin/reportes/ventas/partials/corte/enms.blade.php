@if($corte->enms->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-file-invoice me-2"></i>Registro de ENMs</h5>
        </div>
        <div class="card-body">

           <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="enm-pagado-tab"
                                                        data-bs-toggle="tab" data-bs-target="#enmpagado"
                                                        type="button" role="tab" aria-controls="enmpagado"
                                                        aria-selected="true">
                                                        <i class="fas fa-check-circle me-2 text-success"></i>
                                                        Pagados ({{ $corte->enms->where('edo', true)->count() }})
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="enm-nopagado-tab" data-bs-toggle="tab"
                                                        data-bs-target="#enmnopagado" type="button" role="tab"
                                                        aria-controls="enmnopagado" aria-selected="false">
                                                        <i class="fas fa-times-circle me-2 text-danger"></i>
                                                       No Pagados ({{ $corte->ENMNoPagados()->count() }})
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="enm-acuerdo-tab" data-bs-toggle="tab"
                                                        data-bs-target="#enmacuerdo" type="button" role="tab"
                                                        aria-controls="enmacuerdo" aria-selected="false">
                                                        <i class="fas fa-handshake me-2 text-warning"></i>
                                                      Por Acuerdo ({{ $corte->ENMNoPagadosConvenio()->count() }})
                                                    </button>
                                                </li>


                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <!-- Tab Actividades -->
                                                <div class="tab-pane fade show active" id="enmpagado"
                                                    role="tabpanel" aria-labelledby="enmpagado-tab">

                                                    @include('livewire.admin.reportes.ventas.partials.enm.pagados')

                                                </div>

                                                <!-- Tab Yates -->
                                                <div class="tab-pane fade" id="enmnopagado" role="tabpanel"
                                                    aria-labelledby="enmnopagado-tab">
                                                    @include('livewire.admin.reportes.ventas.partials.enm.no-pagados')

                                                </div>

                                                <!-- Tab Traslados -->
                                                <div class="tab-pane fade" id="enmacuerdo" role="tabpanel"
                                                    aria-labelledby="enmacuerdo-tab">
                                                    @include('livewire.admin.reportes.ventas.partials.enm.no-pagados-convenio')
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


        </div>
    </div>
@endif
