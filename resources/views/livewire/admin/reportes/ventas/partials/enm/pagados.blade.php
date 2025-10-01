  <div class="table-responsive">
      <table class="table table-hover">
          <thead class="table-light">
              <tr>
                  <td>

                  </td>

                  <td>Cupon</td>
                  <td>Actividad</td>
                  <td>Cliente</td>
                  <td>Agencia</td>
                  <td>Descripción</td>
                  <td>Moneda</td>
                  <td colspan="2" class="text-center">Total</td>
              </tr>
              <tr>
                  <td colspan="7"></td>
                  <td class="text-center">USD</td>
                  <td class="text-center">MXN</td>
              </tr>
          </thead>
          <tbody>
              @php
                  $totalUSD = 0;
                  $totalMXN = 0;
              @endphp
              @foreach ($corte->enms->where('edo', true) as $enm)
                  @php
                      if ($enm->venta->c_moneda == 'USD') {
                          $totalUSD += $enm->importe;
                      } elseif ($enm->venta->c_moneda == 'MXN') {
                          $totalMXN += $enm->importe;
                      }
                  @endphp

                  <tr class="{{ $enm->edo == false ? 'table-danger' : '' }}"
                      style="{{ $enm->edo == false ? 'text-decoration: line-through; text-decoration-color: #dc3545; text-decoration-thickness: 2px;' : '' }}">
                      <td>
                          <div class="dropdown">
                              <button type="button" class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                  id="dropdownMenuButton{{ $enm->idVE }}" data-bs-toggle="dropdown">
                                  <i class="fas fa-ellipsis-v"></i>
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $enm->idVE }}">
                                  <li><a class="dropdown-item" href="javascript:void(0);"
                                          wire:click="verReservaCompleta({{ $enm->pasajero->IdReserva }})">Ver
                                          reserva</a>
                                  </li>
                              </ul>
                          </div>
                      </td>

                      <td>
                          {{ $enm->pasajero->CuponDisplay }}
                      </td>
                      <td><i class="{{ $enm->pasajero->Icon }} me-2"></i>{{ $enm->pasajero->NombreActividad }}
                          <br>
                          <small class="text-muted">{{ $enm->pasajero->FechaServicio }}</small>
                      </td>
                      <td>{{ $enm->pasajero->ClienteNombre }}</td>
                      <td>{{ $enm->pasajero->AgenciaNombre }}</td>
                      <td>{{ $enm->descripcion }}</td>
                      <td>{{ $enm->venta->c_moneda }}</td>
                      <td
                          class="{{ $enm->venta->c_moneda == 'USD' && $enm->importe > 0 ? 'text-info' : 'text-muted' }}">
                          <strong>${{ number_format($enm->venta->c_moneda == 'USD' ? $enm->importe : 0, 2) }}</strong>
                      </td>
                      <td
                          class="{{ $enm->venta->c_moneda == 'MXN' && $enm->importe > 0 ? 'text-info' : 'text-muted' }}">
                          <strong>${{ number_format($enm->venta->c_moneda == 'MXN' ? $enm->importe : 0, 2) }}</strong>
                      </td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot class="table-dark">
              <tr>
                  <td colspan="7" class="text-end"><strong>TOTAL:</strong></td>
                  <td class="text-center">
                      <strong class="text-info">${{ number_format($totalUSD, 2) }}</strong>
                  </td>
                  <td class="text-center">
                      <strong class="text-warning">${{ number_format($totalMXN, 2) }}</strong>
                  </td>
              </tr>
          </tfoot>
      </table>
  </div>
