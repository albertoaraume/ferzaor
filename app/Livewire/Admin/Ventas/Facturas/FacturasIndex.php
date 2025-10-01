<?php

namespace App\Livewire\Admin\Ventas\Facturas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Ventas\FacturasService;



class FacturasIndex extends Component
{
    use WithPagination;

    public $fechaInicio;
    public $fechaFin;
    public $estado = '';
    public $clienteId = '';
    public $empresaId = '';
    public $locacionId = '';
    public $tipoId = '';
    private $facturaService;
    public $facturas = [];
    private $facturaCompletaData;


    // Listeners
    protected $listeners = [
        'cerrarModal' => 'cerrarModalDetalle',

    ];


    public function boot(FacturasService $facturaService)
    {
        $this->facturaService = $facturaService;
    }

    public function mount()
    {
        $this->fechaInicio = now()->subDays(15)->format('Y-m-d');
        $this->fechaFin = now()->format('Y-m-d');
    }

      // Getters para acceder a los datos privados desde la vista
  public function getFacturaCompletaProperty()
  {
      return $this->facturaCompletaData;
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

    public function updatingEmpresaId()
    {
       // $this->resetPage();
       $this->dispatch('refreshDataTable');
    }


        public function updatingTipoId()
    {
       // $this->resetPage();
       $this->dispatch('refreshDataTable');
    }



    /**
     * Ver detalles completos de una factura
     */
    public function verFacturaCompleta($folio)
    {
        try {


            // Obtener detalles completos de la factura
            $this->facturaCompletaData = $this->facturaService->obtenerFacturaCompleta($folio);



            if (!$this->facturaCompletaData) {
                session()->flash('error', 'No se encontró la factura con folio: ' . $folio);
                return;
            }



            // Disparar evento para abrir el modal
            $this->dispatch('abrirModalFactura');

        } catch (\Exception $e) {

            session()->flash('error', 'Error al cargar la factura: ' . $e->getMessage());

          
        }
    }




     public function cancelarFactura($ingresoId)
    {
        try {

            /*$resultado = $this->reporteService->cambiarStatus($ingresoId, 'cancelado');

            if ($resultado['success']) {
                session()->flash('message', $resultado['message']);
                $this->dispatch('refreshDataTable');
            } else {
                session()->flash('error', $resultado['message']);
            }*/
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cancelar ingreso: ' . $e->getMessage());
        }
    }






    public function refresh()
{


     $this->dispatch('refreshDataTable');

    // Opcional: mensaje de confirmación
    session()->flash('message', 'Datos actualizados correctamente');
}






    public function render()
    {
        $filtros = $this->obtenerFiltros();
        $this->facturas = $this->facturaService->obtenerFacturas($filtros);

        $totales = $this->facturaService->obtenerTotales($this->facturas);
   
         $data = [
            'facturas' => $this->facturas,
            'filtrosDisponibles' => $this->facturaService->obtenerFiltrosDisponibles(),
            'totales' => $totales,
        ];

        return view('livewire.admin.ventas.facturas.factura-index', $data);
    }




     private function obtenerFiltros(): array
    {
        return [


            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin' => $this->fechaFin,
            'estado' => $this->estado,
            'cliente_id' => $this->clienteId,
            'locacion_id' => $this->locacionId,
            'empresa_id' => $this->empresaId,
            'tipo_id' => $this->tipoId,
        ];
    }
}
