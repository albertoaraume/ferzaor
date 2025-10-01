<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Editar Reserva - {{ Str::upper($reserva->folio) }}</h4>
                <h6>Agencia: {{ $reserva->nombreCliente }}</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a href="{{ route('admin.reservas.show', $reserva->guid) }}" class="btn btn-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left"></i>
                    Volver a Detalle
                </a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header">
                    <i class="ti ti-chevron-up"></i>
                </a>
            </li>
        </ul>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mb-4">
        <!-- Información General de la Reserva -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Servicios de la Reserva - Modo Edición
                    </h6>
                    <div class="d-flex gap-3">
                        <div class="d-flex align-items-center">
                            <span class="me-2 text-muted">Estado:</span>
                            {!! $reserva->Badge !!}
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-2 text-muted">Total:</span>
                            <span class="badge bg-primary">${{ number_format($reserva->ImporteTotal, 2) }} {{ $reserva->c_moneda }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Instrucciones:</strong> Desde esta vista puedes editar los importes, fechas, horas y número de pasajeros de cada servicio,
                        así como cancelar servicios individuales. Los cambios se aplicarán inmediatamente.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas para diferentes servicios -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        @if($reserva->actividades->flatMap->unidades->where('status', '!=', 0)->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="actividades-edit-tab" data-bs-toggle="tab"
                                data-bs-target="#actividades-edit" type="button" role="tab"
                                aria-controls="actividades-edit" aria-selected="true">
                                <i class="fas fa-running me-2"></i>
                                Actividades ({{ $reserva->actividades->flatMap->unidades->where('status', '!=', 0)->count() }})
                            </button>
                        </li>
                        @endif

                        @if($reserva->yates->where('status', '!=', 0)->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $reserva->actividades->flatMap->unidades->where('status', '!=', 0)->count() == 0 ? 'active' : '' }}"
                                id="yates-edit-tab" data-bs-toggle="tab"
                                data-bs-target="#yates-edit" type="button" role="tab" aria-controls="yates-edit"
                                aria-selected="false">
                                <i class="fas fa-ship me-2"></i>
                                Yates ({{ $reserva->yates->where('status', '!=', 0)->count() }})
                            </button>
                        </li>
                        @endif

                        @if($reserva->traslados->where('status', '!=', 0)->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="traslados-edit-tab" data-bs-toggle="tab"
                                data-bs-target="#traslados-edit" type="button" role="tab"
                                aria-controls="traslados-edit" aria-selected="false">
                                <i class="fas fa-car me-2"></i>
                                Traslados ({{ $reserva->traslados->where('status', '!=', 0)->count() }})
                            </button>
                        </li>
                        @endif

                        @if($reserva->adicionales->where('status', '!=', 0)->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="servicios-edit-tab" data-bs-toggle="tab"
                                data-bs-target="#servicios-edit" type="button" role="tab"
                                aria-controls="servicios-edit" aria-selected="false">
                                <i class="fas fa-concierge-bell me-2"></i>
                                Servicios ({{ $reserva->adicionales->where('status', '!=', 0)->count() }})
                            </button>
                        </li>
                        @endif

                        @if($reserva->combos->where('status', '!=', 0)->count() > 0)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="combos-edit-tab" data-bs-toggle="tab"
                                data-bs-target="#combos-edit" type="button" role="tab"
                                aria-controls="combos-edit" aria-selected="false">
                                <i class="fas fa-box me-2"></i>
                                Combos ({{ $reserva->combos->where('status', '!=', 0)->count() }})
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Tab Actividades -->
                        @if($reserva->actividades->flatMap->unidades->where('status', '!=', 0)->count() > 0)
                        <div class="tab-pane fade show active" id="actividades-edit" role="tabpanel"
                            aria-labelledby="actividades-edit-tab">
                            @include('livewire.admin.ventas.reservas.partials.actividades-edit')
                        </div>
                        @endif

                        <!-- Tab Yates -->
                        @if($reserva->yates->where('status', '!=', 0)->count() > 0)
                        <div class="tab-pane fade {{ $reserva->actividades->flatMap->unidades->where('status', '!=', 0)->count() == 0 ? 'show active' : '' }}"
                            id="yates-edit" role="tabpanel" aria-labelledby="yates-edit-tab">
                            @include('livewire.admin.ventas.reservas.partials.yates-edit')
                        </div>
                        @endif

                        <!-- Tab Traslados -->
                        @if($reserva->traslados->where('status', '!=', 0)->count() > 0)
                        <div class="tab-pane fade" id="traslados-edit" role="tabpanel"
                            aria-labelledby="traslados-edit-tab">
                            @include('livewire.admin.ventas.reservas.partials.traslados-edit')
                        </div>
                        @endif

                        <!-- Tab Servicios -->
                        @if($reserva->adicionales->where('status', '!=', 0)->count() > 0)
                        <div class="tab-pane fade" id="servicios-edit" role="tabpanel"
                            aria-labelledby="servicios-edit-tab">
                            @include('livewire.admin.ventas.reservas.partials.servicios-edit')
                        </div>
                        @endif

                        <!-- Tab Combos -->
                        @if($reserva->combos->where('status', '!=', 0)->count() > 0)
                        <div class="tab-pane fade" id="combos-edit" role="tabpanel"
                            aria-labelledby="combos-edit-tab">
                            @include('livewire.admin.ventas.reservas.partials.combos-edit')
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales de Edición -->
    @include('livewire.admin.ventas.reservas.modals.modal-editar-actividad')
    @include('livewire.admin.ventas.reservas.modals.modal-editar-yate')
    @include('livewire.admin.ventas.reservas.modals.modal-editar-traslado')
    @include('livewire.admin.ventas.reservas.modals.modal-editar-servicio')
    @include('livewire.admin.ventas.reservas.modals.modal-editar-combo')
    @include('livewire.admin.ventas.reservas.modals.modal-cancelacion')
</div>
