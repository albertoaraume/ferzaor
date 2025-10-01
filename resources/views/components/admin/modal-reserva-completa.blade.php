<div class="modal fade" id="modalReservaCompleta" tabindex="-1" aria-labelledby="modalReservaCompletaLabel"
    aria-hidden="true" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">


    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="modalReservaCompletaLabel">
                    <i class="fas fa-folder-open me-2"></i>
                    Reserva - {{ $reservaCompleta ? Str::upper($reservaCompleta->folio) : 'N/A' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                @if ($reservaCompleta)
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
                                            {!! $reservaCompleta->Badge !!}
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="me-2 text-muted">Check-in:</span>
                                            {!! $reservaCompleta->BadgeCheckIn !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>ID:</strong></label>
                                                <p>{{ $reservaCompleta->idReserva }}
                                                </p>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Fecha de Compra:</strong></label>
                                                <p>{{ $reservaCompleta->fechaCompra ? \Carbon\Carbon::parse($reservaCompleta->fechaCompra)->format('d/m/Y H:i:s') : 'N/A' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Vendedor:</strong></label>
                                                <p>{{ $reservaCompleta->nombreVendedor }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Cliente:</strong></label>
                                                <p>{{ $reservaCompleta->nombre }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Locación:</strong></label>
                                                <p>{{ $reservaCompleta->locacion->nombreLocacion ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Agente:</strong></label>
                                                <p>{{ $reservaCompleta->agente->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Hotel:</strong></label>
                                                <p>{{ $reservaCompleta->nombreHotel ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Moneda:</strong></label>
                                                <p>{{ $reservaCompleta->descripcionMoneda }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Agencia:</strong></label>
                                                <p>{{ $reservaCompleta->cliente->nombreComercial ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Habitación:</strong></label>
                                                <p>{{ $reservaCompleta->habitacion ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- Información adicional de servicios -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Bebidas:</strong></label>
                                                @if ($reservaCompleta->bebidas && trim($reservaCompleta->bebidas) != '')
                                                    <div class="alert alert-info mb-2">
                                                        <i class="fas fa-cocktail me-2"></i>
                                                        {{ $reservaCompleta->bebidas }}
                                                    </div>
                                                @else
                                                    <p class="text-muted">Sin información de bebidas</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Alimentos:</strong></label>
                                                @if ($reservaCompleta->alimentos && trim($reservaCompleta->alimentos) != '')
                                                    <div class="alert alert-success mb-2">
                                                        <i class="fas fa-utensils me-2"></i>
                                                        {{ $reservaCompleta->alimentos }}
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
                                                @if ($reservaCompleta->impuestos && trim($reservaCompleta->impuestos) != '')
                                                    <div class="alert alert-warning mb-2">
                                                        <i class="fas fa-receipt me-2"></i>
                                                        {{ $reservaCompleta->impuestos }}
                                                    </div>
                                                @else
                                                    <p class="text-muted">Sin información de impuestos</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Comentarios:</strong></label>
                                                @if ($reservaCompleta->comentarios && trim($reservaCompleta->comentarios) != '')
                                                    <div class="alert alert-light border">
                                                        <i class="fas fa-comment-dots me-2"></i>
                                                        {{ $reservaCompleta->comentarios }}
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
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="actividades-tab"
                                                        data-bs-toggle="tab" data-bs-target="#actividades"
                                                        type="button" role="tab" aria-controls="actividades"
                                                        aria-selected="true">
                                                        <i class="fas fa-running me-2"></i>
                                                        Actividades ({{ $reservaCompleta->actividades->count() }})
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="yates-tab" data-bs-toggle="tab"
                                                        data-bs-target="#yates" type="button" role="tab"
                                                        aria-controls="yates" aria-selected="false">
                                                        <i class="fas fa-ship me-2"></i>
                                                        Yates ({{ $reservaCompleta->yates->count() }})
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="traslados-tab" data-bs-toggle="tab"
                                                        data-bs-target="#traslados" type="button" role="tab"
                                                        aria-controls="traslados" aria-selected="false">
                                                        <i class="fas fa-car me-2"></i>
                                                        Traslados ({{ $reservaCompleta->traslados->count() }})
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="servicios-tab" data-bs-toggle="tab"
                                                        data-bs-target="#servicios" type="button" role="tab"
                                                        aria-controls="servicios" aria-selected="false">
                                                        <i class="fas fa-concierge-bell me-2"></i>
                                                        Servicios ({{ $reservaCompleta->adicionales->count() }})
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="combos-tab" data-bs-toggle="tab"
                                                        data-bs-target="#combos" type="button" role="tab"
                                                        aria-controls="combos" aria-selected="false">
                                                        <i class="fas fa-box me-2"></i>
                                                        Combos ({{ $reservaCompleta->combos->count() }})
                                                    </button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="pagos-tab" data-bs-toggle="tab"
                                                        data-bs-target="#pagos" type="button" role="tab"
                                                        aria-controls="pagos" aria-selected="false">
                                                        <i class="fas fa-credit-card me-2"></i>
                                                        Pagos & Ingresos
                                                        ({{ $reservaCompleta->payments->count() + $reservaCompleta->ventasReserva->count() + $reservaCompleta->FacturasRelacionadas->count() }})
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <!-- Tab Actividades -->
                                                <div class="tab-pane fade show active" id="actividades"
                                                    role="tabpanel" aria-labelledby="actividades-tab">
                                                    <x-admin.reserva-actividades :actividades="$reservaCompleta->actividades" />
                                                </div>

                                                <!-- Tab Yates -->
                                                <div class="tab-pane fade" id="yates" role="tabpanel"
                                                    aria-labelledby="yates-tab">
                                                    <x-admin.reserva-yates :yates="$reservaCompleta->yates" />
                                                </div>

                                                <!-- Tab Traslados -->
                                                <div class="tab-pane fade" id="traslados" role="tabpanel"
                                                    aria-labelledby="traslados-tab">
                                                    <x-admin.reserva-traslados :traslados="$reservaCompleta->traslados" />
                                                </div>

                                                <!-- Tab Servicios -->
                                                <div class="tab-pane fade" id="servicios" role="tabpanel"
                                                    aria-labelledby="servicios-tab">
                                                        <x-admin.reserva-servicios :servicios="$reservaCompleta->adicionales" />
                                                </div>

                                                <!-- Tab Combos -->
                                                <div class="tab-pane fade" id="combos" role="tabpanel"
                                                    aria-labelledby="combos-tab">
                                                    <x-admin.reserva-combos :combos="$reservaCompleta->combos" />
                                                </div>

                                                <!-- Tab Pagos e Ingresos -->
                                                <div class="tab-pane fade" id="pagos" role="tabpanel"
                                                    aria-labelledby="pagos-tab">
                                                    <div class="row">
                                                        <!-- Pagos en línea -->
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="mb-0">
                                                                        <i class="fas fa-globe me-2"></i>
                                                                        Pagos en Línea
                                                                        ({{ $reservaCompleta->payments->count() }})
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if ($reservaCompleta->payments->count() > 0)
                                                                        <div class="table-responsive">
                                                                            <table class="table table-sm">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Método</th>
                                                                                        <th>Monto</th>
                                                                                        <th>Moneda</th>
                                                                                        <th>Estado</th>
                                                                                        <th>Fecha</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($reservaCompleta->payments as $payment)
                                                                                        <tr>
                                                                                            <td>
                                                                                                <span
                                                                                                    class="badge bg-primary">{{ $payment->method }}</span>
                                                                                            </td>
                                                                                            <td>${{ number_format($payment->amount, 2) }}
                                                                                            </td>
                                                                                            <td>{{ $payment->currency }}
                                                                                            </td>
                                                                                            <td>
                                                                                                @switch($payment->status)
                                                                                                    @case('approved')
                                                                                                        <span
                                                                                                            class="badge bg-success">Aprobado</span>
                                                                                                    @break

                                                                                                    @case('pending')
                                                                                                        <span
                                                                                                            class="badge bg-warning">Pendiente</span>
                                                                                                    @break

                                                                                                    @case('rejected')
                                                                                                        <span
                                                                                                            class="badge bg-danger">Rechazado</span>
                                                                                                    @break

                                                                                                    @default
                                                                                                        <span
                                                                                                            class="badge bg-secondary">{{ $payment->status }}</span>
                                                                                                @endswitch
                                                                                            </td>
                                                                                            <td>{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y H:i') : 'N/A' }}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    @else
                                                                        <div class="alert alert-info">
                                                                            <i class="fas fa-info-circle me-2"></i>
                                                                            No hay pagos en línea registrados para esta
                                                                            reserva.
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Ingresos relacionados -->
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="mb-0">
                                                                        <i class="fas fa-money-check me-2"></i>
                                                                        Ingresos y Facturas Relacionados
                                                                        ({{ $reservaCompleta->ventasReserva->count() + $reservaCompleta->FacturasRelacionadas->count() }})
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if ($reservaCompleta->ventasReserva->count() > 0 || $reservaCompleta->FacturasRelacionadas->count() > 0)
                                                                        <div class="table-responsive">
                                                                            <table class="table table-sm">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Tipo</th>
                                                                                        <th>ID</th>
                                                                                        <th>Folio</th>
                                                                                        <th>Fecha</th>
                                                                                        <th>Descripción</th>
                                                                                        <th>Importe</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($reservaCompleta->ventasReserva as $venta)
                                                                                        @foreach ($venta->venta->ingresos as $ingresoVenta)
                                                                                            <tr>
                                                                                                <td>Ingreso</td>
                                                                                                <td>{{ $ingresoVenta->ingreso->idIngreso }}
                                                                                                </td>
                                                                                                <td>{{ $ingresoVenta->ingreso->folio }}
                                                                                                </td>

                                                                                                <td>{{ $ingresoVenta->ingreso->fechaAplica ? \Carbon\Carbon::parse($ingresoVenta->ingreso->fechaAplica)->format('d/m/Y') : 'N/A' }}
                                                                                                </td>
                                                                                                <td>{{ $ingresoVenta->ingreso->descripcionFormaPago ?? 'N/A' }}
                                                                                                </td>

                                                                                                <td>${{ number_format($ingresoVenta->total, 2) }}
                                                                                                </td>


                                                                                            </tr>
                                                                                        @endforeach
                                                                                    @endforeach

                                                                                    @foreach ($reservaCompleta->FacturasRelacionadas as $factura)
                                                                                        <tr>
                                                                                            <td>Factura</td>
                                                                                            <td>{{ $factura->c_cfdiConcepto ?? 'N/A' }}
                                                                                            </td>
                                                                                            <td>{{ $factura->comprobante->FolioDisplay ?? 'N/A' }}
                                                                                            </td>

                                                                                            <td>{{ \Carbon\Carbon::parse($factura->comprobante->fechaCreacion)->format('d-m-Y') }}
                                                                                            </td>
                                                                                            <td>{{ $factura->comprobante->tipoComprobanteDescription }}
                                                                                            </td>
                                                                                            <td>${{ number_format($factura->total, 2) }}
                                                                                            </td>


                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    @else
                                                                        <div class="alert alert-info">
                                                                            <i class="fas fa-info-circle me-2"></i>
                                                                            No hay ingresos relacionados registrados
                                                                            para esta
                                                                            reserva.
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Resumen de pagos -->
                                                    <div class="row mt-3">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h6 class="mb-0">
                                                                        <i class="fas fa-calculator me-2"></i>
                                                                        Resumen de Pagos
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            <div class="text-center">
                                                                                <h6 class="text-muted mb-0">Total Pagos
                                                                                    POS
                                                                                </h6>
                                                                                <h5 class="text-primary">
                                                                                    ${{ number_format($reservaCompleta->PagoBalance, 2) }}
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="text-center">
                                                                                <h6 class="text-muted mb-0">Total
                                                                                    Facturado</h6>
                                                                                <h5 class="text-info">
                                                                                    ${{ number_format($reservaCompleta->PagoCredito, 2) }}
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="text-center">
                                                                                <h6 class="text-muted mb-0">Total Pagos
                                                                                    Online
                                                                                </h6>
                                                                                <h5 class="text-success">
                                                                                    ${{ number_format($reservaCompleta->payments->where('status', 'approved')->sum('amount'), 2) }}
                                                                                </h5>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="text-center">
                                                                                <h6 class="text-muted mb-0">Estado de
                                                                                    Pago</h6>
                                                                                <h5>{!! $reservaCompleta->BadgePagada !!}</h5>
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
                                                        ${{ number_format($reservaCompleta->subTotal ?? 0, 2) }}
                                                        <small>{{ $reservaCompleta->c_moneda }}</small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="card border">
                                                <div class="card-body py-2">
                                                    <h6 class="mb-1 text-muted">Descuento</h6>
                                                    <h5 class="mb-0 text-dark">
                                                        ${{ number_format($reservaCompleta->totalDescuento ?? 0, 2) }}
                                                        <small>{{ $reservaCompleta->c_moneda }}</small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="card border">
                                                <div class="card-body py-2">
                                                    <h6 class="mb-1 text-muted">Comisiones</h6>
                                                    <h5 class="mb-0 text-dark">
                                                        ${{ number_format($reservaCompleta->TotalComision ?? 0, 2) }}
                                                        <small>{{ $reservaCompleta->c_moneda }}</small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="card border">
                                                <div class="card-body py-2">
                                                    <h6 class="mb-1 text-muted">Total General</h6>
                                                    <h5 class="mb-0 text-dark fw-bold">
                                                        ${{ number_format($reservaCompleta->ImporteTotal, 2) }}
                                                        <small>{{ $reservaCompleta->c_moneda }}</small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="card border">
                                                <div class="card-body py-2">
                                                    <h6 class="mb-1 text-muted">Total Crédito</h6>
                                                    <h5 class="mb-0 text-dark">
                                                        ${{ number_format($reservaCompleta->TotalCredito ?? 0, 2) }}<small>{{ $reservaCompleta->c_moneda }}</small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="card border">
                                                <div class="card-body py-2">
                                                    <h6 class="mb-1 text-muted">Total Balance</h6>
                                                    <h5 class="mb-0 text-dark">
                                                        ${{ number_format($reservaCompleta->TotalBalance ?? 0, 2) }}<small>{{ $reservaCompleta->c_moneda }}</small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <div class="card bg-warning text-white border-warning">
                                                <div class="card-body text-center py-2">
                                                    <h6 class="mb-1">Saldo Pendiente</h6>
                                                    <h5 class="mb-0 fw-bold">
                                                        ${{ number_format($reservaCompleta->Saldo, 2) }}
                                                        <small>{{ $reservaCompleta->c_moneda }}</small>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No se encontraron datos de la reserva.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                @if ($reservaCompleta)
                    <a href="{{ route('admin.reservas.show', ['guid' => $reservaCompleta->guid]) }}" target="_blank"
                        class="btn btn-primary me-auto">
                        <i class="fas fa-external-link-alt me-2"></i>
                        Ver Detalles
                    </a>
                @endif

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
