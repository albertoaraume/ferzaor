<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class modalDetalleActividad extends Component
{

     public $actividadDetalle;
    /**
     * Create a new component instance.
     */
    public function __construct($actividadDetalle)
    {
        $this->actividadDetalle = $actividadDetalle;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return view('components.admin.modal-detalle-actividad',[ 'actividadDetalle' => $this->actividadDetalle]);
    }
}
