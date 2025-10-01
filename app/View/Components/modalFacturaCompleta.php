<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class modalFacturaCompleta extends Component
{
    public $facturaCompleta;

    /**
     * Create a new component instance.
     */
    public function __construct($facturaCompleta)
    {
        $this->facturaCompleta = $facturaCompleta;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.modal-factura-completa', [
            'facturaCompleta' => $this->facturaCompleta
        ]);
    }
}
