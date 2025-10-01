<div>
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4>Reportes de Tours</h4>
                <h6>Tours</h6>
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
            <label for="tour" class="form-label">Tour</label>
            <select wire:model="tourId" class="form-control select2" id="tour">
                <option value="">Todos</option>
                @foreach ($filtrosDisponibles['tours'] as $idTour => $nombreTour)
                    <option value="{{ $idTour }}">{{ $nombreTour }}</option>
                @endforeach
            </select>
        </div>



    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="proveedor" class="form-label">Proveedor</label>
            <select wire:model="proveedorId" class="form-control select2" id="proveedor">
                <option value="">Todos</option>
                @foreach ($filtrosDisponibles['proveedores'] as $idProveedor => $nombreComercial)
                    <option value="{{ $idProveedor }}">{{ $nombreComercial }}</option>
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
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="button" class="btn btn-primary btn-sm" wire:click="refresh">
                <i class="fas fa-search me-1"></i> Aplicar Filtros
            </button>
            <button type="button" class="btn btn-info btn-sm" wire:click="toggleEstadisticas">
                <i class="fas fa-chart-bar me-1"></i>
                {{ $mostrarEstadisticas ? 'Ocultar' : 'Mostrar' }} Estadísticas
            </button>
        </div>

    </div>


    @if ($mostrarEstadisticas)
     @include('livewire.admin.reportes.reservas.partials.estadisticas-tours')
    @endif



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
                <table class="table datatable" id="toursTable">
                    <thead class="thead-light">
                        <tr>
                            <td>Opcion</td>
                            <td>Status</td>
                            <td>Folio</td>
                            <td>Fecha Venta</td>
                            <td>Fecha Excursion</td>
                            <td>Cupon</td>
                            <td>Agencia</td>
                            <td>Vendedor</td>
                            <td>Locacion</td>
                            <td>Cliente</td>
                            <td>Excursion</td>
                            <td>Proveedor</td>

                            <td>Moneda</td>
                            <td>Forma Pago</td>
                            <td>Pax</td>
                            <td class="text-center">PP</td>
                            <td class="text-center">TPP</td>
                            <td class="text-center">Descuento</td>
                            <td class="text-center">TPV</td>
                            <td class="text-center">SubTotal</td>
                            <td class="text-center">C/Proveedor</td>
                            <td class="text-center">Hotel</td>
                            <td class="text-center">Admin</td>
                            <td class="text-center">Supervisor</td>
                            <td class="text-center">C/Vendedor</td>
                            <td class="text-center">C/Pagadora</td>
                            <td class="text-center">Utilidad</td>
                            <td>P/Vendedor</td>
                            <td>P/Proveedor</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tours as $tour)
                          <tr class="{{ $tour['status'] == 0 ? 'table-danger' : '' }}"
        style="{{ $tour['status'] == 0 ? 'text-decoration: line-through; text-decoration-color: #dc3545; text-decoration-thickness: 2px;' : '' }}">

                                <td>

                                    <div class="btn-group dropup my-1">
                                        <button type="button"
                                            class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                            data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">Detalles</a></li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Cancelar</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{!! $tour['badge'] !!}</td>
                                <td>{{ $tour['folio'] }}</td>
                                <td>{{ $tour['fecha_venta'] }}</td>
                                <td>{{ $tour['fecha_excursion'] }}</td>
                                <td>{{ $tour['cupon'] }}</td>
                                <td>{{ $tour['agencia'] }}</td>
                                <td>{{ $tour['vendedor'] }}</td>
                                <td>{{ $tour['locacion'] }}</td>
                                <td>{{ $tour['cliente'] }}</td>
                                <td>{{ $tour['excursion'] }}</td>
                                <td>{{ $tour['proveedor'] }}</td>

                                <td>{{ $tour['moneda'] }}</td>
                                <td>{{ $tour['forma_pago'] }}</td>
                                <td class="text-center">{{ $tour['pax'] }}</td>
                                <td class="text-center">{{ number_format($tour['pp'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['tpp'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['descuento'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['tpv'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['subTotal'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['c_proveedor'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['c_hotel'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['feeAdmin'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['feeSupervisor'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['c_vendedor'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['c_pagadora'], 2) }}</td>
                                <td class="text-center">{{ number_format($tour['utilidad'], 2) }}</td>
                                <td>{!! $tour['pago_vendedor'] !!}</td>
                                <td>{!! $tour['pago_proveedor'] !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="14" class="text-end">Totales:</th>
                            <th class="text-center">{{ $totales['totales']['pax'] }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['pp'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['tpp'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['descuento'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['tpv'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['subTotal'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['c_proveedor'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['c_hotel'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['feeAdmin'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['feeSupervisor'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['c_vendedor'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['c_pagadora'], 2) }}</th>
                            <th class="text-center">{{ number_format($totales['totales']['utilidad'], 2) }}</th>
                            <th></th>
                            <th></th>
                        </tr>
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








    <x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />




</div>
