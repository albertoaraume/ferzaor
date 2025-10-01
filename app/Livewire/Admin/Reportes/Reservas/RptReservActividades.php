<?php

namespace App\Livewire\Admin\Reportes\Reservas;

use Livewire\Component;

use App\Services\Reportes\Reservas\RptReservActividadesService;
use App\Services\Ventas\ReservaService;

class RptReservActividades extends Component
{


    public $fechaInicio;
    public $fechaFin;
    public $estado = '';
    public $clienteId = '';
    public $locacionId = '';
    public $actividadId = '';
    public $mostrarEstadisticas = false;
    private $reporteService;
    private $reservaService;
    public $useDataTable = true;
    public $tableId = 'actividadesTable';
    private $actividadDetalleData;
    private $reservaCompletaData;


    // Listeners
    protected $listeners = [
        'cerrarModal' => 'cerrarModalDetalle',
        'cerrarModalReserva' => 'cerrarModalReserva',
    ];

    public function boot(RptReservActividadesService $reporteService, ReservaService $reservaService)
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
    public function getActividadDetalleProperty()
    {
        return $this->actividadDetalleData;
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

    public function updatingActividadId()
    {
        // $this->resetPage();
        $this->dispatch('refreshDataTable');
    }

    // Método para obtener datos para DataTables
    public function getDataTableData()
    {
        $filtros = $this->obtenerFiltros();
        // Siempre obtener sin paginación para DataTables
        $actividades = $this->reporteService->obtenerActividades($filtros);
        return $actividades;
    }

    public function toggleEstadisticas()
    {
        $this->mostrarEstadisticas = !$this->mostrarEstadisticas;
    }
    // Método para ver detalle
    public function verDetalle($idAU)
    {
        try {
            // Asignar a propiedad PRIVADA (no causa re-render automático)
            $this->actividadDetalleData = $this->reservaService->obtenerActividadDetalle($idAU);

            if (!$this->actividadDetalleData) {
                session()->flash('error', 'Actividad no encontrada');
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
    public function verReservaCompleta($idAU)
    {
        try {
            $actividad = $this->reservaService->obtenerActividadDetalle($idAU);

            if (!$actividad) {
                session()->flash('error', 'Datos no encontrados');
                return;
            }

            // Asignar a propiedad PRIVADA
            $this->reservaCompletaData = $this->reservaService->reservaCompleta($actividad->actividad->reserva_idReserva);

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
        $actividades = $this->reporteService->obtenerActividades($filtros);

        // Obtener estadísticas
       $estadisticas = $this->reporteService->obtenerEstadisticas($actividades);

        $data = [
            'actividades' => $actividades,
            'filtrosDisponibles' => $this->reporteService->obtenerFiltrosDisponibles(),
            'estadisticas' => $estadisticas,
        ];

        return view('livewire.admin.reportes.reservas.rpt-reserv-actividades', $data);
    }

    private function obtenerFiltros(): array
    {
        return [
            'estado' => $this->estado,
            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin' => $this->fechaFin,
            'cliente_id' => $this->clienteId,
            'locacion_id' => $this->locacionId,
            'actividad_id' => $this->actividadId,
        ];
    }
}
