<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->

                                @if (count($actividades) > 0)
                                    <div class="table-responsive">
                                        <table class="table" id="productos-actividades-table">
                                            <thead class="table-info">
                                                <tr>

                                                    <th>Actividad</th>

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
                                                @forelse($actividades as $index => $item)
                                                    <tr>

                                                        <td>
                                                            <div class="productimgname">

                                                                    <div class="view-product bg-primary-light">
                                                                        <i class="ti ti-swimming text-primary"></i>
                                                                    </div>

                                                                <span class="fw-bold">{{ $item['producto'] }}</span>
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
                                               <tr class="fw-bold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                    <td></td>
                                                    <td>{{ number_format($totales['Actividad']['horas']) }}</td>
                                                    <td>{{ number_format($totales['Actividad']['pax']) }}</td>
                                                    <td class="fw-bold">${{ number_format($totales['Actividad']['ventaTotal'], 2) }}</td>
                                                    <td class="text-danger">${{ number_format($totales['Actividad']['costo'] , 2) }}</td>
                                                    <td class="text-warning">${{ number_format($totales['Actividad']['descuento'], 2) }}</td>
                                                    <td>{{ number_format($totales['Actividad']['enm_total'] , 2) }}</td>
                                                    <td class="text-center text-warning">{{ number_format($totales['Actividad']['enm_no_pagados_total'] , 2) }}</td>
                                                    <td>{{ number_format($totales['Actividad']['fotos_ingresos'] , 2) }}</td>
                                                    <td class="fw-bold text-success">${{ number_format($totales['Actividad']['ventaIngresos'] , 2) }}</td>
                                                    <td class="fw-bold text-success">${{ number_format($totales['Actividad']['utilidad'] , 2) }}</td>
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
