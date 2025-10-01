   <div class="card">
            <div class="card-header">
                <div class="card-title">Estadisticas</div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        @if (!empty($topToursVendidos['detalles']))
                            <h5 class="mb-3">Top 15 Tours Más Vendidos</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Tour</th>

                                            <th class="text-center">Pax</th>
                                            <th class="text-center">Ventas</th>
                                            <th class="text-center">Utilidad</th>
                                            <th class="text-center">% del Top 15</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($topToursVendidos['detalles'] as $index => $tour)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $tour['tour'] }}</td>

                                                <td class="text-center">{{ $tour['pax'] }}</td>
                                                <td class="text-center">{{ number_format($tour['ventas'], 2) }}</td>
                                                <td class="text-center">{{ number_format($tour['utilidad'], 2) }}</td>
                                                <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ $tour['porcentaje'] }}%; border-radius:8px; min-width: 24px;"
                                                            aria-valuenow="{{ $tour['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($tour['porcentaje'] >=30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $tour['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($tour['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $tour['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#2196f3; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $tour['porcentaje'] }}%</span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="2" class="text-end">Totales:</th>
                                            <th class="text-center">
                                                {{ $topToursVendidos['totalPax'] }}
                                            </th>
                                            <th class="text-center">
                                                {{ number_format($topToursVendidos['totalVentas'], 2) }}
                                            </th>
                                             <th class="text-center">
                                                {{ number_format($topToursVendidos['totalUtilidad'], 2) }}
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if (!empty($topLocacionesVentas['detalles']))
                            <h5 class="mb-3">Top 10 Locaciones con Más Ventas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Locación</th>

                                            <th class="text-center"> Pax</th>
                                            <th class="text-center">Ventas</th>
                                            <th class="text-center">Utilidad</th>

                                            <th class="text-center">% del Top 10</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($topLocacionesVentas['detalles'] as $index => $locacion)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $locacion['locacion'] }}</td>

                                                <td class="text-center">{{ $locacion['totalPax'] }}</td>
                                                <td class="text-center">
                                                   $ {{ number_format($locacion['totalVentas'], 2) }}
                                                </td>
                                                   <td class="text-center">
                                                   $ {{ number_format($locacion['utilidad'], 2) }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar bg-success" role="progressbar"
                                                            style="width: {{ $locacion['porcentaje'] }}%; border-radius:8px; min-width: 24px;"
                                                            aria-valuenow="{{ $locacion['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($locacion['porcentaje'] >= 30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $locacion['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($locacion['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $locacion['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#4caf50; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $locacion['porcentaje'] }}%
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="2" class="text-end">Totales:</th>
                                            <th class="text-center">
                                                {{ $topLocacionesVentas['totalPax'] }}
                                            </th>
                                            <th class="text-center">
                                               $ {{ number_format($topLocacionesVentas['totalVentas'], 2) }}
                                            </th>
                                              <th class="text-center">
                                               $ {{ number_format($topLocacionesVentas['totalUtilidad'], 2) }}
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        @if (!empty($topProveedoresVentas['detalles']))
                            <h5 class="mb-3">Top 10 Proveedores con Más Ventas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Proveedor</th>

                                            <th class="text-center">Pax</th>
                                            <th class="text-center">Ventas</th>
                                            <th class="text-center">Utilidad</th>
                                            <th class="text-center">% del Top 10</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topProveedoresVentas['detalles'] as $index => $proveedor)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $proveedor['proveedor'] }}</td>

                                                <td class="text-center">{{ $proveedor['pax'] }}</td>
                                                <td class="text-center">
                                                  $ {{ number_format($proveedor['ventas'], 2) }}
                                                </td>
                                                 <td class="text-center">
                                                  $ {{ number_format($proveedor['utilidad'], 2) }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: {{ $proveedor['porcentaje'] }}%; border-radius:8px; min-width: 24px;"
                                                            aria-valuenow="{{ $proveedor['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($proveedor['porcentaje'] >= 30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $proveedor['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($proveedor['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $proveedor['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#ff9800; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $proveedor['porcentaje'] }}%
                                                            </span>
                                                        @endif

                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="2" class="text-end">Totales:</th>
                                            <th class="text-center">
                                                {{ $topProveedoresVentas['totalPax'] }}
                                            <th class="text-center">
                                                $ {{ number_format($topProveedoresVentas['totalVentas'], 2) }}
                                            </th>
                                              <th class="text-center">
                                                $ {{ number_format($topProveedoresVentas['totalUtilidad'], 2) }}
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        @if (!empty($topProveedoresComisiones['detalles']))
                            <h5 class="mb-3">Top 10 Proveedores con Más Comisiones Generadas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Proveedor</th>


                                            <th class="text-center">Comisiones</th>
                                            <th class="text-center">Utilidad</th>
                                            <th class="text-center">% del Top 10</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topProveedoresComisiones['detalles'] as $index => $proveedor)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $proveedor['proveedor'] }}</td>


                                                <td class="text-center">
                                                    $ {{ number_format($proveedor['comisiones'], 2) }}
                                                </td>
                                                <td class="text-center">
                                                    $ {{ number_format($proveedor['utilidad'], 2) }}
                                                </td>
                                                <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar bg-warning" role="progressbar"
                                                            style="width: {{ $proveedor['porcentaje'] }}%; border-radius:8px; min-width: 24px;"
                                                            aria-valuenow="{{ $proveedor['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($proveedor['porcentaje'] >=30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $proveedor['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($proveedor['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $proveedor['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#ff9800; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $proveedor['porcentaje'] }}%
                                                            </span>
                                                        @endif

                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="2" class="text-end">Totales:</th>

                                            <th class="text-center">
                                                $ {{ number_format($topProveedoresComisiones['totalComisiones'], 2) }}
                                            </th>
                                             <th class="text-center">
                                                $ {{ number_format($topProveedoresComisiones['totalUtilidad'], 2) }}
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        @if (!empty($topVendedoresVentasPax['detalles']))
                            <h5 class="mb-3">Top 10 Vendedores con Más Ventas (PAX)</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Vendedor</th>

                                            <th class="text-center">Pax</th>
                                            <th class="text-center">Ventas</th>
                                            <th class="text-center">Utilidad</th>
                                            <th class="text-center">% del Top 10</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topVendedoresVentasPax['detalles'] as $index => $vendedor)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $vendedor['nombre'] }}</td>

                                                <td class="text-center">{{ $vendedor['pax'] }}</td>
                                                <td class="text-center">
                                                    $ {{ number_format($vendedor['ventas'], 2) }}</td>
                                                     <td class="text-center">
                                                    $ {{ number_format($vendedor['utilidad'], 2) }}</td>
                                                <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{ $vendedor['porcentaje'] }}%; border-radius:8px; min-width: 24px;"
                                                            aria-valuenow="{{ $vendedor['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($vendedor['porcentaje'] >= 30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $vendedor['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($vendedor['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $vendedor['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#060528FF; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $vendedor['porcentaje'] }}%</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="2" class="text-end">Totales:</th>
                                            <th class="text-center">
                                                {{ $topVendedoresVentasPax['totalPax'] }}
                                            </th>
                                            <th class="text-center">
                                                $ {{ number_format($topVendedoresVentasPax['totalVentas'], 2) }}
                                            </th>
                                              <th class="text-center">
                                                $ {{ number_format($topVendedoresVentasPax['totalUtilidad'], 2) }}
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if (!empty($topVendedoresVentas['detalles']))
                            <h5 class="mb-3">Top Vendedores con Más Ventas (TPV)</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Vendedor</th>


                                            <th class="text-center">Ventas</th>
                                            <th class="text-center">Utilidad</th>
                                            <th class="text-center">% del Top 10</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topVendedoresVentas['detalles'] as $index => $vendedor)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $vendedor['nombre'] }}</td>


                                                <td class="text-center">
                                                    $ {{ number_format($vendedor['ventas'], 2) }}</td>
                                                       <td class="text-center">
                                                    $ {{ number_format($vendedor['utilidad'], 2) }}</td>
                                                <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar bg-primary" role="progressbar"
                                                            style="width: {{ $vendedor['porcentaje'] }}%; border-radius:8px; min-width: 24px;"
                                                            aria-valuenow="{{ $vendedor['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($vendedor['porcentaje'] >=30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $vendedor['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($vendedor['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $vendedor['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#060528FF; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $vendedor['porcentaje'] }}%</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="2" class="text-end">Totales:</th>

                                            <th class="text-center">
                                                $ {{ number_format($topVendedoresVentas['totalVentas'], 2) }}
                                            </th>
                                             <th class="text-center">
                                                $ {{ number_format($topVendedoresVentas['totalUtilidad'], 2) }}
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-md-6">
                        @if (!empty($topVendedoresUtilidades['detalles']))

                            <h5 class="mb-3">Top 10 Vendedores con Más Utilidades Generadas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Vendedor</th>


                                            <th class="text-center">Total Utilidades</th>
                                            <th class="text-center">% del Top 10</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topVendedoresUtilidades['detalles'] as $index => $vendedor)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $vendedor['nombre'] }}</td>
                                                <td class="text-center">
                                                    $ {{ number_format($vendedor['utilidad'], 2) }}</td>
                                                <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $vendedor['porcentaje'] }}%; border-radius:8px; min-width: 24px; background-color: #ff5722;"
                                                            aria-valuenow="{{ $vendedor['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($vendedor['porcentaje'] >=30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $vendedor['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($vendedor['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $vendedor['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#060528FF; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $vendedor['porcentaje'] }}%</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="2" class="text-end">Totales:</th>

                                            <th class="text-center">
                                                $ {{ number_format($topVendedoresUtilidades['totalUtilidad'], 2) }}
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>


                        @endif



                    </div>

                    <div class="col-md-6">
                        @if (!empty($topVendedoresComisiones['detalles']))

                            <h5 class="mb-3">Top Vendedores con Más Comisiones Generadas</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Vendedor</th>


                                            <th class="text-center">Total Comisiones</th>
                                            <th class="text-center">% del Top 10</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topVendedoresComisiones['detalles'] as $index => $vendedor)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $vendedor['nombre'] }}</td>
                                                <td class="text-center">
                                                    $ {{ number_format($vendedor['comision'], 2) }}</td>
                                                <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $vendedor['porcentaje'] }}%; border-radius:8px; min-width: 24px; background-color: #ff5722;"
                                                            aria-valuenow="{{ $vendedor['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($vendedor['porcentaje'] >=30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $vendedor['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($vendedor['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $vendedor['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#060528FF; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $vendedor['porcentaje'] }}%</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>

                                        <tr>
                                            <th colspan="2" class="text-end">Totales:</th>

                                            <th class="text-center">
                                                $ {{ number_format($topVendedoresComisiones['totalComisiones'], 2) }}
                                            </th>
                                            <th></th>
                                        </tr>

                                    </tfoot>
                                </table>
                            </div>


                        @endif



                    </div>

                </div>




                <div class="row mt-4">
                    <div class="col-md-6">
                        @if (!empty($topMetodosPagos['detalles']))

                            <h5 class="mb-3">Top Métodos de Pago Más Utilizados</h5>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0" style="min-width:400px;">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>Método de Pago</th>
                                            <th>Pagos</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topMetodosPagos['detalles'] as $index => $metodo)
                                            <tr>
                                                <td class="fw-bold text-primary">{{ $index + 1 }}</td>
                                                <td>{{ $metodo['metodo'] }}</td>
                                                <td>{{ $metodo['pagos'] }}</td>
                                               <td class="text-center">
                                                    <div class="progress"
                                                        style="height:18px; background:#f5f5f5; border-radius:8px; position:relative;">
                                                        <div class="progress-bar" role="progressbar"
                                                            style="width: {{ $metodo['porcentaje'] }}%; border-radius:8px; min-width: 24px; background-color: #224EFFFF;"
                                                            aria-valuenow="{{ $metodo['porcentaje'] }}"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            @if ($metodo['porcentaje'] >= 30)
                                                                <span
                                                                    style="font-size:13px; color:#fff; font-weight:500;">{{ $metodo['porcentaje'] }}%</span>
                                                            @endif
                                                        </div>
                                                        @if ($metodo['porcentaje'] < 30)
                                                            <span
                                                                style="position:absolute; left:calc({{ $metodo['porcentaje'] }}% + 6px); top:0; font-size:13px; color:#060528FF; font-weight:600; background:#fff; padding:0 4px; border-radius:4px;">{{ $metodo['porcentaje'] }}%</span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>


                        @endif
                    </div>
                </div>





            </div>
        </div>
