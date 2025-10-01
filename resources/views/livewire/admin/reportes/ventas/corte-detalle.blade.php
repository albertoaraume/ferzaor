<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Corte - {{ Str::upper($corte->folio) }}</h4>
                <h6>Cajero: {{ $corte->cajero->name }}</h6>
            </div>
        </div>
        <ul class="table-top-head">

            <li>



                <a href="{{ route('admin.reportes.ventas.corte.pdf.preview', ['guid' => $corte->guid]) }}" target="_blank"
                    class="btn btn-outline-primary btn-sm me-2">
                    <i class="fas fa-print me-1"></i>
                </a>
            </li>

            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        class="ti ti-chevron-up"></i></a>
            </li>
        </ul>
    </div>

    <!-- Datos Generales de la Caja -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-info-circle me-2"></i>Datos Generales de la Caja</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="form-label fw-bold">ID:</label>
                        <span class="ms-2">{{ $corte->idCaja }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="form-label fw-bold">Cajero:</label>
                        <span class="ms-2">{{ $corte->cajero->name }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="form-label fw-bold">Fecha de Apertura:</label>
                        <span
                            class="ms-2">{{ \Carbon\Carbon::parse($corte->fechaApertura)->format('d/m/Y H:i:s') }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-group">
                        <label class="form-label fw-bold">Fecha de Cierre:</label>
                        <span
                            class="ms-2">{{ $corte->fechaCierre ? \Carbon\Carbon::parse($corte->fechaCierre)->format('d/m/Y H:i:s') : 'No cerrada' }}</span>
                    </div>
                </div>
                @if ($corte->locacion)
                    <div class="col-md-6">
                        <div class="info-group">
                            <label class="form-label fw-bold">Locación:</label>
                            <span class="ms-2">{{ $corte->locacion->nombreLocacion }}</span>
                        </div>
                    </div>
                @endif
                @if ($corte->sucursal)
                    <div class="col-md-6">
                        <div class="info-group">
                            <label class="form-label fw-bold">Sucursal:</label>
                            <span class="ms-2">{{ $corte->sucursal->nombreSucursal }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Resumen Financiero General -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-calculator me-2"></i>Resumen Ventas General</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-2">
                    <div class="bg-danger bg-opacity-10 p-3 rounded text-center">
                        <h6 class="text-primary mb-1">Ventas Canceladas</h6>
                        <h4 class="mb-0">{{ $corte->ventas->where('status', 0)->count() }}</h4>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="bg-primary bg-opacity-10 p-3 rounded text-center">
                        <h6 class="text-primary mb-1">Ventas Activas</h6>
                        <h4 class="mb-0">{{ $corte->ventas->where('status', '>', 0)->count() }}</h4>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="bg-success bg-opacity-10 p-3 rounded text-center">
                        <h6 class="text-success mb-1">Ingresos MXN</h6>
                        <h4 class="mb-0">${{ number_format($corte->TotalVentas('MXN'), 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="bg-warning bg-opacity-10 p-3 rounded text-center">
                        <h6 class="text-warning mb-1">Comisiones MXN</h6>
                        <h4 class="mb-0">${{ number_format($corte->TotalComisiones('MXN'), 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="bg-info bg-opacity-10 p-3 rounded text-center">
                        <h6 class="text-info mb-1">Ingresos USD</h6>
                        <h4 class="mb-0">${{ number_format($corte->TotalVentas('USD'), 2) }}</h4>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="bg-warning bg-opacity-10 p-3 rounded text-center">
                        <h6 class="text-warning mb-1">Comisiones USD</h6>
                        <h4 class="mb-0">${{ number_format($corte->TotalComisiones('USD'), 2) }}</h4>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-secondary bg-opacity-10 p-3 rounded text-center">
                        <h6 class="text-secondary mb-1">Total General MXN</h6>
                        <h3 class="mb-0 text-dark">${{ number_format($corte->TotalGeneral('MXN'), 2) }}</h3>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-secondary bg-opacity-10 p-3 rounded text-center">
                        <h6 class="text-secondary mb-1">Total General USD</h6>
                        <h3 class="mb-0 text-dark">${{ number_format($corte->TotalGeneral('USD'), 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Resumen de Formas de Pago -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ti ti-credit-card me-2"></i>Resumen de Formas de Pago</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- MXN -->
                <div class="col-md-6">
                    <h6 class="text-primary mb-3"><i class="ti ti-currency-dollar me-1"></i>Moneda Nacional (MXN)</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>Efectivo</td>
                                    <td class="text-end">${{ number_format($corte->TotalEfectivo('MXN'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>TPV Mercado Pago</td>
                                    <td class="text-end">${{ number_format($corte->TotalMercadoPago('MXN'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>TPV Clip</td>
                                    <td class="text-end">${{ number_format($corte->TotalTPVClip('MXN'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>TPV Banorte</td>
                                    <td class="text-end">${{ number_format($corte->TotalTPVBanco('MXN'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Transferencias</td>
                                    <td class="text-end">${{ number_format($corte->TotalTransferencias('MXN'), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>PayPal</td>
                                    <td class="text-end">${{ number_format($corte->TotalPayPal('MXN'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>IZettle</td>
                                    <td class="text-end">${{ number_format($corte->TotalTPVIZETTLE('MXN'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Créditos</td>
                                    <td class="text-end">${{ number_format($corte->TotalCreditos('MXN'), 2) }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- USD -->
                <div class="col-md-6">
                    <h6 class="text-success mb-3"><i class="ti ti-currency-dollar me-1"></i>Dólares Americanos (USD)
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>Efectivo</td>
                                    <td class="text-end">${{ number_format($corte->TotalEfectivo('USD'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>TPV Mercado Pago</td>
                                    <td class="text-end">${{ number_format($corte->TotalMercadoPago('USD'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>TPV Clip</td>
                                    <td class="text-end">${{ number_format($corte->TotalTPVClip('USD'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>TPV Banorte</td>
                                    <td class="text-end">${{ number_format($corte->TotalTPVBanco('USD'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Transferencias</td>
                                    <td class="text-end">${{ number_format($corte->TotalTransferencias('USD'), 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>PayPal</td>
                                    <td class="text-end">${{ number_format($corte->TotalPayPal('USD'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>IZettle</td>
                                    <td class="text-end">${{ number_format($corte->TotalTPVIZETTLE('USD'), 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Créditos</td>
                                    <td class="text-end">${{ number_format($corte->TotalCreditos('USD'), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Salidas y Fondos de Caja -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ti ti-arrow-down me-2"></i>Fondos Efectivo de Caja
                        ({{ $corte->fondos->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Moneda</th>
                                    <th>Inicial</th>
                                    <th>Entrada</th>
                                    <th>Salida</th>
                                    <th>Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($corte->fondos as $fondo)
                                    <tr>
                                        <td>{{ $fondo->descripcionMoneda }}</td>
                                        <td>${{ number_format($fondo->montoInicial, 2) }}</td>
                                        <td>${{ number_format($fondo->montoCobrado, 2) }}</td>
                                        <td>${{ number_format($fondo->salidas->sum('monto'), 2) }}</td>
                                        <td>${{ number_format($fondo->montoFinal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="ti ti-arrow-up me-2"></i>Retiros
                        ({{ $corte->salidas->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Retiro</th>
                                    <th>Tipo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($corte->salidas as $salida)
                                    <tr>
                                        <td>{{ $salida->concepto }}</td>
                                        <td>${{ number_format($salida->monto, 2) }}
                                            <small>{{ $salida->c_moneda }}</small>
                                        </td>
                                        <td>{{ $salida->tipo }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




    </div>




    <!-- Registro de Ventas -->
    @include('livewire.admin.reportes.ventas.partials.corte.ventas', ['corte' => $corte])

    <!-- Servicios Vendidos -->
    @include('livewire.admin.reportes.ventas.partials.corte.servicios', ['corte' => $corte])

    <!-- Productos Vendidos -->
    @include('livewire.admin.reportes.ventas.partials.corte.productos', ['corte' => $corte])

    <!-- Tours Vendidos -->
  @include('livewire.admin.reportes.ventas.partials.corte.tours', ['corte' => $corte])

    <!-- Fotos Relacionadas -->
  @include('livewire.admin.reportes.ventas.partials.corte.fotos', ['corte' => $corte])
 

    <!-- ENM Cobrados -->
    @include('livewire.admin.reportes.ventas.partials.corte.enms')


    @include('livewire.admin.reportes.ventas.partials.corte.checkins')

    <!-- Loading overlay para PDF -->



    <x-loading-overlay wire:loading.flex type="spinner" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />

    <x-admin.modal-detalle-actividad :actividad-detalle="$this->actividadDetalle" />
    <x-admin.modal-reserva-completa :reserva-completa="$this->reservaCompleta" />
    <x-admin.modal-detalle-yate :yate-detalle="$this->yateDetalle" />

</div>
