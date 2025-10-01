<div>


    <!-- Tabla de Ventas-->

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Agencias</h4>
            <p class="text-muted mb-0">Ranking de agencias por rendimiento y utilidad</p>
        </div>
        <div class="card-body">


            @if (count($agencias) > 0)
                <div class="table-responsive">
                    <table class="table" id="agencias-table">
                        <thead class="table-info">
                            <tr>

                                <th>Agencia</th>

                                <th>Horas</th>
                                <th>PAX</th>
                                <th>Total</th>
                                <th>Costo</th>
                                <th>Descuento</th>
                                <th>ENMs</th>
                                <th>ENMs S/C</th>
                                <th>Fotos</th>
                                <th>Ingresos</th>
                                <th>Utilidad</th>
                                <th>Utilidad %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($agencias as $index => $item)
                                <tr>

                                    <td>
                                        <div class="productimgname">

                                            <div class="view-product bg-primary-light toggle-agencias"
                                                data-agencia-id="{{ $index }}">
                                                <i class="ti ti-corner-down-right text-primary"></i>
                                            </div>


                                            <span class="fw-bold">{{ $item['agencia'] }}</span>




                                            </span>
                                        </div>
                                    </td>

                                    <td>{{ number_format($item['horas'], 1) }}</td>
                                    <td>{{ number_format($item['pax']) }}</td>
                                    <td class="fw-bold">${{ number_format($item['ventaTotal'], 2) }}
                                    </td>
                                    <td class="text-danger">${{ number_format($item['costo'], 2) }}
                                    </td>
                                    <td class="text-warning">
                                        ${{ number_format($item['descuento'], 2) }}
                                    </td>
                                    <td>{{ number_format($item['enm_total'], 2) }}<br><small>{!! $item['enm_label'] !!}</small>
                                    </td>
                                    <td class="text-center text-danger">{!! $item['enm_no_pagados_label'] !!}
                                    </td>
                                    <td>{{ number_format($item['fotos_ingresos'], 2) }}</td>
                                    <td class="fw-bold text-success">
                                        ${{ number_format($item['ventaIngresos'], 2) }}</td>
                                    <td class="fw-bold {{ $item['utilidad'] >= 0 ? 'text-success' : 'text-danger' }}">
                                        ${{ number_format($item['utilidad'], 2) }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $item['utilidad_porcentaje'] >= 20 ? 'bg-success' : ($item['utilidad_porcentaje'] >= 10 ? 'bg-warning' : 'bg-danger') }}">
                                            {{ number_format($item['utilidad_porcentaje'], 1) }}%
                                        </span>
                                    </td>
                                </tr>
                                <!-- Fila expandible para actividades -->
                                <tr class="actividades-row d-none" data-agencia-id="{{ $index }}">
                                    <td colspan="12" class="p-0">
                                        <div class="collapse-content bg-light p-3">


                                            @if (isset($item['actividades']) && count($item['actividades']) > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered">
                                                        <thead class="table-secondary">
                                                            <tr>
                                                                <th style="width: 200px;">Producto</th>
                                                                <th>Horas</th>
                                                                <th>PAX</th>
                                                                <th>Total</th>
                                                                <th>Costo</th>
                                                                <th>Descuento</th>
                                                                <th>ENMs</th>
                                                                <th>Fotos</th>
                                                                <th>Ingresos</th>
                                                                <th>Utilidad</th>
                                                                <th>Utilidad %</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($item['actividades'] as $actividad)
                                                                <tr>
                                                                    <td>
                                                                        <small class="text-muted">

                                                                            <div class="view-product bg-primary-light">
                                                                                @if ($actividad['tipo'] === 'Actividad')
                                                                                    <i
                                                                                        class="fas fa-running  text-primary"></i>
                                                                                @elseif($actividad['tipo'] === 'Yate')
                                                                                    <i
                                                                                        class="fas fa-ship text-primary"></i>
                                                                                @elseif($actividad['tipo'] === 'Servicio')
                                                                                    <i
                                                                                        class="fas fa-concierge-bell text-primary"></i>
                                                                                @endif
                                                                                {{ $actividad['nombre'] }}
                                                                            </div>
                                                                        </small>
                                                                    </td>
                                                                    <td><small>{{ number_format($actividad['horas'], 1) }}</small>
                                                                    </td>
                                                                    <td><small>{{ number_format($actividad['pax']) }}</small>
                                                                    </td>
                                                                    <td><small>${{ number_format($actividad['total'], 2) }}</small>
                                                                    </td>
                                                                    <td><small
                                                                            class="text-danger">${{ number_format($actividad['costo'], 2) }}</small>
                                                                    </td>
                                                                    <td><small
                                                                            class="text-warning">${{ number_format($actividad['descuento'], 2) }}</small>
                                                                    </td>
                                                                    <td><small>{{ number_format($actividad['enm'], 2) }}</small>
                                                                    </td>
                                                                    <td><small>{{ number_format($actividad['fotos'], 2) }}</small>
                                                                    </td>
                                                                    <td><small
                                                                            class="text-success">${{ number_format($actividad['ingresos'], 2) }}</small>
                                                                    </td>
                                                                    <td>
                                                                        <small
                                                                            class="{{ $actividad['utilidad'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                                            ${{ number_format($actividad['utilidad'], 2) }}
                                                                        </small>
                                                                    </td>
                                                                    <td>
                                                                        <span
                                                                            class="badge badge-sm {{ $actividad['utilidad_porcentaje'] >= 20 ? 'bg-success' : ($actividad['utilidad_porcentaje'] >= 10 ? 'bg-warning' : 'bg-danger') }}">
                                                                            {{ number_format($actividad['utilidad_porcentaje'], 1) }}%
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="text-center py-3">
                                                    <small class="text-muted">No hay actividades registradas para esta
                                                        agencia</small>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="ti ti-chart-bar-off fa-3x text-muted mb-3"></i>
                                            <h5>No hay datos disponibles</h5>
                                            <p class="text-muted">No se encontraron indicadores para
                                                los
                                                filtros
                                                seleccionados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="table-primary fw-bold">

                                <td></td>
                                <td>{{ number_format($totales['Agencia']['horas']) }}</td>
                                <td>{{ number_format($totales['Agencia']['pax']) }}</td>
                                <td class="fw-bold">${{ number_format($totales['Agencia']['ventaTotal'], 2) }}</td>
                                <td class="text-danger">${{ number_format($totales['Agencia']['costo'], 2) }}</td>
                                <td class="text-warning">${{ number_format($totales['Agencia']['descuento'], 2) }}</td>
                                <td>{{ number_format($totales['Agencia']['enm_total'], 2) }}</td>
                                <td class="text-center text-warning">
                                    {{ number_format($totales['Agencia']['enm_no_pagados_total'], 2) }}</td>
                                <td>{{ number_format($totales['Agencia']['fotos_ingresos'], 2) }}</td>
                                <td class="fw-bold text-success">
                                    ${{ number_format($totales['Agencia']['ventaIngresos'], 2) }}</td>
                                <td class="fw-bold text-success">
                                    ${{ number_format($totales['Agencia']['utilidad'], 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center">
                    No hay productos para mostrar con los filtros seleccionados.
                </div>
            @endif


        </div>
    </div>







</div>
