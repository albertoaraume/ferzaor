    @if ($corte->productos->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-tool me-2"></i>Venta de Productos
                ({{ $corte->productos->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Cupon</th>
                            <th>Producto</th>
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
                        @foreach ($corte->productos as $producto)
                         @php                               
                                $cantidad += $producto->cantidad;
                                $descuento += $producto->descuento;
                                $importe += $producto->importe;
                            @endphp
                            <tr>
                                <td>{{ $producto->idVP }}</td>
                                <td>{{ $producto->cupon?->cupon?->numCupon ?? '' }}</td>
                                <td>{{ $producto->producto->nombreProducto ?? 'N/A' }}</td>
                                <td>{{ $venta->cliente->nombreComercial ?? 'Público General' }}</td>
                                <td>${{ number_format($producto->precio, 2) }}</td>
                                <td>{{ $producto->cantidad }}</td>
                                <td>${{ number_format($producto->descuento, 2) }}</td>
                                <td>$0.00</td>
                                <td>${{ number_format($producto->importe, 2) }}</td>
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