<!-- Vista de Resumen por Tipo -->
<div class="row">


    <!-- Detalle por Tipo -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-layer-group me-2"></i>
                    Tipo de Servicio
                </h5>
            </div>
            <div class="card-body">
                @forelse($reservas as $tipo => $datos)
                    <div class="card mb-3 border">
                        <div class="card-header bg-light cursor-pointer"
                            wire:click="seleccionarTipo('{{ $tipo }}')" style="cursor: pointer;">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-0">
                                        <i
                                            class="fas fa-{{ $tipo === 'ACT' ? 'hiking' : ($tipo === 'YAT' ? 'ship' : ($tipo === 'TRA' ? 'bus' : 'concierge-bell')) }} me-2"></i>
                                        {{ $filtrosDisponibles['tipos'][$tipo] ?? $tipo }}
                                        <span class="badge bg-secondary ms-2">{{ $datos['pasajeros']['total'] }}
                                            pasajeros</span>
                                    </h6>
                                </div>
                                <div class="col-md-4 text-end">
                                    <span class="text-muted">
                                        {{ $tipoSeleccionado === $tipo ? 'Ocultar' : 'Ver' }} detalles
                                        <i
                                            class="fas fa-chevron-{{ $tipoSeleccionado === $tipo ? 'up' : 'down' }} ms-1"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Métricas en el header -->
                            <div class="row mt-2">
                                <div class="col-3 text-center">
                                    <div class="text-primary">
                                        <strong><i
                                                class="fas fa-users me-1"></i>{{ $datos['pasajeros']['total'] }}</strong>
                                        <small class="d-block text-muted">Total</small>
                                    </div>
                                </div>
                                <div class="col-3 text-center">
                                    <div class="text-success">
                                        <strong> <i
                                                class="fas fa-check-circle me-1 text-success"></i>{{ $datos['pasajeros']['pagaron_enm'] }}</strong>
                                        <small class="d-block text-muted">Con ENM</small>
                                    </div>
                                </div>
                                <div class="col-3 text-center">
                                    <div class="text-danger">
                                        <strong> <i class="fas fa-times-circle me-1 text-danger"></i>{{ $datos['pasajeros']['no_pagaron_enm'] }}</strong>
                                        <small class="d-block text-muted">Sin ENM</small>
                                    </div>
                                </div>
                                    <div class="col-3 text-center">
                                        <div class="text-secondary">
                                            <strong> <i class="fas fa-ban me-1 text-secondary"></i>{{ $datos['pasajeros']['no_aplica_enm'] }}</strong>
                                            <small class="d-block text-muted">No Aplica ENM</small>
                                        </div>
                                    </div>
                                <div class="col-3 text-center">
                                    <div class="text-info">
                                        <strong>{{ $datos['pasajeros']['porcentaje_pago'] }}%</strong>
                                        <small class="d-block text-muted">% Pago</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Barra de progreso -->
                            <div class="mt-2">
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar bg-{{ $datos['pasajeros']['porcentaje_pago'] >= 70 ? 'success' : ($datos['pasajeros']['porcentaje_pago'] >= 50 ? 'warning' : 'danger') }}"
                                        style="width: {{ $datos['pasajeros']['porcentaje_pago'] }}%"></div>
                                </div>
                            </div>
                            <!-- Totales ENM por moneda -->
                            <div class="row mt-2">
                                <div class="col-6 text-center">
                                    <span class="text-success">
                                        <strong>${{ number_format($datos['financiero']['total_ingresos_enm_mxn'] ?? 0, 2) }}
                                            MXN</strong>
                                    </span>
                                    <small class="d-block text-muted">Total ENM MXN</small>
                                    <br>
                                    <span class="text-warning">
                                        <strong>Promedio:
                                            ${{ number_format($datos['financiero']['importe_promedio_enm_mxn'] ?? 0, 2) }}
                                            MXN</strong>
                                    </span>
                                </div>
                                <div class="col-6 text-center">
                                    <span class="text-primary">
                                        <strong>${{ number_format($datos['financiero']['total_ingresos_enm_usd'] ?? 0, 2) }}
                                            USD</strong>
                                    </span>
                                    <small class="d-block text-muted">Total ENM USD</small>
                                    <br>
                                    <span class="text-warning">
                                        <strong>Promedio:
                                            ${{ number_format($datos['financiero']['importe_promedio_enm_usd'] ?? 0, 2) }}
                                            USD</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if ($tipoSeleccionado === $tipo)
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Opción</th>
                                                <th>Status</th>
                                                <th> {{ $tipo === 'ACT' ? 'Actividad' : 'Yate' }}</th>
                                             
                                                <th>Cliente</th>
                                                <th>Folio</th>
                                                <th>Agencia</th>
                                                <th>Fecha</th>
                                                <th>Muelle</th>
                                                <th>Pax</th>
                                                <th>Pagaron</th>
                                                <th>No Pagaron</th>
                                                <th>No Aplica</th>
                                                <th>Ingresos MXN</th>
                                                <th>Ingresos USD</th>
                                                <th>Pasajeros</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($datos['grupos'] as $grupo)
                                                <tr>
                                                    <td>
                                                        <div class="btn-group dropup my-1">
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                                                data-bs-toggle="dropdown">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="javascript:void(0);"
                                                                        wire:click="verReservaCompleta('{{ $grupo['clave_grupo'] }}')">Ver
                                                                        reserva</a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>{!! $grupo['badge'] !!}</td>
                                                    <td>
                                                        <strong>
                                                            {{ $grupo['nombre_servicio'] }}
                                                        </strong>
                                                        <br><small
                                                            class="text-muted">{{ $grupo['nombre_paquete'] }}</small>
                                                    </td>
                                                    <td>{{ $grupo['cliente_nombre'] }}</td>
                                                    <td>
                                                        <code>{{ $grupo['folio_reserva'] }}</code>



                                                    </td>
                                                    <td>{{ $grupo['agencia_nombre'] }}</td>
                                                    <td>
                                                        @if ($grupo['fecha_servicio'])
                                                            <strong>{{ \Carbon\Carbon::parse($grupo['fecha_servicio'])->format('d/m/Y') }}</strong>
                                                            <br><small
                                                                class="text-muted">{{ \Carbon\Carbon::parse($grupo['fecha_servicio'])->format('H:i') }}</small>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif

                                                    </td>
                                                    <td>{{ $grupo['muelle_nombre'] }}</td>
                                                    <td>
                                                        <strong>{{ $grupo['total_pasajeros'] }}</strong>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-success">{{ $grupo['pagaron_enm'] }}</span>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-danger">{{ $grupo['no_pagaron_enm'] }}</span>
                                                    </td>
                                                        <td>
                                                            <span class="badge bg-secondary">{{ $grupo['no_aplica_enm'] }}</span>
                                                        </td>

                                                    <td>
                                                        <strong class="text-success">
                                                            ${{ number_format($grupo['total_ingresos_enm_mxn'] ?? 0, 2) }}
                                                            MXN
                                                        </strong>
                                                    </td>
                                                    <td>
                                                        <strong class="text-primary">
                                                            ${{ number_format($grupo['total_ingresos_enm_usd'] ?? 0, 2) }}
                                                            USD
                                                        </strong>
                                                    </td>

                                                    <td>

                                                        <div class="btn-group btn-group-sm">
                                                            <button class="btn btn-outline-primary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#detalleModal{{ $tipo }}_{{ $loop->index }}">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            @if (count($grupo['motivos_no_pago']) > 0)
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary text-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#motivosModal{{ $tipo }}_{{ $loop->index }}">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                    Ver ({{ count($grupo['motivos_no_pago']) }})
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No se encontraron pasajeros</h5>
                        <p class="text-muted">
                            Intenta ajustar los filtros de búsqueda para encontrar resultados.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modales para cada grupo de reservas -->
@if (isset($reservas))
    @foreach ($reservas as $tipo => $datos)
        @foreach ($datos['grupos'] as $grupoIndex => $grupo)
            <!-- Modal de detalle de pasajeros -->
            <div class="modal fade" id="detalleModal{{ $tipo }}_{{ $grupoIndex }}" tabindex="-1"
                aria-labelledby="detalleModalLabel{{ $tipo }}_{{ $grupoIndex }}" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title text-white"
                                id="detalleModalLabel{{ $tipo }}_{{ $grupoIndex }}">
                                <i class="fas fa-users me-2"></i>
                                Detalle de Pasajeros -
                                {{ $grupo['nombre_servicio'] }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white text-primary"
                                data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Información de la reserva -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Información de
                                                la Reserva</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Cliente:</strong> {{ $grupo['cliente_nombre'] }}</p>
                                            <p><strong>Folio:</strong> <code>{{ $grupo['folio_reserva'] }}</code></p>
                                            <p><strong>Agencia:</strong> {{ $grupo['agencia_nombre'] }}</p>
                                            <p><strong>Fecha:</strong> {{ $grupo['fecha_servicio'] }}</p>
                                            <p><strong>Muelle:</strong> {{ $grupo['muelle_nombre'] }}</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Estadísticas ENM
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row text-center">
                                                <div class="col-3">
                                                    <h4 class="text-primary">{{ $grupo['total_pasajeros'] }}</h4>
                                                    <small class="text-muted">Total</small>
                                                </div>
                                                <div class="col-3">
                                                    <h4 class="text-success">{{ $grupo['pagaron_enm'] }}</h4>
                                                    <small class="text-muted">Con ENM</small>
                                                </div>
                                               
                                                
                                                <div class="col-3">
                                                    <h5 class="text-info mb-0">
                                                        ${{ number_format($grupo['total_ingresos_enm_mxn'] ?? 0, 2) }}
                                                        MXN
                                                    </h5>
                                                    <small class="text-muted">Ingresos ENM MXN</small>
                                                </div>
                                                <div class="col-3">
                                                    <h5 class="text-primary mb-0">
                                                        ${{ number_format($grupo['total_ingresos_enm_usd'] ?? 0, 2) }}
                                                        USD
                                                    </h5>
                                                    <small class="text-muted">Ingresos ENM USD</small>
                                                </div>
                                            </div>

                                            <!-- Agregar información adicional -->
                                            <div class="row text-center mt-3 pt-2 border-top">
                                               
                                                <div class="col-6">
                                                    <h6 class="text-warning">
                                                        ${{ number_format($grupo['importe_promedio_enm_mxn'] ?? 0, 2) }}
                                                        MXN
                                                    </h6>
                                                    <small class="text-muted">Promedio ENM MXN</small>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="text-primary">
                                                        ${{ number_format($grupo['importe_promedio_enm_usd'] ?? 0, 2) }}
                                                        USD
                                                    </h6>
                                                    <small class="text-muted">Promedio ENM USD</small>
                                                </div>
                                            </div>
                                            <div class="progress mt-2" style="height: 10px;">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $grupo['porcentaje_pago'] }}%">
                                                    {{ $grupo['porcentaje_pago'] }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de pasajeros -->
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th width="80">ID</th>
                                            <th>Nombre Completo</th>
                                            <th width="120">Edad</th>
                                            <th width="100">Nacionalidad</th>
                                            <th width="120">Estado</th>
                                            <th width="120">Precio</th>
                                            <th>Motivo</th>
                                            <th width="150">Fecha Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($grupo['pasajeros']) && count($grupo['pasajeros']) > 0)
                                            @foreach ($grupo['pasajeros'] as $pasajero)
                                                <tr
                                                    class="{{ $pasajero['pago_enm'] ? 'table-success' : 'table-warning' }}">
                                                    <td>
                                                        <strong>{{ $pasajero['idRP'] }}</strong>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <i
                                                                class="fas fa-user-circle fa-lg me-2 {{ $pasajero['pago_enm'] ? 'text-success' : 'text-warning' }}"></i>
                                                            <div>
                                                                <strong>{{ $pasajero['nombre'] }}</strong>
                                                                @if (isset($pasajero['apellidos']))
                                                                    <br><small
                                                                        class="text-muted">{{ $pasajero['apellidos'] }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if (isset($pasajero['edad']))
                                                            <span class="badge bg-secondary">{{ $pasajero['edad'] }}
                                                                años</span>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($pasajero['nacionalidad']))
                                                            <span
                                                                class="badge bg-info">{{ $pasajero['nacionalidad'] }}</span>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                       {!! $pasajero['status'] !!}
                                                    </td>
                                                    <td>
                                                        @if ($pasajero['pago_enm'])
                                                            @if (isset($pasajero['importe']) && $pasajero['importe'] > 0)
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-dollar-sign me-1"></i>
                                                                    ${{ number_format($pasajero['importe'], 2) }}
                                                                    {{ $pasajero['moneda'] }}
                                                                </span>
                                                            @elseif(isset($pasajero['precio']) && $pasajero['precio'] > 0)
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-dollar-sign me-1"></i>
                                                                    ${{ number_format($pasajero['precio'], 2) }}
                                                                    {{ $pasajero['moneda'] }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-info">
                                                                    <i class="fas fa-check me-1"></i>Pagado
                                                                </span>
                                                            @endif
                                                            
                                                        @else
                                                            <span class="text-muted">
                                                                <i class="fas fa-minus me-1"></i>N/A
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($pasajero['motivo']))
                                                            <span class="text-warning">
                                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                                {{ $pasajero['motivo'] }}
                                                            </span>
                                                        @else
                                                            <span class="text-success">
                                                                <i class="fas fa-check me-1"></i>Sin observaciones
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($pasajero['fecha_registro']))
                                                            <small
                                                                class="text-muted">{{ $pasajero['fecha_registro'] }}</small>
                                                        @else
                                                            <span class="text-muted">N/A</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    <i class="fas fa-users-slash fa-2x mb-2"></i>
                                                    <br>No hay pasajeros registrados para esta reserva
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Cerrar
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de motivos de no pago -->
            @if (isset($grupo['motivos_no_pago']) && count($grupo['motivos_no_pago']) > 0)
                <div class="modal fade" id="motivosModal{{ $tipo }}_{{ $grupoIndex }}" tabindex="-1"
                    aria-labelledby="motivosModalLabel{{ $tipo }}_{{ $grupoIndex }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title"
                                    id="motivosModalLabel{{ $tipo }}_{{ $grupoIndex }}">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Motivos de No Pago ENM
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>{{ $grupo['nombre_servicio'] }}</strong>
                                    -
                                    {{ count($grupo['motivos_no_pago']) }} pasajero(s) no pagaron ENM
                                </div>

                                @foreach ($grupo['motivos_no_pago'] as $motivo)
                                    <div class="card mb-3 border-warning">
                                        <div class="card-header bg-light">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <h6 class="mb-0">
                                                        <i class="fas fa-user me-2"></i>
                                                        <strong>{{ $motivo['nombre'] }}</strong>
                                                        <span class="badge bg-secondary ms-2">ID:
                                                            {{ $motivo['idRP'] }}</span>
                                                    </h6>
                                                </div>
                                                <div class="col-auto">
                                                   {!! $motivo['status']  !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-warning mb-0">
                                                <h6 class="alert-heading">
                                                    <i class="fas fa-comment-alt me-2"></i>Motivo:
                                                </h6>
                                                <p class="mb-0">{{ $motivo['motivo'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endforeach
@endif

<script>
    // Asegurar que los modales funcionen con Livewire
    document.addEventListener('livewire:init', function() {
        Livewire.hook('morph.updated', ({
            el,
            component
        }) => {
            // Reinicializar los modales de Bootstrap después de actualizaciones de Livewire
            const modales = el.querySelectorAll('.modal');
            modales.forEach(modal => {
                if (!modal.hasAttribute('data-bs-initialized')) {
                    new bootstrap.Modal(modal);
                    modal.setAttribute('data-bs-initialized', 'true');
                }
            });
        });
    });
</script>
