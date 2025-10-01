<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Servicio</th>
                <th>Código</th>
                <th>Fecha</th>
                <th>Pax</th>
                <th>Precio</th>
                <th>Moneda</th>
                <th>Estado</th>
                <th width="200">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reserva->adicionales->where('status', '!=', 0) as $servicio)
            <tr class="{{ $servicio->status == 0 ? 'table-danger' : '' }}">
                <td>
                    <div class="d-flex flex-column">
                        <span class="fw-bold">{{ $servicio->nombreServicio ?? 'Servicio Adicional' }}</span>
                        <small class="text-muted">ID: {{ $servicio->idAD }}</small>
                    </div>
                </td>
                <td>{{ $servicio->codigo ?? 'N/A' }}</td>
                <td>
                    @if($servicio->fecha)
                        <div class="d-flex flex-column">
                            <span>{{ \Carbon\Carbon::parse($servicio->fecha)->format('d/m/Y') }}</span>
                            @if($servicio->hora)
                                <small class="text-muted">{{ $servicio->hora }}</small>
                            @endif
                        </div>
                    @else
                        <span class="text-muted">Sin fecha</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-info">{{ $servicio->pax ?? 1 }}</span>
                </td>
                <td>
                    <span class="fw-bold">${{ number_format($servicio->precio, 2) }}</span>
                </td>
                <td>
                    <span class="badge bg-secondary">{{ $servicio->c_moneda }}</span>
                </td>
                <td>
                    {!! $servicio->Badge !!}
                </td>
                <td>
                    <div class="btn-group" role="group">
                        @if($servicio->status != 0)
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            wire:click="editarServicio({{ $servicio->idAD }})"
                            data-bs-toggle="tooltip" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            wire:click="abrirModalCancelacion('servicio', {{ $servicio->idAD }})"
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

@if($reserva->adicionales->where('status', '!=', 0)->count() == 0)
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>
    No hay servicios adicionales activos para editar en esta reserva.
</div>
@endif
