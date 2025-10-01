<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
    @if ($actividades->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Pasajeros</th>
                        <th>Folio</th>
                        <th>Actividad</th>
                        <th>Cupón</th>
                        <th>Fecha</th>
                        <th>Pax</th>
                        <th>Tarifa</th>
                        <th>Credito</th>
                        <th>Balance</th>
                        <th>Estado</th>
                        <th>Factura</th>
                        <th>Pago</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($actividades as $actividad)
                        @foreach ($actividad->unidades as $unidad)
                            <tr class="{{ $unidad->status == 0 ? 'text-decoration-line-through text-danger' : '' }}">
                                <td>
                                    <button class="btn btn-sm btn-outline-primary text-start" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#pasajeros-actividad-{{ $unidad->idAU }}" aria-expanded="false"
                                        aria-controls="pasajeros-actividad-{{ $unidad->idAU }}">
                                        <i class="fas fa-users me-2"></i>

                                    </button>
                                </td>
                                <td>{{ $unidad->FolioDisplay }}</td>
                                <td>{{ $unidad->nombrePaquete }}</td>
                                <td>{{ $unidad->cupon->cupon->cupon ?? 'N/A' }}
                                </td>
                                <td>{{ $unidad->start ? \Carbon\Carbon::parse($unidad->start)->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td>{{ $unidad->pax }}</td>
                                <td>${{ number_format($unidad->tarifa, 2) }}
                                </td>
                                <td>${{ number_format($unidad->TotalCredito, 2) }}
                                </td>
                                <td>${{ number_format($unidad->TotalBalance, 2) }}
                                </td>
                                <td>{!! $unidad->Badge !!}</td>
                                <td>{!! $unidad->BadgeFactura !!}</td>
                                <td>{!! $unidad->BadgePagada !!}</td>

                            </tr>
                            <tr>
                                <td colspan="12" class="p-0">

                                    <div class="collapse mt-2" id="pasajeros-actividad-{{ $unidad->idAU }}">
                                        @if ($unidad->pasajeros && $unidad->pasajeros->count())
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Nombre
                                                            </th>
                                                            <th>Edad
                                                            </th>
                                                            <th>Pagó ENM
                                                            </th>
                                                            <th>Importe
                                                                ENM</th>

                                                            <th>Motivo
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($unidad->pasajeros as $pasajero)
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
                                                                        <span class="badge bg-success">
                                                                            <i class="fas fa-dollar-sign me-1"></i>
                                                                            ${{ number_format($pasajero->InfoPago['importe'], 2) }}
                                                                            {{ $pasajero->InfoPago['moneda'] }}
                                                                        </span>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if (!$pasajero->EnmPagado)
                                                                        <span class="text-warning">
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
                                            <div class="alert alert-warning mb-0">
                                                No hay pasajeros
                                                registrados para esta
                                                actividad.
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="12"><br></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            No hay actividades registradas para esta reserva.
        </div>
    @endif
</div>
