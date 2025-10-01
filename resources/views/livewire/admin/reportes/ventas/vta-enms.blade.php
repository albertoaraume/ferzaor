<div>



<!-- Filtros -->
<div class="card-body border-bottom">
    <div class="row g-3">
        <!-- Fechas -->
        <div class="col-md-2">
            <label class="form-label">Fecha Inicio</label>
            <input type="date" class="form-control form-control-sm" wire:model="fechaInicio">
        </div>
        <div class="col-md-2">
            <label class="form-label">Fecha Fin</label>
            <input type="date" class="form-control form-control-sm" wire:model="fechaFin">
        </div>

        <!-- Tipo de servicio -->
        <div class="col-md-2">
            <label class="form-label">Tipo de Servicio</label>
            <select class="form-select form-select-sm" wire:model="tipo" id="tipo">
                <option value="">Todos</option>
                @foreach ($filtrosDisponibles['tipos'] as $key => $valor)
                    <option value="{{ $key }}">{{ $valor }}</option>
                @endforeach
            </select>
        </div>


        <!-- Cliente -->
        <div class="col-md-2">
            <label class="form-label">Cliente</label>
            <select class="form-select form-select-sm" wire:model="clienteId" id="cliente">
                <option value="">Todos</option>
                @foreach ($filtrosDisponibles['clientes'] as $id => $nombre)
                    <option value="{{ $id }}">{{ $nombre }}</option>
                @endforeach
            </select>
        </div>

        <!-- Locación -->
        <div class="col-md-2">
            <label class="form-label">Locación</label>
            <select class="form-select form-select-sm" wire:model="locacionId" id="locacion">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['locaciones'] as $id => $nombre)
                    <option value="{{ $id }}">{{ $nombre }}</option>
                @endforeach
            </select>
        </div>
       

    </div>
      <div class="row  g-3 mt-2">
         <div class="col-md-3">
            <label for="actividad" class="form-label">Actividad</label>
            <select wire:model="actividadId" class="form-control select2" id="actividad">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['actividades'] as $idActividad => $nombreActividad)
                    <option value="{{ $idActividad }}">{{ $nombreActividad }}</option>
                @endforeach
            </select>
        </div>

          <div class="col-md-3">
            <label for="yate" class="form-label">Yate</label>
            <select wire:model="yateId" class="form-control select2" id="yate">
                <option value="">Todos</option>
                @foreach ($filtrosDisponibles['yates'] as $idYate => $nombreYate)
                    <option value="{{ $idYate }}">{{ $nombreYate }}</option>
                @endforeach
            </select>
        </div>

         <div class="col-md-2">
            <label class="form-label">Muelle <small class="text-muted">(solo yates)</small></label>
            <select class="form-select form-select-sm" wire:model="muelleId" id="muelle"
                {{ $tipo !== 'YAT' && !empty($tipo) ? 'disabled' : '' }}>
                <option value="">Todos</option>
                @if (isset($filtrosDisponibles['muelles']))
                    @foreach ($filtrosDisponibles['muelles'] as $id => $nombre)
                        <option value="{{ $id }}">{{ $nombre }}</option>
                    @endforeach
                @endif
            </select>
            @if ($tipo !== 'YAT' && !empty($tipo))
                <small class="text-warning">Solo disponible para yates</small>
            @endif
        </div>
         <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="button" class="btn btn-primary btn-sm" wire:click="aplicarFiltros">
                <i class="fas fa-search me-1"></i> Aplicar Filtros
            </button>
            <button type="button" class="btn btn-secondary btn-sm" wire:click="limpiarFiltros">
                <i class="fas fa-eraser me-1"></i> Limpiar
            </button>
            <button type="button" class="btn btn-info btn-sm" wire:click="toggleEstadisticas">
                <i class="fas fa-chart-bar me-1"></i>
                {{ $mostrarEstadisticas ? 'Ocultar' : 'Mostrar' }} Resumen
            </button>
        </div>
      </div>

    <!-- Filtros adicionales (segunda fila) -->
    <div class="row g-3 mt-2">
        <!-- Muelle (solo para yates) -->


        <!-- Botones de filtro -->
       
    </div>
</div>

<!-- Resumen General -->
@if ($mostrarEstadisticas)
    <div class="row m-2">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Resumen General
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        // Calcular totales generales
                        $totalPasajerosGeneral = 0;
                        $totalPagaronENMGeneral = 0;
                        $totalNoPagaronENMGeneral = 0;
                        $totalNoAplicaENMGeneral = 0;
                        $totalIngresosENMGeneral = 0;
                        $totalGruposGeneral = 0;

                        if (isset($reservas)) {
                            foreach ($reservas as $tipo => $datos) {
                             
                                $totalPasajerosGeneral += $datos['pasajeros']['total'] ?? 0;
                                $totalPagaronENMGeneral += $datos['pasajeros']['pagaron_enm'] ?? 0;
                                $totalNoPagaronENMGeneral += $datos['pasajeros']['no_pagaron_enm'] ?? 0;
                                $totalNoAplicaENMGeneral += $datos['pasajeros']['no_aplica_enm'] ?? 0;
                                $totalIngresosENMGeneralMXN = $datos['financiero']['total_ingresos_enm_mxn'] ?? 0;
                                $totalIngresosENMGeneralUSD = $datos['financiero']['total_ingresos_enm_usd'] ?? 0;
                                $totalIngresosENMGeneral += $datos['financiero']['total_ingresos_enm'] ?? 0;
                              
                                $totalGruposGeneral += $datos['estadisticas_grupos']['total_grupos'] ?? 0;
                            }
                        }

                        $porcentajePagoGeneral =
                            $totalPasajerosGeneral > 0
                                ? round(($totalPagaronENMGeneral / $totalPasajerosGeneral) * 100, 2)
                                : 0;
                    @endphp

                    <div class="row text-center">
                        <div class="col-md-2 col-6 mb-3">
                            <div class="tarjeta-resumen tarjeta-pasajeros rounded p-3 shadow-sm">
                                <i class="fas fa-users fa-2x mb-2 text-primary"></i>
                                <h3 class="mb-1 fw-bold">{{ number_format($totalPasajerosGeneral) }}</h3>
                                <p class="mb-0 small fw-semibold">Total Pasajeros</p>
                                <small class="d-block mt-1 opacity-85">{{ $totalGruposGeneral }} servicios</small>
                            </div>
                        </div>
                          <div class="col-md-2 col-6 mb-2">
                            <div class="tarjeta-resumen tarjeta-no-aplica rounded p-3 shadow-sm">
                                <i class="fas fa-ban fa-2x mb-2 text-secondary"></i>
                                <h3 class="mb-1 fw-bold">{{ number_format($totalNoAplicaENMGeneral) }}</h3>
                                <p class="mb-0 small fw-semibold">No Aplica ENM</p>
                                <small class="d-block mt-1 opacity-85">Pasajeros sin ENM</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2">
                            <div class="tarjeta-resumen tarjeta-pagaron rounded p-3 shadow-sm">
                                <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                                <h3 class="mb-1 fw-bold">{{ number_format($totalPagaronENMGeneral) }}</h3>
                                <p class="mb-0 small fw-semibold">Pagaron ENM</p>
                                <small class="d-block mt-1 opacity-85">{{ $porcentajePagoGeneral }}% del total</small>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2">
                            <div class="tarjeta-resumen tarjeta-no-pagaron rounded p-3 shadow-sm">
                                <i class="fas fa-times-circle fa-2x mb-2 text-danger"></i>
                                <h3 class="mb-1 fw-bold">{{ number_format($totalNoPagaronENMGeneral) }}</h3>
                                <p class="mb-0 small fw-semibold">No Pagaron ENM</p>
                                <small class="d-block mt-1 opacity-85">{{ 100 - $porcentajePagoGeneral }}% del
                                    total</small>
                            </div>
                        </div>
                      
                        <div class="col-md-2 col-6 mb-2">
                            <div class="tarjeta-resumen tarjeta-ingresos rounded p-3 shadow-sm">
                                <i class="fas fa-dollar-sign fa-2x mb-2 text-primary"></i>
                                <h3 class="mb-1 fw-bold">
                                   
                                    <span class="text-primary">${{ number_format($totalIngresosENMGeneralUSD, 2) }}
                                        USD</span>
                                </h3>
                                <p class="mb-0 small fw-semibold">Ingresos ENM</p>
                                <small class="d-block mt-1 opacity-85">
                                    @if ($totalPagaronENMGeneral > 0)
                                          <span
                                            class="text-primary">${{ number_format($totalIngresosENMGeneralUSD / $totalPagaronENMGeneral, 2) }}
                                            USD promedio</span>
                                    @else
                                        $0.00 promedio
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mb-2">
                            <div class="tarjeta-resumen tarjeta-ingresos rounded p-3 shadow-sm">
                                <i class="fas fa-dollar-sign fa-2x mb-2 text-primary"></i>
                                <h3 class="mb-1 fw-bold">
                                   
                                    <span class="text-primary">${{ number_format($totalIngresosENMGeneralMXN, 2) }}
                                        MXN</span>
                                </h3>
                                <p class="mb-0 small fw-semibold">Ingresos ENM MXN</p>
                                <small class="d-block mt-1 opacity-85">
                                    @if ($totalPagaronENMGeneral > 0)
                                          <span
                                            class="text-primary">${{ number_format($totalIngresosENMGeneralMXN / $totalPagaronENMGeneral, 2) }}
                                            MXN promedio</span>
                                    @else
                                        $0.00 promedio
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Barra de progreso general -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold text-primary mb-0">
                                            <i class="fas fa-chart-line me-2"></i>
                                            Progreso General de Pagos ENM
                                        </h6>
                                        <span
                                            class="badge bg-primary ">{{ $porcentajePagoGeneral }}%</span>
                                    </div>
                                    <div class="progress shadow-sm" style="height: 25px; border-radius: 15px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-custom"
                                            style="width: {{ $porcentajePagoGeneral }}%; border-radius: 15px;"
                                            role="progressbar">
                                            <span class="fw-semibold text-white"
                                                style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                                {{ $totalPagaronENMGeneral }} de {{ $totalPasajerosGeneral }}
                                                pasajeros
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mt-3 text-center">
                                        <div class="col-4">
                                            <small class="text-muted d-block">Meta Ideal</small>
                                            <span class="fw-bold text-success">80%+</span>
                                        </div>
                                          <div class="col-4">
                                            
                                        </div>
                                        <div class="col-4">
                                           
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
@endif


<!-- Contenido Principal según tipo de vista -->

@if (isset($reservas))
    <div class="m-2">
        @include('livewire.admin.reportes.partials.pasajeros')
    </div>    
@endif

<x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
    message="Cargando datos..." />

<x-admin.modal-reserva-completa :reserva-completa="$this->reservaCompleta" />
</div>