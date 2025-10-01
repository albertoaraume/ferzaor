<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->
    @if ($traslados->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Transportación</th>                    
                        <th>Pickup</th>
                        <th>Dropoff</th>
  
                        <th>Pax</th>
                        <th>Cupón</th>
                        <th>Tarifa</th>
                        <th>Balance</th>
                        <th>Detalles</th>
                        <th>Estado</th>
                        <th>Factura</th>
                        <th>Pago</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($traslados as $traslado)
                        <tr class="{{ $traslado->status == 0 ? 'text-decoration-line-through text-danger' : '' }}">
                            <td>{{ $traslado->transportacion->nombreTransportacion ?? 'N/A' }}
                            </td>
                            <td>
                                {{ $traslado->nombreLocacionPickUp ?? 'N/A' }}
                                <br>
                                <small>
                                    {{ \Carbon\Carbon::parse($traslado->fechaArrival)->format('d/m/Y') }} | {{ \Carbon\Carbon::parse($traslado->horaArrival)->format('H:i') }}
                                </small>
                            </td>
                            <td>
                                 {{ $traslado->nombreLocacionDropOff ?? 'N/A' }}
                                <br>
                                <small>
                                    {{ \Carbon\Carbon::parse($traslado->fechaDeparture)->format('d/m/Y') }} | {{ \Carbon\Carbon::parse($traslado->horaDeparture)->format('H:i') }}
                                </small>
                            </td>
                        
                            <td>{{ $traslado->cantPax }}</td>
                            <td>{{ $traslado->cupon->cupon->cupon ?? 'N/A' }}
                            </td>
                            <td>${{ number_format($traslado->tarifa, 2) }}
                            </td>
                            <td>${{ number_format($traslado->balance, 2) }}
                            </td>

                            <td>{{ $traslado->detalles ?? 'N/A' }}</td>
                            <td>{!! $traslado->Badge !!}</td>
                            <td>{!! $traslado->BadgeFactura !!}</td>
                            <td>{!! $traslado->BadgePagada !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            No hay traslados registrados para esta reserva.
        </div>
    @endif
</div>
