<?php

namespace App\Services\Ventas;

use App\Models\Erp\Reserva;
use App\Models\Erp\ReservaAU;
use App\Models\Erp\ReservaY;
use App\Models\Erp\ReservaT;
use App\Models\Erp\ReservaAD;
use App\Models\Erp\ReservaC;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Exception;
class ReservaService
{


    public function reservaByGuid(string $guid): ?Reserva
    {
        return Reserva::with([
            'cliente',
            'vendedor',
            'locacion',
            'empresa',
            // Actividades con sus unidades
            'actividades',
            'actividades.unidades',
            'actividades.unidades.cupon.cupon',
            'actividades.unidades.pasajeros',
            'actividades.unidades.actpaquete.actividad',
            'actividades.actividadorigen',
            // Yates
            'yates',
            'yates.cupon.cupon',
            'yates.pasajeros',
            'yates.yate',
            'yates.paquete',
            // Traslados
            'traslados',
            'traslados.cupon.cupon',
            'traslados.pasajeros',
            'traslados.transportacion',
            'traslados.paquete',
            // Servicios adicionales
            'adicionales',
            'adicionales.cupon.cupon',
            'adicionales.pasajeros',
            'adicionales.servicio',
            // Combos
            'combos',
            'combos.actividades.unidades',
            'combos.cupon.cupon',
            // Tours
            'tours',
            'tours.cupon.cupon',
            'tours.pasajeros',
            // Cupones
            'cupones.actividades',
            'cupones.yates',
            'cupones.transportaciones',
            'cupones.servicios',
        ])->where('guid', $guid)->first();
    }


    public function reservaCompleta(int $reservaId): ?Reserva
    {
        return Reserva::with([
            'cliente',
            'vendedor',
            'locacion',
            'empresa',
            // Actividades con sus unidades
            'actividades',
            'actividades.unidades',
            'actividades.unidades.cupon.cupon',
            'actividades.unidades.pasajeros',
            'actividades.unidades.actpaquete.actividad',
            'actividades.actividadorigen',
            // Yates
            'yates',
            'yates.cupon.cupon',
            'yates.pasajeros',
            'yates.yate',
            'yates.paquete',
            // Traslados
            'traslados',
            'traslados.cupon.cupon',
            'traslados.pasajeros',
            'traslados.transportacion',
            'traslados.paquete',
            // Servicios adicionales
            'adicionales',
            'adicionales.cupon.cupon',
            'adicionales.pasajeros',
            'adicionales.servicio',
            // Combos
            'combos',
            'combos.actividades.unidades',
            'combos.cupon.cupon',
            // Tours
            'tours',
            'tours.cupon.cupon',
            'tours.pasajeros',
            // Cupones
            'cupones.actividades',
            'cupones.yates',
            'cupones.transportaciones',
            'cupones.servicios',
        ])->find($reservaId);
    }

    public function obtenerActividadDetalle(int $actividadId): ?ReservaAU
    {
        return ReservaAU::with(['actividad.reserva.cliente', 'actividad.reserva.locacion'])->find($actividadId);
    }

    public function obtenerYateDetalle(int $yateId): ?ReservaY
    {
        return ReservaY::with(['reserva.cliente', 'reserva.locacion'])->find($yateId);
    }


     public function obtenerTransporteDetalle(int $trasladoId): ?ReservaT
    {

        return ReservaT::with(['reserva'])->find($trasladoId);
    }

        public function obtenerReservas(array $filtros = []): Collection
    {
        $query = $this->construirQuery($filtros);

         $reservas = $query->orderBy('fechaCompra', 'desc')
            ->get();



         if (!empty($filtros['estado']) && $filtros['estado'] === 'sinpago') {
            $reservas = $reservas->filter(function ($reserva) {
                return !$reserva->Pagada;
            });
        }


        return  $reservas->map(function ($reserva) {

            return [
                'idReserva' => $reserva->idReserva,
                'tipo' => $reserva->nombretipoReserva,
                'status' => $reserva->status,
                'badge' => $reserva->Badge,
                'folio' => Str::upper($reserva->folio),
                'pagada' => $reserva->BadgePagada,
                'cliente' => $reserva->nombre,
                'hotel' => $reserva->nombreHotel,
                'agencia' => $reserva->nombreCliente,
                'locacion' => $reserva->locacion->nombreLocacion,
                'vendedor' => $reserva->nombreVendedor,
                'fechaCompra' => Carbon::parse($reserva->fechaCompra)->format('d-m-Y H:i'),
                'moneda' => $reserva->c_moneda,
                'subtotal' => $reserva->subTotal,
                'comision' => $reserva->TotalComision,
                'credito' => $reserva->TotalCredito,
                'balance' => $reserva->TotalBalance,
                'total' => $reserva->ImporteTotal,
                'saldo' => $reserva->Saldo,
            ];
        });
    }


    private function construirQuery(array $filtros): Builder
    {

        $query = Reserva::query()->with(['cliente', 'locacion']);


          // Filtro por fecha inicio
        if (!empty($filtros['fecha_inicio'])) {
            $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();
            $query->whereDate('reservas.fechaCompra', '>=', $fechaInicio);
        }

        // Filtro por fecha fin
        if (!empty($filtros['fecha_fin'])) {
            $fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();
            $query->whereDate('reservas.fechaCompra', '<=', $fechaFin);
        }

        // Hacer join con las tablas relacionadas si hay filtros que lo requieran
        if (!empty($filtros['cliente_id'])) {
            $query->where('reservas.idCliente', $filtros['cliente_id']);
        }
        if (!empty($filtros['locacion_id'])) {
            $query->where('reservas.locacion_idLocacion', $filtros['locacion_id']);
        }


        // Filtro por estado
        if (!empty($filtros['estado'])) {
            $query
                ->when($filtros['estado'] == 'cancelado', function ($q) use ($filtros) {
                    $q->where('reservas.status', 0);
                })
                ->when($filtros['estado'] == 'activas', function ($q) use ($filtros) {
                    $q->whereNotIn('reservas.status', [0, 1]);
                });
        }




        return $query;

    }



    public function obtenerFiltrosDisponibles(): array
    {
        return cache()->remember('filtros_reservas', 3600, function () {
        return [
            'estados' => [
                'activas' => 'Activas',
                'sinpago' => 'Pendientes por pagar',
                'cancelado' => 'Canceladas',
            ],
            'locaciones' => Locacion::where('edo', true)
                                  ->where('isHotel', false)
                                  ->pluck('nombreLocacion', 'idLocacion')
                                  ->toArray(),
            'clientes' => Cliente::where('edo', true)
                                ->orderBy('nombreComercial')
                                ->pluck('nombreComercial', 'idCliente')
                                ->toArray(),

        ];
    });
    }

    public function editarReserva(int $reservaId, array $datos): ?Reserva
    {
        $reserva = Reserva::find($reservaId);
        if (!$reserva) {
            return null;
        }

        // Actualizar los campos de la reserva
        $reserva->fill($datos);
        $reserva->save();

        return $reserva;
    }

    public function cancelarReserva(int $reservaId): ?Reserva
    {
        $reserva = Reserva::find($reservaId);
        if (!$reserva) {
            return null;
        }

        // Cambiar el estado de la reserva a cancelado
        $reserva->status = 0;
        $reserva->save();

        return $reserva;
    }

    /**
     * Actualizar un servicio de la reserva
     */
    public function actualizarServicio(string $tipo, int $id, array $datos): bool
    {
        try {
            DB::beginTransaction();

            $datosActualizacion = [
                'id_update' => Auth::id(),
                'date_update' => now()
            ];

            switch ($tipo) {
                case 'actividad':
                    $datosActualizacion = array_merge($datosActualizacion, [
                        'tarifa' => $datos['precio'],
                        'pax' => $datos['pax']
                    ]);

                    if (isset($datos['fechaHora'])) {
                        $datosActualizacion['start'] = $datos['fechaHora'];
                    }

                    ReservaAU::where('idAU', $id)->update($datosActualizacion);
                    break;

                case 'yate':
                    $datosActualizacion = array_merge($datosActualizacion, [
                        'tarifa' => $datos['precio'],
                        'pax' => $datos['pax']
                    ]);

                    if (isset($datos['fechaHora'])) {
                        $datosActualizacion['start'] = $datos['fechaHora'];
                    }

                    ReservaY::where('idRY', $id)->update($datosActualizacion);
                    break;

                case 'traslado':
                    $datosActualizacion = array_merge($datosActualizacion, [
                        'tarifa' => $datos['precio'],
                        'cantPax' => $datos['pax']
                    ]);

                    if (isset($datos['fecha'])) {
                        $datosActualizacion['fechaArrival'] = $datos['fecha'];
                    }

                    if (isset($datos['hora'])) {
                        $datosActualizacion['horaArrival'] = $datos['hora'];
                    }

                    ReservaT::where('idRT', $id)->update($datosActualizacion);
                    break;

                case 'servicio':
                    $datosActualizacion = array_merge($datosActualizacion, [
                        'precio' => $datos['precio'],
                        'pax' => $datos['pax']
                    ]);

                    if (isset($datos['fechaHora'])) {
                        $datosActualizacion['fecha'] = $datos['fechaHora'];
                    }

                    ReservaAD::where('idAD', $id)->update($datosActualizacion);
                    break;

                case 'combo':
                    $datosActualizacion = array_merge($datosActualizacion, [
                        'tarifa' => $datos['precio'],
                        'pax' => $datos['pax']
                    ]);

                    if (isset($datos['fechaHora'])) {
                        $datosActualizacion['fecha'] = $datos['fechaHora'];
                    }

                    ReservaC::where('idRC', $id)->update($datosActualizacion);
                    break;

                default:
                    throw new Exception("Tipo de servicio no válido: {$tipo}");
            }

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Cancelar un servicio de la reserva
     */
    public function cancelarServicio(string $tipo, int $id, string $motivo): bool
    {
        try {
            DB::beginTransaction();

            $datosActualizacion = [
                'status' => 0,
                'motivo_update' => 'Cancelado: ' . $motivo,
                'id_update' => Auth::id(),
                'date_update' => now()
            ];

            switch ($tipo) {
                case 'actividad':
                    ReservaAU::where('idAU', $id)->update($datosActualizacion);
                    break;

                case 'yate':
                    ReservaY::where('idRY', $id)->update($datosActualizacion);
                    break;

                case 'traslado':
                    ReservaT::where('idRT', $id)->update($datosActualizacion);
                    break;

                case 'servicio':
                    ReservaAD::where('idAD', $id)->update($datosActualizacion);
                    break;

                case 'combo':
                    ReservaC::where('idRC', $id)->update($datosActualizacion);
                    break;

                default:
                    throw new Exception("Tipo de servicio no válido: {$tipo}");
            }

            DB::commit();
            return true;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Obtener datos de un servicio específico para edición
     */
    public function obtenerDatosServicioParaEdicion(string $tipo, int $id): ?array
    {
        switch ($tipo) {
            case 'actividad':
                $actividad = ReservaAU::find($id);
                if (!$actividad) return null;

                return [
                    'id' => $actividad->idAU,
                    'nombre' => $actividad->ActividadDisplay,
                    'precio' => $actividad->precio,
                    'pax' => $actividad->pax,
                    'fecha' => $actividad->start ? Carbon::parse($actividad->start)->format('Y-m-d') : '',
                    'hora' => $actividad->start ? Carbon::parse($actividad->start)->format('H:i') : '',
                    'moneda' => $actividad->c_moneda
                ];

            case 'yate':
                $yate = ReservaY::find($id);
                if (!$yate) return null;

                return [
                    'id' => $yate->idRY,
                    'nombre' => $yate->YateDisplay,
                    'precio' => $yate->tarifa,
                    'pax' => $yate->pax,
                    'fecha' => $yate->start ? Carbon::parse($yate->start)->format('Y-m-d') : '',
                    'hora' => $yate->start ? Carbon::parse($yate->start)->format('H:i') : '',
                    'moneda' => $yate->c_moneda
                ];

            case 'traslado':
                $traslado = ReservaT::find($id);
                if (!$traslado) return null;

                return [
                    'id' => $traslado->idRT,
                    'nombre' => $traslado->nombreTransportacion ?? 'Traslado',
                    'precio' => $traslado->TarifaDisplay,
                    'pax' => $traslado->pax,
                    'fecha' => $traslado->fechaArrival ? Carbon::parse($traslado->fechaArrival)->format('Y-m-d') : '',
                    'hora' => $traslado->horaArrival ?? '',
                    'moneda' => $traslado->c_moneda
                ];

            case 'servicio':
                $servicio = ReservaAD::find($id);
                if (!$servicio) return null;

                return [
                    'id' => $servicio->idAD,
                    'nombre' => $servicio->nombreServicio ?? 'Servicio Adicional',
                    'precio' => $servicio->precio,
                    'pax' => $servicio->pax,
                    'fecha' => $servicio->fecha ? Carbon::parse($servicio->fecha)->format('Y-m-d') : '',
                    'hora' => $servicio->hora ?? '',
                    'moneda' => $servicio->c_moneda
                ];

            case 'combo':
                $combo = ReservaC::find($id);
                if (!$combo) return null;

                return [
                    'id' => $combo->idRC,
                    'nombre' => $combo->ComboDisplay ?? 'Combo',
                    'precio' => $combo->precio,
                    'pax' => $combo->pax,
                    'fecha' => $combo->fecha ? Carbon::parse($combo->fecha)->format('Y-m-d') : '',
                    'hora' => $combo->hora ?? '',
                    'moneda' => $combo->c_moneda
                ];

            default:
                return null;
        }
    }

}
