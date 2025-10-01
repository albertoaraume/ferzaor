<div>

    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Pendientes de Pago</h4>
                <h6>Clientes</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <button wire:click="forzarActualizacionCompleta" class="btn btn-info btn-sm me-2"
                    wire:loading.attr="disabled" wire:loading.class="disabled">
                    <span wire:loading.remove>
                        <i class="fas fa-sync-alt"></i>
                        Actualizar Todos
                    </span>
                    <span wire:loading>
                        <i class="fas fa-spinner fa-spin"></i> Procesando...
                    </span>
                </button>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel" wire:click="exportar"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="exportar">
                        <img src="{{ URL::asset('build/img/icons/excel.svg') }}" alt="img">
                    </span>
                    <span wire:loading wire:target="exportar">
                        <i class="fas fa-spinner fa-spin"></i> Exportando...
                    </span>
                </a>
            </li>
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
        <div class="alert alert-danger alert-dismissible fade show custom-alert-icon shadow-sm d-flex align-items-centers"
            role="alert">
            <i class="feather-alert-octagon flex-shrink-0 me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                    class="fas fa-xmark"></i></button>
        </div>
    @endif


    {{-- ...existing code... --}}
    @if ($procesando)
        <livewire:admin.reportes.barra-progreso-actualizacion :user-id="auth()->user()->id" :total-clientes="$totalClientes" />
    @endif
    {{-- ...existing code... --}}



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice-dollar me-2"></i>
                        Pendientes de Pago
                    </h3>
                </div>
                <div class="card-body">


                    <!-- Filtros -->
                    <div class="row mb-4">

                        <div class="col-md-10">
                            <label for="busqueda" class="form-label">Buscar Cliente</label>
                            <input type="text" wire:model.live="busqueda" class="form-control" id="busqueda"
                                placeholder="Buscar por nombre comercial...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button wire:click="limpiarFiltros" class="btn btn-secondary"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-eraser"></i> Limpiar
                                </button>

                            </div>
                        </div>
                    </div>

                    <!-- Indicador de carga -->
                    <div wire:loading wire:target="obtenerEstadisticasGenerales" class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p class="mt-2">Cargando estado de cuenta...</p>
                    </div>

                    <!-- Tabla de Estado de Cuenta -->
                    <div wire:loading.remove wire:target="obtenerEstadisticasGenerales" class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <td></th>
                                    <td>ID</th>
                                    <td>Cliente</th>
                                    <td colspan="2" class="text-center">Actividades</td>
                                    <td colspan="2" class="text-center">Yates</td>
                                    <td colspan="2" class="text-center">Facturas</td>
                                    <td>Saldo USD</td>
                                    <td>Saldo MXN</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td class="text-center">USD</td>
                                    <td class="text-center">MXN</td>
                                       <td class="text-center">USD</td>
                                    <td class="text-center">MXN</td>
                                       <td class="text-center">USD</td>
                                    <td class="text-center">MXN</td>
                                    <td colspan="3"></td>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estadoCuentas as $estadoCuenta)
                                    <tr>
                                        <td>
                                            <button
                                                wire:click="toggleDetalle({{ $estadoCuenta['cliente']->idCliente }})"
                                                class="btn btn-sm btn-outline-primary">
                                                <i
                                                    class="fas fa-{{ isset($mostrarDetalle[$estadoCuenta['cliente']->idCliente]) ? 'minus' : 'plus' }}"></i>
                                            </button>
                                        </td>
                                        <td>{{ $estadoCuenta['cliente']->idCliente }} </td>
                                        <td>
                                            <strong>{{ $estadoCuenta['cliente']->nombreComercial }}</strong>
                                            @if ($estadoCuenta['cliente']->contacto)
                                                <br><small
                                                    class="text-muted">{{ $estadoCuenta['cliente']->contacto }}</small>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($estadoCuenta['actividades']['saldo_usd'] > 0)
                                                <span
                                                    class="text-info">{{ number_format($estadoCuenta['actividades']['saldo_usd'], 2) }}
                                                    <small>USD</small> </span>
                                            @else
                                                <span class="text-muted">0.00</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($estadoCuenta['actividades']['saldo_mxn'] > 0)
                                                <span
                                                    class="text-info">{{ number_format($estadoCuenta['actividades']['saldo_mxn'], 2) }}
                                                    <small>MXN</small> </span>
                                            @else
                                                <span class="text-muted">0.00</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($estadoCuenta['yates']['saldo_usd'] > 0)
                                                <span
                                                    class="text-info">{{ number_format($estadoCuenta['yates']['saldo_usd'], 2) }}
                                                    <small>USD</small></span>
                                            @else
                                                <span class="text-muted">0.00</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($estadoCuenta['yates']['saldo_mxn'] > 0)
                                                <span
                                                    class="text-info">{{ number_format($estadoCuenta['yates']['saldo_mxn'], 2) }}
                                                    <small>MXN</small> </span>
                                            @else
                                                <span class="text-muted">0.00</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($estadoCuenta['facturas']['saldo_usd'] > 0)
                                                <span
                                                    class="text-info">{{ number_format($estadoCuenta['facturas']['saldo_usd'], 2) }}
                                                    <small>USD</small></span>
                                            @else
                                                <span class="text-muted">0.00</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($estadoCuenta['facturas']['saldo_mxn'] > 0)
                                                <span
                                                    class="text-info">{{ number_format($estadoCuenta['facturas']['saldo_mxn'], 2) }}
                                                    <small>MXN</small></span>
                                            @else
                                                <span class="text-muted">0.00</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($estadoCuenta['saldo_total_usd'] > 0)
                                                <strong
                                                    class="text-success">${{ number_format($estadoCuenta['saldo_total_usd'], 2) }}</strong>
                                            @else
                                                <span class="text-muted">$0.00</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($estadoCuenta['saldo_total_mxn'] > 0)
                                                <strong
                                                    class="text-warning">${{ number_format($estadoCuenta['saldo_total_mxn'], 2) }}</strong>
                                            @else
                                                <span class="text-muted">$0.00</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group dropup my-1">
                                                <button type="button"
                                                    class="btn btn-sm btn-icon btn-outline-primary rounded-pill"
                                                    data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="javascript:void(0);"
                                                            wire:click="actualizarCliente({{ $estadoCuenta['cliente']->idCliente }})">Actualizar</a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="javascript:void(0);">Imprimir</a>
                                                    </li>
                                                    <li><a class="dropdown-item" href="javascript:void(0);">Exportar
                                                            PDF</a></li>


                                                </ul>
                                            </div><br>
                                            <span wire:loading
                                                wire:target="actualizarCliente({{ $estadoCuenta['cliente']->idCliente }})">
                                                <i class="fas fa-spinner fa-spin me-2"></i>Actualizando...
                                            </span>


                                        </td>
                                    </tr>

                                    <!-- Detalle expandible -->
                                    @if (isset($mostrarDetalle[$estadoCuenta['cliente']->idCliente]))
                                        <tr>
                                            <td colspan="12" class="p-0">
                                                <div class="bg-light p-3">
                                                    @php
                                                        $tiposServicios = [
                                                            'actividades' => [
                                                                'titulo' => 'Actividades',
                                                                'color' => 'info',
                                                                'icon' => 'fas fa-map-marker-alt',
                                                            ],
                                                            'yates' => [
                                                                'titulo' => 'Yates',
                                                                'color' => 'primary',
                                                                'icon' => 'fas fa-ship',
                                                            ],

                                                            'facturas' => [
                                                                'titulo' => 'Facturas',
                                                                'color' => 'danger',
                                                                'icon' => 'fas fa-file-invoice',
                                                            ],
                                                        ];
                                                        $clienteId = $estadoCuenta['cliente']->idCliente;
                                                    @endphp

                                                    <!-- Pestañas -->
                                                    <ul class="nav nav-tabs" id="detalle-tabs-{{ $clienteId }}"
                                                        role="tablist">
                                                        @foreach ($tiposServicios as $tipo => $config)
                                                            @if ($estadoCuenta[$tipo]['total'] > 0)
                                                                <li class="nav-item" role="presentation">
                                                                    <button
                                                                        class="nav-link {{ $loop->first ? 'active' : '' }}"
                                                                        id="{{ $tipo }}-tab-{{ $clienteId }}"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#{{ $tipo }}-{{ $clienteId }}"
                                                                        type="button" role="tab"
                                                                        aria-controls="{{ $tipo }}-{{ $clienteId }}"
                                                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                                        <i class="{{ $config['icon'] }} me-2"></i>
                                                                        {{ $config['titulo'] }}
                                                                        <span
                                                                            class="badge bg-{{ $config['color'] }} ms-2">{{ $estadoCuenta[$tipo]['total'] }}</span>
                                                                    </button>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>

                                                    <!-- Contenido de las pestañas -->
                                                    <div class="tab-content mt-3"
                                                        id="detalle-content-{{ $clienteId }}">
                                                        @foreach ($tiposServicios as $tipo => $config)
                                                            @if ($estadoCuenta[$tipo]['total'] > 0)
                                                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                                                    id="{{ $tipo }}-{{ $clienteId }}"
                                                                    role="tabpanel"
                                                                    aria-labelledby="{{ $tipo }}-tab-{{ $clienteId }}">
                                                                    <div class="card border-0">
                                                                        <div class="card-body p-0">
                                                                            <div class="table-responsive">
                                                                                @if ($tipo == 'facturas')
                                                                                    @include(
                                                                                        'admin.panels.facturas',
                                                                                        [
                                                                                            'estadoCuenta' => $estadoCuenta,
                                                                                            'tipo' => $tipo,
                                                                                            'config' => $config,
                                                                                        ]
                                                                                    )
                                                                                @else
                                                                                    @include(
                                                                                        'admin.panels.servicios',
                                                                                        [
                                                                                            'estadoCuenta' => $estadoCuenta,
                                                                                            'tipo' => $tipo,
                                                                                            'config' => $config,
                                                                                        ]
                                                                                    )
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Resumen del tipo -->
                                                                    <div class="bg-light p-2 border-top">
                                                                        <div class="row text-center">
                                                                            <div class="col-md-4">
                                                                                <small class="text-muted">Total
                                                                                    {{ $config['titulo'] }}</small>
                                                                                <br>
                                                                                <strong
                                                                                    class="text-{{ $config['color'] }}">{{ $estadoCuenta[$tipo]['total'] }}</strong>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <small class="text-muted">Saldo
                                                                                    USD</small>
                                                                                <br>
                                                                                <strong
                                                                                    class="text-success">${{ number_format($estadoCuenta[$tipo]['saldo_usd'], 2) }}</strong>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <small class="text-muted">Saldo
                                                                                    MXN</small>
                                                                                <br>
                                                                                <strong
                                                                                    class="text-warning">${{ number_format($estadoCuenta[$tipo]['saldo_mxn'], 2) }}</strong>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="12" class="text-center py-4">
                                            <i class="fas fa-info-circle text-muted fa-2x mb-2"></i>
                                            <p class="text-muted">No se encontraron clientes con saldos pendientes</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-loading-overlay wire:loading.flex type="whirly" background="rgba(0,0,0,0.5)" z-index="9999"
        message="Cargando datos..." />
    <x-admin.modal-reserva-completa :reserva-completa="$this->reservaCompleta" />
    <x-admin.modal-factura-completa :factura-completa="$this->facturaCompleta" />
</div>
