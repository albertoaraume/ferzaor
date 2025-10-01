<?php

namespace App\Livewire\Admin\Ventas\Reservas;

use Livewire\Component;
use App\Services\Ventas\ReservaService;
use Exception;

class ReservaEditar extends Component
{
    public $guid;
    public $reserva;

    // Modales de edición
    public $mostrarModalActividad = false;
    public $mostrarModalYate = false;
    public $mostrarModalTraslado = false;
    public $mostrarModalServicio = false;
    public $mostrarModalCombo = false;

    // Modal de cancelación
    public $mostrarModalCancelacion = false;

    // Datos del item en edición
    public $itemEnEdicion = [];
    public $tipoItemEnEdicion = '';
    public $motivoCancelacion = '';

    // Propiedades para edición
    public $nuevoPrecio = '';
    public $nuevoPax = '';
    public $nuevaFecha = '';
    public $nuevaHora = '';

    private $reservaService;

    protected $listeners = [
        'confirmarCancelacion' => 'cancelarItem',
        'cerrarModales' => 'cerrarTodosLosModales'
    ];

    protected $rules = [
        'nuevoPrecio' => 'required|numeric|min:0',
        'nuevoPax' => 'required|integer|min:1',
        'nuevaFecha' => 'nullable|date',
        'nuevaHora' => 'nullable'
    ];

    protected $messages = [
        'nuevoPrecio.required' => 'El precio es obligatorio',
        'nuevoPrecio.numeric' => 'El precio debe ser un número',
        'nuevoPrecio.min' => 'El precio debe ser mayor a 0',
        'nuevoPax.required' => 'El número de pasajeros es obligatorio',
        'nuevoPax.integer' => 'El número de pasajeros debe ser un número entero',
        'nuevoPax.min' => 'Debe haber al menos 1 pasajero',
        'nuevaFecha.date' => 'Ingrese una fecha válida'
    ];

    public function boot(ReservaService $reservaService)
    {
        $this->reservaService = $reservaService;
    }

    public function mount($guid)
    {
        $this->guid = $guid;
        $this->cargarReserva();
    }

    public function cargarReserva()
    {
        $this->reserva = $this->reservaService->reservaByGuid($this->guid);

        if (!$this->reserva) {
            session()->flash('error', 'Reserva no encontrada');
            return redirect()->route('admin.home');
        }
    }

    // Métodos para abrir modales de edición
    public function editarActividad($idAU)
    {
        $datos = $this->reservaService->obtenerDatosServicioParaEdicion('actividad', $idAU);

        if ($datos) {
            $this->itemEnEdicion = $datos;
            $this->nuevoPrecio = $datos['precio'];
            $this->nuevoPax = $datos['pax'];
            $this->nuevaFecha = $datos['fecha'];
            $this->nuevaHora = $datos['hora'];
            $this->tipoItemEnEdicion = 'actividad';
            $this->mostrarModalActividad = true;
        }
    }

    public function editarYate($idRY)
    {
        $datos = $this->reservaService->obtenerDatosServicioParaEdicion('yate', $idRY);

        if ($datos) {
            $this->itemEnEdicion = $datos;
            $this->nuevoPrecio = $datos['precio'];
            $this->nuevoPax = $datos['pax'];
            $this->nuevaFecha = $datos['fecha'];
            $this->nuevaHora = $datos['hora'];
            $this->tipoItemEnEdicion = 'yate';
            $this->mostrarModalYate = true;
        }
    }

    public function editarTraslado($idRT)
    {
        $datos = $this->reservaService->obtenerDatosServicioParaEdicion('traslado', $idRT);

        if ($datos) {
            $this->itemEnEdicion = $datos;
            $this->nuevoPrecio = $datos['precio'];
            $this->nuevoPax = $datos['pax'];
            $this->nuevaFecha = $datos['fecha'];
            $this->nuevaHora = $datos['hora'];
            $this->tipoItemEnEdicion = 'traslado';
            $this->mostrarModalTraslado = true;
        }
    }

    public function editarServicio($idAD)
    {
        $datos = $this->reservaService->obtenerDatosServicioParaEdicion('servicio', $idAD);

        if ($datos) {
            $this->itemEnEdicion = $datos;
            $this->nuevoPrecio = $datos['precio'];
            $this->nuevoPax = $datos['pax'];
            $this->nuevaFecha = $datos['fecha'];
            $this->nuevaHora = $datos['hora'];
            $this->tipoItemEnEdicion = 'servicio';
            $this->mostrarModalServicio = true;
        }
    }

    public function editarCombo($idRC)
    {
        $datos = $this->reservaService->obtenerDatosServicioParaEdicion('combo', $idRC);

        if ($datos) {
            $this->itemEnEdicion = $datos;
            $this->nuevoPrecio = $datos['precio'];
            $this->nuevoPax = $datos['pax'];
            $this->nuevaFecha = $datos['fecha'];
            $this->nuevaHora = $datos['hora'];
            $this->tipoItemEnEdicion = 'combo';
            $this->mostrarModalCombo = true;
        }
    }

    // Métodos para abrir modal de cancelación
    public function abrirModalCancelacion($tipo, $id)
    {
        $this->tipoItemEnEdicion = $tipo;
        $this->itemEnEdicion = ['id' => $id];
        $this->motivoCancelacion = '';
        $this->mostrarModalCancelacion = true;
    }

    // Método para guardar cambios
    public function guardarCambios()
    {
        $this->validate();

        try {
            $datos = [
                'precio' => $this->nuevoPrecio,
                'pax' => $this->nuevoPax
            ];

            // Preparar fecha y hora según el tipo de servicio
            if ($this->tipoItemEnEdicion === 'traslado') {
                if ($this->nuevaFecha) {
                    $datos['fecha'] = $this->nuevaFecha;
                }
                if ($this->nuevaHora) {
                    $datos['hora'] = $this->nuevaHora;
                }
            } else {
                if ($this->nuevaFecha) {
                    $fechaHora = $this->nuevaFecha;
                    if ($this->nuevaHora) {
                        $fechaHora .= ' ' . $this->nuevaHora;
                    }
                    $datos['fechaHora'] = $fechaHora;
                }
            }

            $this->reservaService->actualizarServicio(
                $this->tipoItemEnEdicion,
                $this->itemEnEdicion['id'],
                $datos
            );

            session()->flash('message', 'Los cambios se guardaron correctamente');
            $this->cerrarTodosLosModales();
            $this->cargarReserva(); // Recargar la reserva

        } catch (Exception $e) {
            session()->flash('error', 'Error al guardar los cambios: ' . $e->getMessage());
        }
    }

    // Método para cancelar item
    public function cancelarItem()
    {
        if (empty($this->motivoCancelacion)) {
            session()->flash('error', 'Debe especificar un motivo de cancelación');
            return;
        }

        try {
            $this->reservaService->cancelarServicio(
                $this->tipoItemEnEdicion,
                $this->itemEnEdicion['id'],
                $this->motivoCancelacion
            );

            session()->flash('message', 'El servicio se canceló correctamente');
            $this->cerrarTodosLosModales();
            $this->cargarReserva(); // Recargar la reserva

        } catch (Exception $e) {
            session()->flash('error', 'Error al cancelar el servicio: ' . $e->getMessage());
        }
    }

    // Cerrar modales
    public function cerrarTodosLosModales()
    {
        $this->mostrarModalActividad = false;
        $this->mostrarModalYate = false;
        $this->mostrarModalTraslado = false;
        $this->mostrarModalServicio = false;
        $this->mostrarModalCombo = false;
        $this->mostrarModalCancelacion = false;

        $this->reset(['itemEnEdicion', 'tipoItemEnEdicion', 'motivoCancelacion', 'nuevoPrecio', 'nuevoPax', 'nuevaFecha', 'nuevaHora']);
    }

    public function render()
    {
        return view('livewire.admin.ventas.reservas.reserva-editar');
    }
}
