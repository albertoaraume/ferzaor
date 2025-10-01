<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class reservaYates extends Component
{
    public $yates;
    /**
     * Create a new component instance.
     */
    public function __construct($yates)
    {
        $this->yates = $yates;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.reserva-yates', [
            'yates' => $this->yates
        ]);
    }
}
