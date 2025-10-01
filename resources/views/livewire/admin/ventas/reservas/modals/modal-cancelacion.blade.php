@if($mostrarModalCancelacion)
<div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Cancelación
                </h5>
                <button type="button" class="btn-close btn-close-white" wire:click="cerrarTodosLosModales"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-warning me-2"></i>
                    <strong>¿Está seguro que desea cancelar este {{ $tipoItemEnEdicion }}?</strong>
                    <p class="mb-0 mt-2">Esta acción no se puede deshacer. El servicio quedará marcado como cancelado.</p>
                </div>

                <div class="mb-3">
                    <label for="motivoCancelacion" class="form-label">Motivo de cancelación <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="motivoCancelacion" rows="3"
                              wire:model="motivoCancelacion"
                              placeholder="Ingrese el motivo de la cancelación..."></textarea>
                    @if(empty($motivoCancelacion) && $errors->has('motivoCancelacion'))
                        <div class="text-danger small">El motivo de cancelación es obligatorio</div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" wire:click="cerrarTodosLosModales">
                    <i class="fas fa-times me-1"></i>No, Cancelar
                </button>
                <button type="button" class="btn btn-danger"
                        wire:click="cancelarItem"
                        @if(empty($motivoCancelacion)) disabled @endif>
                    <i class="fas fa-trash me-1"></i>Sí, Cancelar Servicio
                </button>
            </div>
        </div>
    </div>
</div>
@endif
