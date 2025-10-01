<?php

namespace App\Livewire\Admin\Ventas\Reservas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Ventas\ReservaService;



class ReservasDetalles extends Component
{

    public $guid;
    private $reservaService;


     public function boot(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }

    public function mount($guid)
    {
        $this->guid = $guid;
    }



    public function render()
    {


         $data = [
            'reserva' => $this->reservaService->reservaByGuid($this->guid),
        ];


        return view('livewire.admin.ventas.reservas.reserva-detalle', $data);
    }


}
