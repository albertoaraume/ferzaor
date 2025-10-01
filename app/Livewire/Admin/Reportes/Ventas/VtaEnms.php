<?php

namespace App\Livewire\Admin\Reportes\Ventas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Reportes\Ventas\RptEnmsService;
use App\Services\ReservaService;
use Carbon\Carbon;

class VtaEnms extends Component
{
    use WithPagination;

    // Filtros principales
    public $fechaInicio;
    public $fechaFin;
    public $tipo = '';
    public $clienteId = '';
    public $locacionId = '';
    public $pagoEnm = '';
    public $actividadId = '';
    public $yateId = '';
    public $muelleId = '';
            


    // Configuración de vista
    public $mostrarEstadisticas = false;
   
    public $tipoSeleccionado = null;

    private $reservaCompletaData;

    protected $listeners = [
        'cerrarModal' => 'cerrarModalDetalle',
         'cerrarModalReserva' => 'cerrarModalReserva'
    ];

    private function getReporteService(): RptEnmsService
    {
        return app(RptEnmsService::class);
    }

  private function getReservaService(): ReservaService
    {
        return app(ReservaService::class);
    }


    public function mount()
    {
        // Establecer fechas por defecto (últimos 7 días)
        $this->fechaInicio = Carbon::now()->addDay(-7)->format('Y-m-d');
        $this->fechaFin = Carbon::now()->format('Y-m-d');
    }

      public function getReservaCompletaProperty()
    {
        return $this->reservaCompletaData;
    }

    // Actualizadores para refrescar datos cuando cambien los filtros
    public function updatingTipo()
    {
          // Resetear paginación
    $this->resetPage();
    }

    public function updatingClienteId()
    {
          // Resetear paginación
    $this->resetPage();
    }

    public function updatingLocacionId()
    {
          // Resetear paginación
    $this->resetPage();
    }


    public function updatingPagoEnm()
    {
          // Resetear paginación
    $this->resetPage();
    }

    public function updatingMuelleId()
    {
          // Resetear paginación
    $this->resetPage();
    }

    public function updatingYateId()
    {
          // Resetear paginación
    $this->resetPage();
    }

    public function updatingActividadId()
    {
          // Resetear paginación
    $this->resetPage();
    }

    public function aplicarFiltros()
    {
          // Resetear paginación
    $this->resetPage();
     // Opcional: mensaje de confirmación
    session()->flash('message', 'Datos actualizados correctamente');
    }

    public function limpiarFiltros()
    {
        $this->reset([
            'fechaInicio', 'fechaFin', 'tipo', 'clienteId', 'locacionId',
            'muelleId'
        ]);

         $this->fechaInicio = Carbon::now()->addDay(-7)->format('Y-m-d');
        $this->fechaFin = Carbon::now()->format('Y-m-d');

          // Resetear paginación
         $this->resetPage();
    }

    public function toggleEstadisticas()
    {
        $this->mostrarEstadisticas = !$this->mostrarEstadisticas;
    }


    public function seleccionarTipo($tipo)
    {
        $this->tipoSeleccionado = $this->tipoSeleccionado === $tipo ? null : $tipo;
    }



  // Método para ver reserva completa
    public function verReservaCompleta($clave)
    {
        try {
        $reservaService = $this->getReservaService();
            $idReserva = 0;
            $tipo = substr($clave, 0, 3); // Obtener los primeros 3 caracteres para determinar el tipo
            $id = substr($clave, 4); // Obtener el resto como ID

            if($tipo === 'ACT'){
                $actividad = $reservaService->obtenerActividadDetalle($id);

                if (!$actividad) {
                    session()->flash('error', 'Datos no encontrados');
                    return;
                }
                $idReserva = $actividad->actividad->reserva_idReserva;
            }else if($tipo === 'YAT'){
                $yate = $reservaService->obtenerYateDetalle($id);
                if (!$yate) {
                    session()->flash('error', 'Datos no encontrados');
                    return;
                }
                $idReserva = $yate->reserva_idReserva;
            }

            // Asignar a propiedad PRIVADA
            $this->reservaCompletaData = $reservaService->reservaCompleta($idReserva);

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
          // Resetear paginación
    $this->resetPage();
        session()->flash('message', 'Datos actualizados correctamente');
    }



    private function obtenerFiltros(): array
    {
        return array_filter([
            'fecha_inicio' => $this->fechaInicio,
            'fecha_fin' => $this->fechaFin,
            'tipo' => $this->tipo,
            'cliente_id' => $this->clienteId,
            'locacion_id' => $this->locacionId,
            'actividad_id' => $this->actividadId,
            'yate_id' => $this->yateId,
            'muelle_id' => $this->muelleId,
        ], fn($value) => !empty($value));
    }

    public function render()
    {
        $filtros = $this->obtenerFiltros();
        $reporteService = $this->getReporteService();

        $data = [
            'filtrosDisponibles' => $reporteService->obtenerFiltrosDisponibles(),
        ];

        $data['reservas'] = $reporteService->obtenerReservas($filtros);


        return view('livewire.admin.reportes.ventas.vta-enms', $data);
    }
}
