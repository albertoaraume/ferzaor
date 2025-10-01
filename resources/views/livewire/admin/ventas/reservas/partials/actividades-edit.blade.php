<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Actividad</th>
                <th>Paquete</th>
                <th>Fecha/Hora</th>
                <th>Pax</th>
                <th>Precio</th>
                <th>Moneda</th>
                <th>Estado</th>
                <th width="200">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reserva->actividades as $actividad)
                @foreach($actividad->unidades->where('status', '!=', 0) as $unidad)
                <tr class="{{ $unidad->status == 0 ? 'table-danger' : '' }}">
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-bold">{{ $unidad->ActividadDisplay }}</span>
                            <small class="text-muted">ID: {{ $unidad->idAU }}</small>
                        </div>
                    </td>
                    <td>{{ $unidad->PaqueteDisplay }}</td>
                    <td>
                        @if($unidad->start)
                            <div class="d-flex flex-column">
                                <span>{{ \Carbon\Carbon::parse($unidad->start)->format('d/m/Y') }}</span>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($unidad->start)->format('H:i') }}</small>
                            </div>
                        @else
                            <span class="text-muted">Sin programar</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $unidad->pax }}</span>
                    </td>
                    <td>
                        <span class="fw-bold">${{ number_format($unidad->precio, 2) }}</span>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $unidad->c_moneda }}</span>
                    </td>
                    <td>
                        {!! $unidad->Badge !!}
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            @if($unidad->status != 0)
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                wire:click="editarActividad({{ $unidad->idAU }})"
                                data-bs-toggle="tooltip" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger"
                                wire:click="abrirModalCancelacion('actividad', {{ $unidad->idAU }})"
                                data-bs-toggle="tooltip" title="Cancelar">
                                <i class="fas fa-times"></i>
                            </button>
                            @else
                            <span class="text-muted small">Cancelada</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>

@if($reserva->actividades->flatMap->unidades->where('status', '!=', 0)->count() == 0)
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>
    No hay actividades activas para editar en esta reserva.
</div>
@endif
