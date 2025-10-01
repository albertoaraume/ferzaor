<?php

namespace App\Services\Reportes\Reservas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use App\Models\Erp\Tour;
use App\Models\Erp\Proveedor;
use App\Models\Erp\TourVentaPaquete;
use Carbon\Carbon;
use Illuminate\Support\Str;
class RptReservToursService
{
    public $fechaInicio;
    public $fechaFin;
    public $locacionId;
    public $proveedorId;
    public $clienteId;
    public $tourId;
    public $estado;

    public $tours;
    public $collectionTours;

    private function configurarFiltros($filtros)
    {
        $this->fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();
        $this->fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();
        $this->locacionId = $filtros['locacion_id'] ?? null;
        $this->proveedorId = $filtros['proveedor_id'] ?? null;
        $this->clienteId = $filtros['cliente_id'] ?? null;
        $this->tourId = $filtros['tour_id'] ?? null;
        $this->estado = $filtros['estado'] ?? null;
    }

    public function obtenerTours(array $filtros = []): Collection
    {
        $this->configurarFiltros($filtros);

        $this->tours = $this->construirQuery($filtros)->get();

        $this->collectionTours = collect()
            ->merge($this->tours)
            ->map(function ($tour) {
                return [
                    'idTVPaquete' => $tour->idTVPaquete,
                    'idTour' => $tour->paquete->tour->idTour,
                    'tour' => $tour->paquete->tour->nombreTour ?? 'N/A',
                    'proveedor_id' => $tour->paquete->tour->proveedor->idProveedor ?? 0,
                    'agencia_id' => $tour->tourventa->cliente_idCliente ?? 0,
                    'locacion_id' => $tour->tourventa->locacion_idLocacion ?? 0,
                    'vendedor_id' => $tour->tourventa->vendedor_idVendedor ?? 0,
                    'badge' => $tour->Badge,
                    'folio' => $tour->FolioDisplay,
                    'fecha_venta' => Carbon::parse($tour->tourventa->fecha)->format('d-m-Y'),
                    'fecha_excursion' => Carbon::parse($tour->start)->format('d-m-Y'),
                    'cupon' => $tour->CuponDisplay,
                    'agencia' => $tour->AgenciaDisplay,
                    'vendedor' => $tour->VendedorDisplay,
                    'locacion' => $tour->LocacionDisplay,
                    'cliente' => $tour->ClienteDisplay,
                    'excursion' => $tour->nombrePaquete,
                    'proveedor' => $tour->ProveedorDisplay,
                    'pax' => $tour->pax,
                    'moneda' => $tour->c_moneda,
                    'forma_pago' => $tour->FormaPagoDisplay,
                    'pp' => $tour->tarifa,
                    'tpp' => $tour->importe,
                    'descuento' => $tour->descuento,
                    'tpv' => $tour->TotalVenta,
                    'subTotal' => $tour->SubTotal,
                    'c_proveedor' => $tour->ComisionProveedor,
                    'c_hotel' => $tour->ComisionHotel,
                    'feeAdmin' => $tour->FeeAdmin,
                    'feeSupervisor' => $tour->FeeSuper,
                    'c_vendedor' => $tour->ComisionVendedor,
                    'c_pagadora' => $tour->ComisionPagadora,
                    'utilidad' => $tour->Utilidad,
                    'pago_vendedor' => $tour->scopePagoConcepto('vendedor'),
                    'pago_proveedor' => $tour->scopePagoConcepto('proveedor'),
                    'status' => $tour->status,
                ];
            });

        return $this->collectionTours;
    }

    public function obtenerTotales(): array
    {
        $totales = [
            'pax' => 0,
            'pp' => 0,
            'tpp' => 0,
            'descuento' => 0,
            'tpv' => 0,
            'subTotal' => 0,
            'c_proveedor' => 0,
            'c_hotel' => 0,
            'feeAdmin' => 0,
            'feeSupervisor' => 0,
            'c_vendedor' => 0,
            'c_pagadora' => 0,
            'utilidad' => 0,
        ];

        foreach ($this->collectionTours as $tour) {
            $totales['pax'] += $tour['pax'];
            $totales['pp'] += $tour['pp'];
            $totales['tpp'] += $tour['tpp'];
            $totales['descuento'] += $tour['descuento'];
            $totales['tpv'] += $tour['tpv'];
            $totales['subTotal'] += $tour['subTotal'];
            $totales['c_proveedor'] += $tour['c_proveedor'];
            $totales['c_hotel'] += $tour['c_hotel'];
            $totales['feeAdmin'] += $tour['feeAdmin'];
            $totales['feeSupervisor'] += $tour['feeSupervisor'];
            $totales['c_vendedor'] += $tour['c_vendedor'];
            $totales['c_pagadora'] += $tour['c_pagadora'];
            $totales['utilidad'] += $tour['utilidad'];
        }

        // Estadísticas por estado

        return [
            'totales' => $totales,
        ];
    }

    private function construirQuery(array $filtros): Builder
    {
        $query = TourVentaPaquete::with(['tourventa', 'venta'])->whereHas('tourventa', function ($q) {
            $q->whereDate('fecha', '>=', $this->fechaInicio)->whereDate('fecha', '<=', $this->fechaFin); // Excluir ventas canceladas o pendientes
        });

        // Filtro por estado
        if (!empty($filtros['estado'])) {
            $query
                ->when($this->estado == 'cancelado', function ($q) {
                    $q->where('tours_ventas_paquetes.status', 0);
                })
                ->when($filtros['estado'] == 'confirmado', function ($q) use ($filtros) {
                    $q->where('tours_ventas_paquetes.status', 2);
                });
        }

        // Filtro por agencia (cliente)
        if (!empty($this->clienteId)) {
            $query->whereHas('tourventa', function ($q) {
                $q->where('cliente_idCliente', $this->clienteId);
            });
        }

        // Filtro por locación
        if (!empty($this->locacionId)) {
            $query->whereHas('tourventa', function ($q) {
                $q->where('locacion_idLocacion', $this->locacionId);
            });
        }

        // Filtro por locación
        if (!empty($this->tourId)) {
            $query->whereHas('paquete', function ($q) {
                $q->where('tour_idTour', $this->tourId); // Excluir ventas canceladas o pendientes
            });
        }

        // Filtro por locación
        if (!empty($this->proveedorId)) {
            $query->whereHas('paquete.tour', function ($q) {
                $q->where('proveedor_idProveedor', $this->proveedorId); // Excluir ventas canceladas o pendientes
            });
        }

        return $query;
    }

    public function obtenerFiltrosDisponibles(): array
    {
        return [
            'estados' => [
                'confirmado' => 'Confirmados',
                'cancelado' => 'Cancelados',
            ],
            'locaciones' => Locacion::where('edo', true)->where('isHotel', false)->pluck('nombreLocacion', 'idLocacion')->toArray(),
            'clientes' => Cliente::where('edo', true)->orderBy('nombreComercial')->pluck('nombreComercial', 'idCliente')->toArray(),
            'tours' => Tour::where('edo', true)->whereNot('nombreTour', '-')->orderBy('nombreTour')->pluck('nombreTour', 'idTour')->toArray(),
            'proveedores' => Proveedor::where('edo', true)->orderBy('nombreComercial')->pluck('nombreComercial', 'idProveedor')->toArray(),
        ];
    }

    // TOP 15 Tours más vendidos
    public function topToursVendidos($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('excursion')
            ->map(function ($items, $tourName) {
                return [
                    'tour' => $tourName,
                    'ventas' => $items->sum('tpv'),
                    'utilidad' => $items->sum('utilidad'),
                    'pax' => $items->sum('pax'),
                ];
            })
            ->sortByDesc('pax')
            ->take(15)
            ->values();

        $totalVentasTop = $arrayCollection->sum('pax');

        // Agregar el porcentaje a cada tour
        $arrayCollection = $arrayCollection->map(function ($item) use ($totalVentasTop) {
            $item['porcentaje'] = $totalVentasTop > 0 ? round(($item['pax'] / $totalVentasTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'totalPax' => $arrayCollection->sum('pax'),
            'totalVentas' => $arrayCollection->sum('ventas'),
            'totalUtilidad' => $arrayCollection->sum('utilidad'),
        ];
    }

    // TOP 10 Locaciones con más tours vendidos
    public function topLocacionesVentas($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('locacion_id')
            ->map(function ($items, $locacionId) {
                return [
                    'locacion_id' => $locacionId,
                    'locacion' => $items->first()['locacion'] ?? 'N/A',
                    'totalVentas' => $items->sum('tpv'),
                    'utilidad' => $items->sum('utilidad'),
                    'totalPax' => $items->sum('pax'),
                ];
            })
            ->sortByDesc('totalPax')
            ->take(10)
            ->values();

        $totalVentasLocacionTop = $arrayCollection->sum('totalPax');

        $arrayCollection = $arrayCollection->map(function ($item) use ($totalVentasLocacionTop) {
            $item['porcentaje'] = $totalVentasLocacionTop > 0 ? round(($item['totalPax'] / $totalVentasLocacionTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'totalPax' => $arrayCollection->sum('totalPax'),
            'totalVentas' => $arrayCollection->sum('totalVentas'),
            'totalUtilidad' => $arrayCollection->sum('utilidad'),
        ];
    }

    // TOP 10 Proveedores con más tours vendidos
    public function topProveedoresVentas($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('proveedor_id')
            ->map(function ($items, $proveedorId) {
                return [
                    'proveedor_id' => $proveedorId,
                    'proveedor' => $items->first()['proveedor'] ?? 'N/A',
                    'ventas' => $items->sum('tpv'),
                    'utilidad' => $items->sum('utilidad'),
                    'pax' => $items->sum('pax'),
                ];
            })
            ->sortByDesc('pax')
            ->take(10)
            ->values();

        $totalVentasProveedorTop = $arrayCollection->sum('pax');

        $arrayCollection = $arrayCollection->map(function ($item) use ($totalVentasProveedorTop) {
            $item['porcentaje'] = $totalVentasProveedorTop > 0 ? round(($item['pax'] / $totalVentasProveedorTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'totalPax' => $arrayCollection->sum('pax'),
            'totalVentas' => $arrayCollection->sum('ventas'),
            'totalUtilidad' => $arrayCollection->sum('utilidad'),
        ];
    }

    // TOP 10 Proveedores con más comisiones generadas
    public function topProveedoresComisiones($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('proveedor_id')
            ->map(function ($items, $proveedorId) {
                return [
                    'proveedor_id' => $proveedorId,
                    'proveedor' => $items->first()['proveedor'] ?? 'N/A',
                    'comisiones' => $items->sum('c_proveedor'),
                    'ventas' => $items->sum('tpv'),
                    'utilidad' => $items->sum('utilidad'),
                ];
            })
            ->sortByDesc('comisiones')
            ->take(10)
            ->values();

        $totalComisionesProveedorTop = $arrayCollection->sum('comisiones');

        $arrayCollection = $arrayCollection->map(function ($item) use ($totalComisionesProveedorTop) {
            $item['porcentaje'] = $totalComisionesProveedorTop > 0 ? round(($item['comisiones'] / $totalComisionesProveedorTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'totalComisiones' => $arrayCollection->sum('comisiones'),
            'totalUtilidad' => $arrayCollection->sum('utilidad'),
        ];
    }

    // TOP 10 Vendedores con más tours vendidos
    public function topVendedoresVentasPax($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('vendedor_id')
            ->map(function ($items, $vendedorId) {
                return [
                    'vendedor_id' => $vendedorId,
                    'nombre' => Str::upper($items->first()['vendedor']) ?? 'N/A',
                    'ventas' => $items->sum('tpv'),
                    'utilidad' => $items->sum('utilidad'),
                    'pax' => $items->sum('pax'),
                ];
            })
            ->sortByDesc('pax')
            ->take(10)
            ->values();

        $totalVentasVendedorTop = $arrayCollection->sum('pax');

        $arrayCollection = $arrayCollection->map(function ($item) use ($totalVentasVendedorTop) {
            $item['porcentaje'] = $totalVentasVendedorTop > 0 ? round(($item['pax'] / $totalVentasVendedorTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'totalPax' => $arrayCollection->sum('pax'),
            'totalVentas' => $arrayCollection->sum('ventas'),
            'totalUtilidad' => $arrayCollection->sum('utilidad'),
        ];
    }

    // TOP 10 Vendedores con más ventas
    public function topVendedoresVentas($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('vendedor_id')
            ->map(function ($items, $vendedorId) {
                return [
                    'vendedor_id' => $vendedorId,
                    'nombre' => Str::upper($items->first()['vendedor']) ?? 'N/A',
                    'ventas' => $items->sum('tpv'),
                    'utilidad' => $items->sum('utilidad'),
                ];
            })
            ->sortByDesc('ventas')
            //->take(10)
            ->values();

        $totalVentasVendedorTop = $arrayCollection->sum('ventas');

        $arrayCollection = $arrayCollection->map(function ($item) use ($totalVentasVendedorTop) {
            $item['porcentaje'] = $totalVentasVendedorTop > 0 ? round(($item['ventas'] / $totalVentasVendedorTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'totalPax' => $arrayCollection->sum('pax'),
            'totalVentas' => $arrayCollection->sum('ventas'),
            'totalUtilidad' => $arrayCollection->sum('utilidad'),
        ];
    }

    // TOP 10 Vendedores con más utilidades generadas
    public function topVendedoresUtilidades($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('vendedor_id')
            ->map(function ($items, $vendedorId) {
                return [
                    'vendedor_id' => $vendedorId,
                    'nombre' => Str::upper($items->first()['vendedor']) ?? 'N/A',
                    'utilidad' => $items->sum('utilidad'),
                ];
            })
            ->sortByDesc('utilidad')
            // ->take(10)
            ->values();

        $totalUtilidadVendedorTop = $arrayCollection->sum('utilidad');

        $arrayCollection = $arrayCollection->map(function ($item) use ($totalUtilidadVendedorTop) {
            $item['porcentaje'] = $totalUtilidadVendedorTop > 0 ? round(($item['utilidad'] / $totalUtilidadVendedorTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'totalUtilidad' => $arrayCollection->sum('utilidad'),
        ];
    }

    // TOP 10 Vendedores con más comisiones generadas
    public function topVendedoresComisiones($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('vendedor_id')
            ->map(function ($items, $vendedorId) {
                return [
                    'vendedor_id' => $vendedorId,
                    'nombre' => Str::upper($items->first()['vendedor']) ?? 'N/A',
                    'comision' => $items->sum('c_vendedor'),
                ];
            })
            ->sortByDesc('comision')
            //->take(10)
            ->values();

        $totalComisionVendedorTop = $arrayCollection->sum('comision');

        $arrayCollection = $arrayCollection->map(function ($item) use ($totalComisionVendedorTop) {
            $item['porcentaje'] = $totalComisionVendedorTop > 0 ? round(($item['comision'] / $totalComisionVendedorTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'totalComisiones' => $arrayCollection->sum('comision'),
        ];
    }

    // TOP 10 Vendedores con más comisiones generadas
    public function topMetodosPagos($resultado): array
    {
        $arrayCollection = $resultado
            ->where('status', '>', 0)
            ->groupBy('forma_pago')
            ->map(function ($items, $formaPago) {
                return [
                    'forma_pago' => $formaPago,
                    'metodo' => Str::upper($items->first()['forma_pago']) ?? 'N/A',
                    'pagos' => $items->count(),
                ];
            })
            ->sortByDesc('pagos')
            //->take(10)
            ->values();

        $totalPagosFormaPagoTop = $arrayCollection->sum('pagos');

        $arrayCollection = $arrayCollection->map(function ($item) use ($totalPagosFormaPagoTop) {
            $item['porcentaje'] = $totalPagosFormaPagoTop > 0 ? round(($item['pagos'] / $totalPagosFormaPagoTop) * 100, 2) : 0;
            return $item;
        });

        return [
            'detalles' => $arrayCollection->toArray(),
            'TotalPagos' => $arrayCollection->sum('pagos'),
        ];
    }
}
