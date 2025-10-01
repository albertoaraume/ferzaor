<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dashboardVentasYates extends Component
{

    public $yates;
    public $totales;
    /**
     * Create a new component instance.
     */
    public function __construct($yates, $totales)
    {
        $this->yates = $yates;
        $this->totales = $totales;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
         return view('components.admin.dashboards.ventas.dashboard-ventas-yates', [
            'yates' => $this->yates,
            'totales' => $this->totales
        ]   );
    }
}
