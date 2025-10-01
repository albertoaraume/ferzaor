<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Reportes de Ingresos</h4>
                <h6>Ingresos</h6>
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
            <label for="locacion" class="form-label">Locación</label>
            <select wire:model="locacionId" class="form-control select2" id="locacion">
                <option value="">Todas</option>
                @foreach ($filtrosDisponibles['locaciones'] as $idLocacion => $nombreLocacion)
                    <option value="{{ $idLocacion }}">{{ $nombreLocacion }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="cliente" class="form-label">Cliente</label>
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

    </div>




    <!-- /Ingresos list -->
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
                <table class="table table-striped  datatable checkbox-select-datatable" id="ingresosTable">
                    <thead class="thead-light">
                        <tr>
                            <td>Opcion</td>
                            <td>
                                <input type="checkbox" id="select-all" class="form-check-input">

                            </td>
                            <td>Status</td>
                            <td>Folio</td>
                            <td>Fecha</td>
                            <td>Cliente</td>
                            <td>Locacion</td>
                            <td>Referencia</td>
                            <td>Forma Pago</td>
                            <td>Moneda</td>
                            <td colspan="2" class="text-center">Importe</td>
                            <td colspan="2" class="text-center">Comision</td>
                            <td colspan="2" class="text-center">Total</td>
                        </tr>
                        <tr>
                            <td colspan="10"></td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                            <td>USD</td>
                            <td>MXN</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingresos as $ingreso)
                            <tr>

                                <td>
                                    <div class="btn-group dropup my-1">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">

                                            @if ($ingreso->status == 3)
                                                <li><a class="dropdown-item" href="javascript:void(0);"
                                                        wire:click="confirmarIngreso({{ $ingreso->idIngreso }})">Confirmar</a>
                                                </li>
                                            @endif
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);" wire:click="cancelarIngreso({{ $ingreso->idIngreso }})">Cancelar</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                     @if($ingreso->status == 3)

                                        <input type="checkbox" class="select-row form-check-input"
                                            data-id="{{ $ingreso->idIngreso }}">
                                    @endif
                                </td>
                                <td>{!! $ingreso->Badge !!}</td>
                                <td>{{ $ingreso->folio }}</td>
                                <td>{{ $ingreso->fechaRegistro }}</td>
                                <td>{{ $ingreso->cliente->nombreComercial ?? 'N/A' }}</td>
                                <td>{{ $ingreso->locacion->nombreLocacion ?? 'N/A' }}</td>
                                <td>

                                    <div class="lh-1">
                                        <span> {{ $ingreso->cuenta->titulo ?? 'N/A' }}</span>
                                    </div>
                                    <div class="lh-1">
                                        <span class="fs-11 text-muted">{{ $ingreso->referencia }}</span>
                                    </div>


                                </td>

                                <td>{{ $ingreso->descripcionFormaPago }}</td>
                                <td>{{ $ingreso->c_moneda }}</td>
                                <td>
                                    <strong
                                        class="{{ $ingreso->c_moneda == 'USD' && $ingreso->importe > 0 ? 'text-info' : 'text-muted' }}">
                                        $ {{ number_format($ingreso->c_moneda == 'USD' ? $ingreso->importe : 0, 2) }}

                                    </strong>
                                </td>
                                <td>
                                    <strong
                                        class="{{ $ingreso->c_moneda == 'MXN' && $ingreso->importe > 0 ? 'text-info' : 'text-muted' }}">
                                        $ {{ number_format($ingreso->c_moneda == 'MXN' ? $ingreso->importe : 0, 2) }}

                                    </strong>
                                </td>
                                <td>
                                    <strong
                                        class="{{ $ingreso->c_moneda == 'USD' && $ingreso->comision > 0 ? 'text-info' : 'text-muted' }}">
                                        $ {{ number_format($ingreso->c_moneda == 'USD' ? $ingreso->comision : 0, 2) }}

                                    </strong>
                                </td>
                                <td>
                                    <strong
                                        class="{{ $ingreso->c_moneda == 'MXN' && $ingreso->comision > 0 ? 'text-info' : 'text-muted' }}">
                                        $ {{ number_format($ingreso->c_moneda == 'MXN' ? $ingreso->comision : 0, 2) }}

                                    </strong>
                                </td>
                                <td>
                                    <strong
                                        class="{{ $ingreso->c_moneda == 'USD' && $ingreso->total > 0 ? 'text-info' : 'text-muted' }}">
                                        ${{ number_format($ingreso->c_moneda == 'USD' ? $ingreso->total : 0, 2) }}
                                    </strong>
                                </td>
                                <td>
                                    <strong
                                        class="{{ $ingreso->c_moneda == 'MXN' && $ingreso->total > 0 ? 'text-info' : 'text-muted' }}">
                                        $ {{ number_format($ingreso->c_moneda == 'MXN' ? $ingreso->total : 0, 2) }}

                                    </strong>
                                </td>

                            </tr>
                        @endforeach


                    </tbody>
                    <tfoot>

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

    {{-- Modal de confirmación masiva --}}
    @if ($mostrarModalConfirmacion)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-question-circle text-warning"></i>
                            Confirmar Ingresos
                        </h5>
                        <button type="button" class="btn-close" wire:click="cerrarModalConfirmacion"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro que desea confirmar los <strong>{{ count($ingresosSeleccionados) }}</strong>
                            ingresos seleccionados?</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Esta acción no se puede deshacer. Los ingresos confirmados cambiarán su estado a
                            "Confirmado".
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="cerrarModalConfirmacion">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-success" wire:click="confirmarIngresosSeleccionados">
                            <i class="fas fa-check"></i>
                            Confirmar Ingresos
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />

</div>
