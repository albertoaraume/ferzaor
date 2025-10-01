<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class modalReservaCompleta extends Component
{
    public $reservaCompleta;

    /**
     * Create a new component instance.
     */
    public function __construct($reservaCompleta)
    {
        $this->reservaCompleta = $reservaCompleta;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.modal-reserva-completa', [
            'reservaCompleta' => $this->reservaCompleta
        ]);
    }
}
