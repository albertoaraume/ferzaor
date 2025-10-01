<?php

namespace App\View\Components;

use Closure;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;
class modalDetalleTraslado extends Component
{

     public $trasladoDetalle;
    /**
     * Create a new component instance.
     */
    public function __construct($trasladoDetalle)
    {
        $this->trasladoDetalle = $trasladoDetalle;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        
        return view('components.admin.modal-detalle-traslado',[ 'trasladoDetalle' => $this->trasladoDetalle]);
    }
}
