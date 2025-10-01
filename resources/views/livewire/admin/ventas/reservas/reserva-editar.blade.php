<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Reserva - {{ Str::upper($reserva->folio) }}</h4>
                <h6>Agencia: {{ $reserva->nombreCliente }}</h6> {{ auth()->user()->nameRol }}
            </div>
        </div>
        <ul class="table-top-head">

         

            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        class="ti ti-chevron-up"></i></a>
            </li>
        </ul>
         <div class="page-btn mt-0">
                    <a href="{{ route('admin.reservas.show', $reserva->guid) }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Volver a la reserva</a>
                </div>
    </div>

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
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="actividades-tab" data-bs-toggle="tab"
                                        data-bs-target="#actividades" type="button" role="tab"
                                        aria-controls="actividades" aria-selected="true">
                                        <i class="fas fa-running me-2"></i>
                                        Actividades ({{ $reserva->actividades->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="yates-tab" data-bs-toggle="tab"
                                        data-bs-target="#yates" type="button" role="tab" aria-controls="yates"
                                        aria-selected="false">
                                        <i class="fas fa-ship me-2"></i>
                                        Yates ({{ $reserva->yates->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="traslados-tab" data-bs-toggle="tab"
                                        data-bs-target="#traslados" type="button" role="tab"
                                        aria-controls="traslados" aria-selected="false">
                                        <i class="fas fa-car me-2"></i>
                                        Traslados ({{ $reserva->traslados->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="servicios-tab" data-bs-toggle="tab"
                                        data-bs-target="#servicios" type="button" role="tab"
                                        aria-controls="servicios" aria-selected="false">
                                        <i class="fas fa-concierge-bell me-2"></i>
                                        Servicios ({{ $reserva->adicionales->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="combos-tab" data-bs-toggle="tab"
                                        data-bs-target="#combos" type="button" role="tab"
                                        aria-controls="combos" aria-selected="false">
                                        <i class="fas fa-box me-2"></i>
                                        Combos ({{ $reserva->combos->count() }})
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pagos-tab" data-bs-toggle="tab"
                                        data-bs-target="#pagos" type="button" role="tab" aria-controls="pagos"
                                        aria-selected="false">
                                        <i class="fas fa-credit-card me-2"></i>
                                        Pagos & Ingresos
                                        ({{ $reserva->payments->count() + $reserva->ventasReserva->count() + $reserva->FacturasRelacionadas->count() }})
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Tab Actividades -->
                                <div class="tab-pane fade show active" id="actividades" role="tabpanel"
                                    aria-labelledby="actividades-tab">
                                    <x-admin.reserva-actividades :actividades="$reserva->actividades" />
                                </div>

                                <!-- Tab Yates -->
                                <div class="tab-pane fade" id="yates" role="tabpanel"
                                    aria-labelledby="yates-tab">
                                    <x-admin.reserva-yates :yates="$reserva->yates" />
                                </div>

                                <!-- Tab Traslados -->
                                <div class="tab-pane fade" id="traslados" role="tabpanel"
                                    aria-labelledby="traslados-tab">
                                    <x-admin.reserva-traslados :traslados="$reserva->traslados" />
                                </div>

                                <!-- Tab Servicios -->
                                <div class="tab-pane fade" id="servicios" role="tabpanel"
                                    aria-labelledby="servicios-tab">
                                    <x-admin.reserva-servicios :servicios="$reserva->adicionales" />
                                </div>

                                <!-- Tab Combos -->
                                <div class="tab-pane fade" id="combos" role="tabpanel"
                                    aria-labelledby="combos-tab">
                                    <x-admin.reserva-combos :combos="$reserva->combos" />
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
                                                        ({{ $reserva->payments->count() }})
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    @if ($reserva->payments->count() > 0)
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
                                                                    @foreach ($reserva->payments as $payment)
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
                                                        ({{ $reserva->ventasReserva->count() + $reserva->FacturasRelacionadas->count() }})
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    @if ($reserva->ventasReserva->count() > 0 || $reserva->FacturasRelacionadas->count() > 0)
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
                                                                    @foreach ($reserva->ventasReserva as $venta)
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

                                                                    @foreach ($reserva->FacturasRelacionadas as $factura)
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
                                                                <h6 class="text-muted mb-0">Total Pagos POS
                                                                </h6>
                                                                <h5 class="text-primary">
                                                                    ${{ number_format($reserva->PagoBalance, 2) }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="text-center">
                                                                <h6 class="text-muted mb-0">Total Facturado</h6>
                                                                <h5 class="text-info">
                                                                    ${{ number_format($reserva->PagoCredito, 2) }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="text-center">
                                                                <h6 class="text-muted mb-0">Total Pagos
                                                                    Online
                                                                </h6>
                                                                <h5 class="text-success">
                                                                    ${{ number_format($reserva->payments->where('status', 'approved')->sum('amount'), 2) }}
                                                                </h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="text-center">
                                                                <h6 class="text-muted mb-0">Estado de
                                                                    Pago</h6>
                                                                <h5>{!! $reserva->BadgePagada !!}</h5>
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
