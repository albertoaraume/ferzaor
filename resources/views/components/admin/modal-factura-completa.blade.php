<!-- Modal para ver detalles completos de la factura -->
<div class="modal fade" id="modalFacturaCompleta" tabindex="-1" aria-labelledby="modalFacturaCompletaLabel"
    aria-hidden="true" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <!-- Header simple como el de reserva -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="modalFacturaCompletaLabel">
                    <i class="fas fa-file-invoice me-2"></i>
                    Factura - {{ $facturaCompleta ? $facturaCompleta['factura']['invoice'] . ' | ' . $facturaCompleta['factura']['folio'] : 'N/A' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body con estilo similar al de reserva -->
            <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                @if ($facturaCompleta)
                    <!-- Información General de la Factura -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Información General del Comprobante
                                    </h6>
                                    <div class="d-flex gap-3">


                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row g-3">
                                        <!-- Columna izquierda: UUID, Timbrado, Versión, Locación -->
                                        <div class="col-md-3">

                                            <div class="mb-2">
                                                <label class="form-label"><strong>Status:</strong></label>
                                                <div>{!! $facturaCompleta['factura']['Badge'] !!}</div>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label"><strong>Fecha de
                                                        Emisión:</strong></label>
                                                <p class="mb-0">
                                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                                    {{ \Carbon\Carbon::parse($facturaCompleta['factura']['fecha'])->format('d-m-Y') }}
                                                </p>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label"><strong>Versión CFDI:</strong></label>
                                                <p class="mb-0">
                                                    <i class="fas fa-file-code text-info me-2"></i>
                                                    {{ $facturaCompleta['factura']['version'] }}
                                                </p>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label"><strong>Locación:</strong></label>
                                                <p class="mb-0">
                                                    <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                                    {{ $facturaCompleta['factura']['locacion'] }}
                                                </p>
                                            </div>

                                            <div class="mb-2">
                                                <label class="form-label"><strong>Capturada por:</strong></label>
                                                <p class="mb-0">
                                                    <i class="fas fa-user-edit text-success me-2"></i>
                                                    {{ $facturaCompleta['factura']['usuarioCaptura'] }}
                                                </p>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><strong>Condiciones de Pago:</strong></label>
                                                <p>
                                                    <i class="fas fa-handshake text-primary me-2"></i>
                                                    {{ $facturaCompleta['factura']['condicionesDePago'] }}
                                                </p>
                                            </div>








                                        </div>
                                        <!-- Columna centro: Emisión, Captura, Observaciones -->
                                        <div class="col-md-3">

                                            <div class="mb-2">
                                                <label class="form-label"><strong>Tipo de Comprobante</strong></label>
                                                <p class="mb-0">
                                                    <i class="fas fa-file-alt text-primary me-2"></i>
                                                    {{ $facturaCompleta['factura']['tipoDeComprobante'] ?: 'No especificado' }}
                                                </p>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label"><strong>Fecha de Timbrado:</strong></label>
                                                <p class="mb-0">
                                                    <i class="fas fa-calendar-check text-success me-2"></i>
                                                    {{ \Carbon\Carbon::parse($facturaCompleta['factura']['fechaTimbrado'])->format('d-m-Y H:i:s') }}
                                                </p>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label"><strong>Tipo de Cambio:</strong></label>
                                                <p class="mb-0">
                                                    <i class="fas fa-exchange-alt text-info me-2"></i>
                                                    {{ $facturaCompleta['totales']['tipoCambio'] && $facturaCompleta['totales']['tipoCambio'] != 1 ? number_format($facturaCompleta['totales']['tipoCambio'], 4) : 'No aplica' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Forma de Pago:</strong></label>
                                                <p>
                                                    <i class="fas fa-credit-card text-warning me-2"></i>
                                                    {{ $facturaCompleta['factura']['formaPago'] ?: 'No especificado' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Método de Pago:</strong></label>
                                                <p>
                                                    <i class="fas fa-money-check-alt text-success me-2"></i>
                                                    {{ $facturaCompleta['factura']['metodoPago'] ?: 'No especificado' }}
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Moneda:</strong></label>
                                                <p>
                                                    <i class="fas fa-money-check-alt text-success me-2"></i>
                                                    {{ $facturaCompleta['factura']['monedaDescripcion'] ?: 'No especificado' }}
                                                </p>
                                            </div>

                                        </div>
                                        <!-- Columna derecha: Tipo de cambio, Motivo cancelación, Status -->
                                        <div class="col-md-3">




                                            <div class="mb-2">
                                                <label class="form-label"><strong>Folio Fiscal
                                                        (UUID):</strong></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control fw-bold"
                                                        value="{{ $facturaCompleta['factura']['uuid'] }}" readonly>
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        onclick="copyToClipboard('{{ $facturaCompleta['factura']['uuid'] }}')"
                                                        title="Copiar UUID">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </div>
                                            </div>





                                        </div>
                                    </div>




                                    @if ($facturaCompleta['factura']['motivoCancelacion'])
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label"><strong>Motivo de
                                                            cancelación:</strong></label>
                                                    <div class="alert alert-danger">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        {{ $facturaCompleta['factura']['motivoCancelacion'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Información del Emisor y Receptor -->
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="card h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0 text-white"><i class="fas fa-building me-2"></i>Emisor</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>RFC:</strong></label>
                                        <p class="fw-bold">
                                            {{ $facturaCompleta['emisor']['rfc'] ?: 'No especificado' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Razón Social:</strong></label>
                                        <p>{{ $facturaCompleta['emisor']['nombre'] ?: 'No especificado' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Régimen Fiscal:</strong></label>
                                        <p>{{ $facturaCompleta['emisor']['regimenFiscal'] ?: 'No especificado' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0 text-white"><i class="fas fa-user me-2"></i>Receptor</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label"><strong>RFC:</strong></label>
                                        <p class="fw-bold">
                                            {{ $facturaCompleta['receptor']['rfc'] ?: 'No especificado' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Razón Social:</strong></label>
                                        <p>{{ $facturaCompleta['receptor']['nombre'] ?: 'No especificado' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><strong>Uso CFDI:</strong></label>
                                        <p>{{ $facturaCompleta['receptor']['usoCFDI'] ?: 'No especificado' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Tabs para Conceptos, Facturas Relacionadas e Ingresos -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <ul class="nav nav-tabs card-header-tabs" id="facturaTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="conceptos-tab" data-bs-toggle="tab"
                                                data-bs-target="#conceptos" type="button" role="tab"
                                                aria-controls="conceptos" aria-selected="true">
                                                <i class="fas fa-list me-1"></i> Conceptos
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="relacionadas-tab" data-bs-toggle="tab"
                                                data-bs-target="#relacionadas" type="button" role="tab"
                                                aria-controls="relacionadas" aria-selected="false">
                                                <i class="fas fa-link me-1"></i> Facturas Relacionadas
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="ingresos-tab" data-bs-toggle="tab"
                                                data-bs-target="#ingresos" type="button" role="tab"
                                                aria-controls="ingresos" aria-selected="false">
                                                <i class="fas fa-money-bill-wave me-1"></i> Ingresos
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body tab-content" id="facturaTabsContent">
                                    <!-- Tab Conceptos -->
                                    <div class="tab-pane fade show active" id="conceptos" role="tabpanel"
                                        aria-labelledby="conceptos-tab">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th class="text-center">Cantidad</th>
                                                        <th class="text-center">Unidad</th>
                                                        <th>Descripción</th>
                                                        <th class="text-end">Valor Unitario</th>
                                                        <th class="text-end">Importe</th>
                                                        <th class="text-end">Descuento</th>
                                                        <th class="text-end">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($facturaCompleta['conceptos'] as $concepto)
                                                        <tr>
                                                            <td class="text-center">
                                                                <strong>{{ number_format($concepto['cantidad'], 0) }}</strong>
                                                            </td>
                                                            <td class="text-center"><span
                                                                    class="badge bg-secondary">{{ $concepto['claveUnidad'] ?: 'N/A' }}</span>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <strong>{{ $concepto['descripcion'] }}</strong>
                                                                    @if ($concepto['noIdentificacion'])
                                                                        <br><small class="text-muted">ID:
                                                                            {{ $concepto['noIdentificacion'] }}</small>
                                                                    @endif
                                                                    @if ($concepto['claveProdServ'])
                                                                        <br><small class="text-muted">Código:
                                                                            {{ $concepto['claveProdServ'] }}</small>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="text-end">
                                                                <strong>${{ number_format($concepto['valorUnitario'], 2) }}</strong>
                                                            </td>
                                                            <td class="text-end">
                                                                <strong>${{ number_format($concepto['importe'], 2) }}</strong>
                                                            </td>
                                                            <td class="text-end">
                                                                @if ($concepto['descuento'] > 0)
                                                                    <strong
                                                                        class="text-success">-${{ number_format($concepto['descuento'], 2) }}</strong>
                                                                @else
                                                                    <span class="text-muted">$0.00</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-end"><strong
                                                                    class="text-primary">${{ number_format($concepto['importe'] - $concepto['descuento'], 2) }}</strong>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="table-primary">
                                                    <tr>
                                                        <td rowspan="7" colspan="5">

                                                                    <div class="mb-3">
                                                                        <label
                                                                            class="form-label"><strong>Observaciones:</strong></label>
                                                                        <div class="alert alert-info">
                                                                            <i class="fas fa-info-circle me-2"></i>
                                                                            {{ $facturaCompleta['factura']['observaciones'] }}
                                                                        </div>
                                                                    </div>


                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end">
                                                            <h5 class="mb-0">SUBTOTAL:</h5>
                                                        </th>
                                                        <th class="text-end">
                                                            <h4 class="mb-0 text-primary">
                                                                ${{ number_format($facturaCompleta['totales']['subtotal'], 2) }}
                                                                {{ $facturaCompleta['factura']['moneda'] }}</h4>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end">
                                                            <h5 class="mb-0">DESCUENTO:</h5>
                                                        </th>
                                                        <th class="text-end">
                                                            <h4 class="mb-0 text-primary">
                                                                ${{ number_format($facturaCompleta['totales']['descuentos'], 2) }}
                                                                {{ $facturaCompleta['factura']['moneda'] }}</h4>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end">
                                                            <h5 class="mb-0">IMP. TRASLADADOS:</h5>
                                                        </th>
                                                        <th class="text-end">
                                                            <h4 class="mb-0 text-primary">
                                                                ${{ number_format($facturaCompleta['totales']['impuestosTrasladados'], 2) }}
                                                                {{ $facturaCompleta['factura']['moneda'] }}</h4>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end">
                                                            <h5 class="mb-0">IMP. RETENIDOS:</h5>
                                                        </th>
                                                        <th class="text-end">
                                                            <h4 class="mb-0 text-primary">
                                                                ${{ number_format($facturaCompleta['totales']['impuestosRetenidos'], 2) }}
                                                                {{ $facturaCompleta['factura']['moneda'] }}</h4>
                                                        </th>
                                                    </tr>

                                                    <tr>
                                                        <th class="text-end">
                                                            <h5 class="mb-0">TOTAL GENERAL:</h5>
                                                        </th>
                                                        <th class="text-end">
                                                            <h4 class="mb-0 text-primary">
                                                                ${{ number_format($facturaCompleta['totales']['total'], 2) }}
                                                                {{ $facturaCompleta['factura']['moneda'] }}</h4>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Tab Facturas Relacionadas -->
                                    <div class="tab-pane fade" id="relacionadas" role="tabpanel"
                                        aria-labelledby="relacionadas-tab">
                                        @if (!empty($facturaCompleta['factura']['relacionadas']))
                                            <ul class="list-group mt-3">
                                                @foreach ($facturaCompleta['factura']['relacionadas'] as $relacionada)
                                                    <li class="list-group-item">
                                                        <strong>UUID:</strong>
                                                        {{ $relacionada['uuid'] ?? $relacionada }}
                                                        @if (isset($relacionada['folio']))
                                                            <span class="ms-2"><strong>Folio:</strong>
                                                                {{ $relacionada['folio'] }}</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="alert alert-info mt-3">No hay facturas relacionadas.</div>
                                        @endif
                                    </div>
                                    <!-- Tab Ingresos -->
                                    <div class="tab-pane fade" id="ingresos" role="tabpanel"
                                        aria-labelledby="ingresos-tab">
                                        @if (!empty($facturaCompleta['ingresos']))
                                            <div class="table-responsive mt-3">
                                                <table class="table table-bordered table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Fecha</th>
                                                            <th>Monto</th>
                                                            <th>Referencia</th>
                                                            <th>Tipo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($facturaCompleta['ingresos'] as $ingreso)
                                                            <tr>
                                                                <td>{{ \Carbon\Carbon::parse($ingreso['fecha'])->format('d/m/Y H:i:s') }}
                                                                </td>
                                                                <td><strong>${{ number_format($ingreso['monto'], 2) }}</strong>
                                                                </td>
                                                                <td>{{ $ingreso['referencia'] ?? '-' }}</td>
                                                                <td>{{ $ingreso['tipo'] ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info mt-3">No hay ingresos registrados para esta
                                                factura.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning"></i>
                        </div>
                        <h5 class="text-muted">No se encontraron datos de la factura</h5>
                        <p class="text-muted">Verifique que el folio sea correcto o intente nuevamente.</p>
                    </div>
                @endif
            </div>

            <!-- Footer simple -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cerrar
                </button>

            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('UUID copiado al portapapeles');
        }, function(err) {
            console.error('Error al copiar: ', err);
        });
    }
</script>
