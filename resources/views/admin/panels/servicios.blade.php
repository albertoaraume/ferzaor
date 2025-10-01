  <table class="table table-sm table-striped table-hover mb-0">
      <thead class="table-{{ $config['color'] }}">
          <tr>
              <th width="4%">Ver</th>
              <th width="10%">Folio</th>
              <th width="10%">Cupon</th>
              <th width="15%">Cliente</th>
              <th width="10%">Vendedor</th>
              <th width="15%">Locación</th>
              <th width="35%">Descripción</th>
              <th width="15%">Fecha</th>
              <th width="10%">Pax</th>
              <th width="15%">Saldo USD</th>
              <th width="10%">Saldo MXN</th>
              <th width="10%">Status</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($estadoCuenta[$tipo]['detalles'] as $detalle)
              <tr>
                  <td>
                      <div class="btn-group dropup my-1">
                          <button type="button" class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                              data-bs-toggle="dropdown">
                              <i class="fas fa-ellipsis-v"></i>
                          </button>
                          <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="javascript:void(0);"
                                      wire:click="verReservaCompleta('{{ $tipo }}','{{ $detalle['id'] }}')">Ver
                                      reserva</a>
                              </li>

                          </ul>
                      </div>
                  </td>
                  <td>
                      <code class="text-dark">{{ $detalle['folio'] }}</code>
                  </td>
                  <td>
                      <code class="text-dark">{{ $detalle['cupon'] ?? '' }}</code>
                  </td>
                  <td>
                      <span class="fw-medium">{{ $detalle['cliente'] ?? '' }}</span>
                  </td>
                  <td>
                      <span class="fw-medium">{{ $detalle['vendedor'] ?? '' }}</span>
                  </td>
                  <td>
                      <span class="fw-medium">{{ $detalle['locacion'] ?? '' }}</span>
                  <td>
                      <span class="fw-medium">{{ $detalle['descripcion'] }}</span>
                  </td>
                  <td>
                      <small class="text-muted">
                          {{ $detalle['fecha'] ? \Carbon\Carbon::parse($detalle['fecha'])->format('d/m/Y H:i') : 'N/A' }}
                      </small>
                  </td>
                  <td>
                      @if ($detalle['pax'] > 0)
                          <span class="badge bg-light text-dark">{{ $detalle['pax'] }}</span>
                      @else
                          <span class="text-muted">-</span>
                      @endif
                  </td>

                  <td>
                      <strong
                          class="{{ $detalle['moneda'] == 'USD' && $detalle['saldo'] > 0 ? 'text-danger' : 'text-muted' }}">
                          ${{ number_format($detalle['moneda'] == 'USD' ? $detalle['saldo'] : 0, 2) }}
                          <small>USD</small>
                      </strong>
                  </td>
                  <td>
                      <strong
                          class="{{ $detalle['moneda'] == 'MXN' && $detalle['saldo'] > 0 ? 'text-danger' : 'text-muted' }}">
                          ${{ number_format($detalle['moneda'] == 'MXN' ? $detalle['saldo'] : 0, 2) }}
                          <small>MXN</small>
                      </strong>
                  </td>
                  <td> {!! $detalle['status'] !!}</td>
              </tr>
          @endforeach
      </tbody>
  </table>
