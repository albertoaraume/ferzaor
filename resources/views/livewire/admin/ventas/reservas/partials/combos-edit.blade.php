<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Combo</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Pax</th>
                <th>Precio</th>
                <th>Moneda</th>
                <th>Estado</th>
                <th width="200">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reserva->combos->where('status', '!=', 0) as $combo)
            <tr class="{{ $combo->status == 0 ? 'table-danger' : '' }}">
                <td>
                    <div class="d-flex flex-column">
                        <span class="fw-bold">{{ $combo->ComboDisplay ?? 'Combo' }}</span>
                        <small class="text-muted">ID: {{ $combo->idRC }}</small>
                    </div>
                </td>
                <td>{{ $combo->tipo ?? 'N/A' }}</td>
                <td>
                    @if($combo->fecha)
                        <div class="d-flex flex-column">
                            <span>{{ \Carbon\Carbon::parse($combo->fecha)->format('d/m/Y') }}</span>
                            @if($combo->hora)
                                <small class="text-muted">{{ $combo->hora }}</small>
                            @endif
                        </div>
                    @else
                        <span class="text-muted">Sin fecha</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-info">{{ $combo->pax ?? 1 }}</span>
                </td>
                <td>
                    <span class="fw-bold">${{ number_format($combo->precio, 2) }}</span>
                </td>
                <td>
                    <span class="badge bg-secondary">{{ $combo->c_moneda }}</span>
                </td>
                <td>
                    {!! $combo->Badge !!}
                </td>
                <td>
                    <div class="btn-group" role="group">
                        @if($combo->status != 0)
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            wire:click="editarCombo({{ $combo->idRC }})"
                            data-bs-toggle="tooltip" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            wire:click="abrirModalCancelacion('combo', {{ $combo->idRC }})"
                            data-bs-toggle="tooltip" title="Cancelar">
                            <i class="fas fa-times"></i>
                        </button>
                        @else
                        <span class="text-muted small">Cancelado</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($reserva->combos->where('status', '!=', 0)->count() == 0)
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>
    No hay combos activos para editar en esta reserva.
</div>
@endif
