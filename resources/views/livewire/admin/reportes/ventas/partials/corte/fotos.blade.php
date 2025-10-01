  @if ($corte->fotos?->count() > 0)
      <div class="card mb-4">
          <div class="card-header">
              <h5 class="card-title mb-0"><i class="ti ti-photo me-2"></i>Venta de Fotos
                  ({{ $corte->fotos?->count() ?? 0 }})</h5>
          </div>
          <div class="card-body">
              <div class="row g-3">
                  <div class="table-responsive">
                      <table class="table table-hover">
                          <thead class="table-light">
                              <tr>
                                  <th>ID</th>
                                  <th>Cupon</th>
                                  <th>Descripcion</th>
                                  <th>Cliente</th>
                                  <th>Precio Unit.</th>
                                  <th>Cantidad</th>
                                  <th>Descuento</th>

                                  <th>Importe</th>

                              </tr>
                          </thead>
                          <tbody>
                              @php
                                  $cantidad = 0;
                                  $descuento = 0;
                                  $importe = 0;
                              @endphp
                              @foreach ($corte->fotos ?? [] as $foto)
                                  @php
                                      $cantidad += $foto->cantidad;
                                      $descuento += $foto->descuento;
                                      $importe += $foto->importe;
                                  @endphp
                                  <tr>
                                      <td>{{ $foto->idVF }}</td>
                                      <td>{{ $foto->foto->cupon?->cupon ?? '' }}</td>
                                      <td>{{ $foto->descripcion ?? 'N/A' }}</td>
                                      <td>{{ $foto->venta->cliente->nombreComercial ?? 'Público General' }}</td>
                                      <td>${{ number_format($foto->precio, 2) }}</td>
                                      <td>{{ $foto->cantidad }}</td>
                                      <td>${{ number_format($foto->descuento, 2) }}</td>
                                      <td>${{ number_format($foto->importe, 2) }}</td>
                                  </tr>
                              @endforeach

                          </tbody>
                          <tfoot class="table-light">
                              <tr>
                                  <th colspan="5" class="text-end">Totales:</th>
                                  <th>{{ $cantidad }}</th>
                                  <th>${{ number_format($descuento, 2) }}</th>
                                  
                                  <th>${{ number_format($importe, 2) }}</th>
                              </tr>
                          </tfoot>
                      </table>
                  </div>

              </div>
          </div>
      </div>
  @endif
