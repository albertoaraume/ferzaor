<div>
    <!-- An unexamined life is not worth living. - Socrates -->
     @if ($servicios->count() > 0)
                                                        <div class="table-responsive">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Folio</th>
                                                                        <th>Servicio</th>
                                                                        <th>Código</th>
                                                                        <th>Cupón</th>
                                                                        <th>Precio</th>

                                                                        <th>Credito</th>
                                                                        <th>Balance</th>


                                                                        <th>Estado</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($reservaCompleta->adicionales as $servicio)
                                                                        <tr
                                                                            class="{{ $servicio->status == 0 ? 'text-decoration-line-through text-danger' : '' }}">
                                                                            <td>{{ $servicio->FolioDisplay }}</td>
                                                                            <td>{{ $servicio->nombreServicio }}</td>
                                                                            <td>{{ $servicio->codigo }}</td>
                                                                            <td>{{ $servicio->cupon->cupon->cupon ?? 'N/A' }}
                                                                            </td>

                                                                            <td>${{ number_format($servicio->precio, 2) }}
                                                                            </td>
                                                                            <td>${{ number_format($servicio->TotalCredito, 2) }}
                                                                            <td>${{ number_format($servicio->TotalBalance, 2) }}
                                                                            </td>
                                                                            <td>{!! $servicio->Badge !!}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            No hay servicios adicionales registrados para esta reserva.
                                                        </div>
                                                    @endif
</div>