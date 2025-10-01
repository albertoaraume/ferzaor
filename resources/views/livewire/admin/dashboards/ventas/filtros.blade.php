  <!-- Filtros -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Locación</label>
                        <select class="form-control" wire:model="locacion_id">
                            <option value="">Todas las locaciones</option>
                            @foreach ($listlocaciones as $locacion)
                                <option value="{{ $locacion->idLocacion }}">{{ $locacion->nombreLocacion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Fecha Inicio</label>
                        <input type="date" class="form-control" wire:model="fecha_inicio">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>Fecha Fin</label>
                        <input type="date" class="form-control" wire:model="fecha_fin">
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="d-flex">
                            <button wire:click="aplicarFiltros" class="btn btn-filters btn-primary ms-auto">
                                <i class="fa fa-search me-2"></i>Aplicar Filtros
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
