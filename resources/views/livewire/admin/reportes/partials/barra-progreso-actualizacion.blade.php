<div>
   
<div class="w-100 my-3">
        <label>Actualizando clientes...</label>
        <div class="progress" style="height: 25px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated"
                role="progressbar"
                style="width: {{ $totalClientes ? ($progreso / $totalClientes) * 100 : 0 }}%;"
                aria-valuenow="{{ $progreso }}"
                aria-valuemin="0"
                aria-valuemax="{{ $totalClientes }}">
                {{ $progreso }} / {{ $totalClientes }}
            </div>
        </div>
        <span wire:poll.1500ms="actualizarProgreso" style="display:none"></span>
    </div>
  
</div>