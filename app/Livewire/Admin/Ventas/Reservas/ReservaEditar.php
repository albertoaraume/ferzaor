<?php

namespace App\Livewire\Admin\Ventas\Reservas;

use Livewire\Component;
use App\Services\Ventas\ReservaService;
use App\Models\Erp\ReservaAU;
use App\Models\Erp\ReservaY;
use App\Models\Erp\ReservaT;
use App\Models\Erp\ReservaAD;
use App\Models\Erp\ReservaC;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        $actividad = $this->reserva->actividades->flatMap->unidades->firstWhere('idAU', $idAU);

        if ($actividad) {
            $this->itemEnEdicion = [
                'id' => $actividad->idAU,
                'nombre' => $actividad->ActividadDisplay,
                'precio' => $actividad->precio,
                'pax' => $actividad->pax,
                'fecha' => $actividad->start ? \Carbon\Carbon::parse($actividad->start)->format('Y-m-d') : '',
                'hora' => $actividad->start ? \Carbon\Carbon::parse($actividad->start)->format('H:i') : '',
                'moneda' => $actividad->c_moneda
            ];

            $this->nuevoPrecio = $actividad->precio;
            $this->nuevoPax = $actividad->pax;
            $this->nuevaFecha = $actividad->start ? \Carbon\Carbon::parse($actividad->start)->format('Y-m-d') : '';
            $this->nuevaHora = $actividad->start ? \Carbon\Carbon::parse($actividad->start)->format('H:i') : '';
            $this->tipoItemEnEdicion = 'actividad';
            $this->mostrarModalActividad = true;
        }
    }

    public function editarYate($idRY)
    {
        $yate = $this->reserva->yates->firstWhere('idRY', $idRY);

        if ($yate) {
            $this->itemEnEdicion = [
                'id' => $yate->idRY,
                'nombre' => $yate->YateDisplay,
                'precio' => $yate->tarifa,
                'pax' => $yate->pax,
                'fecha' => $yate->start ? \Carbon\Carbon::parse($yate->start)->format('Y-m-d') : '',
                'hora' => $yate->start ? \Carbon\Carbon::parse($yate->start)->format('H:i') : '',
                'moneda' => $yate->c_moneda
            ];

            $this->nuevoPrecio = $yate->tarifa;
            $this->nuevoPax = $yate->pax;
            $this->nuevaFecha = $yate->start ? \Carbon\Carbon::parse($yate->start)->format('Y-m-d') : '';
            $this->nuevaHora = $yate->start ? \Carbon\Carbon::parse($yate->start)->format('H:i') : '';
            $this->tipoItemEnEdicion = 'yate';
            $this->mostrarModalYate = true;
        }
    }

    public function editarTraslado($idRT)
    {
        $traslado = $this->reserva->traslados->firstWhere('idRT', $idRT);

        if ($traslado) {
            $this->itemEnEdicion = [
                'id' => $traslado->idRT,
                'nombre' => $traslado->nombreTransportacion ?? 'Traslado',
                'precio' => $traslado->TarifaDisplay,
                'pax' => $traslado->pax,
                'fecha' => $traslado->fechaArrival ? \Carbon\Carbon::parse($traslado->fechaArrival)->format('Y-m-d') : '',
                'hora' => $traslado->horaArrival ?? '',
                'moneda' => $traslado->c_moneda
            ];

            $this->nuevoPrecio = $traslado->TarifaDisplay;
            $this->nuevoPax = $traslado->pax;
            $this->nuevaFecha = $traslado->fechaArrival ? \Carbon\Carbon::parse($traslado->fechaArrival)->format('Y-m-d') : '';
            $this->nuevaHora = $traslado->horaArrival ?? '';
            $this->tipoItemEnEdicion = 'traslado';
            $this->mostrarModalTraslado = true;
        }
    }

    public function editarServicio($idAD)
    {
        $servicio = $this->reserva->adicionales->firstWhere('idAD', $idAD);

        if ($servicio) {
            $this->itemEnEdicion = [
                'id' => $servicio->idAD,
                'nombre' => $servicio->nombreServicio ?? 'Servicio Adicional',
                'precio' => $servicio->precio,
                'pax' => $servicio->pax,
                'fecha' => $servicio->fecha ? \Carbon\Carbon::parse($servicio->fecha)->format('Y-m-d') : '',
                'hora' => $servicio->hora ?? '',
                'moneda' => $servicio->c_moneda
            ];

            $this->nuevoPrecio = $servicio->precio;
            $this->nuevoPax = $servicio->pax;
            $this->nuevaFecha = $servicio->fecha ? \Carbon\Carbon::parse($servicio->fecha)->format('Y-m-d') : '';
            $this->nuevaHora = $servicio->hora ?? '';
            $this->tipoItemEnEdicion = 'servicio';
            $this->mostrarModalServicio = true;
        }
    }

    public function editarCombo($idRC)
    {
        $combo = $this->reserva->combos->firstWhere('idRC', $idRC);

        if ($combo) {
            $this->itemEnEdicion = [
                'id' => $combo->idRC,
                'nombre' => $combo->ComboDisplay ?? 'Combo',
                'precio' => $combo->precio,
                'pax' => $combo->pax,
                'fecha' => $combo->fecha ? \Carbon\Carbon::parse($combo->fecha)->format('Y-m-d') : '',
                'hora' => $combo->hora ?? '',
                'moneda' => $combo->c_moneda
            ];

            $this->nuevoPrecio = $combo->precio;
            $this->nuevoPax = $combo->pax;
            $this->nuevaFecha = $combo->fecha ? \Carbon\Carbon::parse($combo->fecha)->format('Y-m-d') : '';
            $this->nuevaHora = $combo->hora ?? '';
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
            DB::beginTransaction();

            $fechaHora = null;
            if ($this->nuevaFecha) {
                $fechaHora = $this->nuevaFecha;
                if ($this->nuevaHora) {
                    $fechaHora .= ' ' . $this->nuevaHora;
                }
            }

            switch ($this->tipoItemEnEdicion) {
                case 'actividad':
                    $this->actualizarActividad($fechaHora);
                    break;
                case 'yate':
                    $this->actualizarYate($fechaHora);
                    break;
                case 'traslado':
                    $this->actualizarTraslado($fechaHora);
                    break;
                case 'servicio':
                    $this->actualizarServicio($fechaHora);
                    break;
                case 'combo':
                    $this->actualizarCombo($fechaHora);
                    break;
            }

            DB::commit();

            session()->flash('message', 'Los cambios se guardaron correctamente');
            $this->cerrarTodosLosModales();
            $this->cargarReserva(); // Recargar la reserva

        } catch (Exception $e) {
            DB::rollback();
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
            DB::beginTransaction();

            switch ($this->tipoItemEnEdicion) {
                case 'actividad':
                    ReservaAU::where('idAU', $this->itemEnEdicion['id'])
                        ->update([
                            'status' => 0,
                            'motivo_update' => 'Cancelado: ' . $this->motivoCancelacion,
                            'id_update' => Auth::id(),
                            'date_update' => now()
                        ]);
                    break;
                case 'yate':
                    ReservaY::where('idRY', $this->itemEnEdicion['id'])
                        ->update([
                            'status' => 0,
                            'motivo_update' => 'Cancelado: ' . $this->motivoCancelacion,
                            'id_update' => Auth::id(),
                            'date_update' => now()
                        ]);
                    break;
                case 'traslado':
                    ReservaT::where('idRT', $this->itemEnEdicion['id'])
                        ->update([
                            'status' => 0,
                            'motivo_update' => 'Cancelado: ' . $this->motivoCancelacion,
                            'id_update' => Auth::id(),
                            'date_update' => now()
                        ]);
                    break;
                case 'servicio':
                    ReservaAD::where('idAD', $this->itemEnEdicion['id'])
                        ->update([
                            'status' => 0,
                            'motivo_update' => 'Cancelado: ' . $this->motivoCancelacion,
                            'id_update' => Auth::id(),
                            'date_update' => now()
                        ]);
                    break;
                case 'combo':
                    ReservaC::where('idRC', $this->itemEnEdicion['id'])
                        ->update([
                            'status' => 0,
                            'motivo_update' => 'Cancelado: ' . $this->motivoCancelacion,
                            'id_update' => Auth::id(),
                            'date_update' => now()
                        ]);
                    break;
            }

            DB::commit();

            session()->flash('message', 'El servicio se canceló correctamente');
            $this->cerrarTodosLosModales();
            $this->cargarReserva(); // Recargar la reserva

        } catch (Exception $e) {
            DB::rollback();
            session()->flash('error', 'Error al cancelar el servicio: ' . $e->getMessage());
        }
    }

    // Métodos privados para actualizar cada tipo de servicio
    private function actualizarActividad($fechaHora)
    {
        $datos = [
            'tarifa' => $this->nuevoPrecio,
            'pax' => $this->nuevoPax,
            'id_update' => Auth::id(),
            'date_update' => now()
        ];

        if ($fechaHora) {
            $datos['start'] = $fechaHora;
        }

        ReservaAU::where('idAU', $this->itemEnEdicion['id'])->update($datos);
    }

    private function actualizarYate($fechaHora)
    {
        $datos = [
            'tarifa' => $this->nuevoPrecio,
            'pax' => $this->nuevoPax,
            'id_update' => Auth::id(),
            'date_update' => now()
        ];

        if ($fechaHora) {
            $datos['start'] = $fechaHora;
        }

        ReservaY::where('idRY', $this->itemEnEdicion['id'])->update($datos);
    }

    private function actualizarTraslado($fechaHora)
    {
        $datos = [
            'tarifa' => $this->nuevoPrecio,
            'cantPax' => $this->nuevoPax,
            'id_update' => Auth::id(),
            'date_update' => now()
        ];

        if ($this->nuevaFecha) {
            $datos['fechaArrival'] = $this->nuevaFecha;
        }

        if ($this->nuevaHora) {
            $datos['horaArrival'] = $this->nuevaHora;
        }

        ReservaT::where('idRT', $this->itemEnEdicion['id'])->update($datos);
    }

    private function actualizarServicio($fechaHora)
    {
        $datos = [
            'precio' => $this->nuevoPrecio,
            'pax' => $this->nuevoPax,
            'id_update' => Auth::id(),
            'date_update' => now()
        ];

        if ($fechaHora) {
            $datos['fecha'] = $fechaHora;
        }

        ReservaAD::where('idAD', $this->itemEnEdicion['id'])->update($datos);
    }

    private function actualizarCombo($fechaHora)
    {
        $datos = [
            'tarifa' => $this->nuevoPrecio,
            'pax' => $this->nuevoPax,
            'id_update' => Auth::id(),
            'date_update' => now()
        ];

        if ($fechaHora) {
            $datos['fecha'] = $fechaHora;
        }

        ReservaC::where('idRC', $this->itemEnEdicion['id'])->update($datos);
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
