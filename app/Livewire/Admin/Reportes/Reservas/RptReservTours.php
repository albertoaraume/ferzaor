<?php

namespace App\Livewire\Admin\Reportes\Reservas;

use Livewire\Component;
use App\Services\Reportes\Reservas\RptReservToursService;
use Carbon\Carbon;
use Log;

class RptReservTours extends Component
{

        public $fechaInicio;
    public $fechaFin;
    public $estado = '';
    public $clienteId = '';
    public $locacionId = '';
    public $proveedorId = '';
    public $tourId = '';
    public $mostrarEstadisticas = false;
    private $reporteService;    
   
    public $tours;
    public $toursTopVendidos;
    public $locacionesTopVentas;
    public $proveedoresTopVentas;
    public $proveedorTopComisiones;
    public $vendedoresTopVentasPax;
    public $vendedoresTopVentas;   
    public $vendedoresTopUtilidades;
    public $vendedoresTopComisiones;
    public $metodosTopPagos;

    
    public function boot(RptReservToursService $reporteService)
    {
        $this->reporteService = $reporteService;
       
    }

    public function mount()
    {
        $this->fechaInicio =  now()->day(-7)->format('Y-m-d');
       $this->fechaFin = now()->format('Y-m-d');
       
    }

        public function toggleEstadisticas()
    {
        $this->mostrarEstadisticas = !$this->mostrarEstadisticas;

        if( $this->mostrarEstadisticas ) {
        $this->toursTopVendidos  = $this->reporteService->topToursVendidos($this->tours);
        $this->locacionesTopVentas = $this->reporteService->topLocacionesVentas($this->tours);
        $this->proveedoresTopVentas = $this->reporteService->topProveedoresVentas($this->tours);
        $this->proveedorTopComisiones = $this->reporteService->topProveedoresComisiones($this->tours);
        $this->vendedoresTopVentasPax = $this->reporteService->topVendedoresVentasPax($this->tours); // IGNORE
        $this->vendedoresTopVentas = $this->reporteService->topVendedoresVentas($this->tours);
        $this->vendedoresTopUtilidades = $this->reporteService->topVendedoresUtilidades($this->tours);

        $this->vendedoresTopComisiones = $this->reporteService->topVendedoresComisiones($this->tours);

        $this->metodosTopPagos = $this->reporteService->topMetodosPagos($this->tours);
        
        }
         $this->dispatch('refreshDataTable');
    }

    public function updatingEstado()
    {
        //$this->resetPage();
        $this->dispatch('refreshDataTable');
    }

    public function updatingClienteId()
    {
        //$this->resetPage();
        $this->dispatch('refreshDataTable');
    }

    public function updatingLocacionId()
    {
        // $this->resetPage();
        $this->dispatch('refreshDataTable');
    }

    public function updatingTourId()
    {
        // $this->resetPage();
        $this->dispatch('refreshDataTable');
    }


     public function updatingProveedorId()
    {
        // $this->resetPage();
        $this->dispatch('refreshDataTable');
    }

   




    public function refresh()
{

     $this->dispatch('refreshDataTable');
    
    session()->flash('message', 'Datos actualizados correctamente');
}




 

    public function render()
    {
        $filtros = $this->obtenerFiltros();

        $this->tours = $this->reporteService->obtenerTours($filtros);

        $totales= $this->reporteService->obtenerTotales();
 $data = [
            'tours' => $this->tours,
            'filtrosDisponibles' => $this->reporteService->obtenerFiltrosDisponibles(),
            'totales' => $totales,
            'topToursVendidos' => $this->toursTopVendidos,
            'topLocacionesVentas' => $this->locacionesTopVentas,
            'topProveedoresVentas' => $this->proveedoresTopVentas,
            'topProveedoresComisiones' => $this->proveedorTopComisiones,
            'topVendedoresVentasPax' => $this->vendedoresTopVentasPax,
            'topVendedoresVentas' => $this->vendedoresTopVentas,
            'topVendedoresUtilidades' => $this->vendedoresTopUtilidades,
            'topVendedoresComisiones' => $this->vendedoresTopComisiones,
            'topMetodosPagos' => $this->metodosTopPagos,
        ];
        return view('livewire.admin.reportes.reservas.rpt-reserv-tours', $data);
    }




     private function obtenerFiltros(): array
    {
        return [
            
            'estado' => $this->estado,
            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin' => $this->fechaFin,
            'cliente_id' => $this->clienteId,
            'locacion_id' => $this->locacionId,
            'tour_id' => $this->tourId,
            'proveedor_id' => $this->proveedorId,
        ];
    }


}
