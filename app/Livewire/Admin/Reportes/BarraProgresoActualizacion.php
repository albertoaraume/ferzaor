<?php
namespace App\Livewire\Admin\Reportes;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class BarraProgresoActualizacion extends Component
{public $userId;
    public $progreso = 0;
    public $totalClientes = 0;
 

    protected $listeners = ['iniciarActualizacion' => 'iniciarActualizacion'];

    public function mount($userId, $totalClientes)
    {
        $this->userId = $userId;
        $this->totalClientes = $totalClientes;
       
    }

    public function actualizarProgreso()
    {
        $this->progreso = Cache::get('progreso_actualizacion_' . $this->userId, 0);    
        if ($this->progreso >= $this->totalClientes) {                      
            $this->dispatch('actualizacionCompletada');
            Cache::forget('progreso_actualizacion_' . $this->userId);
        }
    }

    public function render()
    {
        return view('livewire.admin.reportes.partials.barra-progreso-actualizacion');
    }
}
