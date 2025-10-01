<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class reservaCombos extends Component
{
    public $combos;
    /**
     * Create a new component instance.
     */
    public function __construct($combos)
    {
        $this->combos = $combos;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.reserva-combos', [
            'combos' => $this->combos
        ]);
    }   
}
