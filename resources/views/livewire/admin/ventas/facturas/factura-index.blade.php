<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Reportes de Facturas</h4>
                <h6>Facturas</h6>
            </div>
        </div>
        <ul class="table-top-head">


            <li class="excel-button-container"></li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh" wire:click="refresh"><i
                        class="ti ti-refresh"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                        class="ti ti-chevron-up"></i></a>
            </li>
        </ul>
    </div>


    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show custom-alert-icon shadow-sm d-flex align-items-centers"
            role="alert">
            <i class="feather-alert-octagon flex-shrink-0 me-2"></i>
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                    class="fas fa-xmark"></i></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-success alert-dismissible fade show custom-alert-icon shadow-sm d-flex align-items-centers"
            role="alert">
            <i class="feather-alert-octagon flex-shrink-0 me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                    class="fas fa-xmark"></i></button>
        </div>
    @endif


    {{-- Filtros --}}
    <div class="row mb-3">
        <div class="col-md-2">
            <label for="fechaInicio" class="form-label">Fecha Inicio</label>
            <input type="date" wire:model="fechaInicio" class="form-control" id="fechaInicio">
        </div>
        <div class="col-md-2">
            <label for="fechaFin" class="form-label">Fecha Fin</label>
            <input type="date" wire:model="fechaFin" class="form-control" id="fechaFin">
        </div>
         <div class="col-md-3">
            <label for="empresa" class="form-label">Empresa</label>
            <select wire:model="empresaId" class="form-control select2" id="empresa">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['empresas'] as $idEmpresa => $nombreEmpresa)
                    <option value="{{ $idEmpresa }}">{{ $nombreEmpresa }}</option>
                @endforeach
            </select>
        </div>

    </div>
    <div class="row mb-3">
        <div class="col-md-2">
            <label for="tipo" class="form-label">Tipo</label>
            <select wire:model="tipoId" class="form-control select2" id="tipo">
                <option value="">Todos</option>
                @foreach ($filtrosDisponibles['tipos'] as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="locacion" class="form-label">Locación</label>
            <select wire:model="locacionId" class="form-control select2" id="locacion">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['locaciones'] as $idLocacion => $nombreLocacion)
                    <option value="{{ $idLocacion }}">{{ $nombreLocacion }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="cliente" class="form-label">Agencia</label>
            <select wire:model="clienteId" class="form-control select2" id="cliente">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['clientes'] as $idCliente => $nombreComercial)
                    <option value="{{ $idCliente }}">{{ $nombreComercial }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-2">
            <label for="estado" class="form-label">Estado</label>
            <select wire:model="estado" class="form-control select2" id="estado">
                <option value="">Todos</option>
                @foreach ($filtrosDisponibles['estados'] as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-2">
            <button type="button" class="btn btn-primary btn-sm" wire:click="refresh">
                <i class="fas fa-search me-1"></i> Aplicar Filtros
            </button>

        </div>

    </div>




    <!-- /Facturas list -->
    <div class="card">
        <div class="card-header">
            <div class="row w-100 align-items-center">
                <div class="col-md-4">
                    <div class="search-set">
                        <div class="search-input">
                            <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                        </div>
                    </div>


                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <div class="length-container">
                            {{-- Row per page --}}
                        </div>
                        <div class="info-container">
                            {{-- Información de registros --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table datatable " id="facturasTable">
                    <thead class="thead-light">
                        <tr>
                            <td>Opcion</td>
                            <td>Status</td>
                            <td>Timbrado</td>
                            <td>Tipo</td>
                            <td>Folio</td>
                            <td>RFC</td>
                            <td>Agencia</td>
                            <td>Locación</td>
                            <td>Fecha Creacion</td>
                            <td>Fecha Timbrado</td>
                            <td>Moneda</td>
                            <td colspan="2" class="text-center">SubTotal</td>
                            <td colspan="2" class="text-center">Descuento</td>
                            <td colspan="2" class="text-center">Imp. Trasladados</td>
                            <td colspan="2" class="text-center">Imp. Retenidos</td>
                            <td colspan="2" class="text-center">Total</td>
                            <td colspan="2" class="text-center">Abono</td>
                            <td colspan="2" class="text-center">Saldo</td>
                        </tr>
                        <tr>
                            <td colspan="11"></td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facturas as $factura)
                              <tr class="{{ $factura['status'] == 0 ? 'table-danger' : '' }}"
        style="{{ $factura['status'] == 0 ? 'text-decoration: line-through; text-decoration-color: #dc3545; text-decoration-thickness: 2px;' : '' }}">
                                <td>
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item"
                                                    wire:click="verFacturaCompleta({{ $factura['idComprobante'] }})"
                                                    href="#"><i class="fas fa-eye me-2"></i>Ver Factura</a></li>

                                        </ul>
                                    </div>
                                </td>
                                <td>{!! $factura['badge'] !!}</td>
                                <td>{!! $factura['badgeTimbrado'] !!}</td>
                                <td>{{ $factura['tipoComprobante'] }}</td>
                                <td>{{ $factura['folio'] }}</td>
                                <td>{{ $factura['receptor']['rfc'] }}</td>
                                <td>{{ $factura['receptor']['razonsocial'] }}</td>
                                <td>{{ $factura['locacion'] }}</td>
                                <td>{{ $factura['fechaCreacion'] }}</td>
                                <td>{{ $factura['fechaTimbrado'] }}</td>
                                <td>{{ $factura['moneda'] }}</td>
                                <td
                                    class="text-end {{ $factura['moneda'] === 'USD' && $factura['subTotal'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'USD' ? number_format($factura['subTotal'], 2) : '0.00' }}
                                </td>
                               <td
                                    class="text-end {{ $factura['moneda'] === 'MXN' && $factura['subTotal'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'MXN' ? number_format($factura['subTotal'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'USD' && $factura['descuento'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'USD' ? number_format($factura['descuento'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'MXN' && $factura['descuento'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'MXN' ? number_format($factura['descuento'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'USD' && $factura['trasladados'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'USD' ? number_format($factura['trasladados'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'MXN' && $factura['trasladados'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'MXN' ? number_format($factura['trasladados'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'USD' && $factura['retenciones'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'USD' ? number_format($factura['retenciones'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'MXN' && $factura['retenciones'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'MXN' ? number_format($factura['retenciones'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'USD' && $factura['total'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'USD' ? number_format($factura['total'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'MXN' && $factura['total'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'MXN' ? number_format($factura['total'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'USD' && $factura['abono'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'USD' ? number_format($factura['abono'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'MXN' && $factura['abono'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $factura['moneda'] === 'MXN' ? number_format($factura['abono'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'USD' && $factura['saldo'] > 0 ? 'fw-bold text-danger' : '' }}">
                                    {{ $factura['moneda'] === 'USD' ? number_format($factura['saldo'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $factura['moneda'] === 'MXN' && $factura['saldo'] > 0 ? 'fw-bold text-danger' : '' }}">
                                    {{ $factura['moneda'] === 'MXN' ? number_format($factura['saldo'], 2) : '0.00' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="11" class="text-end fw-bold">Totales:</td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['subTotalUSD'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['subTotalMXN'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['descuentoUSD'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['descuentoMXN'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['trasladadosUSD'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['trasladadosMXN'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['retencionesUSD'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['retencionesMXN'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['totalUSD'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['totalMXN'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['abonoUSD'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-info">
                                {{ number_format($totales['abonoMXN'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-danger">
                                {{ number_format($totales['saldoUSD'], 2) }}
                            </td>
                            <td class="text-end fw-bold text-danger">
                                {{ number_format($totales['saldoMXN'], 2) }}
                            </td>
                        </tr>

                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="length-container">
                    {{-- Aquí se colocará la información de registros --}}
                </div>
                <div class="pagination-container">
                    {{-- Aquí se colocará la paginación --}}
                </div>
            </div>
        </div>
    </div>
    <!-- /Ingresos list -->



    <x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />
    <x-admin.modal-factura-completa :factura-completa="$this->facturaCompleta" />
</div>
