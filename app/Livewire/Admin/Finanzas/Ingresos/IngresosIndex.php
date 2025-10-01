<?php

namespace App\Livewire\Admin\Finanzas\Ingresos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Finanzas\IngresosService;



class IngresosIndex extends Component
{
    use WithPagination;

    public $fechaInicio;
    public $fechaFin;
    public $estado = '';
    public $clienteId = '';
    public $locacionId = '';
    private $reporteService;
    public $tableId = 'ingresosTable';
    public $ingresos = [];
    private $ingresoDetalleData;
    public $mostrarModalConfirmacion = false;
    public $seleccionarTodos = false;
    public $valor = 1;

    public $ingresosSeleccionados = [];



    // Listeners
    protected $listeners = [
        'cerrarModal' => 'cerrarModalDetalle',

    ];


    public function boot(IngresosService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

    public function mount()
    {
        $this->fechaInicio = now()->subDays(7)->format('Y-m-d');
        $this->fechaFin = now()->format('Y-m-d');
    }

      // Getters para acceder a los datos privados desde la vista
    public function getIngresoDetalleProperty()
    {
        return $this->ingresoDetalleData;
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


    // Método para ver detalle
    public function verDetalle($idIng)
    {
        try {
            // Asignar a propiedad PRIVADA (no causa re-render automático)
            $this->ingresoDetalleData = $this->reporteService->obtenerIngresoDetalle($idIng);

            if (!$this->ingresoDetalleData) {
                session()->flash('error', 'Ingreso no encontrado');
                return;
            }

            // Emitir evento para abrir modal
            $this->dispatch('abrirModalDetalle');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar los detalles: ' . $e->getMessage());
        }
    }



    // Método para abrir modal de confirmación
    public function abrirModalConfirmacion()
    {
        if (empty($this->ingresosSeleccionados)) {
            session()->flash('error', 'Debe seleccionar al menos un ingreso para confirmar');
            return;
        }

        $this->mostrarModalConfirmacion = true;
    }

    // Método para cerrar modal de confirmación
    public function cerrarModalConfirmacion()
    {
        $this->mostrarModalConfirmacion = false;
    }



    // Método para confirmar ingreso individual
    public function confirmarIngreso($ingresoId)
    {
        try {

            $resultado = $this->reporteService->confirmarIngresosMasivo([$ingresoId]);

            if ($resultado['success']) {
                session()->flash('message', 'Ingreso confirmado correctamente');
                $this->dispatch('refreshDataTable');
            } else {
                session()->flash('error', $resultado['message']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error al confirmar ingreso: ' . $e->getMessage());
        }
    }

     public function cancelarIngreso($ingresoId)
    {
        try {

            $resultado = $this->reporteService->cambiarStatus($ingresoId, 'cancelado');

            if ($resultado['success']) {
                session()->flash('message', $resultado['message']);
                $this->dispatch('refreshDataTable');
            } else {
                session()->flash('error', $resultado['message']);
            }
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
        $this->ingresos = $this->reporteService->obtenerIngresosFiltrados($filtros);

         $data = [
            'ingresos' => $this->ingresos,
            'filtrosDisponibles' => $this->reporteService->obtenerFiltrosDisponibles(),
          //  'estadisticas' => $estadisticas,
        ];

        return view('livewire.admin.finanzas.ingresos.ingresos-index', $data);
    }




     private function obtenerFiltros(): array
    {
        return [


            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin' => $this->fechaFin,
              'estado' => $this->estado,
            'cliente_id' => $this->clienteId,
            'locacion_id' => $this->locacionId,
        ];
    }
}
