  @if ($corte->tours->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fas fa-map me-2"></i>Tours Vendidos
                    ({{ $corte->tours->count() }})
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cupon</th>
                                <th>Tour</th>
                                <th>Cliente</th>
                                <th>Precio Unit.</th>
                                <th>Cantidad</th>
                                <th>Descuento</th>
                                <th>Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php

                            $precio = 0;
                            $descuento = 0;
                            $importe = 0;
                            $pax = 0;
                            @endphp
                            @foreach ($corte->tours as $tour)
                                @php
                                $precio += $tour->precio;
                                $descuento += $tour->descuento;
                                $importe += $tour->importe;
                                $pax += $tour->cantidad;
                                @endphp
                                <tr>
                                    <td>{{ $tour->idVT }}</td>
                                    <td>{{ $tour->cupon?->cupon?->numCupon ?? '' }}</td>
                                    <td>{{ $tour->descripcion ?? 'N/A' }}</td>
                                    <td>{{ $venta->cliente->nombreComercial ?? 'Público General' }}</td>
                                    <td>${{ number_format($tour->precio, 2) }}</td>
                                    <td>{{ $tour->cantidad }}</td>
                                    <td>${{ number_format($tour->descuento, 2) }}</td>

                                    <td>${{ number_format($tour->importe, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Totales:</th>
                                <th>${{ number_format($precio, 2) }}</th>
                                <th>{{ $pax }}</th>
                                <th>${{ number_format($descuento, 2) }}</th>
                                <th>${{ number_format($importe, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endif
