<div>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
     @if ($yates->count() > 0)
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Pasajeros</th>
                                                                        <th>Folio</th>
                                                                        <th>Yate</th>
                                                                        <th>Paquete</th>
                                                                        <th>Cupón</th>
                                                                        <th>Pax</th>
                                                                        <th>Fecha</th>
                                                                        <th>Muelle</th>

                                                                        <th>Tarifa</th>
                                                                        <th>Credito</th>
                                                                        <th>Balance</th>
                                                                        <th>Estado</th>
                                                                            <th>Factura</th>
                        <th>Pago</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($yates as $yate)
                                                                        <tr
                                                                            class="{{ $yate->status == 0 ? 'text-decoration-line-through text-danger' : '' }}">
                                                                            <td>
                                                                                <button
                                                                                    class="btn btn-sm btn-outline-primary text-start"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#pasajeros-yate-{{ $yate->idRY }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="pasajeros-yate-{{ $yate->idRY }}">
                                                                                    <i class="fas fa-users me-2"></i>

                                                                                </button>
                                                                            </td>
                                                                            <td>{{ $yate->idRY }}</td>
                                                                            <td>{{ $yate->yate->nombreYate ?? 'N/A' }}
                                                                            </td>
                                                                            <td>{{ $yate->paquete->nombrePaquete ?? 'N/A' }}
                                                                            <td>{{ $yate->cupon->cupon->cupon ?? 'N/A' }}
                                                                            </td>
                                                                            <td>{{ $yate->pax }}</td>
                                                                            <td>{{ $yate->start ? \Carbon\Carbon::parse($yate->start)->format('d/m/Y H:i') : 'N/A' }}
                                                                            </td>
                                                                            <td>{{ $yate->muelle->nombreMuelle ?? 'N/A' }}
                                                                            </td>

                                                                            <td>${{ number_format($yate->tarifa, 2) }}
                                                                            </td>
                                                                            <td>${{ number_format($yate->TotalCredito, 2) }}
                                                                            </td>
                                                                            <td>${{ number_format($yate->TotalBalance, 2) }}
                                                                            </td>
                                                                            <td>{!! $yate->Badge !!}</td>
                                                                            <td>{!! $yate->BadgeFactura  !!}</td>
                                                                            <td>{!! $yate->BadgePagada  !!}</td>

                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="14" class="p-0">

                                                                                <div class="collapse mt-2"
                                                                                    id="pasajeros-yate-{{ $yate->idRY }}">
                                                                                    @if ($yate->pasajeros && $yate->pasajeros->count())
                                                                                        <div class="table-responsive">
                                                                                            <table
                                                                                                class="table table-bordered table-sm mb-0">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th>Nombre
                                                                                                        </th>
                                                                                                        <th>Edad
                                                                                                        </th>
                                                                                                        <th>Estado
                                                                                                        </th>
                                                                                                        <th>Importe
                                                                                                            ENM</th>
                                                                                                        <th>Motivo</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    @foreach ($yate->pasajeros as $pasajero)
                                                                                                        <tr>
                                                                                                            <td>{{ $pasajero->nombre }}
                                                                                                            </td>
                                                                                                            <td>{{ $pasajero->edad }}
                                                                                                            </td>
                                                                                                            <td>
                                                                                                              {!! $pasajero->ENMBadge !!} 
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                @if ($pasajero->EnmPagado)
                                                                                                                    <span
                                                                                                                        class="badge bg-success">
                                                                                                                        <i
                                                                                                                            class="fas fa-dollar-sign me-1"></i>
                                                                                                                        ${{ number_format($pasajero->InfoPago['importe'], 2) }}
                                                                                                                        {{ $pasajero->InfoPago['moneda'] }}
                                                                                                                    </span>
                                                                                                                @else
                                                                                                                    -
                                                                                                                @endif
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                @if (!$pasajero->EnmPagado)
                                                                                                                    <span
                                                                                                                        class="text-warning">
                                                                                                                        <i
                                                                                                                            class="fas fa-exclamation-triangle me-1"></i>
                                                                                                                        {{ $pasajero->motivo ?? 'No especificado' }}
                                                                                                                    </span>
                                                                                                                @endif
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @endforeach
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>
                                                                                    @else
                                                                                        <div
                                                                                            class="alert alert-warning mb-0">
                                                                                            No hay pasajeros
                                                                                            registrados para esta
                                                                                            actividad.
                                                                                        </div>
                                                                                    @endif
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                     
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            No hay yates registrados para esta reserva.
                                                        </div>
                                                    @endif
</div>