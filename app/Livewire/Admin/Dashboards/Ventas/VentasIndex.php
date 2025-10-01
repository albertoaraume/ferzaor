<?php

namespace App\Livewire\Admin\Dashboards\Ventas;

use Livewire\Component;
use App\Services\Dashboards\VentasService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class VentasIndex extends Component
{


    public $locacion_id = null;
    public $fecha_inicio = null;
    public $fecha_fin = null;

    private $ventasService;

    public $productos = [];
    public $actividades = [];
    public $yates = [];
    public $servicios = [];
    public $tours = [];


    public $proveedores = [];
    public $agencias = [];
    public $locaciones = [];

    public $cargaDatos = false;

    public $labels = [];
    public $utilidades = [];
    public $descuentos = [];
    public $comisiones = [];
    public $porcentajes = [];

    public $totales = [];


      public function boot(VentasService $ventasService)
    {
        $this->ventasService = $ventasService;
    }


    public function mount()
    {
        // Inicializa los filtros con valores por defecto si lo deseas
        $this->fecha_inicio = now()->subDays(7)->format('Y-m-d');
        $this->fecha_fin = now()->format('Y-m-d');


    }



    public function aplicarFiltros()
    {
        $this->cargaDatos = true;
    }



    public function cargarProductos()
    {
        try {
            $filtros = [
                'locacion_id' => $this->locacion_id,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
            ];
            $this->ventasService->configurarFiltros($filtros);

            $datos = $this->ventasService->obtenerProductos();

            $this->productos = $datos;





             $this->actividades = $datos->where('tipo', 'Actividad');
             $this->yates = $datos->where('tipo', 'Yate');
             $this->servicios = $datos->where('tipo', 'Servicio');
                $this->tours = $datos->where('tipo', 'Tour');

             $this->proveedores = $this->ventasService->obtenerProveedores();

             $this->agencias = $this->ventasService->obtenerAgencias();

             $this->locaciones = $this->ventasService->obtenerLocaciones();



            // Calcular las sumatorias después de cargar los datos
                $this->totales = $this->ventasService->obtenerSumatoriasPorTipo($this->productos);
                $this->totales['Proveedor'] = $this->ventasService->obtenerSumatorias($this->proveedores);
                $this->totales['Agencia'] = $this->ventasService->obtenerSumatorias($this->agencias);
                $this->totales['Locacion'] = $this->ventasService->obtenerSumatorias($this->locaciones);



              $this->dispatch('refreshDataTable');



        } catch (\Exception $e) {
            $this->dispatch('mostrar-error', ['mensaje' => 'Error al cargar Ventas: ' . $e->getMessage()]);
        }
    }






    public function render()
    {
        $listLocaciones = $this->ventasService->getLocaciones();

        if ($this->cargaDatos) {
            $this->cargarProductos();
        }


        return view('livewire.admin.dashboards.ventas.ventas-index', [
            'actividades' => $this->actividades,
            'yates' => $this->yates,
            'servicios' => $this->servicios,
            'tours' => $this->tours,
            'listlocaciones' => $listLocaciones,
            'locacion_id' => $this->locacion_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);
    }
}
