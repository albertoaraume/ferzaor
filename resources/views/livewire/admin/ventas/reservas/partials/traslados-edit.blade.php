<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Transportación</th>
                <th>Ruta</th>
                <th>Fecha/Hora</th>
                <th>Pax</th>
                <th>Tarifa</th>
                <th>Moneda</th>
                <th>Estado</th>
                <th width="200">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reserva->traslados->where('status', '!=', 0) as $traslado)
            <tr class="{{ $traslado->status == 0 ? 'table-danger' : '' }}">
                <td>
                    <div class="d-flex flex-column">
                        <span class="fw-bold">{{ $traslado->nombreTransportacion ?? 'Traslado' }}</span>
                        <small class="text-muted">ID: {{ $traslado->idRT }}</small>
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <small><i class="fas fa-map-marker-alt text-success"></i> {{ $traslado->nombreLocacionPickUp ?? 'N/A' }}</small>
                        <small><i class="fas fa-map-marker-alt text-danger"></i> {{ $traslado->nombreLocacionDropOff ?? 'N/A' }}</small>
                    </div>
                </td>
                <td>
                    @if($traslado->fechaArrival)
                        <div class="d-flex flex-column">
                            <span>{{ \Carbon\Carbon::parse($traslado->fechaArrival)->format('d/m/Y') }}</span>
                            <small class="text-muted">{{ $traslado->horaArrival ?? 'Sin hora' }}</small>
                        </div>
                    @else
                        <span class="text-muted">Sin programar</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-info">{{ $traslado->pax }}</span>
                </td>
                <td>
                    <span class="fw-bold">${{ number_format($traslado->TarifaDisplay, 2) }}</span>
                </td>
                <td>
                    <span class="badge bg-secondary">{{ $traslado->c_moneda }}</span>
                </td>
                <td>
                    {!! $traslado->Badge !!}
                </td>
                <td>
                    <div class="btn-group" role="group">
                        @if($traslado->status != 0)
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            wire:click="editarTraslado({{ $traslado->idRT }})"
                            data-bs-toggle="tooltip" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            wire:click="abrirModalCancelacion('traslado', {{ $traslado->idRT }})"
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

@if($reserva->traslados->where('status', '!=', 0)->count() == 0)
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>
    No hay traslados activos para editar en esta reserva.
</div>
@endif
