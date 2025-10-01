<?php

namespace App\Livewire\Admin\Reportes\Reservas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Reportes\Reservas\RptReservYatesService;
use App\Services\Ventas\ReservaService;

class RptReservYates extends Component
{
    use WithPagination;

    public $fechaInicio;
    public $fechaFin;
    public $estado = '';
    public $clienteId = '';
    public $locacionId = '';

    public $yateId = '';
    public $mostrarEstadisticas = false;
    private $reporteService;
    private $reservaService;
    public $useDataTable = true;
    public $tableId = 'yatesTable';
    private $yateDetalleData;
    private $reservaCompletaData;

        public $cargarDatos = false;

    // Listeners
    protected $listeners = [
        'cerrarModal' => 'cerrarModalDetalle',
        'cerrarModalReserva' => 'cerrarModalReserva'
    ];


    public function boot(RptReservYatesService $reporteService, ReservaService $reservaService)
    {
        $this->reporteService = $reporteService;
         $this->reservaService = $reservaService;
    }

    public function mount()
    {
        $this->fechaInicio = now()->format('Y-m-d');
        $this->fechaFin = now()->format('Y-m-d');
    }

      // Getters para acceder a los datos privados desde la vista
    public function getYateDetalleProperty()
    {
        return $this->yateDetalleData;
    }

    public function getReservaCompletaProperty()
    {
        return $this->reservaCompletaData;
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

    public function updatingYateId()
    {
       // $this->resetPage();
       $this->dispatch('refreshDataTable');
    }

      // Método para obtener datos para DataTables
    public function getDataTableData()
    {
        $filtros = $this->obtenerFiltros();
        // Siempre obtener sin paginación para DataTables
        $yates = $this->reporteService->obtenerYates($filtros);
        return $yates;
    }

    public function toggleEstadisticas()
    {
        $this->mostrarEstadisticas = !$this->mostrarEstadisticas;
    }
    // Método para ver detalle
    public function verDetalle($idRY)
    {
        try {
            // Asignar a propiedad PRIVADA (no causa re-render automático)
            $this->yateDetalleData = $this->reservaService->obtenerYateDetalle($idRY);

            if (!$this->yateDetalleData) {
                session()->flash('error', 'Yate no encontrada');
                return;
            }

            // Emitir evento para abrir modal
            $this->dispatch('abrirModalDetalle');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar los detalles: ' . $e->getMessage());
        }
    }



        // Método para ver reserva completa

    // Método para ver reserva completa
    public function verReservaCompleta($idRY)
    {
        try {
            $yate = $this->reservaService->obtenerYateDetalle($idRY);

            if (!$yate) {
                session()->flash('error', 'Datos no encontrados');
                return;
            }

            // Asignar a propiedad PRIVADA
            $this->reservaCompletaData = $this->reservaService->reservaCompleta($yate->reserva_idReserva);



            if (!$this->reservaCompletaData) {
                session()->flash('error', 'No se pudo cargar la información completa de la reserva');
                return;
            }

            $this->dispatch('abrirModalReserva');

        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar la reserva: ' . $e->getMessage());
        }
    }



    public function refresh()
{


     $this->dispatch('refreshDataTable');


    session()->flash('message', 'Datos actualizados correctamente');
}






    public function render()
    {
        $filtros = $this->obtenerFiltros();
        $yates = $this->reporteService->obtenerYates($filtros);

        // Obtener estadísticas
       $estadisticas = $this->reporteService->obtenerEstadisticas($yates);

        $data = [
            'yates' => $yates,
            'filtrosDisponibles' => $this->reporteService->obtenerFiltrosDisponibles(),
            'estadisticas' => $estadisticas,
        ];

        return view('livewire.admin.reportes.reservas.rpt-reserv-yates', $data);
    }




     private function obtenerFiltros(): array
    {
        return [

            'estado' => $this->estado,
            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin' => $this->fechaFin,
            'cliente_id' => $this->clienteId,
            'locacion_id' => $this->locacionId,
            'yate_id' => $this->yateId
        ];
    }
}
