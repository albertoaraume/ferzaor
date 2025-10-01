<?php

namespace App\Services\Reportes\Ventas;


use App\Models\Erp\Locacion;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Erp\Caja;


class RptCortesService
{

     public function corteByGuid(string $guid): ?Caja
    {

        return Caja::with([
            'cajero',
            'locacion',
            'ventas',
            'salidas',
            'salidas.usuario',
            'checkins'
        ])->where('guid', $guid)->first();

    }
    public function obtenerCortes(array $filtros = []): Collection
    {

          $query = $this->construirQuery($filtros);

       $cortes = $query->orderBy('fechaApertura', 'desc')->get();



        return  $cortes->map(function ($caja) {




            return [
                'idCaja' => $caja->idCaja,
                'guid' => $caja->guid,
                'folio' => $caja->folio,
                'fechaApertura' => Carbon::parse($caja->fechaApertura)->format('d-m-Y'),
                 'horaApertura' => Carbon::parse($caja->fechaApertura)->format('H:i A'),
                'fechaCierre' => $caja->fechaCierre ? Carbon::parse($caja->fechaCierre)->format('d-m-Y') : '-',
                'horacierre' => $caja->fechaCierre ? Carbon::parse($caja->fechaCierre)->format('H:i A') : '-',
                'status' => $caja->Badge,
                'cajero' => $caja->cajero?->name ?? 'N/A',
                'locacion' => $caja->locacion?->nombreLocacion ?? 'N/A',
                'efectivo_usd' => $caja->TotalEfectivo('USD'),
                'efectivo_mxn' => $caja->TotalEfectivo('MXN'),
                'tpv_mpago_usd' => $caja->TotalMercadoPago('USD'),
                'tpv_mpago_mxn' => $caja->TotalMercadoPago('MXN'),
                'tpv_clip_usd' => $caja->TotalTPVClip('USD'),
                'tpv_clip_mxn' => $caja->TotalTPVClip('MXN'),
                'tpv_banorte_usd' => $caja->TotalTPVBanco('USD')  ,
                'tpv_banorte_mxn' => $caja->TotalTPVBanco('MXN'),
                'trans_usd' => $caja->TotalTransferencias('USD'),
                'trans_mxn' => $caja->TotalTransferencias('MXN'),
                'paypal_usd' => $caja->TotalPayPal('USD'),
                'paypal_mxn' => $caja->TotalPayPal('MXN'),
                'zelle_usd' => $caja->TotalTPVIZETTLE('USD'),
                'zelle_mxn' => $caja->TotalTPVIZETTLE('MXN'),
                'creditos_usd' => $caja->TotalCreditos('USD'),
                'creditos_mxn' => $caja->TotalCreditos('MXN'),
                // Agrega más campos según sea necesario
            ];

        });
    }



    private function construirQuery(array $filtros): Builder
    {
        $query = Caja::query()->with(['ventas', 'salidas', 'checkins']);


              // Filtro por fecha inicio
        if (!empty($filtros['fecha_inicio'])) {

             $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();

            $query->whereDate('fechaApertura', '>=', $fechaInicio);
        }

        // Filtro por fecha fin
        if (!empty($filtros['fecha_fin'])) {
            $fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();
            $query->whereDate('fechaApertura', '<=', $fechaFin);
        }



        // Filtro por locación
        if (!empty($filtros['locacion_id'])) {

            $query->where('locacion_idLocacion', $filtros['locacion_id']);
        }




        return $query;
    }


 public function obtenerTotales($resultados): array
    {


        $totales = [
           'efectivoUSD' => 0,
            'efectivoMXN' => 0,
            'tpvMPagoUSD' => 0,
            'tpvMPagoMXN' => 0,
            'tpvClipUSD' => 0,
            'tpvClipMXN' => 0,
            'tpvBanorteUSD' => 0,
            'tpvBanorteMXN' => 0,
            'transUSD' => 0,
            'transMXN' => 0,
            'paypalUSD' => 0,
            'paypalMXN' => 0,
            'zelleUSD' => 0,
            'zelleMXN' => 0,
            'creditosUSD' => 0,
            'creditosMXN' => 0,
        ];

        foreach ($resultados as $corte) {
            $totales['efectivoUSD'] += $corte['efectivo_usd'];
            $totales['efectivoMXN'] += $corte['efectivo_mxn'];
            $totales['tpvMPagoUSD'] += $corte['tpv_mpago_usd'];
            $totales['tpvMPagoMXN'] += $corte['tpv_mpago_mxn'];
            $totales['tpvClipUSD'] += $corte['tpv_clip_usd'];
            $totales['tpvClipMXN'] += $corte['tpv_clip_mxn'];
            $totales['tpvBanorteUSD'] += $corte['tpv_banorte_usd'];
            $totales['tpvBanorteMXN'] += $corte['tpv_banorte_mxn'];
            $totales['transUSD'] += $corte['trans_usd'];
            $totales['transMXN'] += $corte['trans_mxn'];
            $totales['paypalUSD'] += $corte['paypal_usd'];
            $totales['paypalMXN'] += $corte['paypal_mxn'];
            $totales['zelleUSD'] += $corte['zelle_usd'];
            $totales['zelleMXN'] += $corte['zelle_mxn'];
            $totales['creditosUSD'] += $corte['creditos_usd'];
            $totales['creditosMXN'] += $corte['creditos_mxn'];
        }


        return $totales;
    }


    public function obtenerFiltrosDisponibles(): array
    {
        return [

            'locaciones' => Locacion::where('edo', true)->where('isHotel', false)->pluck('nombreLocacion', 'idLocacion')->toArray(),
        ];
    }
}
