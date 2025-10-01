   @if ($corte->ventas->count() > 0)
       <div class="card mb-4">
           <div class="card-header">
               <h5 class="card-title mb-0"><i class="ti ti-shopping-cart me-2"></i>Ventas Registradas
                   ({{ $corte->ventas->count() }})</h5>
           </div>
           <div class="card-body">
               <div class="table-responsive">
                   <table class="table table-hover">
                       <thead class="table-light">
                           <tr>
                               <td></td>
                               <td>Folio</td>
                               <td>Fecha</td>
                               <td>Cliente</td>
                               <td>Moneda</td>

                               <td colspan="2" class="text-center">Subtotal</td>
                               <td colspan="2" class="text-center">Descuento</td>
                               <td colspan="2" class="text-center">Comision</td>
                               <td colspan="2" class="text-center">Total</td>

                               <td>Estado</td>
                           </tr>
                           <tr>
                               <td colspan="5"></td>

                               <td class="text-center">USD</td>
                               <td class="text-center">MXN</td>

                               <td class="text-center">USD</td>
                               <td class="text-center">MXN</td>


                               <td class="text-center">USD</td>
                               <td class="text-center">MXN</td>

                               <td class="text-center">USD</td>
                               <td class="text-center">MXN</td>
                               <td></td>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $subTotalUSD = 0;
                               $subTotalMXN = 0;

                               $descuentoUSD = 0;
                               $descuentoMXN = 0;
                               $comisionUSD = 0;
                               $comisionMXN = 0;
                               $totalUSD = 0;
                               $totalMXN = 0;
                           @endphp
                           @foreach ($corte->ventas as $venta)
                               @php
                                   if ($venta->status > 0) {
                                       if ($venta->c_moneda == 'USD') {
                                           $subTotalUSD += $venta->subTotal;
                                           $descuentoUSD += $venta->descuento;
                                           $comisionUSD += $venta->comision;
                                           $totalUSD += $venta->total;
                                       } elseif ($venta->c_moneda == 'MXN') {
                                           $subTotalMXN += $venta->subTotal;
                                           $descuentoMXN += $venta->descuento;
                                           $comisionMXN += $venta->comision;
                                           $totalMXN += $venta->total;
                                       }
                                   }
                               @endphp


                               <tr class="{{ $venta->status == 0 ? 'table-danger' : '' }}"
                                   style="{{ $venta->status == 0 ? 'text-decoration: line-through; text-decoration-color: #dc3545; text-decoration-thickness: 2px;' : '' }}"
                                   data-bs-toggle="collapse" data-bs-target="#ingresos-{{ $venta->idVenta }}"
                                   aria-expanded="false" aria-controls="ingresos-{{ $venta->idVenta }}"
                                   style="cursor: pointer;">

                                   <td>
                                       <i class="ti ti-chevron-right collapse-icon" id="icon-{{ $venta->idVenta }}"></i>
                                   </td>
                                   <td>{{ $venta->folio }}</td>
                                   <td>{{ \Carbon\Carbon::parse($venta->fechaVenta)->format('d/m/Y H:i') }}</td>
                                   <td>{{ $venta->cliente->nombre ?? 'Público General' }}</td>
                                   <td>{{ $venta->c_moneda }}</td>
                                   <td
                                       class="{{ $venta->c_moneda == 'USD' && $venta->subTotal > 0 ? 'text-info' : 'text-muted' }}">
                                       <strong>${{ number_format($venta->c_moneda == 'USD' ? $venta->subTotal : 0, 2) }}</strong>
                                   </td>
                                   <td
                                       class="{{ $venta->c_moneda == 'MXN' && $venta->subTotal > 0 ? 'text-info' : 'text-muted' }}">
                                       <strong>${{ number_format($venta->c_moneda == 'MXN' ? $venta->subTotal : 0, 2) }}</strong>
                                   </td>
                                   <td
                                       class="{{ $venta->c_moneda == 'USD' && $venta->descuento > 0 ? 'text-info' : 'text-muted' }}">
                                       <strong>${{ number_format($venta->c_moneda == 'USD' ? $venta->descuento : 0, 2) }}</strong>
                                   </td>
                                   <td
                                       class="{{ $venta->c_moneda == 'MXN' && $venta->descuento > 0 ? 'text-info' : 'text-muted' }}">
                                       <strong>${{ number_format($venta->c_moneda == 'MXN' ? $venta->descuento : 0, 2) }}</strong>
                                   </td>
                                   <td
                                       class="{{ $venta->c_moneda == 'USD' && $venta->comision > 0 ? 'text-info' : 'text-muted' }}">
                                       <strong>${{ number_format($venta->c_moneda == 'USD' ? $venta->comision : 0, 2) }}</strong>
                                   </td>
                                   <td
                                       class="{{ $venta->c_moneda == 'MXN' && $venta->comision > 0 ? 'text-info' : 'text-muted' }}">
                                       <strong>${{ number_format($venta->c_moneda == 'MXN' ? $venta->comision : 0, 2) }}</strong>
                                   </td>
                                   <td
                                       class="{{ $venta->c_moneda == 'USD' && $venta->comision > 0 ? 'text-info' : 'text-muted' }}">
                                       <strong>${{ number_format($venta->c_moneda == 'USD' ? $venta->total : 0, 2) }}</strong>
                                   </td>
                                   <td
                                       class="{{ $venta->c_moneda == 'MXN' && $venta->comision > 0 ? 'text-info' : 'text-muted' }}">
                                       <strong>${{ number_format($venta->c_moneda == 'MXN' ? $venta->total : 0, 2) }}</strong>
                                   </td>


                                   <td>{!! $venta->Badge !!}</td>
                               </tr>
                               <tr>
                                   <td colspan="14" class="p-0">
                                       <div class="collapse" id="ingresos-{{ $venta->idVenta }}">
                                           <div class="card card-body m-2 bg-light">
                                               <h6 class="mb-3"><i class="ti ti-cash me-2"></i>Ingresos registrados
                                                   para esta venta:</h6>

                                              
                                                   <div class="table-responsive">
                                                       <table class="table table-sm table-striped">
                                                           <thead>
                                                               <tr>
                                                                 
                                                                   <td>Status</td>
                                                                   <td>Folio</td>
                                                                   <td>Fecha</td>
                                                                   <td>Cliente</td>
                                                                   <td>Locacion</td>
                                                                   <td>Referencia</td>
                                                                   <td>Forma Pago</td>
                                                                   <td>Moneda</td>
                                                                   <td>TC</td>
                                                                   <td colspan="2" class="text-center">Importe</td>
                                                                   <td colspan="2" class="text-center">Comision</td>
                                                                   <td colspan="2" class="text-center">Total</td>
                                                               </tr>
                                                               <tr>
                                                                   <td colspan="9"></td>
                                                                   <td>USD</td>
                                                                   <td>MXN</td>
                                                                   <td>USD</td>
                                                                   <td>MXN</td>
                                                                   <td>USD</td>
                                                                   <td>MXN</td>
                                                               </tr>
                                                           </thead>
                                                           <tbody>
                                                               @foreach ($venta->ingresos as $ing)
                                                                   <tr>

                                                                       
                                                                     
                                                                       <td>{!! $ing->ingreso->Badge !!}</td>
                                                                       <td>{{ $ing->ingreso->folio }}</td>
                                                                       <td>{{ $ing->ingreso->fechaRegistro }}</td>
                                                                       <td>{{ $ing->ingreso->cliente->nombreComercial ?? 'N/A' }}</td>
                                                                       <td>{{ $ing->ingreso->locacion->nombreLocacion ?? 'N/A' }}</td>
                                                                       <td>

                                                                           <div class="lh-1">
                                                                               <span>
                                                                                   {{ $ing->ingreso->cuenta->titulo ?? 'N/A' }}</span>
                                                                           </div>
                                                                           <div class="lh-1">
                                                                               <span
                                                                                   class="fs-11 text-muted">{{ $ing->ingreso->referencia }}</span>
                                                                           </div>


                                                                       </td>

                                                                       <td>{{ $ing->ingreso->descripcionFormaPago }}</td>
                                                                       <td>{{ $ing->ingreso->c_moneda }}</td>
                                                                           <td>{{ $ing->ingreso->tipoCambio }}</td>
                                                                       <td>
                                                                           <strong
                                                                               class="{{ $ing->ingreso->c_moneda == 'USD' && $ing->ingreso->importe > 0 ? 'text-info' : 'text-muted' }}">
                                                                               $
                                                                               {{ number_format($ing->ingreso->c_moneda == 'USD' ? $ing->ingreso->importe : 0, 2) }}

                                                                           </strong>
                                                                       </td>
                                                                       <td>
                                                                           <strong
                                                                               class="{{ $ing->ingreso->c_moneda == 'MXN' && $ing->ingreso->importe > 0 ? 'text-info' : 'text-muted' }}">
                                                                               $
                                                                               {{ number_format($ing->ingreso->c_moneda == 'MXN' ? $ing->ingreso->importe : 0, 2) }}

                                                                           </strong>
                                                                       </td>
                                                                       <td>
                                                                           <strong
                                                                               class="{{ $ing->ingreso->c_moneda == 'USD' && $ing->ingreso->comision > 0 ? 'text-info' : 'text-muted' }}">
                                                                               $
                                                                               {{ number_format($ing->ingreso->c_moneda == 'USD' ? $ing->ingreso->comision : 0, 2) }}

                                                                           </strong>
                                                                       </td>
                                                                       <td>
                                                                           <strong
                                                                               class="{{ $ing->ingreso->c_moneda == 'MXN' && $ing->ingreso->comision > 0 ? 'text-info' : 'text-muted' }}">
                                                                               $
                                                                               {{ number_format($ing->ingreso->c_moneda == 'MXN' ? $ing->ingreso->comision : 0, 2) }}

                                                                           </strong>
                                                                       </td>
                                                                       <td>
                                                                           <strong
                                                                               class="{{ $ing->ingreso->c_moneda == 'USD' && $ing->ingreso->total > 0 ? 'text-info' : 'text-muted' }}">
                                                                               ${{ number_format($ing->ingreso->c_moneda == 'USD' ? $ing->ingreso->total : 0, 2) }}
                                                                           </strong>
                                                                       </td>
                                                                       <td>
                                                                           <strong
                                                                               class="{{ $ing->ingreso->c_moneda == 'MXN' && $ing->ingreso->total > 0 ? 'text-info' : 'text-muted' }}">
                                                                               $
                                                                               {{ number_format($ing->ingreso->c_moneda == 'MXN' ? $ing->ingreso->total : 0, 2) }}

                                                                           </strong>
                                                                       </td>

                                                                   </tr>
                                                               @endforeach
                                                           </tbody>                                                        
                                                       </table>
                                                   </div>
                                             
                                           </div>
                                       </div>
                                   </td>
                               </tr>
                           @endforeach
                       </tbody>
                       <tfoot class="table-dark">
                           <tr>
                               <td colspan="5" class="text-end"><strong>TOTAL:</strong></td>

                               <td class="text-center">
                                   <strong class="text-info">${{ number_format($subTotalUSD, 2) }}</strong>
                               </td>
                               <td class="text-center">
                                   <strong class="text-warning">${{ number_format($subTotalMXN, 2) }}</strong>
                               </td>

                               <td class="text-center">
                                   <strong class="text-info">${{ number_format($descuentoUSD, 2) }}</strong>
                               </td>
                               <td class="text-center">
                                   <strong class="text-warning">${{ number_format($descuentoMXN, 2) }}</strong>
                               </td>

                               <td class="text-center">
                                   <strong class="text-info">${{ number_format($comisionUSD, 2) }}</strong>
                               </td>
                               <td class="text-center">
                                   <strong class="text-warning">${{ number_format($comisionMXN, 2) }}</strong>
                               </td>

                               <td class="text-center">
                                   <strong class="text-info">${{ number_format($totalUSD, 2) }}</strong>
                               </td>
                               <td class="text-center">
                                   <strong class="text-warning">${{ number_format($totalMXN, 2) }}</strong>
                               </td>

                               <td></td>
                           </tr>
                       </tfoot>
                   </table>
               </div>
           </div>
       </div>

   @endif
