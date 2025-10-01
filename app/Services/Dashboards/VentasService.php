<?php

namespace App\Services\Dashboards;

use App\Models\Erp\Locacion;
use App\Models\Erp\ReservaAU;
use App\Models\Erp\ReservaY;
use App\Models\Erp\ReservaAD;
use App\Models\Erp\TipoCambio;
use App\Models\Erp\VentaServicio;
use App\Models\Erp\VentaTour;
use App\Models\Erp\TourVentaPaquete;
use App\Helpers\Helper;
use App\Models\Erp\FotoVentaPaquete;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VentasService
{
    private $fechaInicio;
    private $fechaFin;
    private $locacionId;


    public $productos = [];

    public $actividades = [];
    public $yates = [];
    public $servicios = [];
    public $fotos = [];
    public $tours = [];

    public $columnas = ['horas', 'pax', 'ventaTotal', 'costo', 'descuento', 'enm_total', 'enm_no_pagados_total', 'fotos_ingresos', 'ventaIngresos', 'utilidad'];


    public function __construct()
    {
        // Constructor vacío - se configuran las fechas dinámicamente
    }

    /**
     * Configurar filtros para las consultas
     */
    public function configurarFiltros($filtros)
    {
        $this->fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();
        $this->fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();
        $this->locacionId = $filtros['locacion_id'] ?? null;

    }

    public function obtenerSumatoriasPorTipo($productos)
    {
        $tipos = ['Actividad', 'Yate', 'Servicio', 'Tour'];
       $totalesPorTipo = [];

        foreach ($tipos as $tipo) {
            $productosFiltrados = $productos->where('tipo', $tipo);
            $totalesPorTipo[$tipo] = [];
            foreach ($this->columnas as $columna) {
                $totalesPorTipo[$tipo][$columna] = $productosFiltrados->sum($columna);
            }
        }

        // También calcular totales generales
        $totalesPorTipo['general'] = [];
        foreach ($this->columnas as $columna) {
            $totalesPorTipo['general'][$columna] = $productos->sum($columna);
        }

        return $totalesPorTipo;
    }

 public function obtenerSumatorias($productos)
    {

        $totalesProductos = [];
            foreach ($this->columnas as $columna) {
                 $totalesProductos[$columna] = $productos->sum($columna);
            }
        return $totalesProductos;
    }



    /**
     * Obtener Ventas principales
     */
    public function obtenerProductos(): Collection
    {
        // Obtener datos de actividades
      $this->actividades = $this->obtenerDatosActividades();

        // Obtener datos de yates
        $this->yates = $this->obtenerDatosYates();

        // Obtener datos de servicios
     $this->servicios = $this->obtenerDatosServicios();

        // Obtener datos de fotos
     $this->fotos = $this->obtenerDatosFotos();

        // Obtener datos de tours
        $this->tours = $this->obtenerDatosTours();




        // Procesar Productos
        $collectProductos = collect()
           ->merge($this->actividades)
          ->merge($this->yates)
          ->merge($this->servicios)
            ->merge($this->fotos)
            ->merge($this->tours)
            ->groupBy('producto_id')

            ->map(function ($items, $productoId) {
                $primerItem = $items->first();

                // Agregar métricas agrupadas
                $horas = $items->sum('horas');
                $pax = $items->sum('pax');
                $ventaTotal = $items->sum('ventaTotal');
                $costo = $items->sum('costo');
                $descuento = $items->sum('descuento');
                $ventaIngresos = $items->sum('ventaIngresos');

                $pagaronEnm = $items->sum('enm_pagados');
                $noPagaronEnm = $items->sum('enm_no_pagados');
                $totalENM = $items->sum('enm_ingresos');
                $tarifaPorPax = $pagaronEnm > 0 ? $totalENM / $pagaronEnm : 0;


                $totalFotos = $items->sum('fotos_ingresos');

                $ingresosTotal = $ventaIngresos + $totalENM + $totalFotos;

                $utilidad = $ingresosTotal - $costo;
                $utilidadPorcentaje = $ingresosTotal > 0 ? ($utilidad / $ingresosTotal) * 100 : 0;

                return [
                    'producto_id' => $productoId,
                    'producto' => $primerItem['producto'],
                    'tipo' => $primerItem['tipo'],

                    'proveedor_id' => $primerItem['proveedor_id'],
                    'proveedor' => $primerItem['proveedor'],
                    'agencia_id' => $primerItem['agencia_id'],
                    'agencia' => $primerItem['agencia'],
                    'locacion_id' => $primerItem['locacion_id'],
                    'locacion' => $primerItem['locacion'],

                    'horas' => $horas,
                    'pax' => $pax,
                    'ventaTotal' => $ventaTotal,
                    'costo' => $costo,
                    'descuento' => $descuento,
                    'ventaIngresos' => $ventaIngresos,

                    'enm_pagados' => $pagaronEnm,
                    'enm_no_pagados' => $noPagaronEnm,
                    'enm_total' => $totalENM,
                    'enm_no_pagados_total' => $noPagaronEnm * 20,
                    'enm_tarifa' => $tarifaPorPax,
                    'enm_label' => '(' . $pagaronEnm . ' x ' . number_format($tarifaPorPax, 2) . ')',
                    'enm_no_pagados_label' => '(' . $noPagaronEnm . ') ' . number_format($noPagaronEnm * 20, 2),

                    'fotos_ingresos' => $totalFotos,

                    'ingresosTotal' => $ingresosTotal,
                    'utilidad' => $utilidad,
                    'utilidad_porcentaje' => $utilidadPorcentaje,
                ];
            })
            ->sortBy('producto')
            ->values();

        return $collectProductos;
    }

    /**
     * Obtener Ventas  proveedores
     */
    public function obtenerProveedores(): Collection
    {
        // Procesar Productos
        $collectProvedores = collect()
            ->merge($this->actividades)
            ->merge($this->yates)
            ->merge($this->fotos)
            ->merge($this->tours)
            ->groupBy('proveedor_id')

            ->map(function ($items, $proveedorId) {
                $primerItem = $items->first();

                // Agregar métricas agrupadas
                $horas = $items->sum('horas');
                $pax = $items->sum('pax');
                $ventaTotal = $items->sum('ventaTotal');
                $costo = $items->sum('costo');
                $descuento = $items->sum('descuento');
                $ventaIngresos = $items->sum('ventaIngresos');

                $pagaronEnm = $items->sum('enm_pagados');
                $noPagaronEnm = $items->sum('enm_no_pagados');
                $totalENM = $items->sum('enm_ingresos');
                $tarifaPorPax = $pagaronEnm > 0 ? $totalENM / $pagaronEnm : 0;
                $totalFotos = $items->sum('fotos_ingresos');

                $ingresosTotal = $ventaIngresos + $totalENM + $totalFotos;
                $utilidad = $ingresosTotal - $costo;
                $utilidadPorcentaje = $ingresosTotal > 0 ? ($utilidad / $ingresosTotal) * 100 : 0;

                return [
                    'proveedor_id' => $proveedorId,
                    'proveedor' => $primerItem['proveedor'],

                    'horas' => $horas,
                    'pax' => $pax,
                    'ventaTotal' => $ventaTotal,
                    'costo' => $costo,
                    'descuento' => $descuento,
                    'ventaIngresos' => $ventaIngresos,

                    'enm_pagados' => $pagaronEnm,
                    'enm_no_pagados' => $noPagaronEnm,
                    'enm_total' => $totalENM,
                       'enm_no_pagados_total' => $noPagaronEnm * 20,
                    'enm_tarifa' => $tarifaPorPax,
                    'enm_label' => '(' . $pagaronEnm . ' x ' . number_format($tarifaPorPax, 2) . ')',
                    'enm_no_pagados_label' => '(' . $noPagaronEnm . ') ' . number_format($noPagaronEnm * 20, 2),

                    'fotos_ingresos' => $totalFotos,

                    'ingresosTotal' => $ingresosTotal,
                    'utilidad' => $utilidad,
                    'utilidad_porcentaje' => $utilidadPorcentaje,
                ];
            })
            ->values();

        return $collectProvedores;
    }

    /**
     * Obtener Ventas  por agencia
     */
    public function obtenerAgencias(): Collection
    {
        // Procesar Productos
        $collectAgencias = collect()
            ->merge($this->actividades)
            ->merge($this->yates)
            ->merge($this->servicios)
            ->merge($this->fotos)
            ->merge($this->tours)
            ->groupBy('agencia_id')

            ->map(function ($items, $agenciaId) {
                $primerItem = $items->first();

                // Agregar métricas agrupadas
                $horas = $items->sum('horas');
                $pax = $items->sum('pax');
                $ventaTotal = $items->sum('ventaTotal');
                $costo = $items->sum('costo');
                $descuento = $items->sum('descuento');
                $ventaIngresos = $items->sum('ventaIngresos');

                $pagaronEnm = $items->sum('enm_pagados');
                $noPagaronEnm = $items->sum('enm_no_pagados');
                $totalENM = $items->sum('enm_ingresos');
                $tarifaPorPax = $pagaronEnm > 0 ? $totalENM / $pagaronEnm : 0;
                $totalFotos = $items->sum('fotos_ingresos');

                $ingresosTotal = $ventaIngresos + $totalENM + $totalFotos;
                $utilidad = $ingresosTotal - $costo;
                $utilidadPorcentaje = $ingresosTotal > 0 ? ($utilidad / $ingresosTotal) * 100 : 0;


                 // Agrupar actividades por producto para obtener el detalle
            $actividades = $items->groupBy('producto_id')->map(function ($productItems) {
                $primerProducto = $productItems->first();

                // Calcular métricas por producto
                $prodHoras = $productItems->sum('horas');
                $prodPax = $productItems->sum('pax');
                $prodVentaTotal = $productItems->sum('ventaTotal');
                $prodCosto = $productItems->sum('costo');
                $prodDescuento = $productItems->sum('descuento');
                $prodVentaIngresos = $productItems->sum('ventaIngresos');

                $prodPagaronEnm = $productItems->sum('enm_pagados');
                $prodNoPagaronEnm = $productItems->sum('enm_no_pagados');
                $prodTotalENM = $productItems->sum('enm_ingresos');
                $prodTotalFotos = $productItems->sum('fotos_ingresos');

                $prodIngresosTotal = $prodVentaIngresos + $prodTotalENM + $prodTotalFotos;
                $prodUtilidad = $prodIngresosTotal - $prodCosto;
                $prodUtilidadPorcentaje = $prodIngresosTotal > 0 ? ($prodUtilidad / $prodIngresosTotal) * 100 : 0;

                return [
                    'producto_id' => $primerProducto['producto_id'],
                    'nombre' => $primerProducto['producto'],
                    'tipo' => $primerProducto['tipo'],
                    'proveedor' => $primerProducto['proveedor'],
                    'horas' => $prodHoras,
                    'pax' => $prodPax,
                    'total' => $prodVentaTotal,
                    'costo' => $prodCosto,
                    'descuento' => $prodDescuento,
                    'enm' => $prodTotalENM,
                    'enm_pagados' => $prodPagaronEnm,
                    'enm_no_pagados' => $prodNoPagaronEnm,
                    'fotos' => $prodTotalFotos,
                    'ingresos' => $prodIngresosTotal,
                    'utilidad' => $prodUtilidad,
                    'utilidad_porcentaje' => $prodUtilidadPorcentaje,
                ];
            })->values();

                return [
                    'agencia_id' => $agenciaId,
                    'agencia' => $primerItem['agencia'],

                    'horas' => $horas,
                    'pax' => $pax,
                    'ventaTotal' => $ventaTotal,
                    'costo' => $costo,
                    'descuento' => $descuento,
                    'ventaIngresos' => $ventaIngresos,

                    'enm_pagados' => $pagaronEnm,
                    'enm_no_pagados' => $noPagaronEnm,
                    'enm_total' => $totalENM,
                    'enm_no_pagados_total' => $noPagaronEnm * 20,
                    'enm_tarifa' => $tarifaPorPax,
                    'enm_label' => '(' . $pagaronEnm . ' x ' . number_format($tarifaPorPax, 2) . ')',
                    'enm_no_pagados_label' => '(' . $noPagaronEnm . ') ' . number_format($noPagaronEnm * 20, 2),

                    'fotos_ingresos' => $totalFotos,

                    'ingresosTotal' => $ingresosTotal,
                    'utilidad' => $utilidad,
                    'utilidad_porcentaje' => $utilidadPorcentaje,

                     // Agregar las obes detalladas
                'actividades' => $actividades,
                ];
            })
            ->values();

        return $collectAgencias;
    }

    /**
     * Obtener Ventas  por agencia
     */
    public function obtenerLocaciones(): Collection
    {
        // Procesar Productos
        $collectLocaciones = collect()
            ->merge($this->actividades)
            ->merge($this->yates)
            ->merge($this->servicios)
            ->merge($this->fotos)
            ->merge($this->tours)
            ->groupBy('locacion_id')

            ->map(function ($items, $locacionId) {
                $primerItem = $items->first();

                // Agregar métricas agrupadas
                $horas = $items->sum('horas');
                $pax = $items->sum('pax');
                $ventaTotal = $items->sum('ventaTotal');
                $costo = $items->sum('costo');
                $descuento = $items->sum('descuento');
                $ventaIngresos = $items->sum('ventaIngresos');

                $pagaronEnm = $items->sum('enm_pagados');
                $noPagaronEnm = $items->sum('enm_no_pagados');
                $totalENM = $items->sum('enm_ingresos');
                $tarifaPorPax = $pagaronEnm > 0 ? $totalENM / $pagaronEnm : 0;
                $totalFotos = $items->sum('fotos_ingresos');

                $ingresosTotal = $ventaIngresos + $totalENM + $totalFotos;
                $utilidad = $ingresosTotal - $costo;
                $utilidadPorcentaje = $ingresosTotal > 0 ? ($utilidad / $ingresosTotal) * 100 : 0;

                return [
                    'locacion_id' => $locacionId,
                    'locacion' => $primerItem['locacion'],

                    'horas' => $horas,
                    'pax' => $pax,
                    'ventaTotal' => $ventaTotal,
                    'costo' => $costo,
                    'descuento' => $descuento,
                    'ventaIngresos' => $ventaIngresos,

                    'enm_pagados' => $pagaronEnm,
                    'enm_no_pagados' => $noPagaronEnm,
                    'enm_total' => $totalENM,
                       'enm_no_pagados_total' => $noPagaronEnm * 20,
                    'enm_tarifa' => $tarifaPorPax,
                    'enm_label' => '(' . $pagaronEnm . ' x ' . number_format($tarifaPorPax, 2) . ')',
                    'enm_no_pagados_label' => '(' . $noPagaronEnm . ') ' . number_format($noPagaronEnm * 20, 2),

                    'fotos_ingresos' => $totalFotos,

                    'ingresosTotal' => $ingresosTotal,
                    'utilidad' => $utilidad,
                    'utilidad_porcentaje' => $utilidadPorcentaje,
                ];
            })
            ->values();

        return $collectLocaciones;
    }

    /**
     * Obtener datos de actividades
     */
    private function obtenerDatosActividades(): Collection
    {
        try {
            $query = ReservaAU::with(['actividad', 'pasajeros.ventaenm.venta'])
                ->whereDate('reservas_a_u.start', '>=', $this->fechaInicio)
                ->whereDate('reservas_a_u.start', '<=', $this->fechaFin)
                ->whereNotIn('reservas_a_u.status', [0, 1, 6]);

            // Filtrar por locación si se especifica
            if (!empty($this->locacionId)) {

                $query->whereHas('actividad', function ($q) {
                    $q->where('idLocacion', $this->locacionId);
                });
            }

            $actividades = $query->get();

            return $actividades->map(function ($item) {
                $enmsData = $this->obtenerPasajeros($item->pasajeros);
                $conversion = $this->obtenerConversion($item->c_moneda, $item->date_create, $item->actividad->reserva->locacion_idLocacion);

                $total = ($item->tarifa / $conversion) * $item->PaxDisplay;
                $costo = $item->Costo / $conversion;
                $comision = $item->TotalComision / $conversion;
                $descuento = $item->descuento / $conversion;
                $ventaIngresos = ($item->TotalCredito / $conversion) + ($item->TotalBalance / $conversion);



                $nombreAgencia = $item->actividad->reserva->tipoReserva == 'AG' ?$item->actividad->reserva->nombreCliente : 'Venta Directa';

                return [
                    'producto_id' => 'actividad_' . $item->actividad->idActividad,
                    'producto' => $item->actividad->nombreActividad,
                    'proveedor_id' => $item->actividad->actividadorigen->proveedor_idProveedor ?? 'N/A',
                    'proveedor' => $item->actividad->actividadorigen->proveedor->nombreComercial ?? 'N/A',
                    'agencia_id' => $item->actividad->reserva->idCliente,
                    'agencia' => $nombreAgencia,
                    'locacion_id' => $item->actividad->reserva->locacion_idLocacion ?? 'N/A',
                    'locacion' => $item->actividad->reserva->locacion->nombreLocacion ?? 'N/A',
                    'tipo' => 'Actividad',
                    'horas' => $item->HorasRenta ?? 0,
                    'pax' => $item->PaxDisplay ?? 0,
                    'ventaTotal' => $total,
                    'costo' => $costo,
                    'comision' => $comision,
                    'descuento' => $descuento,
                    'ventaIngresos' => $ventaIngresos,
                    'enm_pagados' => $enmsData['enm_pagados'],
                    'enm_no_pagados' => $enmsData['enm_no_pagados'],
                    'enm_ingresos' => $enmsData['enm_ingresos'],
                   'fotos_ingresos' =>0,
                ];
            });
        } catch (\Exception $e) {
            Log::error('Error al obtener datos de actividades: ' . $e->getMessage());
            return collect();
        }
    }

    private function obtenerDatosYates(): Collection
    {
        try {
            $query = ReservaY::with(['pasajeros.ventaenm.venta'])
                ->whereDate('reservas_y.start', '>=', $this->fechaInicio)
                ->whereDate('reservas_y.start', '<=', $this->fechaFin)
                ->whereNotIn('reservas_y.status', [0, 1, 6]);

                //$query->where('idYate',188);

            // Filtrar por locación si se especifica
            if (!empty($this->locacionId)) {

                $query->whereHas('reserva', function ($q) {
                    $q->where('locacion_idLocacion', $this->locacionId);
                });
            }

            $yates = $query->get();

            return $yates->map(function ($itemR) {
                $enmsData = $this->obtenerPasajeros($itemR->pasajeros);
                $conversion = $this->obtenerConversion($itemR->c_moneda, $itemR->date_create, $itemR->reserva->locacion_idLocacion);

                $total = $itemR->tarifa / $conversion;
                $costo = $itemR->Costo / $conversion;
                $comision = $itemR->TotalComision / $conversion;
                $descuento = $itemR->descuento / $conversion;
                $ventaIngresos = $itemR->TotalCredito / $conversion + $itemR->TotalBalance / $conversion;

                $nombreAgencia = $itemR->reserva->tipoReserva == 'AG' ?$itemR->reserva->nombreCliente : 'Venta Directa';


                return [
                    'producto_id' => 'yate_' . $itemR->idYate,
                    'producto' => $itemR->yate->nombreYate,
                    'proveedor_id' => $itemR->yate->idProveedor ?? 'N/A',
                    'proveedor' => $itemR->yate->proveedor->nombreComercial ?? 'N/A',
                    'agencia_id' => $itemR->reserva->idCliente,
                    'agencia' => $nombreAgencia,
                    'locacion_id' => $itemR->reserva->locacion_idLocacion ?? 'N/A',
                    'locacion' => $itemR->reserva->locacion->nombreLocacion ?? 'N/A',
                    'tipo' => 'Yate',

                    'horas' => $itemR->HorasRenta ?? 0,
                    'pax' => $itemR->PaxDisplay ?? 0,
                    'ventaTotal' => $total,
                    'costo' => $costo,
                    'comision' => $comision,
                    'descuento' => $descuento,
                    'ventaIngresos' => $ventaIngresos,
                    'enm_pagados' => $enmsData['enm_pagados'],
                    'enm_no_pagados' => $enmsData['enm_no_pagados'],
                    'enm_ingresos' => $enmsData['enm_ingresos'],
                   'fotos_ingresos' => 0,
                ];
            });
        } catch (\Exception $e) {
            Log::error('Error al obtener datos de yates: ' . $e->getMessage());
            return collect();
        }
    }

    private function obtenerPasajeros($pasajeros)
    {
        try {
            // Filtrar los que aplican ENM
            $aplicanEnm = $pasajeros->filter(function ($pasajero) {
                return $pasajero->EnmAplica;
            });



            // Clasificar por pago ENM
            $pagaronEnm = $aplicanEnm->filter(function ($pasajero) {
                return $pasajero->EnmPagado;
            });

            $noPagaronEnm = $aplicanEnm->filter(function ($pasajero) {
                return !$pasajero->EnmPagado;
            });

            $totalIngresosENM = $pagaronEnm->filter(fn($p) => $this->obtenerInformacionPago($p)['moneda'] == 'USD')->sum(fn($p) => $this->obtenerInformacionPago($p)['importe']);

            return [
                'enm_pagados' => $pagaronEnm->count(),
                'enm_no_pagados' => $noPagaronEnm->count(),
                'enm_ingresos' => $totalIngresosENM,
            ];
        } catch (\Exception $e) {
            // Manejo de excepciones
            Log::error('Error al obtener pasajeros ENM: ' . $e->getMessage());
            return [
                'enm_pagados' => 0,
                'enm_no_pagados' => 0,
                'enm_ingresos' => 0,
            ];
        }
    }

    private function obtenerInformacionPago($pasajero): array
    {
        $defaultInfo = [
            'precio' => 0,
            'cantidad' => 0,
            'descuento' => 0,
            'importe' => 0,
            'moneda' => 'USD',
        ];

        if (!$pasajero->EnmPagado) {
            return $defaultInfo;
        }

        $ventaENM = $pasajero->ventaenm;



        $fechaReserva = $pasajero->tipo == 'ACT' ? $ventaENM->pasajero->actividad->created_at : $ventaENM->pasajero->yate->created_at;

        $conversion = $this->obtenerConversion($ventaENM->venta?->c_moneda, $fechaReserva, $ventaENM->venta->locacion_idLocacion);



        $precio = $ventaENM->precio / $conversion;
        $descuento = $ventaENM->descuento / $conversion;
        $importe = $ventaENM->importe / $conversion;

        return [
            'precio' => $precio,
            'descuento' => $descuento,
            'importe' => $importe,
            'moneda' => 'USD',
        ];
    }

    private function obtenerDatosFotos(): Collection
    {
        try {
            $query = FotoVentaPaquete::query()
                ->whereHas('fotoVenta', function ($q) {
                    $q->whereDate('fecha', '>=', $this->fechaInicio)
                      ->whereDate('fecha', '<=', $this->fechaFin)
                     ->where('status', '>=', 2);
                });

  if (!empty($this->locacionId)) {
                $query->whereHas('fotoVenta', function ($q) {
                    $q->where('locacion_idLocacion', $this->locacionId);
                });
            }




            $fotos = $query->get();

             return $fotos->map(function ($item) {

                $producto=[
                    'id' =>0,
                    'tipo' => '',
                    'nombre' => 'N/A',
                    'paquete' => 'N/A',
                    'proveedor_id' => 0,
                    'proveedor' => 'N/A',
                    'agencia_id' => 0,
                    'agencia' => 'N/A',
                    'locacion_id' => 0,
                    'locacion' => 'N/A',
                ];

                $producto['id'] =$item->tipoPaquete == 'ACT' ? $item->unidad->actividad->idActividad : $item->yate->idYate;
                $producto['tipo']  = $item->tipoPaquete == 'ACT' ? 'Actividad' : 'Yate';
                $producto['nombre'] = $item->tipoPaquete == 'ACT' ? $item->unidad->actividad->nombreActividad : $item->yate->yate->nombreYate;
                $producto['paquete'] = $item->nombrePaquete ?? 'N/A';
                $producto['proveedor_id'] = $item->tipoPaquete == 'ACT' ? ($item->unidad->actividad->actividadorigen->proveedor_idProveedor ?? 0) : ($item->yate->idProveedor ?? 0);
                $producto['proveedor'] = $item->tipoPaquete == 'ACT' ? ($item->unidad->actividad->actividadorigen->proveedor->nombreComercial ?? 'N/A') : ($item->yate->proveedor->nombreComercial ?? 'N/A');
                $producto['agencia_id'] = $item->fotoVenta->cliente_idCliente ?? 0;
                $producto['agencia'] = $item->fotoVenta->cliente->nombreCliente ?? 'N/A';
                $producto['locacion_id'] = $item->fotoVenta->locacion_idLocacion ?? 0;
                $producto['locacion'] = $item->fotoVenta->locacion->nombreLocacion ?? 'N/A';



                return [
                    'producto_id' => strtolower($producto['tipo']) . '_' . $producto['id'],
                    'producto' =>  $producto['paquete'] .' / '. $producto['nombre'],
                    'proveedor_id' => $producto['proveedor_id'] ?? 'N/A',
                    'proveedor' => $producto['proveedor'] ?? 'N/A',
                    'agencia_id' => $producto['agencia_id'] ?? 'N/A',
                    'agencia' => $producto['agencia'] ?? 'N/A',
                    'locacion_id' => $producto['locacion_id'] ?? 'N/A',
                    'locacion' => $producto['locacion'] ?? 'N/A',
                    'tipo' => $producto['tipo'],
                    'horas' => 0,
                    'pax' => 0,
                    'ventaTotal' => 0,
                    'costo' => 0,
                    'comision' => 0,
                    'descuento' => 0,
                    'ventaIngresos' => 0,
                    'enm_pagados' => 0,
                    'enm_no_pagados' => 0,
                    'enm_ingresos' => 0,
                    'fotos_ingresos' =>$item->comision ?? 0,
                ];
            });
        } catch (\Exception $e) {
            Log::error('Error al obtener fotos: ' . $e->getMessage());
            return collect();
        }
    }

private function obtenerDatosServicios(): Collection
    {
        try {
        $collectServicios = collect()
            ->merge($this->obtenerDatosServiciosVentas())
            ->merge($this->obtenerDatosServiciosReserva())
             ->map(function ($item, $servicioId) {
                    return[
                    'producto_id' => $item['producto_id'],
                    'producto' => $item['producto'],

                    'proveedor_id' => 0,
                    'proveedor' => 'N/A',
                    'agencia_id' => $item['agencia_id'],
                    'agencia' => $item['agencia'],
                    'locacion_id' => $item['locacion_id'] ,
                    'locacion' => $item['locacion'],

                    'tipo' => 'Servicio',
                    'pax' => $item['pax'],
                    'ventaTotal' => $item['ventaTotal'],
                    'costo' =>$item['costo'],
                    'comision' => $item['comision'],
                    'descuento' => $item['descuento'],
                    'ventaIngresos' => $item['ventaIngresos'],

                    'enm_pagados' => 0,
                    'enm_no_pagados' => 0,
                    'enm_total' => 0,
                    'enm_tarifa' => 0,
                    'enm_label' => '(0 x 0)',
                    'enm_no_pagados_label' => '(0 x 0)',

                    'fotos_ingresos' => 0,
                    ];
             })->values();

        return $collectServicios;

        } catch (\Exception $e) {
                    Log::error('Error al obtener datos de servicios: ' . $e->getMessage());
                    return collect();
        
     }
}

    private function obtenerDatosServiciosVentas(): Collection
    {
        try {
            $query = VentaServicio::with(['servicio', 'venta'])->whereHas('venta', function ($q) {
                $q->whereDate('fechaVenta', '>=', $this->fechaInicio)
                    ->whereDate('fechaVenta', '<=', $this->fechaFin)
                    ->whereNotIn('status', [0, 1]); // Excluir ventas canceladas o pendientes
            });

            // Filtrar por locación si se especifica
            if (!empty($this->locacionId)) {
                $query->whereHas('venta', function ($q) {
                    $q->where('locacion_idLocacion', $this->locacionId);
                });
            }

          $serviciosVenta = $query->get();

         
           return $serviciosVenta->map(function ($item) {
                $conversion = $this->obtenerConversion($item->venta->c_moneda, $item->fechaVenta, $item->venta->locacion_idLocacion);

                $precio = $item->precio / $conversion;
                $comision = $item->comision / $conversion;
                $descuento = $item->descuento / $conversion;
                $importe = $item->importe / $conversion;

                return [
                    'producto_id' => 'servicio_' . $item->servicio->idServicio,
                    'producto' => $item->servicio->nombreServicio,

                    'proveedor_id' => 0,
                    'proveedor' => 'N/A',
                    'agencia_id' => $item->venta->cliente_idCliente ?? 0,
                    'agencia' => $item->venta->cliente->nombreCliente ?? 'N/A',
                    'locacion_id' => $item->venta->locacion_idLocacion ?? 0,
                    'locacion' => $item->venta->locacion->nombreLocacion ?? 'N/A',

                    'tipo' => 'Servicio',
                    'pax' => $item->cantidad ?? 1,
                    'ventaTotal' => $precio * $item->cantidad,
                    'costo' => 0,
                    'comision' => $comision,
                    'descuento' => $descuento,
                    'ventaIngresos' => $importe,

                    'enm_pagados' => 0,
                    'enm_no_pagados' => 0,
                    'enm_total' => 0,
                    'enm_tarifa' => 0,
                    'enm_label' => '(0 x 0)',
                    'enm_no_pagados_label' => '(0 x 0)',

                    'fotos_ingresos' => 0,
                ];
            });


        } catch (\Exception $e) {
            Log::error('Error al obtener datos de servicios: ' . $e->getMessage());
            return collect();
        }
    }


    private function obtenerDatosServiciosReserva(): Collection
    {
        try {
               // Servicios de ReservaAD
        $queryAD = ReservaAD::with(['servicio', 'reserva'])
                ->whereDate('date_create', '>=', $this->fechaInicio)
                ->whereDate('date_create', '<=', $this->fechaFin)
                ->whereNotIn('status', [0, 1, 6]);
       

        if (!empty($this->locacionId)) {
            $queryAD->whereHas('reserva', function ($q) {
                $q->where('locacion_idLocacion', $this->locacionId);
            });
        }

        $serviciosAD = $queryAD->get();

     

        return $serviciosAD->map(function ($item) {
          
            $conversion = $this->obtenerConversion($item->reserva->c_moneda, $item->date_create, $item->reserva->locacion_idLocacion);

            $total = $item->precio / $conversion;        
            $costo = 0;
            $comision = $item->TotalComision / $conversion;
            $descuento = $item->descuento / $conversion;
            $ventaIngresos = ($item->TotalCredito / $conversion) + ($item->TotalBalance / $conversion);


            return [
                'producto_id' => 'servicio_' . $item->servicio->idServicio,
                'producto' => $item->servicio->nombreServicio,

                'proveedor_id' => 0,
                'proveedor' => 'N/A',
                'agencia_id' => $item->reserva->idCliente ?? 0,
                'agencia' => $item->reserva->nombreCliente ?? 'N/A',
                'locacion_id' => $item->reserva->locacion_idLocacion ?? 0,
                'locacion' => $item->reserva->locacion->nombreLocacion ?? 'N/A',

                'tipo' => 'Servicio',
                'pax' => 1,
                'ventaTotal' => $total,
                'costo' => $costo,
                'comision' => $comision,
                'descuento' => $descuento,
                'ventaIngresos' => $ventaIngresos,

                'enm_pagados' => 0,
                'enm_no_pagados' => 0,
                'enm_total' => 0,
                'enm_tarifa' => 0,
                'enm_label' => '(0 x 0)',
                'enm_no_pagados_label' => '(0 x 0)',
                'fotos_ingresos' => 0,
            ];
        });

      

        } catch (\Exception $e) {
            Log::error('Error al obtener datos de servicios: ' . $e->getMessage());
            return collect();
        }
    }


    private function obtenerDatosTours(): Collection
    {
        try {


            $query = TourVentaPaquete::with(['tourventa', 'venta'])
            ->where('status', '>=',2)
            ->whereHas('venta', function ($q) {
                $q->whereDate('created_at', '>=', $this->fechaInicio)
                    ->whereDate('created_at', '<=', $this->fechaFin)
                    ->where('edo', true); // Excluir ventas canceladas o pendientes
            });

            // Filtrar por locación si se especifica
            if (!empty($this->locacionId)) {
                $query->whereHas('tourventa', function ($q) {
                    $q->where('locacion_idLocacion', $this->locacionId);
                });
            }

            $tours = $query->get();



            return $tours->map(function ($item) {
                $conversion = $this->obtenerConversion($item->tourventa->c_moneda, $item->tourventa->fecha, $item->tourventa->locacion_idLocacion);

                $ventaTotal = $item->importe / $conversion;
                $ventaIngresos = $item->TotalVenta / $conversion;
                $costo = $item->CostoTotal / $conversion;
                $comision = $item->ComisionTotal / $conversion;


                return [
                    'producto_id' => 'tour_' . $item->paquete->tour->idTour,
                    'producto' => $item->paquete->tour->nombreTour,

                    'proveedor_id' => $item->paquete->tour->proveedor->idProveedor ?? 'N/A',
                    'proveedor' => $item->paquete->tour->proveedor->nombreComercial ?? 'N/A',
                    'agencia_id' => $item->tourventa->cliente_idCliente ?? 0,
                    'agencia' => $item->tourventa->cliente->nombreCliente ?? 'N/A',
                    'locacion_id' => $item->tourventa->locacion_idLocacion ?? 'N/A',
                    'locacion' => $item->tourventa->locacion->nombreLocacion ?? 'N/A',
                    'tipo' => 'Tour',
                    'horas' => number_format($item->paquete->tiempo / 60 , 2) ,
                    'pax' => $item->pax ?? 1,
                    'ventaTotal' => $ventaTotal,
                    'costo' => $costo,
                    'comision' => $comision,
                    'descuento' => 0,
                    'ventaIngresos' => $ventaIngresos,
                    'enm_pagados' => 0,
                    'enm_no_pagados' => 0,
                    'enm_total' => 0,
                    'enm_tarifa' => 0,
                    'enm_label' => '(0 x 0)',
                    'enm_no_pagados_label' => '(0 x 0)',
                    'fotos_ingresos' => 0,
                ];
            });
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Error al obtener datos de tours: ' . $e->getMessage());
            return collect();
        }
    }

    private function obtenerConversion($moneda, $created, $locacion)
    {
        $monedaOrigenMX = false;
        if ($moneda == 'MXN'):
            $monedaOrigenMX = true;
            $fecha = Carbon::parse($created);

            $monedasSeleccionadas = $this->filtrarMoneda($this->registrosMonedas(), 'USD', 'MXN', $locacion);
            $obtenerMonedaCambio = $this->getMoneda($monedasSeleccionadas, $fecha);
        endif;
        if ($monedaOrigenMX && $obtenerMonedaCambio != null):
            $conversion = $obtenerMonedaCambio['precio'];
        else:
            $conversion = 1;
        endif;

        return $conversion;
    }

    private function filtrarMoneda($monedas, $monedaOrigen, $monedaBase, $loc)
    {

        $monedaFiltrada = [];
        foreach ($monedas as $moneda):
            if ($moneda['c_moneda'] == $monedaOrigen && $moneda['c_monedaBase'] == $monedaBase && $moneda['locacion_idLocacion'] == $loc):
                $monedaFiltrada[] = $moneda;
            endif;
        endforeach;

        return $monedaFiltrada;
    }

    private function registrosMonedas()
    {
        $registrosMonedas = TipoCambio::get()->toarray();

        $registrosMonedas = array_map(function ($registro) {
            $registro['fechaAlta'] = Carbon::parse($registro['fechaAlta']);
            return $registro;
        }, $registrosMonedas);

        return $registrosMonedas;
    }

    private function getMoneda($fechas, $fechaExterna)
    {
        $moneda = null;
        foreach ($fechas as $index => $registro) {
            $fechaActual = $registro['fechaAlta'];

            // Comprobar el registro anterior (si existe)
            $fechaAnterior = $index > 0 ? $fechas[$index - 1]['fechaAlta'] : null;

            // Comprobar el registro siguiente (si existe)
            $fechaSiguiente = $index < count($fechas) - 1 ? $fechas[$index + 1]['fechaAlta'] : null;

            // Validar si la fecha externa está dentro del rango entre el anterior y siguiente
            $isInRange = true;

            // Comprobamos si la fecha externa está antes de la fecha anterior
            if ($fechaAnterior && $fechaExterna->lessThanOrEqualTo($fechaAnterior)) {
                $isInRange = false; // Si la fecha externa es antes de la anterior, no cumple con el rango
            }

            // Comprobamos si la fecha externa está después de la fecha siguiente
            if ($fechaSiguiente && $fechaExterna->greaterThanOrEqualTo($fechaSiguiente)) {
                $isInRange = false; // Si la fecha externa es después de la siguiente, no cumple con el rango
            }

            // Aquí decidimos qué hacer con el registro basado en la comparación con la fecha externa
            if ($isInRange) {
                // La fecha externa está dentro del rango de este registro
                $moneda = $registro;
                break;
            }
        }

        return $moneda;
    }

    /**
     * Obtener lista de locaciones disponibles
     */
    public function getLocaciones(): Collection
    {
        return Locacion::where('edo', true)->where('isHotel', false)->orderBy('nombreLocacion')->get();
    }
}
