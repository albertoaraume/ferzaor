<?php

namespace App\Helpers;

use App\Models\Erp\TipoCambio;
use Carbon\Carbon;
class Helper
{


  public static function convertTCFull($monedaOrigen, $importeOrigen, $monedaBase, $loc, $emp)
    {


        if ($monedaOrigen != $monedaBase) {


            $banderaTC = 1;
            $tipoCambio = TipoCambio::where('actual', true)
                ->where('c_moneda', $monedaOrigen)
                ->where('c_monedaBase', $monedaBase)
                ->where('locacion_idLocacion', $loc)
                ->where('empresa_idEmpresa', $emp)->first();


            if ($tipoCambio == null) {
                $banderaTC = 3;
            } else {
                $banderaTC = 2;
            }

            if ($banderaTC < 3) {
                if ($tipoCambio->signo == '*') {
                    $importeOrigen = $importeOrigen * $tipoCambio->precio;
                } else if ($tipoCambio->signo == '/') {
                    $importeOrigen = $importeOrigen / $tipoCambio->precio;
                }
            } else {
                $importeOrigen = 0;
            }
        }

        return round($importeOrigen, 2);
    }

}
