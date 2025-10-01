
<!-- filepath: /Users/albertoarau/Development/Projects/Laravel/Devs/ferzaor/resources/views/components/modal-detalle-yate.blade.php -->
@props(['yateDetalle'])
<div class="modal fade" 
     id="modalDetalleYate" 
     tabindex="-1" 
     aria-labelledby="modalDetalleYateLabel" 
     aria-hidden="true" 
     wire:ignore.self
     data-bs-backdrop="static" 
     data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalleYateLabel">
                    <i class="fas fa-info-circle me-2"></i>
                    Detalles del yate
                </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($yateDetalle)
                    <div class="row">
                        <!-- Información General -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Información General</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Estado:</strong></div>
                                        <div class="col-sm-7">{!! $yateDetalle->Badge !!}</div>
                                    </div>
                                      <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Reserva:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->FolioReservaDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Folio:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->FolioDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Cupón:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->CuponDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Yate:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->yateDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Paquete:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->PaqueteDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Fecha:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->start ? \Carbon\Carbon::parse($yateDetalle->start)->format('d/m/Y H:i') : 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Pax:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->PaxDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Locación:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->LocacionDisplay }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Cliente -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Información del Cliente</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Cliente:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->ClienteDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Agencia:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->AgenciaDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Vendedor:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->VendedorDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Hotel:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->HotelDisplay }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Forma de Pago:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->FormaPago }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-5"><strong>Moneda:</strong></div>
                                        <div class="col-sm-7">{{ $yateDetalle->c_moneda }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Financiera -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Información Financiera</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Concepto</th>
                                                    <th class="text-center">USD</th>
                                                    <th class="text-center">MXN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Tarifa</strong></td>
                                                    <td class="text-center">
                                                        {{ $yateDetalle->c_moneda == 'USD' ? '$' . number_format($yateDetalle->tarifa, 2) : '$0.00' }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $yateDetalle->c_moneda == 'MXN' ? '$' . number_format($yateDetalle->tarifa, 2) : '$0.00' }}
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td><strong>Descuento</strong></td>
                                                    <td class="text-center">
                                                        {{ $yateDetalle->c_moneda == 'USD' ? '$' . number_format($yateDetalle->descuento, 2) : '$0.00' }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $yateDetalle->c_moneda == 'MXN' ? '$' . number_format($yateDetalle->descuento, 2) : '$0.00' }}
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td><strong>Comisión</strong></td>
                                                    <td class="text-center">
                                                        {{ $yateDetalle->c_moneda == 'USD' ? '$' . number_format($yateDetalle->comision, 2) : '$0.00' }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $yateDetalle->c_moneda == 'MXN' ? '$' . number_format($yateDetalle->comision, 2) : '$0.00' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <hr>
                                                    </td>
                                                </tr>
                                                @if($yateDetalle->TotalCredito > 0)
                                                <tr>
                                                    <td><strong>Crédito</strong></td>
                                                    <td class="text-center text-danger">
                                                        <strong>{{ $yateDetalle->c_moneda == 'USD' ? '$' . number_format($yateDetalle->TotalCredito, 2) : '$0.00' }}</strong>
                                                    </td>
                                                    <td class="text-center text-danger">
                                                       <strong> {{ $yateDetalle->c_moneda == 'MXN' ? '$' . number_format($yateDetalle->TotalCredito, 2) : '$0.00' }}</strong>
                                                    </td>
                                                </tr>
                                                @endif
                                                  @if($yateDetalle->TotalBalance > 0)
                                                <tr class="table-warning">
                                                    <td><strong>Balance</strong></td>
                                                    <td class="text-center text-success">
                                                        <strong>{{ $yateDetalle->c_moneda == 'USD' ? '$' . number_format($yateDetalle->TotalBalance, 2) : '$0.00' }}</strong>
                                                    </td>
                                                    <td class="text-center text-success">
                                                        <strong>{{ $yateDetalle->c_moneda == 'MXN' ? '$' . number_format($yateDetalle->TotalBalance, 2) : '$0.00' }}</strong>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Información Técnica -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Información Técnica</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="row mb-2">
                                                <div class="col-sm-6"><strong>ID:</strong></div>
                                                <div class="col-sm-6">{{ $yateDetalle->idRY }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row mb-2">
                                                <div class="col-sm-6"><strong>Pagada:</strong></div>
                                                <div class="col-sm-6">
                                                      {!! $yateDetalle->BadgePagada !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row mb-2">
                                                <div class="col-sm-6"><strong>Facturado:</strong></div>
                                                <div class="col-sm-6">
                                                    {!! $yateDetalle->BadgeFactura  !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row mb-2">
                                                <div class="col-sm-6"><strong>Crédito:</strong></div>
                                                <div class="col-sm-6">
                                                    <span class="badge {{ $yateDetalle->isCredito == true ? 'bg-warning' : 'bg-success' }}">
                                                        {{ $yateDetalle->isCredito ? 'Sí' : 'No' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de cambios (si existe) -->
                    @if($yateDetalle->movimientos && $yateDetalle->movimientos->count() > 0)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"><i class="fas fa-history me-2"></i>Historial de Movimientos</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Usuario</th>
                                                        <th>Status</th>
                                                        <th>Motivo</th>
                                                        <th>Autorizacion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($yateDetalle->movimientos as $movimiento)
                                                        <tr>
                                                            <td>{{ $movimiento->created_at ? $movimiento->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                                           <td>{{ $movimiento->usuario->name }}</td>
                                                            <td>{{ $movimiento->status ?? 'N/A' }}</td>
                                                            <td>{{ $movimiento->motivo }}</td>
                                                            <td>{{ $movimiento->UsuarioAuth }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2">Cargando detalles de la yate...</p>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                
            </div>
        </div>
    </div>
</div>
