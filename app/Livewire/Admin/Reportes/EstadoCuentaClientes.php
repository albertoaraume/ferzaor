<?php

namespace App\Livewire\Admin\Reportes;

use App\Services\EstadoCuentaService;
use App\Services\Ventas\ReservaService;
use App\Services\ClienteService;
use App\Services\Ventas\FacturasService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EstadoCuentaExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;



class EstadoCuentaClientes extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $clienteId = '';
    public $busqueda = '';
    public $ordenarPor = 'cliente.nombreComercial';
    public $direccionOrden = 'asc';
    public $mostrarDetalle = [];
    public $estadisticasGenerales = [];



    public $modoTiempoReal = false;

    protected $estadoCuentaService;

    private $reservaCompletaData;
    private $facturaCompletaData;

    private $reservaService;
    private $clienteService;
    private $facturaService;

    public $progreso = 0;
    public $totalClientes = 0;
    public $procesando = false;


    protected $listeners = [
        'actualizacionCompletada' => 'mostrarNotificacionActualizacion'
    ];


    public function boot(EstadoCuentaService $estadoCuentaService, ReservaService $reservaService, FacturasService $facturaService, ClienteService $clienteService)
    {
       $this->estadoCuentaService = $estadoCuentaService;
       $this->reservaService = $reservaService;
       $this->facturaService = $facturaService;
       $this->clienteService = $clienteService;


    }

    public function mount()
    {
           $this->totalClientes = $this->clienteService->clientesActivos();
           $cant = Cache::get('progreso_actualizacion_' . auth()->user()->id);
           $this->procesando = $cant > 0 ? true : false;
    }

    public function render()
    {
        $filtros = [
            'cliente_id' => $this->clienteId,
        ];


        $estadoCuentas = $this->estadoCuentaService->obtenerEstadoCuentaRapido($filtros);

        // Aplicar búsqueda
        if ($this->busqueda) {
            $estadoCuentas = $estadoCuentas->filter(function ($estadoCuenta) {
                return stripos($estadoCuenta['cliente']->nombreComercial, $this->busqueda) !== false;
            });
        }


        // Aplicar ordenamiento
        $estadoCuentas = $estadoCuentas->sortBy($this->ordenarPor, SORT_REGULAR, $this->direccionOrden === 'desc');


        // Opciones para filtros
        $data = $this->estadoCuentaService->obtenerFiltrosDisponibles();

        return view('livewire.admin.reportes.estado-cuenta-clientes', [
            'estadoCuentas' => $estadoCuentas,
            'filtrosDisponibles' => $data,
        ]);
    }

    public function mostrarNotificacionActualizacion()
    {
        session()->flash('message', '¡Actualización completada!');
        $this->procesando = false;
    }

    public function getReservaCompletaProperty()
  {
      return $this->reservaCompletaData;
  }

  public function getFacturaCompletaProperty()
  {
      return $this->facturaCompletaData;
  }

   public function verReservaCompleta($tipo, $folio)
  {
      try {

          $idReserva = 0;



          if($tipo === 'actividades'){
              $actividad = $this->reservaService->obtenerActividadDetalle($folio);

              if (!$actividad) {
                  session()->flash('error', 'Datos no encontrados');
                  return;
              }
              $idReserva = $actividad->actividad->reserva_idReserva;
          }else if($tipo === 'yates'){
              $yate = $this->reservaService->obtenerYateDetalle($folio);
              if (!$yate) {
                  session()->flash('error', 'Datos no encontrados');

                  return;
              }
              $idReserva = $yate->reserva_idReserva;
          }

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

            Log::error('Error al cargar factura completa', [
                'folio' => $folio,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
   * Forzar actualización completa mediante job
   */
  public function forzarActualizacionCompleta()
  {        try {

        $this->procesando = true;
        $this->progreso = 0;


        // Limpia el progreso anterior
         Cache::forget('progreso_actualizacion_' . auth()->user()->id);

                // Actualizar todos los clientes
                Artisan::call('ferzaor:clientes-saldos', [
                    '--user' => auth()->user()->id,
                    '--cliente' => null,
                ]);
                session()->flash('message', 'Se ha iniciado la actualización de todos los clientes. Los datos se actualizarán en unos minutos.');

      } catch (\Exception $e) {
          session()->flash('error', 'Error en la actualización: ' . $e->getMessage());
      }
  }



  /**
   * Actualizar un cliente específico
   */
  public function actualizarCliente($clienteId)
  {         try {
      $this->procesando = true;
        $this->progreso = 0;
        $this->totalClientes = 1;

            // Limpia el progreso anterior
         Cache::forget('progreso_actualizacion_' . auth()->user()->id);

            Artisan::call('ferzaor:clientes-saldos', [
                 '--user' => auth()->user()->id,
                '--cliente' => $clienteId
            ]);
      session()->flash('message', 'Se ha iniciado la actualización del cliente. Los datos se actualizarán en unos minutos.');
  } catch (\Exception $e) {
      session()->flash('error', 'Error actualizando cliente: ' . $e->getMessage());
  }
  }




     public function refresh()
{


    // Resetear paginación
    $this->resetPage();

    // Opcional: mensaje de confirmación
    session()->flash('message', 'Datos actualizados correctamente');
}



    public function toggleDetalle($clienteId)
    {
        if (isset($this->mostrarDetalle[$clienteId])) {
            unset($this->mostrarDetalle[$clienteId]);
        } else {
            $this->mostrarDetalle[$clienteId] = true;
        }
    }

    public function ordenarPor($campo)
    {
        if ($this->ordenarPor === $campo) {
            $this->direccionOrden = $this->direccionOrden === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $campo;
            $this->direccionOrden = 'desc';
        }
    }

    public function limpiarFiltros()
    {
        $this->clienteId = '';
        $this->busqueda = '';
        $this->ordenarPor = 'cliente.nombreComercial';
        $this->direccionOrden = 'asc';
        $this->mostrarDetalle = [];

    }

   public function exportar()
{
    try {


        $filtros = [
            'cliente_id' => $this->clienteId,
        ];

        // Generar nombre del archivo
        $filename = 'estado_cuenta_' . date('Y-m-d_H-i-s') . '.xlsx';


        // TODO: Implementar exportación cuando la clase EstadoCuentaExport esté disponible
        session()->flash('message', 'Funcionalidad de exportación en desarrollo.');

        /*
        // Crear y descargar el archivo Excel
        return Excel::download(
            new EstadoCuentaExport($filtros, $this->busqueda),
            $filename
        );
        */

    } catch (\Exception $e) {

        session()->flash('error', 'Error al exportar: ' . $e->getMessage());
        Log::error('Error en exportación de estado de cuenta', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}

}
