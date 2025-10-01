<?php

namespace App\Services\Reportes\Ventas;

use App\Models\Erp\ReservaP;
use App\Models\Erp\ReservaAU;
use App\Models\Erp\ReservaY;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use App\Models\Erp\Muelle;
use App\Models\Erp\Actividad;
use App\Models\Erp\Yate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Str;


class RptEnmsService
{
    public function obtenerReservas(array $filtros = []): Collection
    {
        $reservasAgrupadas = $this->obtenerReservasAgrupadasConDetalle($filtros);

        return $reservasAgrupadas->groupBy('tipo')->map(function ($reservasPorTipo, $tipo) {
            $totalGrupos = $reservasPorTipo->count();
            $totalPasajeros = $reservasPorTipo->sum('total_pasajeros');
            $gruposConPagoENM = $reservasPorTipo
                ->filter(function ($grupo) {
                    return $grupo['tiene_pago_enm'];
                })
                ->count();
            $gruposSinPagoENM = $totalGrupos - $gruposConPagoENM;
            $pasajerosPagaronENM = $reservasPorTipo->sum('pagaron_enm');
            $pasajerosNoPagaronENM = $reservasPorTipo->sum('no_pagaron_enm');
            $pasajerosNoAplicaENM = $reservasPorTipo->sum('no_aplica_enm');
            $porcentajePagoGrupos = $totalGrupos > 0 ? round(($gruposConPagoENM / $totalGrupos) * 100, 2) : 0;
            $porcentajePagoPasajeros = $totalPasajeros > 0 ? round(($pasajerosPagaronENM / $totalPasajeros) * 100, 2) : 0;

            // Calcular importe total sumando los importes individuales de cada pasajero
            $importeTotal = $reservasPorTipo->sum(function ($grupo) {
                return collect($grupo['pasajeros'])->sum('importe');
            });

            // Calcular total de ingresos ENM por tipo
            $totalIngresosENMPorTipo = $reservasPorTipo->sum('total_ingresos_enm');

            return [
                'tipo' => $tipo,
                'estadisticas_grupos' => [
                    'total_grupos' => $totalGrupos,
                    'grupos_con_pago_enm' => $gruposConPagoENM,
                    'grupos_sin_pago_enm' => $gruposSinPagoENM,
                    'porcentaje_pago_grupos' => $porcentajePagoGrupos,
                ],
                'pasajeros' => [
                    'total' => $totalPasajeros,
                    'pagaron_enm' => $pasajerosPagaronENM,
                    'no_pagaron_enm' => $pasajerosNoPagaronENM,
                    'no_aplica_enm' => $pasajerosNoAplicaENM,
                    'porcentaje_pago' => $porcentajePagoPasajeros,
                ],
                'financiero' => [
                    'importe_total' => $importeTotal,
                    'total_ingresos_enm' => $totalIngresosENMPorTipo,
                    'total_ingresos_enm_mxn' => $reservasPorTipo->sum('total_ingresos_enm_mxn'),
                    'total_ingresos_enm_usd' => $reservasPorTipo->sum('total_ingresos_enm_usd'),
                    'importe_promedio_por_grupo' => $totalGrupos > 0 ? round($importeTotal / $totalGrupos, 2) : 0,
                    'importe_promedio_por_pasajero' => $totalPasajeros > 0 ? round($importeTotal / $totalPasajeros, 2) : 0,
                    'importe_promedio_enm_por_pasajero' => $pasajerosPagaronENM > 0 ? round($totalIngresosENMPorTipo / $pasajerosPagaronENM, 2) : 0,
                    'importe_promedio_enm_mxn' => $pasajerosPagaronENM > 0 ? round($reservasPorTipo->sum('total_ingresos_enm_mxn') / $pasajerosPagaronENM, 2) : 0,
                    'importe_promedio_enm_usd' => $pasajerosPagaronENM > 0 ? round($reservasPorTipo->sum('total_ingresos_enm_usd') / $pasajerosPagaronENM, 2) : 0,
                ],
                'grupos' => $reservasPorTipo->map(function ($grupo) {
                    return [
                        'clave_grupo' => $grupo['clave_grupo'],
                        'badge' => $grupo['badge'],
                        'nombre_servicio' => $grupo['nombre_servicio'],
                        'nombre_paquete' => $grupo['nombre_paquete'],
                        'fecha_servicio' => $grupo['fecha_servicio'],
                        'cliente_nombre' => $grupo['cliente_nombre'],
                        'agencia_nombre' => $grupo['agencia_nombre'],
                        'folio_reserva' => $grupo['folio_reserva'],
                        'muelle_nombre' => $grupo['muelle_nombre'],
                        'total_pasajeros' => $grupo['total_pasajeros'],
                        'pagaron_enm' => $grupo['pagaron_enm'],
                        'no_pagaron_enm' => $grupo['no_pagaron_enm'],
                        'no_aplica_enm' => $grupo['no_aplica_enm'],
                        'porcentaje_pago' => $grupo['porcentaje_pago'],
                        'importe_mxn' => $grupo['importe_mxn'] ?? 0,
                        'importe_usd' => $grupo['importe_usd'] ?? 0,
                        'total_ingresos_enm' => $grupo['total_ingresos_enm'] ?? ($grupo['total_ingresos_enm_mxn'] ?? 0) + ($grupo['total_ingresos_enm_usd'] ?? 0),
                        'total_ingresos_enm_mxn' => $grupo['total_ingresos_enm_mxn'] ?? 0,
                        'total_ingresos_enm_usd' => $grupo['total_ingresos_enm_usd'] ?? 0,
                        'importe_promedio_enm' => $grupo['importe_promedio_enm'] ?? 0,
                        'importe_promedio_enm_mxn' => $grupo['importe_promedio_enm_mxn'] ?? 0,
                        'importe_promedio_enm_usd' => $grupo['importe_promedio_enm_usd'] ?? 0,
                        'tiene_pago_enm' => $grupo['tiene_pago_enm'],
                        'motivos_no_pago' => $grupo['motivos_no_pago'],
                        'pasajeros' => $grupo['pasajeros'],
                    ];
                }),
            ];
        });
    }

    private function obtenerReservasAgrupadasConDetalle(array $filtros = []): Collection
    {
        $grupos = collect();

        if (!empty($filtros['tipo'])) {
            if ($filtros['tipo'] === 'ACT') {
                $actividades = $this->obtenerActividadesFiltradas($filtros);
                foreach ($actividades as $actividad) {
                    $grupos->push($this->procesarPasajeros($actividad, $actividad->pasajeros, 'ACT', 'ACT_' . $actividad->idAU));
                }
            }

            if ($filtros['tipo'] === 'YAT') {
                $yates = $this->obtenerYatesFiltrados($filtros);
                foreach ($yates as $yate) {
                    $grupos->push($this->procesarPasajeros($yate, $yate->pasajeros, 'YAT', 'YAT_' . $yate->idRY));
                }
            }
        }else{

            $actividades = $this->obtenerActividadesFiltradas($filtros);
                foreach ($actividades as $actividad) {
                    $grupos->push($this->procesarPasajeros($actividad, $actividad->pasajeros, 'ACT', 'ACT_' . $actividad->idAU));
                }

                  $yates = $this->obtenerYatesFiltrados($filtros);
                foreach ($yates as $yate) {
                    $grupos->push($this->procesarPasajeros($yate, $yate->pasajeros, 'YAT', 'YAT_' . $yate->idRY));
                }

        }

      

        return $grupos;
    }

  private function procesarPasajeros($item, $pasajeros, $tipo, $clave)
{
    // Filtrar pasajeros que aplican ENM
    $pasajerosAplicaENM = $pasajeros->filter(fn($r) => $r->EnmAplica);
    $pasajerosNoAplicaENM = $pasajeros->filter(fn($r) => !$r->EnmAplica);


    $totalPasajeros = $pasajerosAplicaENM->count() + $pasajerosNoAplicaENM->count();
    $pagaronENM = $pasajerosAplicaENM->filter(fn($r) => $this->verificarPagoENM($r))->count();
    $noPagaronENM = $pasajerosAplicaENM->filter(fn($r) => !$this->verificarPagoENM($r))->count();
    $noAplicaENM = $pasajerosNoAplicaENM->count();

    $motivosNoPago = $this->obtenerMotivosNoPago($pasajeros->filter(fn($r) => !$this->verificarPagoENM($r)));

    // Clasificar importes por moneda solo para los que aplican ENM
    $importeGrupoMXN = $pasajerosAplicaENM->filter(fn($p) => $this->obtenerInformacionPago($p)['moneda'] === 'MXN')->sum(fn($p) => $this->obtenerInformacionPago($p)['importe']);
    $importeGrupoUSD = $pasajerosAplicaENM->filter(fn($p) => $this->obtenerInformacionPago($p)['moneda'] === 'USD')->sum(fn($p) => $this->obtenerInformacionPago($p)['importe']);

    $totalIngresosENM_MXN = $pasajerosAplicaENM->filter(fn($p) => $this->verificarPagoENM($p) && $this->obtenerInformacionPago($p)['moneda'] === 'MXN')->sum(fn($p) => $this->obtenerInformacionPago($p)['importe']);
    $totalIngresosENM_USD = $pasajerosAplicaENM->filter(fn($p) => $this->verificarPagoENM($p) && $this->obtenerInformacionPago($p)['moneda'] === 'USD')->sum(fn($p) => $this->obtenerInformacionPago($p)['importe']);

    $pasajerosDetallados = $pasajeros->map(function ($pasajero) {
        $infoPago = $this->obtenerInformacionPago($pasajero);
        return [
            'idRP' => $pasajero->idRP,
            'nombre' => $pasajero->nombre,
            'precio' => $infoPago['precio'],
            'cantidad' => $infoPago['cantidad'] ?? 1,
            'descuento' => $infoPago['descuento'],
            'importe' => $infoPago['importe'],
            'moneda' => $infoPago['moneda'],
            'pago_enm' => $this->verificarPagoENM($pasajero),
            'aplica_enm' => $pasajero->EnmAplica,
            'fecha_registro' => $infoPago['fecha_registro'] ?? 'N/A',
            'motivo' => $pasajero->motivo ?? 'N/A',
            'status' => $pasajero->ENMBadge
        ];
    });

    return [
        'clave_grupo' => $clave,
        'tipo' => $tipo,
        'badge' => $item->Badge,
        'nombre_servicio' => $this->getNombre($item, $tipo),
        'nombre_paquete' => $this->getNombrePaquete($item, $tipo),
        'fecha_servicio' => $this->getFechaServicio($item, $tipo),
        'cliente_nombre' => $this->getClienteNombre($item, $tipo),
        'agencia_nombre' => $this->getAgenciaNombre($item, $tipo),
        'folio_reserva' => Str::upper($this->getFolioReserva($item, $tipo)),
        'muelle_nombre' => $this->getMuelleNombre($item, $tipo),
        'total_pasajeros' => $totalPasajeros,
        'pagaron_enm' => $pagaronENM,
        'no_pagaron_enm' => $noPagaronENM,
        'no_aplica_enm' => $noAplicaENM,
        'porcentaje_pago' => ($totalPasajeros - $noAplicaENM) > 0 ? round(($pagaronENM / ($totalPasajeros - $noAplicaENM)) * 100, 2) : 0,
        'importe_mxn' => $importeGrupoMXN,
        'importe_usd' => $importeGrupoUSD,
        'total_ingresos_enm_mxn' => $totalIngresosENM_MXN,
        'total_ingresos_enm_usd' => $totalIngresosENM_USD,
        'importe_promedio_enm_mxn' => $pagaronENM > 0 ? round($totalIngresosENM_MXN / $pagaronENM, 2) : 0,
        'importe_promedio_enm_usd' => $pagaronENM > 0 ? round($totalIngresosENM_USD / $pagaronENM, 2) : 0,
        'tiene_pago_enm' => $pagaronENM > 0,
        'motivos_no_pago' => $motivosNoPago,
        'pasajeros' => $pasajerosDetallados->toArray(),
    ];
}

    // Nueva función para obtener actividades filtradas
    private function obtenerActividadesFiltradas(array $filtros)
    {
        $query = ReservaAU::query()->with(['actividad.reserva', 'actividad.actividadorigen.clasificacion', 'pasajeros.ventaenm.venta']);
       //$query->whereIn('idAu', [155806]);
        $query->whereNotIn('status', [0, 1, 6]);
        if (!empty($filtros['fecha_inicio']) && !empty($filtros['fecha_fin'])) {
             $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();
              $fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();

            $query->whereBetween('start', [$fechaInicio, $fechaFin]);
        }

         if (!empty($filtros['actividad_id'])) {
            $query->whereHas('actividad', function ($q) use ($filtros) {
                $q->where('idActividad', $filtros['actividad_id']);
            });
        }

        if (!empty($filtros['cliente_id'])) {
            $query->whereHas('actividad.reserva', function ($q) use ($filtros) {
                $q->where('idCliente', $filtros['cliente_id']);
            });
        }
        if (!empty($filtros['locacion_id'])) {
            $query->whereHas('actividad.reserva', function ($q) use ($filtros) {
                $q->where('locacion_idLocacion', $filtros['locacion_id']);
            });
        }
        return $query->get();
    }

    // Nueva función para obtener yates filtrados
    private function obtenerYatesFiltrados(array $filtros)
    {
        $query = ReservaY::query()->with(['reserva', 'paquete', 'muelle', 'yate', 'pasajeros.ventaenm.venta']);
       //$query->whereIn('idRY', [27635,27637]);
        $query->whereNotIn('status', [0, 1, 6]);
        if (!empty($filtros['fecha_inicio']) && !empty($filtros['fecha_fin'])) {
             $fechaInicio = Carbon::parse($filtros['fecha_inicio'])->startOfDay();
    $fechaFin = Carbon::parse($filtros['fecha_fin'])->endOfDay();

            $query->whereBetween('start', [$fechaInicio, $fechaFin]);
        }

         if (!empty($filtros['yate_id'])) {
            $query->whereHas('yate', function ($q) use ($filtros) {
                $q->where('idYate', $filtros['yate_id']);
            });
        }

        if (!empty($filtros['cliente_id'])) {
            $query->whereHas('reserva', function ($q) use ($filtros) {
                $q->where('idCliente', $filtros['cliente_id']);
            });
        }
        if (!empty($filtros['locacion_id'])) {
            $query->whereHas('reserva', function ($q) use ($filtros) {
                $q->where('locacion_idLocacion', $filtros['locacion_id']);
            });
        }
        if (!empty($filtros['muelle_id'])) {
            $query->where('idMuelle', $filtros['muelle_id']);
        }
        return $query->get();
    }

    private function verificarPagoENM($pasajero): bool
    {
        if (isset($pasajero->ventaenm) && $pasajero->ventaenm !== null) {
            return true;
        }

        return false;
    }

    private function getNombre($item, $tipo): string
    {
        if ($tipo === 'ACT') {
            return optional($item->actividad)->nombreActividad ?? 'N/A';
        }
        if ($tipo === 'YAT') {
            return optional($item->yate)->nombreYate ?? 'N/A';
        }
        return 'N/A';
    }

    private function getNombrePaquete($item, $tipo): string
    {
        if ($tipo === 'YAT') {
            return optional($item->paquete)->nombrePaquete ?? 'N/A';
        } elseif ($tipo === 'ACT') {
            return optional($item->actividad?->actividadorigen?->clasificacion)->descripcion ?? 'N/A';
        }
        return 'N/A';
    }

    private function getFechaServicio($item, $tipo): string
    {
        return $item->start ?? 'N/A';
    }

    private function getClienteNombre($item, $tipo): string
    {
        if ($tipo === 'ACT') {
            return optional($item->actividad?->reserva)->nombre ?? 'N/A';
        } elseif ($tipo === 'YAT') {
            return optional($item->reserva)->nombre ?? 'N/A';
        }
        return 'N/A';
    }

    private function getFolioReserva($item, $tipo): string
    {
        if ($tipo === 'ACT') {
            return optional($item->actividad?->reserva)->folio ?? 'N/A';
        } elseif ($tipo === 'YAT') {
            return optional($item->reserva)->folio ?? 'N/A';
        }
        return 'N/A';
    }

    private function getMuelleNombre($item, $tipo): string
    {
        if ($tipo === 'YAT') {
            return optional($item->muelle)->nombreMuelle ?? 'N/A';
        }
        return 'N/A';
    }

    private function getAgenciaNombre($item, $tipo): string
    {
        if ($tipo === 'ACT') {
            return optional($item->actividad?->reserva)->nombreCliente ?? 'N/A';
        } elseif ($tipo === 'YAT') {
            return optional($item->reserva)->nombreCliente ?? 'N/A';
        }
        return 'N/A';
    }

    private function obtenerInformacionPago($pasajero): array
    {
        $defaultInfo = [
            'precio' => 0,
            'cantidad' => 0,
            'descuento' => 0,
            'importe' => 0,
            'moneda' => 'N/A',
        ];

        if (!$this->verificarPagoENM($pasajero)) {
            return $defaultInfo;
        }

        $ventaENM = $pasajero->ventaenm;
        $precio = $ventaENM->precio ?? 0;
        $descuento = $ventaENM->descuento ?? 0;
        $importe = $ventaENM->importe ?? 0;
        $fecha = $ventaENM->venta?->fechaVenta ?? null;
        // Determinar moneda
        $moneda = $ventaENM->venta?->c_moneda ?? 'N/A';

        return [
            'precio' => $precio,
            'descuento' => $descuento,
            'importe' => $importe,
            'moneda' => $moneda,
            'fecha_registro' => $fecha,
        ];
    }

    private function obtenerMotivosNoPago($pasajeroSinPago): array
    {
        return $pasajeroSinPago
            ->map(function ($pasajero) {
                return [
                    'idRP' => $pasajero->idRP,
                    'nombre' => $pasajero->nombre,
                    'motivo' => $pasajero->motivo ?? 'No especificado',
                    'status' => $pasajero->ENMBadge ?? 'No especificado',
                ];
            })
            ->toArray();
    }

    public function obtenerFiltrosDisponibles(): array
    {
        return [
            'tipos' => [
                'ACT' => 'Actividades',
                'YAT' => 'Yates',
            ],

            'locaciones' => Locacion::where('edo', true)->where('isHotel', false)->pluck('nombreLocacion', 'idLocacion')->toArray(),
            'clientes' => Cliente::where('edo', true)->orderBy('nombreComercial')->pluck('nombreComercial', 'idCliente')->toArray(),
            'actividades' => Actividad::where('edo', true)->orderBy('nombreActividad')->pluck('nombreActividad', 'idActividad')->toArray(),
            'yates' => Yate::where('edo', true)->orderBy('nombreYate')->pluck('nombreYate', 'idYate')->toArray(),
            'muelles' => Muelle::where('edo', true)->orderBy('nombreMuelle')->pluck('nombreMuelle', 'idMuelle')->toArray(),
        ];
    }
}
