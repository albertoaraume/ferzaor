<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dashboardVentasProductos extends Component
{

   public $productos;
    public $totales;
    /**
     * Create a new component instance.
     */
    public function __construct($productos, $totales)
    {
        $this->productos = $productos;
        $this->totales = $totales;

        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.dashboards.ventas.dashboard-ventas-productos', [
            'productos' => $this->productos
            ,'totales' => $this->totales
        ]);
    }
}
