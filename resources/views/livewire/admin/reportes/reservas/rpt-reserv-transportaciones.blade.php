<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Reportes de Transportaciones</h4>
                <h6>Transportaciones</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li class="excel-button-container"></li>
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
    </div>
    <div class="row mb-3">

        <div class="col-md-2">
            <label for="locacion" class="form-label">Locación</label>
            <select wire:model="locacionId" class="form-control select2" id="locacion">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['locaciones'] ?? [] as $idLocacion => $nombreLocacion)
                    <option value="{{ $idLocacion }}">{{ $nombreLocacion }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="cliente" class="form-label">Cliente</label>
            <select wire:model="clienteId" class="form-control select2" id="cliente">
                <option value="">Todos</option>
                @foreach ($filtrosDisponibles['clientes'] ?? [] as $idCliente => $nombreCliente)
                    <option value="{{ $idCliente }}">{{ $nombreCliente }}</option>
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
                <table class="table datatable" id="transportacionesTable">
                    <thead class="thead-light">
                        <tr>
                            <td>Opcion</td>
                            <td>Status</td>
                            <td>Folio</td>
                            <td>Tipo</td>
                            <td>Cupon</td>
                            <td>Pagada</td>
                            <td>Factura</td>
                            <td>Servicios</td>
                            <td>Cliente</td>
                            <td>Hotel</td>
                            <td>Agencia</td>
                            <td>Vendedor</td>
                            <td>Locacion</td>
                            <td>PickUp</td>
                            <td>DropOff</td>

                            <td>Pax</td>
                            <td>Moneda</td>
                            <td>Forma Pago</td>
                            <td colspan="2" class="text-center">Tarifa</td>
                            <td colspan="2" class="text-center">Credito</td>
                            <td colspan="2" class="text-center">Balance</td>

                        </tr>
                        <tr>
                            <td colspan="18"></td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transportaciones as $transportacion)
                            <tr class="{{ $transportacion['status'] == 0 ? 'table-danger' : '' }}"
                                style="{{ $transportacion['status'] == 0 ? 'text-decoration: line-through; text-decoration-color: #dc3545; text-decoration-thickness: 2px;' : '' }}">

                                <td>

                                    <div class="btn-group dropup my-1">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verDetalle({{ $transportacion['idRT'] }})">Detalles</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verReservaCompleta({{ $transportacion['idReserva'] }})">Ver
                                                    reserva</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Cancelar</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{!! $transportacion['badge'] !!}</td>
                                <td>{{ $transportacion['folio'] }}</td>
                                <td>{{ $transportacion['tipo'] }}</td>
                                <td>{{ $transportacion['cupon'] }}</td>

                                <td>{!! $transportacion['badgePagada'] !!}</td>
                                <td>{!! $transportacion['badgeFactura'] !!}</td>

                                <td>
                                    @if (!empty($transportacion['servicios']))
                                        <ul class="mb-0 ps-3">
                                            @foreach ($transportacion['servicios'] as $servicio)
                                                <li>{!! $servicio !!}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>{{ $transportacion['cliente'] }}</td>
                                <td>{{ $transportacion['hotel'] }}</td>
                                <td>{{ $transportacion['agencia'] }}</td>
                                <td>{{ $transportacion['vendedor'] }}</td>
                                <td>{{ $transportacion['locacion'] }}</td>

                                <td>
                                    <strong>
                                        {{ $transportacion['pickup'] }}
                                    </strong>
                                    <br><small class="text-muted">
                                        {{ \Carbon\Carbon::parse($transportacion['fechaPickup'])->format('d-m-Y') }}
                                        {{ \Carbon\Carbon::parse($transportacion['horaPickup'])->format('h:i A') }}
                                    </small>


                                </td>
                                <td>
                                    <strong>
                                        {{ $transportacion['dropoff'] }}
                                    </strong>
                                    <br><small class="text-muted">
                                        {{ \Carbon\Carbon::parse($transportacion['fechaDropoff'])->format('d-m-Y') }}
                                        {{ \Carbon\Carbon::parse($transportacion['horaDropoff'])->format('h:i A') }}
                                    </small>


                                </td>


                                <td>{{ $transportacion['pax'] }}</td>
                                <td>{{ $transportacion['moneda'] }}</td>
                                <td>{{ $transportacion['formaPago'] }}</td>
                                <td>{{ number_format($transportacion['tarifaUSD'], 2) }}</td>
                                <td>{{ number_format($transportacion['tarifaMXN'], 2) }}</td>
                                <td>{{ number_format($transportacion['creditoUSD'], 2) }}</td>
                                <td>{{ number_format($transportacion['creditoMXN'], 2) }}</td>
                                <td>{{ number_format($transportacion['balanceUSD'], 2) }}</td>
                                <td>{{ number_format($transportacion['balanceMXN'], 2) }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-light text-bold">
                            <td colspan="18" class="text-end">Totales</td>
                            <td>{{ number_format($totales['tarifaUSD'], 2) }}</td>
                            <td>{{ number_format($totales['tarifaMXN'], 2) }}</td>
                            <td>{{ number_format($totales['creditoUSD'], 2) }}</td>
                            <td>{{ number_format($totales['creditoMXN'], 2) }}</td>
                            <td>{{ number_format($totales['balanceUSD'], 2) }}</td>
                            <td>{{ number_format($totales['balanceMXN'], 2) }}</td>
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

    <x-admin.modal-detalle-traslado :traslado-detalle="$this->trasladoDetalle" />
    <x-admin.modal-reserva-completa :reserva-completa="$this->reservaCompleta" />
</div>
