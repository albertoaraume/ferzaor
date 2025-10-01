<?php

namespace App\Livewire\Admin\Reportes\Reservas;

use Livewire\Component;


use Livewire\WithPagination;
use App\Services\Reportes\Reservas\RptReservTransportacionesService;
use App\Services\Ventas\ReservaService;
use Carbon\Carbon;

class RptReservTransportaciones extends Component
{
    use WithPagination;

    public $fechaInicio;
    public $fechaFin;
    public $estado = '';
    public $clienteId = '';
    public $locacionId = '';
    public $mostrarEstadisticas = false;
      private $reporteService;
    private $reservaService;
    public $useDataTable = true;

    private $trasladoDetalleData;
    private $reservaCompletaData;

        protected $listeners = [
        'cerrarModal' => 'cerrarModalDetalle',
        'cerrarModalReserva' => 'cerrarModalReserva'
    ];


    public function boot(RptReservTransportacionesService $reporteService, ReservaService $reservaService)
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
    public function getTrasladoDetalleProperty()
    {
        return $this->trasladoDetalleData;
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
        $this->dispatch('refreshDataTable');
    }

    public function updatingLocacionId()
    {
        $this->dispatch('refreshDataTable');
    }

    public function getDataTableData()
    {
        $filtros = $this->obtenerFiltros();
        $transportaciones = $this->reporteService->obtenerTransportaciones($filtros);
        return $transportaciones;
    }

        // Método para ver detalle
    public function verDetalle($idRT)
    {
        try {
            // Asignar a propiedad PRIVADA (no causa re-render automático)
            $this->trasladoDetalleData = $this->reservaService->obtenerTransporteDetalle($idRT);

            if (!$this->trasladoDetalleData) {
                session()->flash('error', 'Transporte no encontrado');
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
    public function verReservaCompleta($idReserva)
    {
        try {


            // Asignar a propiedad PRIVADA
            $this->reservaCompletaData = $this->reservaService->reservaCompleta($idReserva);

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
        $transportaciones = $this->reporteService->obtenerTransportaciones($filtros);

      

          // Obtener estadísticas
       $totales = $this->reporteService->obtenerTotales($transportaciones);


        $data = [
            'transportaciones' => $transportaciones,
            'filtrosDisponibles' => $this->reporteService->obtenerFiltrosDisponibles(),
            'totales' => $totales,
        ];

        return view('livewire.admin.reportes.reservas.rpt-reserv-transportaciones', $data);
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
