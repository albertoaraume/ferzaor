<?php

namespace App\Livewire\Admin\Reportes\Ventas;

use Livewire\Component;

use App\Services\Reportes\Ventas\RptCortesService;
use App\Services\Ventas\ReservaService;
use Carbon\Carbon;

class VtaCortes extends Component
{
 

    public $fechaInicio;
    public $fechaFin;

    public $locacionId = '';
    private $reporteService;






    public function boot(RptCortesService $reporteService)
    {
        $this->reporteService = $reporteService;
  
    }

    public function mount()
    {
         $this->fechaInicio =  now()->addDay(-2)->format('Y-m-d');
        $this->fechaFin = now()->format('Y-m-d');
    }

  



    public function updatingLocacionId()
    {
        $this->dispatch('refreshDataTable');
    }

    public function getDataTableData()
    {
        $filtros = $this->obtenerFiltros();
        $cortes = $this->reporteService->obtenerCortes($filtros);
        return $cortes;
    }

        // Método para ver detalle




    public function refresh()
    {
        $this->dispatch('refreshDataTable');
        session()->flash('message', 'Datos actualizados correctamente');
    }

    public function render()
    {
        $filtros = $this->obtenerFiltros();
        $cortes = $this->reporteService->obtenerCortes($filtros);

        $totales = $this->reporteService->obtenerTotales($cortes);

        $data = [
            'cortes' => $cortes,
            'filtrosDisponibles' => $this->reporteService->obtenerFiltrosDisponibles(),
            'totales' => $totales,
        ];

        return view('livewire.admin.reportes.ventas.vta-cortes', $data);
    }

    private function obtenerFiltros(): array
    {
        return [
          
            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin' => $this->fechaFin,
           
            'locacion_id' => $this->locacionId,
        ];
    }
}
