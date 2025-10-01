<div>


    <!-- Tabla de Ventas-->

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Productos</h4>
            <p class="text-muted mb-0">Ranking de productos por rendimiento y utilidad</p>
        </div>
        <div class="card-body">


            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active " id="todos-tab" data-bs-toggle="tab" data-bs-target="#todos"
                                type="button" role="tab" aria-controls="todos" aria-selected="true">
                                <i class="fas fa-box me-2"></i>
                                Todos
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="actividades-tab" data-bs-toggle="tab" data-table-id="productos-actividades-table"
                                data-bs-target="#actividades" type="button" role="tab" aria-controls="actividades"
                                aria-selected="true">
                                <i class="fas fa-running me-2"></i>
                                Actividades
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="yates-tab" data-bs-toggle="tab" data-bs-target="#yates" data-table-id="productos-yates-table"
                                type="button" role="tab" aria-controls="yates" aria-selected="false">
                                <i class="fas fa-ship me-2"></i>
                                Yates
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="servicios-tab" data-bs-toggle="tab" data-bs-target="#servicios" data-table-id="productos-servicios-table"
                                type="button" role="tab" aria-controls="servicios" aria-selected="false">
                                <i class="fas fa-concierge-bell me-2"></i>
                                Servicios
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tours-tab" data-bs-toggle="tab" data-bs-target="#tours" data-table-id="productos-tours-table"
                                type="button" role="tab" aria-controls="tours" aria-selected="false">
                                <i class="fas fa-map me-2"></i>
                                Tours
                            </button>
                        </li>

                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        <!-- Tab Todos -->
                        <div class="tab-pane fade show active" id="todos" role="tabpanel"
                            aria-labelledby="todos-tab">
                            <x-admin.dashboards.ventas.dashboard-ventas-productos :productos="$productos" :totales="$totales" />
                        </div>

                        <!-- Tab Actividades -->
                        <div class="tab-pane fade " id="actividades" role="tabpanel" aria-labelledby="actividades-tab">
                            <x-admin.dashboards.ventas.dashboard-ventas-actividades :actividades="$actividades" :totales="$totales"  />
                        </div>

                        <!-- Tab Yates -->
                        <div class="tab-pane fade" id="yates" role="tabpanel" aria-labelledby="yates-tab">
                            <x-admin.dashboards.ventas.dashboard-ventas-yates :yates="$yates" :totales="$totales"  />
                        </div>

                        <div class="tab-pane fade" id="servicios" role="tabpanel" aria-labelledby="servicios-tab">
                            <x-admin.dashboards.ventas.dashboard-ventas-servicios :servicios="$servicios" :totales="$totales"  />
                        </div>


                        <div class="tab-pane fade" id="tours" role="tabpanel" aria-labelledby="tours-tab">
                                <x-admin.dashboards.ventas.dashboard-ventas-tours :tours="$tours" :totales="$totales"  />
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>







</div>
