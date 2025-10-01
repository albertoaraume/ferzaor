<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dashboardVentasActividades extends Component
{

    public $actividades;
    public $totales;
    /**
     * Create a new component instance.
     */
    public function __construct($actividades, $totales)
    {


        $this->actividades = $actividades;
         $this->totales = $totales;
    }

        //


    /**
     * Get the view / contents that represent the component.
     */

    public function render(): View|Closure|string
    {
        return view('components.admin.dashboards.ventas.dashboard-ventas-actividades', [
            'actividades' => $this->actividades,
            'totales' => $this->totales
        ]   );
    }
}
