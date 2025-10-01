<?php
namespace App\Services\Reportes\Reservas;

use App\Models\Erp\ReservaT;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class RptReservTransportacionesService
{
    public function obtenerTransportaciones(array $filtros = []): Collection
    {



          $query = $this->construirQuery($filtros);

       $traslados = $query->orderBy('reservas_t.fechaArrival', 'desc')->get();

         if (!empty($filtros['estado']) && $filtros['estado'] === 'sinpago') {
            $traslados = $traslados->filter(function ($traslado) {
                return !$traslado->Pagada;
            });
        }

        return  $traslados->map(function ($traslado) {


             $servicios = [];
    if ($traslado->reserva) {
        $actividades = $traslado->reserva->allactividades?->whereNotIn('status',[0,1])->map(function($a) {
        return '<i class="ti ti-swimming text-muted"></i> ' . $a->nombreTarifa . ' <br><small>' . (Carbon::parse($a->start)->format('d-m-Y H:i') ?? '-') . '</small>';
    })->toArray() ?? [];
    $yates = $traslado->reserva->yates?->whereNotIn('status',[0,1])->map(function($y) {
        return '<i class="fas fa-ship text-muted"></i> ' . $y->yate->nombreYate . ' <br><small>' . (Carbon::parse($y->start)->format('d-m-Y H:i') ?? '-') . '</small>';
    })->toArray() ?? [];
    $otrosServicios = $traslado->reserva->servicios?->whereNotIn('status',[0,1])->map(function($s) {
        return '<i class="fas fa-cogs text-muted"></i> ' . $s->nombreServicio . ' <br><small>' . (Carbon::parse($s->created_at)->format('d-m-Y') ?? '-') . '</small>';
    })->toArray() ?? [];
    $servicios = array_merge($actividades, $yates, $otrosServicios);
    }

   
            return [
                'idRT' => $traslado->idRT,
                'idReserva' => $traslado->reserva_idReserva,
                'badge' => $traslado->Badge,
                'folio' => $traslado->FolioDisplay,
                'tipo' => $traslado->TipoDisplay,
                'cupon' => $traslado->CuponDisplay,
                'badgePagada' => $traslado->BadgePagada,
                'badgeFactura' => $traslado->BadgeFactura,
                'cliente' => $traslado->ClienteDisplay,
                'hotel' => $traslado->HotelDisplay,
                'agencia' => $traslado->AgenciaDisplay,
                'vendedor' => $traslado->VendedorDisplay,
                'transportacion' => $traslado->nombreTransportacion,
                'locacion' => $traslado->LocacionDisplay,
                'paquete' => $traslado->PaqueteDisplay,

                'pax' => $traslado->PaxDisplay,
                'pickup' => $traslado->nombreLocacionPickUp,
                'fechaPickup' => $traslado->fechaArrival,
                'horaPickup' => $traslado->horaArrival,
                'dropoff' => $traslado->nombreLocacionDropOff,
                'fechaDropoff' => $traslado->fechaDeparture,
                'horaDropoff' => $traslado->horaDeparture,
                'moneda' => $traslado->c_moneda,
                'formaPago' => $traslado->FormaPago,
                'tarifaUSD' => $traslado->c_moneda == 'USD' ? $traslado->TarifaDisplay : 0,
                'tarifaMXN' => $traslado->c_moneda == 'MXN' ? $traslado->TarifaDisplay : 0,
                'creditoUSD' => $traslado->c_moneda == 'USD' ? $traslado->TotalCredito : 0,
                'creditoMXN' => $traslado->c_moneda == 'MXN' ? $traslado->TotalCredito : 0,
                'balanceUSD' => $traslado->c_moneda == 'USD' ? $traslado->TotalBalance : 0,
                'balanceMXN' => $traslado->c_moneda == 'MXN' ? $traslado->TotalBalance : 0,
                'saldoUSD' => $traslado->c_moneda == 'USD' ? $traslado->Saldo : 0,
                'saldoMXN' => $traslado->c_moneda == 'MXN' ? $traslado->Saldo : 0,
                'pago_vendedor' => $traslado->scopePagoConcepto('vendedor'),
                'pago_proveedor' => $traslado->scopePagoConcepto('proveedor'),
                'status' => $traslado->status,
               'servicios' => $servicios,

            ];
        });
    }


    private function construirQuery(array $filtros): Builder
    {
        $query = ReservaT::query()->with(['transportacion', 'paquete','reserva']);

        // Hacer join con las tablas relacionadas si hay filtros que lo requieran
        if (!empty($filtros['cliente_id']) || !empty($filtros['locacion_id'])) {
            $query->join('reservas', 'reservas.idReserva', '=', 'reservas_t.reserva_idReserva')->select('reservas_t.*'); // Solo seleccionar campos de reservas_t
        }

        $query->where('reservas_t.status', '!=', 1) // Excluir reservas con status 1
            ->whereHas('reserva', function ($q) {
                $q->where('edo', 2);
            });

              // Filtro por fecha inicio
        if (!empty($filtros['fecha_inicio'])) {

             $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();

            $query->whereDate('reservas_t.fechaArrival', '>=', $fechaInicio);
        }

        // Filtro por fecha fin
        if (!empty($filtros['fecha_fin'])) {
            $fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();
            $query->whereDate('reservas_t.fechaArrival', '<=', $fechaFin);
        }


        // Filtro por estado
        if (!empty($filtros['estado'])) {


            $query
                ->when($filtros['estado'] == 'cancelado', function ($q) use ($filtros) {
                    $q->where('reservas_t.status', 0);
                })
                ->when($filtros['estado'] == 'activas', function ($q) use ($filtros) {
                    $q->whereNotIn('reservas_t.status', [0,1,6]);
                })
                 ->when($filtros['estado'] == 'reservados', function ($q) use ($filtros) {
                    $q->whereIn('reservas_t.status',[2]);
                })
                 ->when($filtros['estado'] == 'realizadas', function ($q) use ($filtros) {
                    $q->whereIn('reservas_t.status', [7, 8, 9]);
                })
                ->when($filtros['estado'] == 'sinfactura', function ($q) use ($filtros) {
                    $q->where('reservas_t.edoFacturado', false)->whereNotIn('reservas_t.status', [0, 6]); // Excluir cancelados y no show
                })
                ->when($filtros['estado'] == 'noshow', function ($q) use ($filtros) {
                    $q->where('reservas_t.status', 6);
                });
        }


        // Filtro por agencia (cliente)
        if (!empty($filtros['cliente_id'])) {
            $query->where('reservas.idCliente', $filtros['cliente_id']);
        }

        // Filtro por locación
        if (!empty($filtros['locacion_id'])) {

            $query->where('reservas.locacion_idLocacion', $filtros['locacion_id']);
        }




        return $query;
    }


     public function obtenerTotales($resultados): array
    {


        $totales = [
            'tarifaUSD' => 0,
            'tarifaMXN' => 0,
            'creditoUSD' => 0,
            'creditoMXN' => 0,
            'balanceUSD' => 0,
            'balanceMXN' => 0,
            'saldoUSD' => 0,
            'saldoMXN' => 0,
        ];

        foreach ($resultados as $traslado) {
            $totales['tarifaUSD'] += $traslado['tarifaUSD'];
            $totales['tarifaMXN'] += $traslado['tarifaMXN'];
            $totales['creditoUSD'] += $traslado['creditoUSD'];
            $totales['creditoMXN'] += $traslado['creditoMXN'];
            $totales['balanceUSD'] += $traslado['balanceUSD'];
            $totales['balanceMXN'] += $traslado['balanceMXN'];
            $totales['saldoUSD'] += $traslado['saldoUSD'];
            $totales['saldoMXN'] += $traslado['saldoMXN'];
        }




        return $totales;
    }

    public function obtenerFiltrosDisponibles(): array
    {
        return [
            'estados' => [
                'activas' => 'Activas',
                'reservados' => 'Reservados',
                'realizadas' => 'Realizadas',
                'sinfactura' => 'Pendientes por facturar',
                'sinpago' => 'Pendientes por pagar',
                'cancelado' => 'Cancelados',
                'noshow' => 'No Show',
            ],
            'locaciones' => Locacion::where('edo', true)->where('isHotel', false)->pluck('nombreLocacion', 'idLocacion')->toArray(),
            'clientes' => Cliente::where('edo', true)->orderBy('nombreComercial')->pluck('nombreComercial', 'idCliente')->toArray(),
        ];
    }
}
