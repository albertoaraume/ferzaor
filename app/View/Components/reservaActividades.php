<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class reservaActividades extends Component
{

    public $actividades;
    /**
     * Create a new component instance.
     */
    public function __construct($actividades)
    {
        $this->actividades = $actividades;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.reserva-actividades', [
            'actividades' => $this->actividades
            ]);
    }
}
