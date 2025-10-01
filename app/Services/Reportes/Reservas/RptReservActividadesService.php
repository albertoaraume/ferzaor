<?php

namespace App\Services\Reportes\Reservas;

use App\Models\Erp\ReservaAU;
use App\Models\Erp\Reserva;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use App\Models\Erp\Actividad;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Carbon\Carbon;
class RptReservActividadesService
{

    public function obtenerActividades(array $filtros = []): Collection
    {
        $query = $this->construirQuery($filtros);

         $actividades = $query->with(['actividad.actividadorigen.clasificacion'])
            ->orderBy('start', 'desc')
            ->get();



         if (!empty($filtros['estado']) && $filtros['estado'] === 'sinpago') {
            $actividades = $actividades->filter(function ($actividad) {
                return !$actividad->Pagada;
            });
        }


        return  $actividades->map(function ($actividad) {

            return [
                'idAU' => $actividad->idAU,
                'badge' => $actividad->Badge,
                'folio' => $actividad->FolioDisplay,
                'cupon' => $actividad->CuponDisplay,
                'badgePagada' => $actividad->BadgePagada,
                'badgeFactura' => $actividad->BadgeFactura,
                'cliente' => $actividad->ClienteDisplay,
                'hotel' => $actividad->HotelDisplay,
                'agencia' => $actividad->AgenciaDisplay,
                'vendedor' => $actividad->VendedorDisplay,
                'actividad' => $actividad->ActividadDisplay,
                'locacion' => $actividad->LocacionDisplay,
                'paquetes' => $actividad->PaqueteDisplay,
                'pax' => $actividad->PaxDisplay,
                'start' => $actividad->start,
                'moneda' => $actividad->c_moneda,
                'formaPago' => $actividad->FormaPago,
                'tarifaUSD' => $actividad->c_moneda == 'USD' ? $actividad->tarifa : '0.00',
                'tarifaMXN' => $actividad->c_moneda == 'MXN' ? $actividad->tarifa  : '0.00',
                'creditoUSD' => $actividad->c_moneda == 'USD' ? $actividad->TotalCredito  : '0.00',
                'creditoMXN' => $actividad->c_moneda == 'MXN' ? $actividad->TotalCredito  : '0.00',
                'balanceUSD' => $actividad->c_moneda == 'USD' ? $actividad->TotalBalance  : '0.00',
                'balanceMXN' => $actividad->c_moneda == 'MXN' ? $actividad->TotalBalance  : '0.00',
                'status' => $actividad->status
            ];
        });
    }



    public function obtenerEstadisticas($resultados): array
    {



        $totales = [
            'pax' => 0,
            'credito_usd' => 0,
            'credito_mxn' => 0,
            'balance_usd' => 0,
            'balance_mxn' => 0,
            'tarifa_usd' => 0,
            'tarifa_mxn' => 0,
        ];

        foreach ($resultados as $actividad) {
            $totales['pax'] += $actividad['pax'];
            if ($actividad['moneda'] == 'USD') {
                $totales['credito_usd'] += $actividad['creditoUSD'];
                $totales['balance_usd'] += $actividad['balanceUSD'];
                $totales['tarifa_usd'] += $actividad['tarifaUSD'];
            } else {
                $totales['credito_mxn'] += $actividad['creditoMXN'];
                $totales['balance_mxn'] += $actividad['balanceMXN'];
                $totales['tarifa_mxn'] += $actividad['tarifaMXN'];
            }
        }

        // Estadísticas por estado


        return [

            'totales' => $totales,

        ];
    }




    private function construirQuery(array $filtros): Builder
    {

        $query = ReservaAU::query()->with(['actividad',
        'actividad.reserva.cliente', 'actividad.reserva.locacion']);

        // Hacer join con las tablas relacionadas si hay filtros que lo requieran
        if (!empty($filtros['cliente_id']) || !empty($filtros['locacion_id'])) {
            $query->join('reservas_a', 'reservas_a.idRA', '=', 'reservas_a_u.reserva_a_idRA')->join('reservas', 'reservas.idReserva', '=', 'reservas_a.reserva_idReserva')->select('reservas_a_u.*'); // Solo seleccionar campos de reservas_au
        }

        $query
            ->where('reservas_a_u.status', '!=', 1) // Excluir reservas con status 1
            ->whereHas('actividad.reserva', function ($q) {
                $q->where('edo', 2);
            });

               // Filtro por locación
        if (!empty($filtros['actividad_id'])) {
            $query->whereHas('actividad', function ($q) use($filtros) {
                $q->where('idActividad', $filtros['actividad_id']);
            });
        }

        // Filtro por estado
        if (!empty($filtros['estado'])) {
            $query
                ->when($filtros['estado'] == 'cancelado', function ($q) use ($filtros) {
                    $q->where('reservas_a_u.status', 0);
                })
                ->when($filtros['estado'] == 'activas', function ($q) use ($filtros) {
                    $q->whereNotIn('reservas_a_u.status', [0,1,6]);
                })
                 ->when($filtros['estado'] == 'reservados', function ($q) use ($filtros) {
                    $q->whereNotIn('reservas_a_u.status',[2]);
                })
                ->when($filtros['estado'] == 'realizadas', function ($q) use ($filtros) {
                    $q->whereIn('reservas_a_u.status', [7, 8, 9]);
                })
                ->when($filtros['estado'] == 'sinfactura', function ($q) use ($filtros) {
                    $q->where('reservas_a_u.edoFacturado', false)->whereNotIn('reservas_a_u.status', [0, 6]); // Excluir cancelados y no show
                })
                ->when($filtros['estado'] == 'sinpago', function ($q) {
                    $q->where('reservas_a_u.pagado', false)->whereNotIn('reservas_a_u.status', [0, 6]); // Excluir cancelados y no show
                })
                ->when($filtros['estado'] == 'noshow', function ($q) use ($filtros) {
                    $q->where('reservas_a_u.status', 6);
                });
        }

        // Filtro por fecha inicio
        if (!empty($filtros['fecha_inicio'])) {
            $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();
            $query->whereDate('reservas_a_u.start', '>=', $fechaInicio);
        }

        // Filtro por fecha fin
        if (!empty($filtros['fecha_fin'])) {
            $fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();
            $query->whereDate('reservas_a_u.start', '<=', $fechaFin);
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

    public function obtenerFiltrosDisponibles(): array
    {
        return cache()->remember('filtros_actividades', 3600, function () {
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
            'locaciones' => Locacion::where('edo', true)
                                  ->where('isHotel', false)
                                  ->pluck('nombreLocacion', 'idLocacion')
                                  ->toArray(),
            'clientes' => Cliente::where('edo', true)
                                ->orderBy('nombreComercial')
                                ->pluck('nombreComercial', 'idCliente')
                                ->toArray(),
            'actividades' => Actividad::where('edo', true)
                                    ->orderBy('nombreActividad')
                                    ->pluck('nombreActividad', 'idActividad')
                                    ->toArray(),
        ];
    });
    }
}
