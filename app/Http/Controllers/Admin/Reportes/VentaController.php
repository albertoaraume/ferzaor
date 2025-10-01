<?php

namespace App\Http\Controllers\Admin\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\Reportes\Ventas\RptCortesService;
use Barryvdh\DomPDF\Facade\Pdf;

class VentaController extends Controller
{

     public function showCorte($guid)
    {

        return view('admin.reportes.ventas.vta-cortes-detalles', compact('guid'));
    }

         public function imprimirCorte($guid)
    {

                $corteService = app(RptCortesService::class);
            $corte = $corteService->corteByGuid($guid);
            
            if (!$corte) {
                abort(404, 'Corte no encontrado');
            }

            $data = [
                'corte' => $corte,
                'titulo' => 'Corte de Caja - ' . Str::upper($corte->folio),
                'fecha_generacion' => now()->format('d/m/Y H:i:s')
            ];

            $pdf = Pdf::loadView('exports.pdf.corte', $data);
            $pdf->setPaper('A4', 'portrait');
            
            return $pdf->stream();
    }

}
