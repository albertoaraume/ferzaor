<?php

namespace App\Services\Ventas;

use App\Models\Erp\CFDIComprobante;
use Illuminate\Support\Collection;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use App\Models\Erp\Empresa;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
class FacturasService
{
    /**
     * Obtener detalles completos de una factura
     */
    public function obtenerFacturaCompleta(int $folio): ?array
    {
        try {

            // Buscar la factura por folio (invoice) con relaciones e ingresos relacionados
            $factura = CFDIComprobante::where('idComprobante', $folio)
                ->with(['emisor', 'receptor', 'conceptos', 'ingresos.ingreso'])
                ->first();

            if (!$factura) {
                return null;
            }



            // Obtener conceptos de la factura (ya cargados con with)
            $conceptos = $factura->conceptos;

            // Ingresos relacionados a la factura
            $ingresos = [];
            foreach ($factura->ingresos as $ingresoFactura) {
                    $ingresos[] = [
                        'id' => $ingresoFactura->ingreso_idIngreso,
                        'folio' => $ingresoFactura->ingreso->folio,
                        'referencia' => $ingresoFactura->ingreso->referencia,
                        'fechaRegistro' =>$ingresoFactura->ingreso->fechaRegistro,
                        'formaPago' => $ingresoFactura->ingreso->descripcionFormaPago,
                        'monto' => $ingresoFactura->importe_ingresado,
                        'moneda' => $ingresoFactura->ingreso->c_moneda,
                        'tc' => $ingresoFactura->ingreso->tipoCambio ?? 0,
                        'total' => $ingresoFactura->importe,
                        'status' => $ingresoFactura->Badge,
                    ];

            }

             // Facturas relacionadas
        $facturasRelacionadas = [];
        if ($factura->relacionadas && $factura->relacionadas->count()) {
            foreach ($factura->relacionadas as $relacionada) {
                $facturasRelacionadas[] = [
                    'uuid' => $relacionada->UUID ?? '',
                    'folio' => $relacionada->FolioDisplay ?? '',
                ];
            }
        }

            return [
                'factura' => [
                    'id' => $factura->idComprobante,
                    'folio' => $factura->FolioDisplay,
                    'invoice' => $factura->invoice ?? '',
                    'serie' => $factura->serie ?? '',
                    'fecha' => $factura->fechaCreacion,
                    'fechaTimbrado' => $factura->fechaTimbrado,
                    'tipoDeComprobante' => $factura->tipoComprobanteDescription,
                    'metodoPago' => $factura->metodoPagoDescription,
                    'formaPago' => $factura->formaPagoDescription,
                    'condicionesDePago' => $factura->condicionesdePago,
                    'moneda' => $factura->moneda ?? '',
                    'monedaDescripcion' => $factura->monedaDescription ?? '',
                    'lugarExpedicion' => $factura->lugarExpedicion,
                    'noCertificado' => $factura->noCertificado,
                    'uuid' => $factura->UUID,
                    'version' => $factura->version,
                    'Badge' => $factura->Badge,
                    'observaciones' => $factura->observaciones,
                    'motivoCancelacion' => $factura->motivoCancelacion,
                    'usuarioCaptura' => $factura->capturo?->name ?? '',
                    'locacion' => $factura->locacion?->nombreLocacion ?? '',
                      'relacionadas' => $facturasRelacionadas, // <-- Agregado aquí
                ],
                'emisor' => [
                    'rfc' => $factura->emisor?->rfc ?? '',
                    'nombre' => $factura->emisor?->nombre ?? '',
                    'regimenFiscal' => $factura->emisor?->regimenFiscal ?? '',
                ],
                'receptor' => [
                    'rfc' => $factura->receptor?->rfc ?? '',
                    'nombre' => $factura->receptor?->nombre ?? '',
                    'usoCFDI' => $factura->useCFDIDescription ?? '',
                    'regimenFiscalReceptor' => $factura->receptor?->regimenFiscalReceptor ?? '',
                ],
                'conceptos' => $conceptos->map(function ($concepto) {
                    return [
                        'id' => $concepto->c_cfdiConcepto,
                        'claveProdServ' => $concepto->claveProdServ ?? '',
                        'noIdentificacion' => $concepto->noIdentificacion ?? '',
                        'cantidad' => $concepto->cantidad ?? 0,
                        'claveUnidad' => $concepto->claveUnidad ?? '',
                        'unidad' => $concepto->unidad ?? '',
                        'descripcion' => $concepto->descripcion ?? '',
                        'valorUnitario' => $concepto->valorUnitario ?? 0,
                        'importe' => $concepto->importe ?? 0,
                        'descuento' => $concepto->descuento ?? 0,
                        'objetoImp' => $concepto->objetoImp ?? '',
                    ];
                })->toArray(),
                'totales' => [
                    'subtotal' => $factura->subTotal,
                    'descuentos' => $factura->descuento,
                    'impuestosRetenidos' => $factura->cfdiRetenidos->sum('importe') ?? 0,
                    'impuestosTrasladados' => $factura->cfdiTrasladados->sum('importe') ?? 0,
                    'total' => $factura->Total,
                    'saldo' => $factura->Saldo,
                    'tipoCambio' => $factura->tipoCambio,
                ],
                'ingresos' => $ingresos,
            ];

        } catch (\Exception $e) {
            Log::error('Error al obtener factura completa', [
                'folio' => $folio,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    public function obtenerFacturas(array $filtros = []): Collection
        {
        try {


          $query = $this->construirQuery($filtros);
          $facturas = $query->orderBy('fechaCreacion', 'desc')->get();

            return  $facturas->map(function ($factura) {

            return [
                'idComprobante' => $factura->idComprobante,
                'badge' => $factura->Badge,
                'badgeTimbrado' => $factura->BadgeTimbrado,
                'tipoComprobante' => $factura->tipoComprobanteDescription,
                'folio' => $factura->FolioDisplay,
                'fechaCreacion' => Carbon::parse($factura->fechaCreacion)->format('d-m-Y'),
                'fechaTimbrado' => Carbon::parse($factura->fechaTimbrado)->format('d-m-Y') ?? '',
                'locacion' => $factura->locacion->nombreLocacion ?? '',
                'emisor' => [
                    'rfc' => $factura->emisor?->rfc ?? '',
                    'razonsocial' => $factura->emisor?->nombre ?? '',                    
                ],           
                'receptor' => [
                    'rfc' => $factura->receptor?->rfc ?? '',
                    'razonsocial' => $factura->receptor?->nombre ?? '',
                ],           
                'moneda' => $factura->moneda ?? '',
                'subTotal' => $factura->SubTotal,
                'descuento' => $factura->Descuento,
                'trasladados' => $factura->ToTalTrasladados,
                'retenciones' => $factura->ToTalRetenidos,
                'total' => $factura->Total,
                'abono' => $factura->TotalPagos,
                'saldo' => $factura->Saldo,
                'status' => $factura->status
            ];
        });

        } catch (\Exception $e) {
            Log::error('Error al obtener facturas filtradas: ' . $e->getMessage());
            throw $e;
        }
    }

     public function obtenerTotales($resultados): array
    {



        $totales = [
        'subTotalMXN' => 0,
        'subTotalUSD' => 0,
        'descuentoMXN' => 0,
        'descuentoUSD' => 0,
        'trasladadosMXN' => 0,
        'trasladadosUSD' => 0,
        'retencionesMXN' => 0,
        'retencionesUSD' => 0,
        'totalMXN' => 0,
        'totalUSD' => 0,
        'abonoMXN' => 0,
        'abonoUSD' => 0,
        'saldoMXN' => 0,
        'saldoUSD' => 0,
        ];

        foreach ($resultados as $factura) {
          if($factura['status'] > 0){
            if ($factura['moneda'] == 'USD') {
               $totales['subTotalUSD'] += $factura['subTotal'];
                $totales['descuentoUSD'] += $factura['descuento'];
                $totales['trasladadosUSD'] += $factura['trasladados'];
                $totales['retencionesUSD'] += $factura['retenciones'];
                $totales['totalUSD'] += $factura['total'];
                $totales['abonoUSD'] += $factura['abono'];
                $totales['saldoUSD'] += $factura['saldo'];
            } else {
                $totales['subTotalMXN'] += $factura['subTotal'];
                $totales['descuentoMXN'] += $factura['descuento'];
                $totales['trasladadosMXN'] += $factura['trasladados'];
                $totales['retencionesMXN'] += $factura['retenciones'];
                $totales['totalMXN'] += $factura['total'];
                $totales['abonoMXN'] += $factura['abono'];
                $totales['saldoMXN'] += $factura['saldo'];
            }
        }
        }

   


        return $totales;
    }



    /**
     * Aplicar filtros al query
     */
    private function construirQuery(array $filtros): Builder
    {

        $query = CFDIComprobante::with(['emisor', 'receptor', 'conceptos', 'ingresos.ingreso']);

        // Filtro por fecha inicio
        if (!empty($filtros['fecha_inicio'])) {
             $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();
            $query->whereDate('fechaCreacion', '>=', $fechaInicio);
        }

        // Filtro por fecha fin
        if (!empty($filtros['fecha_fin'])) {
            $fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();
            $query->whereDate('fechaCreacion', '<=', $fechaFin);
        }

           // Filtrar por cliente
        if (!empty($filtros['cliente_id'])) {
            $query->whereHas('receptor.razonsocial', function ($q) use ($filtros) {
                $q->where('cliente_idCliente', $filtros['cliente_id']);
            });
        }

        // Filtrar por locación
        if (!empty($filtros['locacion_id'])) {
            $query->where('cfdi_comprobantes.locacion_idLocacion', $filtros['locacion_id']);
        }

         // Filtrar por empresa
        if (!empty($filtros['empresa_id'])) {
             $query->whereHas('emisor', function ($q) use ($filtros) {
                $q->where('empresa_idEmpresa', $filtros['empresa_id']);
            });
        }

         // Filtrar por empresa
        if (!empty($filtros['tipo_id'])) {
             $query->where('tipoComprobante', $filtros['tipo_id']);
        }



      // Filtro por estado
        if (!empty($filtros['estado'])) {
            $query
                ->when($filtros['estado'] == 'cancelado', function ($q) use ($filtros) {
                    $q->where('cfdi_comprobantes.status', 0);
                })
                ->when($filtros['estado'] == 'proceso', function ($q) use ($filtros) {
                    $q->where('cfdi_comprobantes.status', 1);
                })            
                ->when($filtros['estado'] == 'sinPago', function ($q) {
                    $q->where('cfdi_comprobantes.status', 2); // Excluir cancelados y no show
                })  
                ->when($filtros['estado'] == 'pagadas', function ($q) use ($filtros) {
                    $q->where('cfdi_comprobantes.status', 3);
                });
        }

     
        return $query;

    }

          public function obtenerFiltrosDisponibles(): array
    {
        return [
            'estados' => [               
                'proceso' => 'En Proceso',
                'sinPago' => 'Pendientes de Pago',
                'pagadas' => 'Pagadas',
                'cancelada' => 'Canceladas',
            ],
             'tipos' => [               
                'I' => 'Ingreso',
                'E' => 'Egreso',
                'P' => 'Pago',
            ],
            'locaciones' => Locacion::where('edo', true)->where('isHotel', false)->pluck('nombreLocacion', 'idLocacion')->toArray(),
            'clientes' => Cliente::where('edo', true)->orderBy('nombreComercial')->pluck('nombreComercial', 'idCliente')->toArray(),
            'empresas' => Empresa::where('edo', true)->orderBy('nombreComercial')->pluck('nombreComercial', 'idEmpresa')->toArray(),
        ];
    }

}
