  <table class="table table-sm table-striped table-hover mb-0">
      <thead class="table-{{ $config['color'] }}">
          <tr>
              <th width="4%">Ver</th>
              <th width="13%">Folio</th>
              <th width="30%">Descripción</th>
              <th width="12%">Fecha</th>
              <th width="10%">Total</th>
              <th width="10%">Abono</th>
              <th width="10%">Saldo USD</th>
              <th width="10%">Saldo MXN</th>
              <th width="8%">Status</th>

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
                                      wire:click="verFacturaCompleta('{{ $detalle['id'] }}')">Ver
                                      factura</a>
                              </li>

                          </ul>
                      </div>
                  </td>
                  <td>
                      <code class="text-dark">{{ $detalle['folio'] }}</code>
                  </td>
                  <td>
                      <span class="fw-medium">{{ $detalle['descripcion'] }}</span>
                  </td>
                  <td>
                      <small class="text-muted">
                          {{ $detalle['fecha'] ? \Carbon\Carbon::parse($detalle['fecha'])->format('d/m/Y') : 'N/A' }}
                      </small>
                  </td>
                  <td>
                      <strong>
                          ${{ $detalle['total'] }}
                      </strong>
                  </td>
                  <td>
                      <strong>
                          ${{ number_format($detalle['abono'], 2) }} <small>{{ $detalle['moneda'] }}</small>
                      </strong>
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
