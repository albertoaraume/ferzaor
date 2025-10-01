<?php

namespace App\Services\Reportes\Reservas;

use App\Models\Erp\ReservaY;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use App\Models\Erp\Yate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use DB;
class RptReservYatesService
{
    public function obtenerYates(array $filtros = []): Collection
    {
        $query = $this->construirQuery($filtros);

        $yates = $query->orderBy('start', 'desc')->get();

        if (!empty($filtros['estado']) && $filtros['estado'] === 'sinpago') {
            $yates = $yates->filter(function ($yate) {
                return !$yate->Pagada;
            });
        }

        return $yates->map(function ($yate) {
            return [
                'idRY' => $yate->idRY,
                'badge' => $yate->Badge,
                'folio' => $yate->FolioDisplay,
                'cupon' => $yate->CuponDisplay,
                'badgePagada' => $yate->BadgePagada,
                'badgeFactura' => $yate->BadgeFactura,
                'cliente' => $yate->ClienteDisplay,
                'hotel' => $yate->HotelDisplay,
                'agencia' => $yate->AgenciaDisplay,
                'vendedor' => $yate->VendedorDisplay,
                'yate' => $yate->YateDisplay,
                'locacion' => $yate->LocacionDisplay,
                'paquete' => $yate->PaqueteDisplay,
                'pax' => $yate->PaxDisplay,
                'start' => $yate->start,
                'moneda' => $yate->c_moneda,
                'formaPago' => $yate->FormaPago,
                'tarifaUSD' => $yate->c_moneda == 'USD' ? $yate->tarifa : 0,
                'tarifaMXN' => $yate->c_moneda == 'MXN' ? $yate->tarifa : 0,
                'creditoUSD' => $yate->c_moneda == 'USD' ? $yate->TotalCredito : 0,
                'creditoMXN' => $yate->c_moneda == 'MXN' ? $yate->TotalCredito : 0,
                'balanceUSD' => $yate->c_moneda == 'USD' ? $yate->TotalBalance : 0,
                'balanceMXN' => $yate->c_moneda == 'MXN' ? $yate->TotalBalance : 0,
                'saldoUSD' => $yate->c_moneda == 'USD' ? $yate->Saldo : 0,
                'saldoMXN' => $yate->c_moneda == 'MXN' ? $yate->Saldo : 0,
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
            'saldo_usd' => 0,
            'saldo_mxn' => 0,
        ];

        foreach ($resultados as $yate) {
            $totales['pax'] += $yate['pax'];
            if ($yate['moneda'] == 'USD') {
                $totales['credito_usd'] += $yate['creditoUSD'];
                $totales['balance_usd'] += $yate['balanceUSD'];
                $totales['tarifa_usd'] += $yate['tarifaUSD'];
                $totales['saldo_usd'] += $yate['saldoUSD'];
            } else {
                $totales['credito_mxn'] += $yate['creditoMXN'];
                $totales['balance_mxn'] += $yate['balanceMXN'];
                $totales['tarifa_mxn'] += $yate['tarifaMXN'];
                $totales['saldo_mxn'] += $yate['saldoMXN'];
            }
        }

        // Estadísticas por estado

        return [
            'totales' => $totales,
        ];
    }

    private function construirQuery(array $filtros): Builder
    {
        $query = ReservaY::query()->with(['yate', 'reserva.cliente', 'reserva.locacion']);

        // Hacer join con las tablas relacionadas si hay filtros que lo requieran
        if (!empty($filtros['cliente_id']) || !empty($filtros['locacion_id'])) {
            $query->join('reservas', 'reservas.idReserva', '=', 'reservas_y.reserva_idReserva')->select('reservas_y.*'); // Solo seleccionar campos de reservas_y
        }

        $query
            ->where('reservas_y.status', '!=', 1) // Excluir reservas con status 1
            ->whereHas('reserva', function ($q) {
                $q->where('edo', 2);
            });

        // Filtro por estado
        if (!empty($filtros['estado'])) {
            $query
                ->when($filtros['estado'] == 'cancelado', function ($q) use ($filtros) {
                    $q->where('reservas_y.status', 0);
                })
                ->when($filtros['estado'] == 'activas', function ($q) use ($filtros) {
                    $q->whereNotIn('reservas_y.status', [0, 1, 6]);
                })
                ->when($filtros['estado'] == 'reservados', function ($q) use ($filtros) {
                    $q->whereIn('reservas_y.status', [2]);
                })
                ->when($filtros['estado'] == 'realizadas', function ($q) use ($filtros) {
                    $q->whereIn('reservas_y.status', [7, 8, 9]);
                })
                ->when($filtros['estado'] == 'sinfactura', function ($q) use ($filtros) {
                    $q->where('reservas_y.edoFacturado', false)->whereNotIn('reservas_y.status', [0, 6]); // Excluir cancelados y no show
                })
                ->when($filtros['estado'] == 'sinpago', function ($q) {
                    $q->where('reservas_y.pagado', false)->whereNotIn('reservas_y.status', [0, 6]); // Excluir cancelados y no show
                })
                ->when($filtros['estado'] == 'noshow', function ($q) use ($filtros) {
                    $q->where('reservas_y.status', 6);
                });
        }

        // Filtro por fecha inicio
        if (!empty($filtros['fecha_inicio'])) {
            $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();

            $query->whereDate('reservas_y.start', '>=', $fechaInicio);
        }

        // Filtro por fecha fin
        if (!empty($filtros['fecha_fin'])) {
            $fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();
            $query->whereDate('reservas_y.start', '<=', $fechaFin);
        }

        // Filtro por agencia (cliente)
        if (!empty($filtros['cliente_id'])) {
            $query->where('reservas.idCliente', $filtros['cliente_id']);
        }

        // Filtro por locación
        if (!empty($filtros['locacion_id'])) {
            $query->where('reservas.locacion_idLocacion', $filtros['locacion_id']);
        }

        // Filtro por locación
        if (!empty($filtros['yate_id'])) {
            $query->where('reservas_y.idYate', $filtros['yate_id']);
        }

        return $query;
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
            'yates' => Yate::where('edo', true)->whereNot('nombreYate', '-')->orderBy('nombreYate')->pluck('nombreYate', 'idYate')->toArray(),
        ];
    }
}
