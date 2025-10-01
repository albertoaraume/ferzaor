<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Reporte de Actividades</h4>
                <h6>Actividades </h6>
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

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm d-flex align-items-centers"
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



    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="actividad" class="form-label">Actividad</label>
            <select wire:model="actividadId" class="form-control select2" id="actividad">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['actividades'] as $idActividad => $nombreActividad)
                    <option value="{{ $idActividad }}">{{ $nombreActividad }}</option>
                @endforeach
            </select>
        </div>


        <div class="col-md-2">
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
        <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-primary btn-sm" wire:click="refresh">
                <i class="fas fa-search me-1"></i> Aplicar Filtros
            </button>
        </div>

    </div>



    <!-- /Yates list -->
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
                <table class="table datatable" id="actividadesTable">
                    <thead class="thead-light">
                        <tr>
                            <td>Opcion</td>
                            <td>Status</td>
                            <td>Folio</td>
                            <td>Cupon</td>
                            <td>Pagada</td>
                            <td>Factura</td>
                            <td>Cliente</td>
                            <td>Hotel</td>
                            <td>Agencia</td>
                            <td>Vendedor</td>
                            <td>Actividad</td>
                            <td>Locacion</td>
                            <td>Paquete</td>
                            <td>Pax</td>
                            <td>Fecha</td>
                            <td>Moneda</td>
                            <td>Forma Pago</td>
                            <td colspan="2" class="text-center">Tarifa</td>
                            <td colspan="2" class="text-center">Credito</td>
                            <td colspan="2" class="text-center">Balance</td>
                        </tr>
                        <tr>
                            <td colspan="17"></td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($actividades as $actividad)
                            <tr class="{{ $actividad['status'] == 0 ? 'table-danger' : '' }}"
                                style="{{ $actividad['status'] == 0 ? 'text-decoration: line-through; text-decoration-color: #dc3545; text-decoration-thickness: 2px;' : '' }}">
                                <td>

                                    <div class="dropdown">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            id="dropdownMenuButton{{ $actividad['idAU'] }}"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $actividad['idAU'] }}">
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verDetalle({{ $actividad['idAU'] }})">Detalles</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verReservaCompleta({{ $actividad['idAU'] }})">Ver
                                                    reserva</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Finalizar</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Cancelar</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{!! $actividad['badge'] !!}</td>
                                <td>{{ $actividad['folio'] }}</td>
                                <td>{{ $actividad['cupon'] }}</td>
                                <td>{!! $actividad['badgePagada'] !!}</td>
                                <td>{!! $actividad['badgeFactura'] !!}</td>
                                <td>{{ $actividad['cliente'] }}</td>
                                <td>{{ $actividad['hotel'] }}</td>
                                <td>{{ $actividad['agencia'] }}</td>
                                <td>{{ $actividad['vendedor'] }}</td>
                                <td>{{ $actividad['actividad'] }}</td>
                                <td>{{ $actividad['locacion'] }}</td>
                                <td>{{ $actividad['paquetes'] }}</td>
                                <td>{{ $actividad['pax'] }}</td>
                                <td>{{ $actividad['start'] }}</td>
                                <td>{{ $actividad['moneda'] }}</td>
                                <td>{{ $actividad['formaPago'] }}</td>
                                <td>{{ number_format($actividad['tarifaUSD'], 2) }}
                                </td>
                                <td>{{ number_format($actividad['tarifaMXN'], 2) }}
                                </td>
                                <td>{{ number_format($actividad['creditoUSD'], 2) }}
                                </td>
                                <td>{{ number_format($actividad['creditoMXN'], 2) }}
                                </td>
                                <td class="text-success">{{ number_format($actividad['balanceUSD'], 2) }}
                                </td>
                                <td class="text-success">{{ number_format($actividad['balanceMXN'], 2) }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                    <tfoot>
                        <tr class="bg-light text-bold">
                            <td colspan="13" class="text-end">Total:</td>
                            <td class="text-center">{{ $estadisticas['totales']['pax'] }}</td>
                            <td colspan="3"></td>
                            <td>{{ number_format($estadisticas['totales']['tarifa_usd'], 2) }}</td>
                            <td>{{ number_format($estadisticas['totales']['tarifa_mxn'], 2) }}</td>
                            <td>{{ number_format($estadisticas['totales']['credito_usd'], 2) }}</td>
                            <td>{{ number_format($estadisticas['totales']['credito_mxn'], 2) }}</td>
                            <td>{{ number_format($estadisticas['totales']['balance_usd'], 2) }}</td>
                            <td>{{ number_format($estadisticas['totales']['balance_mxn'], 2) }}</td>

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
    <!-- /Yates list -->




    <x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />

    <x-admin.modal-detalle-actividad :actividad-detalle="$this->actividadDetalle" />
    <x-admin.modal-reserva-completa :reserva-completa="$this->reservaCompleta" />
</div>
