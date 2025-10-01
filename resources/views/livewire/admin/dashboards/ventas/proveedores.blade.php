<div>


    <!-- Tabla de Ventas-->

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Proveedores</h4>
            <p class="text-muted mb-0">Ranking de proveedores por rendimiento y utilidad</p>
        </div>
        <div class="card-body">


              @if (count($proveedores) > 0)
                                    <div class="table-responsive">
                                        <table class="table" id="proveedores-table">
                                            <thead class="table-info">
                                                <tr>

                                                    <th>Proveedor</th>

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
                                                @forelse($proveedores as $index => $item)
                                                    <tr>

                                                        <td>
                                                            <div class="productimgname">

                                                                    <div class="view-product bg-primary-light">
                                                                        <i class="ti ti-building-store text-primary"></i>
                                                                    </div>

                                                                <span class="fw-bold">{{ $item['proveedor'] }}</span>
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
                                                        <td
                                                            class="fw-bold {{ $item['utilidad'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                            ${{ number_format($item['utilidad'], 2) }}
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="badge {{ $item['utilidad_porcentaje'] >= 20 ? 'bg-success' : ($item['utilidad_porcentaje'] >= 10 ? 'bg-warning' : 'bg-danger') }}">
                                                                {{ number_format($item['utilidad_porcentaje'], 1) }}%
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="13" class="text-center py-4">
                                                            <div class="empty-state">
                                                                <i
                                                                    class="ti ti-chart-bar-off fa-3x text-muted mb-3"></i>
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
                                                    <td>{{ number_format($totales['Proveedor']['horas']) }}</td>
                                                    <td>{{ number_format($totales['Proveedor']['pax']) }}</td>
                                                    <td class="fw-bold">${{ number_format($totales['Proveedor']['ventaTotal'], 2) }}</td>
                                                    <td class="text-danger">${{ number_format($totales['Proveedor']['costo'] , 2) }}</td>
                                                    <td class="text-warning">${{ number_format($totales['Proveedor']['descuento'], 2) }}</td>
                                                    <td>{{ number_format($totales['Proveedor']['enm_total'] , 2) }}</td>
                                                    <td class="text-center text-warning">{{ number_format($totales['Proveedor']['enm_no_pagados_total'] , 2) }}</td>
                                                    <td>{{ number_format($totales['Proveedor']['fotos_ingresos'] , 2) }}</td>
                                                    <td class="fw-bold text-success">${{ number_format($totales['Proveedor']['ventaIngresos'] , 2) }}</td>
                                                    <td class="fw-bold text-success">${{ number_format($totales['Proveedor']['utilidad'] , 2) }}</td>
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
