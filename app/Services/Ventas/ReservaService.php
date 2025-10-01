<?php

namespace App\Services\Ventas;

use App\Models\Erp\Reserva;
use App\Models\Erp\ReservaAU;
use App\Models\Erp\ReservaY;
use App\Models\Erp\ReservaT;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Str;
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

}
