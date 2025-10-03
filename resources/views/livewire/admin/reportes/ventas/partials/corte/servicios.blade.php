    @if ($corte->servicios->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-tool me-2"></i>Venta de Servicios
                ({{ $corte->servicios->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cupon</th>
                            <th>Servicio</th>
                            <th>Cliente</th>
                            <th>Precio Unit.</th>
                            <th>Cantidad</th>
                            <th>Descuento</th>
                            <th>Credito</th>
                            <th>Importe</th>

                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cantidad = 0;
                            $descuento = 0;
                            $importe = 0;
                        @endphp
                        @foreach ($corte->servicios as $servicio)
                            @php
                                $cantidad += $servicio->cantidad;
                                $descuento += $servicio->descuento;
                                $importe += $servicio->importe;
                            @endphp
                             <tr class="{{ $servicio->edo == false ? 'table-danger' : '' }}"
                      style="{{ $servicio->edo == false ? 'text-decoration: line-through; text-decoration-color: #dc3545; text-decoration-thickness: 2px;' : '' }}">
                                <td>{{ $servicio->idVS }}</td>
                                <td>{{ $servicio->cupon?->cupon?->numCupon ?? '' }}</td>
                                <td>{{ $servicio->servicio->nombreServicio ?? 'N/A' }}</td>
                                <td>{{ $venta->cliente->nombreComercial ?? 'Público General' }}</td>
                                <td>${{ number_format($servicio->precio, 2) }}</td>
                                <td>{{ $servicio->cantidad }}</td>
                                <td>${{ number_format($servicio->descuento, 2) }}</td>
                                <td>$0.00</td>
                                <td>${{ number_format($servicio->importe, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="5" class="text-end">Totales:</th>
                            <th>{{ $cantidad }}</th>
                            <th>${{ number_format($descuento, 2) }}</th>
                            <th>$0.00</th>
                            <th>${{ number_format($importe, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endif
