<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class dashboardVentasTours extends Component
{

    public $tours;
    public $totales;

    /**
     * Create a new component instance.
     */
    public function __construct($tours, $totales)
    {


        $this->tours = $tours;
         $this->totales = $totales;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.dashboards.ventas.dashboard-ventas-tours', [
            'tours' => $this->tours,
            'totales' => $this->totales,
        ]);
    }
}
