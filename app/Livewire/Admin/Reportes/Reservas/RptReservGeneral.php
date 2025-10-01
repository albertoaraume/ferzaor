<?php

namespace App\Livewire\Admin\Reportes\Reservas;

use Livewire\Component;


use App\Services\Ventas\ReservaService;

class RptReservGeneral extends Component
{


    public $fechaInicio;
    public $fechaFin;
    public $estado = '';
    public $clienteId = '';
    public $locacionId = '';

    private $reservaService;

    private $reservaCompletaData;


    // Listeners
    protected $listeners = [
        'cerrarModal' => 'cerrarModalDetalle',
        'cerrarModalReserva' => 'cerrarModalReserva',
    ];

    public function boot(ReservaService $reservaService)
    {

        $this->reservaService = $reservaService;
    }

    public function mount()
    {
        $this->fechaInicio = now()->format('Y-m-d');
        $this->fechaFin = now()->format('Y-m-d');
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


    // Método para obtener datos para DataTables
    public function getDataTableData()
    {
        $filtros = $this->obtenerFiltros();
        // Siempre obtener sin paginación para DataTables
        $reservas = $this->reservaService->obtenerReservas($filtros);
        return $reservas;
    }


    // Método para ver reserva completa

    // Método para ver reserva completa
    public function verReservaCompleta($id)
    {
        try {

            // Asignar a propiedad PRIVADA
            $this->reservaCompletaData = $this->reservaService->reservaCompleta($id);

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
        $reservas = $this->reservaService->obtenerReservas($filtros);

        // Obtener estadísticas
       //$estadisticas = $this->reservaService->obtenerEstadisticas($reservas);

        $data = [
            'reservas' => $reservas,
            'filtrosDisponibles' => $this->reservaService->obtenerFiltrosDisponibles(),
            'estadisticas' => []
        ];

        return view('livewire.admin.reportes.reservas.rpt-reserv-general', $data);
    }

    private function obtenerFiltros(): array
    {
        return [
            'estado' => $this->estado,
            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin' => $this->fechaFin,
            'cliente_id' => $this->clienteId,
            'locacion_id' => $this->locacionId,

        ];
    }
}
