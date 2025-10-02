<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Reportes de Cortes</h4>
                <h6>Cortes</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li class="excel-button-container"></li>
            <li class="copy-button-container"></li>
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
        <div class="col-md-2">
            <label for="locacion" class="form-label">Locación</label>
            <select wire:model="locacionId" class="form-control select2" id="locacion">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['locaciones'] ?? [] as $idLocacion => $nombreLocacion)
                    <option value="{{ $idLocacion }}">{{ $nombreLocacion }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-primary btn-sm" wire:click="refresh">
                <i class="fas fa-search me-1"></i> Aplicar Filtros
            </button>
        </div>
    </div>


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
                <table class="table datatable" id="cortesTable">
                    <thead class="thead-light">
                        <tr>
                            <td>Opcion</td>
                            <td>Status</td>
                            <td>ID</td>
                            <td>Folio</td>
                            <td>Apertura</td>
                            <td>Cierre</td>
                            <td>Cajero</td>
                            <td>Locacion</td>

                            <td colspan="2" class="text-center">Efectivo</td>
                            <td colspan="2" class="text-center">TPV MPago</td>
                            <td colspan="2" class="text-center">TPV CLIP</td>
                            <td colspan="2" class="text-center">TPV Banorte</td>
                            <td colspan="2" class="text-center">Transferencia</td>
                            <td colspan="2" class="text-center">PayPal</td>
                            <td colspan="2" class="text-center">Zelle</td>
                            <td colspan="2" class="text-center">Creditos</td>
                            <td colspan="2" class="text-center">Total</td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
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
                            <td>USD</td>
                            <td>MXN</td>
                             <td>USD</td>
                            <td>MXN</td>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cortes as $corte)
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            id="dropdownMenuButton{{ $corte['idCaja'] }}"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $corte['idCaja'] }}">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.reportes.ventas.corte-detalle', ['guid' => $corte['guid']]) }}" target="_blank">
                                                    Ver detalles
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('admin.reportes.ventas.corte.pdf.preview',['guid' => $corte['guid']]) }}" target="_blank">Imprimir</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{!! $corte['status'] !!}</td>
                                <td>{{ $corte['idCaja'] }}</td>
                                <td>{{ $corte['folio'] }}</td>
                                <td>{{ $corte['fechaApertura'] }} <br>
                                    <small>{{ $corte['horaApertura'] }}</small>
                                </td>
                                <td>{{ $corte['fechaCierre'] }}
                                    <br>
                                    <small>{{ $corte['horacierre'] }}</small>
                                </td>
                                <td>{{ $corte['cajero'] }}</td>
                                <td>{{ $corte['locacion'] }}</td>

                                <td class="text-end {{ $corte['efectivo_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['efectivo_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['efectivo_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['efectivo_mxn'], 2) }}</td>
                                <td class="text-end {{ $corte['tpv_mpago_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['tpv_mpago_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['tpv_mpago_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['tpv_mpago_mxn'], 2) }}</td>
                                <td class="text-end {{ $corte['tpv_clip_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['tpv_clip_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['tpv_clip_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['tpv_clip_mxn'], 2) }}</td>
                                <td class="text-end {{ $corte['tpv_banorte_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['tpv_banorte_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['tpv_banorte_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['tpv_banorte_mxn'], 2) }}</td>
                                <td class="text-end {{ $corte['trans_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['trans_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['trans_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['trans_mxn'], 2) }}</td>
                                <td class="text-end {{ $corte['paypal_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['paypal_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['paypal_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['paypal_mxn'], 2) }}</td>
                                <td class="text-end {{ $corte['zelle_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['zelle_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['zelle_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['zelle_mxn'], 2) }}</td>
                                <td class="text-end {{ $corte['creditos_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['creditos_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['creditos_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['creditos_mxn'], 2) }}</td>

                                <td class="text-end {{ $corte['total_usd'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['total_usd'], 2) }}</td>
                                <td class="text-end {{ $corte['total_mxn'] > 0 ? 'fw-bold text-info' : '' }}">{{ number_format($corte['total_mxn'], 2) }}</td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary">
                            <td colspan="8" class="text-end fw-bold">Totales:</td>

                            <td class="text-end fw-bold text-primary">{{ number_format($totales['efectivoUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['efectivoMXN'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['tpvMPagoUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['tpvMPagoMXN'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['tpvClipUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['tpvClipMXN'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['tpvBanorteUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['tpvBanorteMXN'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['transUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['transMXN'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['paypalUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['paypalMXN'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['zelleUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['zelleMXN'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['creditosUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['creditosMXN'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['totalUSD'] ?? 0, 2) }}</td>
                            <td class="text-end fw-bold text-primary">{{ number_format($totales['totalMXN'] ?? 0, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="length-container">
                    {{-- Información de registros --}}
                </div>
                <div class="pagination-container">
                    {{-- Paginación --}}
                </div>
            </div>
        </div>
    </div>

    <x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />

</div>
