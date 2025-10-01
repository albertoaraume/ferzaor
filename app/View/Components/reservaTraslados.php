<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class reservaTraslados extends Component
{
    public $traslados;

    /**
     * Create a new component instance.
     */
    public function __construct($traslados)
    {
        $this->traslados = $traslados;
    }

    /**
     * Get the view / contents that represent the component.
     */             
     
    public function render(): View|Closure|string
    {
        return view('components.admin.reserva-traslados', [
            'traslados' => $this->traslados
        ]);
    }
}
