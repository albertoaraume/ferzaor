<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dashboardVentasGraficos extends Component
{

      public array $utilidades;
        public array $descuentos;
        public array $comisiones;
        public array $labels;
        public array $porcentajes;

    /**
     * Create a new component instance.
     */
    public function __construct(
       array $utilidades,
       array $descuentos,
       array $comisiones,
       array $labels,
       array $porcentajes
    ) {
        $this->utilidades = $utilidades;
        $this->descuentos = $descuentos;
        $this->comisiones = $comisiones;
        $this->labels = $labels;
        $this->porcentajes = $porcentajes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.dashboards.ventas.dashboard-ventas-graficos');
    }
}
