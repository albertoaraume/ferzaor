@if($mostrarModalServicio)
<div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-concierge-bell me-2"></i>
                    Editar Servicio Adicional
                </h5>
                <button type="button" class="btn-close btn-close-white" wire:click="cerrarTodosLosModales"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="guardarCambios">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Servicio:</label>
                            <p class="text-muted">{{ $itemEnEdicion['nombre'] ?? '' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nuevoPrecio" class="form-label">Precio <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">{{ $itemEnEdicion['moneda'] ?? 'USD' }}</span>
                                <input type="number" class="form-control" id="nuevoPrecio"
                                       wire:model="nuevoPrecio" step="0.01" min="0">
                            </div>
                            @error('nuevoPrecio') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nuevoPax" class="form-label">Pasajeros <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nuevoPax"
                                   wire:model="nuevoPax" min="1">
                            @error('nuevoPax') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nuevaFecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="nuevaFecha"
                                   wire:model="nuevaFecha">
                            @error('nuevaFecha') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nuevaHora" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="nuevaHora"
                                   wire:model="nuevaHora">
                            @error('nuevaHora') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarTodosLosModales">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-primary" wire:click="guardarCambios">
                    <i class="fas fa-save me-1"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>
@endif
