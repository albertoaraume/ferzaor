<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Yate</th>
                <th>Paquete</th>
                <th>Fecha/Hora</th>
                <th>Pax</th>
                <th>Tarifa</th>
                <th>Moneda</th>
                <th>Estado</th>
                <th width="200">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reserva->yates->where('status', '!=', 0) as $yate)
            <tr class="{{ $yate->status == 0 ? 'table-danger' : '' }}">
                <td>
                    <div class="d-flex flex-column">
                        <span class="fw-bold">{{ $yate->YateDisplay }}</span>
                        <small class="text-muted">ID: {{ $yate->idRY }}</small>
                    </div>
                </td>
                <td>{{ $yate->PaqueteDisplay }}</td>
                <td>
                    @if($yate->start)
                        <div class="d-flex flex-column">
                            <span>{{ \Carbon\Carbon::parse($yate->start)->format('d/m/Y') }}</span>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($yate->start)->format('H:i') }}</small>
                        </div>
                    @else
                        <span class="text-muted">Sin programar</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-info">{{ $yate->pax }}</span>
                </td>
                <td>
                    <span class="fw-bold">${{ number_format($yate->tarifa, 2) }}</span>
                </td>
                <td>
                    <span class="badge bg-secondary">{{ $yate->c_moneda }}</span>
                </td>
                <td>
                    {!! $yate->Badge !!}
                </td>
                <td>
                    <div class="btn-group" role="group">
                        @if($yate->status != 0)
                        <button type="button" class="btn btn-sm btn-outline-primary"
                            wire:click="editarYate({{ $yate->idRY }})"
                            data-bs-toggle="tooltip" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                            wire:click="abrirModalCancelacion('yate', {{ $yate->idRY }})"
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

@if($reserva->yates->where('status', '!=', 0)->count() == 0)
<div class="alert alert-info">
    <i class="fas fa-info-circle me-2"></i>
    No hay yates activos para editar en esta reserva.
</div>
@endif
