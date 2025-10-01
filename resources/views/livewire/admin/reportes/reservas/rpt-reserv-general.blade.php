<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Reporte de Reservas</h4>
                <h6>Detalles de Reservas</h6>
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
                <table class="table datatable" id="reservasTable">
                    <thead class="thead-light">
                        <tr>
                            <td>Opcion</td>
                            <td>Status</td>
                            <td>Pagada</td>
                            <td>Tipo</td>
                            <td>Folio</td>
                          
                            <td>Cliente</td>
                            <td>Hotel</td>
                            <td>Agencia</td>
                            <td>Vendedor</td>
                            <td>Locacion</td>
                            <td>Fecha Compra</td>
                            <td>Moneda</td>
                            <td colspan="2" class="text-center">SubTotal</td>
                            <td colspan="2" class="text-center">Comision</td>
                            <td colspan="2" class="text-center">Credito</td>
                            <td colspan="2" class="text-center">Balance</td>
                            <td colspan="2" class="text-center">Total</td>
                            <td colspan="2" class="text-center">Saldo</td>
                        </tr>
                        <tr>
                            <td colspan="12"></td>
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

                        @forelse ($reservas as $reserva)
                            <tr>
                                <td>
                                    <div class="btn-group dropup my-1">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">

                                            <li><a class="dropdown-item" href="javascript:void(0);"
                                                    wire:click="verReservaCompleta({{ $reserva['idReserva'] }})">Vista
                                                    previa</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Cancelar</a></li>
                                        </ul>
                                    </div>
                                </td>
                               <td>{!! $reserva['badge'] !!}</td>
                                <td>{!! $reserva['pagada'] !!}</td>
                               <td>{{ $reserva['tipo'] }}</td>
                            
                            
                               <td>{{ $reserva['folio'] }}</td>
                           
                                <td>{{ $reserva['cliente'] }}</td>
                                <td>{{ $reserva['hotel'] }}</td>
                                <td>{{ $reserva['agencia'] }}</td>
                                <td>{{ $reserva['vendedor'] }}</td>
                                <td>{{ $reserva['locacion'] }}</td>
                                <td>{{ $reserva['fechaCompra'] }}</td>
                                <td>{{ $reserva['moneda'] }}</td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'USD' && $reserva['subtotal'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'USD' ? number_format($reserva['subtotal'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'MXN' && $reserva['subtotal'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'MXN' ? number_format($reserva['subtotal'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'USD' && $reserva['comision'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'USD' ? number_format($reserva['comision'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'MXN' && $reserva['comision'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'MXN' ? number_format($reserva['comision'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'USD' && $reserva['credito'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'USD' ? number_format($reserva['credito'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'MXN' && $reserva['credito'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'MXN' ? number_format($reserva['credito'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'USD' && $reserva['balance'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'USD' ? number_format($reserva['balance'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'MXN' && $reserva['balance'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'MXN' ? number_format($reserva['balance'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'USD' && $reserva['total'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'USD' ? number_format($reserva['total'], 2) : '0.00' }}
                                </td>
                                <td
                                    class="text-end {{ $reserva['moneda'] === 'MXN' && $reserva['total'] > 0 ? 'fw-bold text-info' : '' }}">
                                    {{ $reserva['moneda'] === 'MXN' ? number_format($reserva['total'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $reserva['moneda'] === 'USD' && $reserva['saldo'] > 0 ? 'fw-bold text-danger' : '' }}">
                                    {{ $reserva['moneda'] === 'USD' ? number_format($reserva['saldo'], 2) : '0.00' }}
                                </td>
                                <td class="text-end {{ $reserva['moneda'] === 'MXN' && $reserva['saldo'] > 0 ? 'fw-bold text-danger' : '' }}">
                                    {{ $reserva['moneda'] === 'MXN' ? number_format($reserva['saldo'], 2) : '0.00' }}
                                </td>
                            </tr>
                            @empty
                           
                        @endforelse
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
    <!-- /Yates list -->




    <x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />

    <x-admin.modal-reserva-completa :reserva-completa="$this->reservaCompleta" />
</div>
