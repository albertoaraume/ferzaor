<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Reserva - {{ Str::upper($reserva->folio) }}</h4>
                <h6>Agencia: {{ $reserva->nombreCliente }}</h6> 
            </div>
        </div>
        <ul class="table-top-head">



            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        class="ti ti-chevron-up"></i></a>
            </li>
        </ul>
        <div class="page-btn mt-0">
            <a href="{{ route('admin.reservas.show', $reserva->guid) }}" class="btn btn-secondary"><i
                    data-feather="arrow-left" class="me-2"></i>Volver a la reserva</a>
        </div>
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
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información General de la Reserva
                    </h6>
                    <div class="d-flex gap-3">
                        <div class="d-flex align-items-center">
                            <span class="me-2 text-muted">Estado:</span>
                            {!! $reserva->Badge !!}
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-2 text-muted">Check-in:</span>
                            {!! $reserva->BadgeCheckIn !!}
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>ID:</strong></label>
                                <p>{{ $reserva->idReserva }}
                                </p>
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Fecha de Compra:</strong></label>
                                <p>{{ $reserva->fechaCompra ? \Carbon\Carbon::parse($reserva->fechaCompra)->format('d/m/Y H:i:s') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Vendedor:</strong></label>
                                <p>{{ $reserva->nombreVendedor }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Cliente:</strong></label>
                                <p>{{ $reserva->nombre }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Locación:</strong></label>
                                <p>{{ $reserva->locacion->nombreLocacion ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Agente:</strong></label>
                                <p>{{ $reserva->agente->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Hotel:</strong></label>
                                <p>{{ $reserva->nombreHotel ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Moneda:</strong></label>
                                <p>{{ $reserva->descripcionMoneda }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Agencia:</strong></label>
                                <p>{{ $reserva->cliente->nombreComercial ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label"><strong>Habitación:</strong></label>
                                <p>{{ $reserva->habitacion ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- Información adicional de servicios -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Bebidas:</strong></label>
                                @if ($reserva->bebidas && trim($reserva->bebidas) != '')
                                    <div class="alert alert-info mb-2">
                                        <i class="fas fa-cocktail me-2"></i>
                                        {{ $reserva->bebidas }}
                                    </div>
                                @else
                                    <p class="text-muted">Sin información de bebidas</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Alimentos:</strong></label>
                                @if ($reserva->alimentos && trim($reserva->alimentos) != '')
                                    <div class="alert alert-success mb-2">
                                        <i class="fas fa-utensils me-2"></i>
                                        {{ $reserva->alimentos }}
                                    </div>
                                @else
                                    <p class="text-muted">Sin información de alimentos</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Impuestos:</strong></label>
                                @if ($reserva->impuestos && trim($reserva->impuestos) != '')
                                    <div class="alert alert-warning mb-2">
                                        <i class="fas fa-receipt me-2"></i>
                                        {{ $reserva->impuestos }}
                                    </div>
                                @else
                                    <p class="text-muted">Sin información de impuestos</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><strong>Comentarios:</strong></label>
                                @if ($reserva->comentarios && trim($reserva->comentarios) != '')
                                    <div class="alert alert-light border">
                                        <i class="fas fa-comment-dots me-2"></i>
                                        {{ $reserva->comentarios }}
                                    </div>
                                @else
                                    <p class="text-muted">Sin comentarios</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Espacio disponible para futuros campos -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestañas para diferentes secciones -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                @if ($reserva->actividades->flatMap->unidades->where('status', '!=', 0)->count() > 0)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="actividades-edit-tab" data-bs-toggle="tab"
                                            data-bs-target="#actividades-edit" type="button" role="tab"
                                            aria-controls="actividades-edit" aria-selected="true">
                                            <i class="fas fa-running me-2"></i>
                                            Actividades
                                            ({{ $reserva->actividades->flatMap->unidades->where('status', '!=', 0)->count() }})
                                        </button>
                                    </li>
                                @endif
                                @if ($reserva->yates->where('status', '!=', 0)->count() > 0)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="yates-edit-tab" data-bs-toggle="tab"
                                            data-bs-target="#yates-edit" type="button" role="tab"
                                            aria-controls="yates-edit" aria-selected="false">
                                            <i class="fas fa-ship me-2"></i>
                                            Yates ({{ $reserva->yates->where('status', '!=', 0)->count() }})
                                        </button>
                                    </li>
                                @endif
                                @if ($reserva->traslados->where('status', '!=', 0)->count() > 0)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="traslados-edit-tab" data-bs-toggle="tab"
                                            data-bs-target="#traslados-edit" type="button" role="tab"
                                            aria-controls="traslados-edit" aria-selected="false">
                                            <i class="fas fa-car me-2"></i>
                                            Traslados ({{ $reserva->traslados->where('status', '!=', 0)->count() }})
                                        </button>
                                    </li>
                                @endif
                                @if ($reserva->adicionales->where('status', '!=', 0)->count() > 0)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="servicios-edit-tab" data-bs-toggle="tab"
                                            data-bs-target="#servicios-edit" type="button" role="tab"
                                            aria-controls="servicios-edit" aria-selected="false">
                                            <i class="fas fa-concierge-bell me-2"></i>
                                            Servicios ({{ $reserva->adicionales->where('status', '!=', 0)->count() }})
                                        </button>
                                    </li>
                                @endif
                                @if ($reserva->combos->where('status', '!=', 0)->count() > 0)
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
        </div>

        <!-- Resumen Financiero - Lateral Derecho -->
        <div class="col-lg-2">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-calculator me-2"></i>
                        Resumen Financiero
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Información financiera -->
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="card border">
                                <div class="card-body py-2">
                                    <h6 class="mb-1 text-muted">SubTotal</h6>
                                    <h5 class="mb-0 text-dark">
                                        ${{ number_format($reserva->subTotal ?? 0, 2) }}
                                        <small>{{ $reserva->c_moneda }}</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="card border">
                                <div class="card-body py-2">
                                    <h6 class="mb-1 text-muted">Descuento</h6>
                                    <h5 class="mb-0 text-dark">
                                        ${{ number_format($reserva->totalDescuento ?? 0, 2) }}
                                        <small>{{ $reserva->c_moneda }}</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="card border">
                                <div class="card-body py-2">
                                    <h6 class="mb-1 text-muted">Comisiones</h6>
                                    <h5 class="mb-0 text-dark">
                                        ${{ number_format($reserva->TotalComision ?? 0, 2) }}
                                        <small>{{ $reserva->c_moneda }}</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="card border">
                                <div class="card-body py-2">
                                    <h6 class="mb-1 text-muted">Total General</h6>
                                    <h5 class="mb-0 text-dark fw-bold">
                                        ${{ number_format($reserva->ImporteTotal, 2) }}
                                        <small>{{ $reserva->c_moneda }}</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="card border">
                                <div class="card-body py-2">
                                    <h6 class="mb-1 text-muted">Total Crédito</h6>
                                    <h5 class="mb-0 text-dark">
                                        ${{ number_format($reserva->TotalCredito ?? 0, 2) }}<small>{{ $reserva->c_moneda }}</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="card border">
                                <div class="card-body py-2">
                                    <h6 class="mb-1 text-muted">Total Balance</h6>
                                    <h5 class="mb-0 text-dark">
                                        ${{ number_format($reserva->TotalBalance ?? 0, 2) }}<small>{{ $reserva->c_moneda }}</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="card bg-warning text-white border-warning">
                                <div class="card-body text-center py-2">
                                    <h6 class="mb-1">Saldo Pendiente</h6>
                                    <h5 class="mb-0 fw-bold">
                                        ${{ number_format($reserva->Saldo, 2) }}
                                        <small>{{ $reserva->c_moneda }}</small>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






</div>
