<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dashboardVentasServicios extends Component
{

    public $servicios;
    public $totales;
    /**
     * Create a new component instance.
     */
    public function __construct($servicios, $totales)
    {
          $this->servicios = $servicios;
         $this->totales = $totales;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.dashboards.ventas.dashboard-ventas-servicios',
        [
            'servicios' => $this->servicios
            ,'totales' => $this->totales
        ]);
    }
}
