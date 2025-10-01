<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class reservaServicios extends Component
{

    public $servicios;
    /**
     * Create a new component instance.
     */
    public function __construct($servicios)
    {
        $this->servicios = $servicios;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.reserva-servicios', [
            'servicios' => $this->servicios
        ]   );
    }
}
