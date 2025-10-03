<!-- Actividades / Check-ins -->
@if ($corte->checkinsActividadesRelacionadas()->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-list-check me-2"></i>Registro de Actividades / Check-ins
                ({{ $corte->checkinsActividadesRelacionadas()->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <td></td>
                            <td>Status</td>

                            <td>Folio</td>
                            <td>Cupon</td>
                            <td>Pagada</td>
                            <td>Factura</td>
                            <td>Cliente</td>
                            <td>Agencia</td>
                            <td>Actividad</td>


                            <td colspan="2" class="text-center">Tarifa</td>
                            <td>Pax</td>
                            <td colspan="2" class="text-center">Descuento</td>
                            <td colspan="2" class="text-center">Credito</td>
                            <td colspan="2" class="text-center">Balance</td>
                            <td colspan="2" class="text-center">Abono</td>
                            <td colspan="2" class="text-center">Saldo</td>
                        </tr>
                        <tr>
                            <td colspan="9"></td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td></td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                             <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                             <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                    </thead>
                    <tbody>
                        @php
                            $tarifaUSD = 0;
                            $tarifaMXN = 0;
                            $descuentoUSD = 0;
                            $descuentoMXN = 0;
                            $creditoUSD = 0;
                            $creditoMXN = 0;
                            $balanceUSD = 0;
                            $balanceMXN = 0;
                            $abonoUSD = 0;
                            $abonoMXN = 0;
                            $saldoUSD = 0;
                            $saldoMXN = 0;
                        @endphp
                        @foreach ($corte->checkinsActividadesRelacionadas()->sortByDesc('created_at') as $act)
                            @php
                                if ($act->c_moneda == 'USD') {
                                    $tarifaUSD += $act->tarifa;
                                    $descuentoUSD += $act->descuento;
                                    $creditoUSD += $act->TotalCredito;
                                    $balanceUSD += $act->TotalBalance;
                                    $abonoUSD += $act->Pagos;
                                    $saldoUSD += $act->Saldo;
                                } elseif ($act->c_moneda == 'MXN') {
                                    $tarifaMXN += $act->tarifa;
                                    $descuentoMXN += $act->descuento;
                                    $creditoMXN += $act->TotalCredito;
                                    $balanceMXN += $act->TotalBalance;
                                    $abonoMXN += $act->Pagos;
                                    $saldoMXN += $act->Saldo;
                                }
                            @endphp

                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            id="dropdownMenuButton{{ $act->idAU }}" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $act->idAU }}">
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verDetalleActividad({{ $act->idAU }})">Detalles</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verReservaCompleta({{ $act->actividad->reserva_idReserva }})">Ver
                                                    reserva</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{!! $act->Badge !!}</td>
                                <td>{{ $act->FolioDisplay }}</td>
                                <td>{{ $act->CuponDisplay }}</td>
                                <td>{!! $act->BadgePagada !!}</td>
                                <td>{!! $act->BadgeFactura !!}</td>
                                <td>{{ $act->ClienteDisplay }}</td>
                                <td>{{ $act->AgenciaDisplay }}</td>
                                <td> <strong>{{ $act->ActividadDisplay }}</strong>
                                    <br>
                                    <small>{{ \Carbon\Carbon::parse($act->start)->format('d-m-Y H:i') }}</small>

                                </td>

                                <td
                                    class="{{ $act->c_moneda == 'USD' && $act->tarifa > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'USD' ? $act->tarifa : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $act->c_moneda == 'MXN' && $act->tarifa > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'MXN' ? $act->tarifa : 0, 2) }}</strong>
                                </td>
                                <td>{{ $act->PaxDisplay }}</td>
                                <td
                                    class="{{ $act->c_moneda == 'USD' && $act->descuento > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'USD' ? $act->descuento : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $act->c_moneda == 'MXN' && $act->descuento > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'MXN' ? $act->descuento : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $act->c_moneda == 'USD' && $act->TotalCredito > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'USD' ? $act->TotalCredito : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $act->c_moneda == 'MXN' && $act->TotalCredito > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'MXN' ? $act->TotalCredito : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $act->c_moneda == 'USD' && $act->TotalBalance > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'USD' ? $act->TotalBalance : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $act->c_moneda == 'MXN' && $act->TotalBalance > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'MXN' ? $act->TotalBalance : 0, 2) }}</strong>
                                </td>
                                 <td
                                    class="{{ $act->c_moneda == 'USD' && $act->Pagos > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'USD' ? $act->Pagos : 0, 2) }}</strong>
                                </td>
                                    <td
                                        class="{{ $act->c_moneda == 'MXN' && $act->Pagos > 0 ? 'text-info' : 'text-muted' }}">
                                        <strong>${{ number_format($act->c_moneda == 'MXN' ? $act->Pagos : 0, 2) }}</strong>
                                    </td>
                                <td
                                    class="{{ $act->c_moneda == 'USD' && $act->Saldo > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'USD' ? $act->Saldo : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $act->c_moneda == 'MXN' && $act->Saldo > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($act->c_moneda == 'MXN' ? $act->Saldo : 0, 2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="9" class="text-end"><strong>TOTAL:</strong></td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($tarifaUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($tarifaMXN, 2) }}</strong>
                            </td>
                            <td></td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($descuentoUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($descuentoMXN, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($creditoUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($creditoMXN, 2)  }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($balanceUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($balanceMXN, 2) }}</strong>
                            </td>
                                <td class="text-center">
                                    <strong class="text-info">${{ number_format($abonoUSD, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <strong class="text-warning">${{ number_format($abonoMXN, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <strong class="text-info">${{ number_format($saldoUSD, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <strong class="text-warning">${{ number_format($saldoMXN, 2) }}</strong>
                                </td>
                            </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- Yates / Check-ins -->
@if ($corte->checkinsYatesRelacionadas()->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-list-check me-2"></i>Registro de Yates / Check-ins
                ({{ $corte->checkinsYatesRelacionadas()->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <td></td>
                            <td>Status</td>
                            <td>Folio</td>
                            <td>Cupon</td>
                            <td>Pagada</td>
                            <td>Factura</td>
                            <td>Cliente</td>
                            <td>Agencia</td>
                            <td>Actividad</td>


                            <td colspan="2" class="text-center">Tarifa</td>
                            <td>Pax</td>
                            <td colspan="2" class="text-center">Descuento</td>
                            <td colspan="2" class="text-center">Credito</td>
                            <td colspan="2" class="text-center">Balance</td>
                             <td colspan="2" class="text-center">Abono</td>
                            <td colspan="2" class="text-center">Saldo</td>
                        </tr>
                        <tr>
                            <td colspan="9"></td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td></td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                             <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                             <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                    </thead>
                    <tbody>
                         @php
                            $tarifaUSD = 0;
                            $tarifaMXN = 0;
                            $descuentoUSD = 0;
                            $descuentoMXN = 0;
                            $creditoUSD = 0;
                            $creditoMXN = 0;
                            $balanceUSD = 0;
                            $balanceMXN = 0;
                            $abonoUSD = 0;
                            $abonoMXN = 0;
                            $saldoUSD = 0;
                            $saldoMXN = 0;
                        @endphp
                        @foreach ($corte->checkinsYatesRelacionadas()->sortByDesc('created_at') as $yat)
                         @php
                                if ($yat->c_moneda == 'USD') {
                                    $tarifaUSD += $yat->tarifa;
                                    $descuentoUSD += $yat->descuento;
                                    $creditoUSD += $yat->TotalCredito;
                                    $balanceUSD += $yat->TotalBalance;
                                    $abonoUSD += $yat->Pagos;
                                    $saldoUSD += $yat->Saldo;
                                } elseif ($yat->c_moneda == 'MXN') {
                                    $tarifaMXN += $yat->tarifa;
                                    $descuentoMXN += $yat->descuento;
                                    $creditoMXN += $yat->TotalCredito;
                                    $balanceMXN += $yat->TotalBalance;
                                    $abonoMXN += $yat->Pagos;
                                    $saldoMXN += $yat->Saldo;
                                }
                            @endphp

                        <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            id="dropdownMenuButton{{ $yat->idRY }}" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $yat->idRY }}">
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verDetalleYate({{ $yat->idRY }})">Detalles</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verReservaCompleta({{ $yat->reserva_idReserva }})">Ver
                                                    reserva</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{!! $yat->Badge !!}</td>
                                <td>{{ $yat->FolioDisplay }}</td>
                                <td>{{ $yat->CuponDisplay }}</td>
                                <td>{!! $yat->BadgePagada !!}</td>
                                <td>{!! $yat->BadgeFactura !!}</td>
                                <td>{{ $yat->ClienteDisplay }}</td>
                                <td>{{ $yat->AgenciaDisplay }}</td>
                                <td> <strong>{{ $yat->YateDisplay }}</strong>
                                    <br>
                                    <small>{{ \Carbon\Carbon::parse($yat->start)->format('d-m-Y H:i') }}</small>
                                </td>



                                <td
                                    class="{{ $yat->c_moneda == 'USD' && $yat->tarifa > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'USD' ? $yat->tarifa : 0, 2) }}</strong>
                                </td>

                                <td
                                    class="{{ $yat->c_moneda == 'MXN' && $yat->tarifa > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'MXN' ? $yat->tarifa : 0, 2) }}</strong>
                                </td>
                                <td><strong>{{ $yat->PaxDisplay }}</strong></td>
                                <td
                                    class="{{ $yat->c_moneda == 'USD' && $yat->descuento > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'USD' ? $yat->descuento : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $yat->c_moneda == 'MXN' && $yat->descuento > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'MXN' ? $yat->descuento : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $yat->c_moneda == 'USD' && $yat->TotalCredito > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'USD' ? $yat->TotalCredito : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $yat->c_moneda == 'MXN' && $yat->TotalCredito > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'MXN' ? $yat->TotalCredito : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $yat->c_moneda == 'USD' && $yat->TotalBalance > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'USD' ? $yat->TotalBalance : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $yat->c_moneda == 'MXN' && $yat->TotalBalance > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'MXN' ? $yat->TotalBalance : 0, 2) }}</strong>
                                </td>


                                 <td
                                    class="{{ $yat->c_moneda == 'USD' && $yat->Pagos > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'USD' ? $yat->Pagos : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $yat->c_moneda == 'MXN' && $yat->Pagos > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'MXN' ? $yat->Pagos : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $yat->c_moneda == 'USD' && $yat->Saldo > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'USD' ? $yat->Saldo : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $yat->c_moneda == 'MXN' && $yat->Saldo > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($yat->c_moneda == 'MXN' ? $yat->Saldo : 0, 2) }}</strong>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                     <tfoot class="table-dark">
                        <tr>
                            <td colspan="9" class="text-end"><strong>TOTAL:</strong></td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($tarifaUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($tarifaMXN, 2) }}</strong>
                            </td>
                            <td></td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($descuentoUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($descuentoMXN, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($creditoUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($creditoMXN, 2)  }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($balanceUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($balanceMXN, 2) }}</strong>
                            </td>
                                <td class="text-center">
                                        <strong class="text-info">${{ number_format($abonoUSD, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-warning">${{ number_format($abonoMXN, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-info">${{ number_format($saldoUSD, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-warning">${{ number_format($saldoMXN, 2) }}</strong>
                                    </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endif


<!-- Transportaciones / Check-ins -->
@if ($corte->checkinsTransportacionesRelacionadas()->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-list-check me-2"></i>Registro de Transportaciones /
                Check-ins
                ({{ $corte->checkinsTransportacionesRelacionadas()->count() }})</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <td></td>
                            <td>Status</td>
                            <td>Folio</td>
                            <td>Cupon</td>
                            <td>Pagada</td>
                            <td>Factura</td>
                            <td>Cliente</td>
                            <td>Agencia</td>
                            <td>Vendedor</td>

                            <td>PickUp</td>
                            <td>DropOff</td>


                            <td colspan="2" class="text-center">Tarifa</td>
                            <td>Pax</td>
                            <td colspan="2" class="text-center">Descuento</td>
                            <td colspan="2" class="text-center">Credito</td>
                            <td colspan="2" class="text-center">Balance</td>
                             <td colspan="2" class="text-center">Abono</td>
                            <td colspan="2" class="text-center">Saldo</td>
                        </tr>
                        <tr>
                            <td colspan="11"></td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td></td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                    </thead>
                    <tbody>
                         @php
                            $tarifaUSD = 0;
                            $tarifaMXN = 0;
                            $descuentoUSD = 0;
                            $descuentoMXN = 0;
                            $creditoUSD = 0;
                            $creditoMXN = 0;
                            $balanceUSD = 0;
                            $balanceMXN = 0;
                            $abonoUSD = 0;
                            $abonoMXN = 0;
                            $saldoUSD = 0;
                            $saldoMXN = 0;
                        @endphp
                        @foreach ($corte->checkinsTransportacionesRelacionadas()->sortByDesc('created_at') as $tra)
                         @php
                                if ($tra->c_moneda == 'USD') {
                                    $tarifaUSD += $tra->tarifa;
                                    $descuentoUSD += $tra->descuento;
                                    $creditoUSD += $tra->TotalCredito;
                                    $balanceUSD += $tra->TotalBalance;
                                    $abonoUSD += $tra->Pagos;
                                    $saldoUSD += $tra->Saldo;
                                } elseif ($tra->c_moneda == 'MXN') {
                                    $tarifaMXN += $tra->tarifa;
                                    $descuentoMXN += $tra->descuento;
                                    $creditoMXN += $tra->TotalCredito;
                                    $balanceMXN += $tra->TotalBalance;
                                    $abonoMXN += $tra->Pagos;
                                    $saldoMXN += $tra->Saldo;
                                }
                            @endphp

                        <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            id="dropdownMenuButton{{ $tra->idRT }}" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $tra->idRT }}">
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verDetalleTransporte({{ $tra->idRT }})">Detalles</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verReservaCompleta({{ $tra->reserva_idReserva }})">Ver
                                                    reserva</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{!! $tra->Badge !!}</td>
                                <td>{{ $tra->FolioDisplay }}</td>
                                <td>{{ $tra->CuponDisplay }}</td>
                                <td>{!! $tra->BadgePagada !!}</td>
                                <td>{!! $tra->BadgeFactura !!}</td>
                                <td>{{ $tra->ClienteDisplay }}</td>
                                <td>{{ $tra->AgenciaDisplay }}</td>
                                <td>{{ $tra->VendedorDisplay }}</td>

                                <td>
                                    <strong>
                                        {{ $tra->nombreLocacionPickUp }}
                                    </strong>
                                    <br><small class="text-muted">
                                        {{ \Carbon\Carbon::parse($tra->fechaArrival)->format('d-m-Y') }}
                                        {{ \Carbon\Carbon::parse($tra->horaArrival)->format('h:i A') }}
                                    </small>

                                </td>
                                <td>
                                    <strong>
                                        {{ $tra->nombreLocacionPickUp }}
                                    </strong>
                                    <br><small class="text-muted">
                                        {{ \Carbon\Carbon::parse($tra->fechaArrival)->format('d-m-Y') }}
                                        {{ \Carbon\Carbon::parse($tra->horaArrival)->format('h:i A') }}
                                    </small>

                                </td>



                                <td
                                    class="{{ $tra->c_moneda == 'USD' && $tra->tarifa > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'USD' ? $tra->tarifa : 0, 2) }}</strong>
                                </td>

                                <td
                                    class="{{ $tra->c_moneda == 'MXN' && $tra->tarifa > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'MXN' ? $tra->tarifa : 0, 2) }}</strong>
                                </td>
                                <td><strong>{{ $tra->PaxDisplay }}</strong></td>
                                <td
                                    class="{{ $tra->c_moneda == 'USD' && $tra->descuento > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'USD' ? $tra->descuento : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $tra->c_moneda == 'MXN' && $tra->descuento > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'MXN' ? $tra->descuento : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $tra->c_moneda == 'USD' && $tra->TotalCredito > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'USD' ? $tra->TotalCredito : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $tra->c_moneda == 'MXN' && $tra->TotalCredito > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'MXN' ? $tra->TotalCredito : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $tra->c_moneda == 'USD' && $tra->TotalBalance > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'USD' ? $tra->TotalBalance : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $tra->c_moneda == 'MXN' && $tra->TotalBalance > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'MXN' ? $tra->TotalBalance : 0, 2) }}</strong>
                                </td>
                                    <td
                                        class="{{ $tra->c_moneda == 'USD' && $tra->Pagos > 0 ? 'text-info' : 'text-muted' }}">
                                        <strong>${{ number_format($tra->c_moneda == 'USD' ? $tra->Pagos : 0, 2) }}</strong>
                                    </td>
                                    <td
                                        class="{{ $tra->c_moneda == 'MXN' && $tra->Pagos > 0 ? 'text-info' : 'text-muted' }}">
                                        <strong>${{ number_format($tra->c_moneda == 'MXN' ? $tra->Pagos : 0, 2) }}</strong>
                                    </td>
                                <td
                                    class="{{ $tra->c_moneda == 'USD' && $tra->Saldo > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'USD' ? $tra->Saldo : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $tra->c_moneda == 'MXN' && $tra->Saldo > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($tra->c_moneda == 'MXN' ? $tra->Saldo : 0, 2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                      <tfoot class="table-dark">
                        <tr>
                            <td colspan="11" class="text-end"><strong>TOTAL:</strong></td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($tarifaUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($tarifaMXN, 2) }}</strong>
                            </td>
                            <td></td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($descuentoUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($descuentoMXN, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($creditoUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($creditoMXN, 2)  }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($balanceUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($balanceMXN, 2) }}</strong>
                            </td>
                                <td class="text-center">
                                        <strong class="text-info">${{ number_format($abonoUSD, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-warning">${{ number_format($abonoMXN, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-info">${{ number_format($saldoUSD, 2) }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <strong class="text-warning">${{ number_format($saldoMXN, 2) }}</strong>
                                    </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endif

<!-- Servicios / Check-ins -->
@if ($corte->checkinsServiciosRelacionadas()->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-list-check me-2"></i>Registro de Servicios /
                Check-ins
                ({{ $corte->checkinsServiciosRelacionadas()->count() }})</h5>
        </div>
        <div class="card-body">
                 <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <td></td>
                            <td>Status</td>

                            <td>Folio</td>
                            <td>Cupon</td>
                            <td>Pagada</td>
                            <td>Factura</td>
                            <td>Cliente</td>
                            <td>Agencia</td>
                            <td>Servicio</td>


                            <td colspan="2" class="text-center">Precio</td>


                            <td colspan="2" class="text-center">Credito</td>
                            <td colspan="2" class="text-center">Balance</td>
                            <td colspan="2" class="text-center">Abono</td>
                            <td colspan="2" class="text-center">Saldo</td>
                        </tr>
                        <tr>
                            <td colspan="9"></td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>

                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                            <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>

                             <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                             <td class="text-center">USD</td>
                            <td class="text-center">MXN</td>
                    </thead>
                    <tbody>
                        @php
                            $tarifaUSD = 0;
                            $tarifaMXN = 0;

                            $creditoUSD = 0;
                            $creditoMXN = 0;
                            $balanceUSD = 0;
                            $balanceMXN = 0;
                            $abonoUSD = 0;
                            $abonoMXN = 0;
                            $saldoUSD = 0;
                            $saldoMXN = 0;
                        @endphp
                        @foreach ($corte->checkinsServiciosRelacionadas()->sortByDesc('created_at') as $serv)
                            @php
                                if ($serv->c_moneda == 'USD') {
                                    $tarifaUSD += $serv->precio;

                                    $creditoUSD += $serv->TotalCredito;
                                    $balanceUSD += $serv->TotalBalance;
                                    $abonoUSD += $serv->Pagos;
                                    $saldoUSD += $serv->Saldo;
                                } elseif ($serv->c_moneda == 'MXN') {
                                    $tarifaMXN += $serv->precio;

                                    $creditoMXN += $serv->TotalCredito;
                                    $balanceMXN += $serv->TotalBalance;
                                    $abonoMXN += $serv->Pagos;
                                    $saldoMXN += $serv->Saldo;
                                }
                            @endphp

                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            id="dropdownMenuButton{{ $serv->idAD }}" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $serv->idAD }}">

                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verReservaCompleta({{ $serv->reserva_idReserva }})">Ver
                                                    reserva</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td></td>
                                <td>{{ $serv->FolioDisplay }}</td>
                                <td>{{ $serv->CuponDisplay }}</td>
                                <td>{!! $serv->BadgePagada !!}</td>
                                <td>{!! $serv->BadgeFactura !!}</td>
                                <td>{{ $serv->ClienteDisplay }}</td>
                                <td>{{ $serv->AgenciaDisplay }}</td>
                                <td> <strong>{{ $serv->ServicioDisplay }}</strong>

                                </td>

                                <td
                                    class="{{ $serv->c_moneda == 'USD' && $serv->precio > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($serv->c_moneda == 'USD' ? $serv->precio : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $serv->c_moneda == 'MXN' && $serv->precio > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($serv->c_moneda == 'MXN' ? $serv->precio : 0, 2) }}</strong>
                                </td>


                                <td
                                    class="{{ $serv->c_moneda == 'USD' && $serv->TotalCredito > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($serv->c_moneda == 'USD' ? $serv->TotalCredito : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $serv->c_moneda == 'MXN' && $serv->TotalCredito > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($serv->c_moneda == 'MXN' ? $serv->TotalCredito : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $serv->c_moneda == 'USD' && $serv->TotalBalance > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($serv->c_moneda == 'USD' ? $serv->TotalBalance : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $serv->c_moneda == 'MXN' && $serv->TotalBalance > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($serv->c_moneda == 'MXN' ? $serv->TotalBalance : 0, 2) }}</strong>
                                </td>
                                 <td
                                    class="{{ $serv->c_moneda == 'USD' && $serv->Pagos > 0 ? 'text-info' : 'text-muted' }}">
                                        <strong>${{ number_format($serv->c_moneda == 'USD' ? $serv->Pagos : 0, 2) }}</strong>
                                </td>
                                    <td
                                        class="{{ $serv->c_moneda == 'MXN' && $serv->Pagos > 0 ? 'text-info' : 'text-muted' }}">
                                        <strong>${{ number_format($serv->c_moneda == 'MXN' ? $serv->Pagos : 0, 2) }}</strong>
                                    </td>
                                <td
                                    class="{{ $serv->c_moneda == 'USD' && $serv->Saldo > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($serv->c_moneda == 'USD' ? $serv->Saldo : 0, 2) }}</strong>
                                </td>
                                <td
                                    class="{{ $serv->c_moneda == 'MXN' && $serv->Saldo > 0 ? 'text-info' : 'text-muted' }}">
                                    <strong>${{ number_format($serv->c_moneda == 'MXN' ? $serv->Saldo : 0, 2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="9" class="text-end"><strong>TOTAL:</strong></td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($tarifaUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($tarifaMXN, 2) }}</strong>
                            </td>


                            <td class="text-center">
                                <strong class="text-info">${{ number_format($creditoUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($creditoMXN, 2)  }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-info">${{ number_format($balanceUSD, 2) }}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-warning">${{ number_format($balanceMXN, 2) }}</strong>
                            </td>
                                <td class="text-center">
                                    <strong class="text-info">${{ number_format($abonoUSD, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <strong class="text-warning">${{ number_format($abonoMXN, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <strong class="text-info">${{ number_format($saldoUSD, 2) }}</strong>
                                </td>
                                <td class="text-center">
                                    <strong class="text-warning">${{ number_format($saldoMXN, 2) }}</strong>
                                </td>
                            </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endif
