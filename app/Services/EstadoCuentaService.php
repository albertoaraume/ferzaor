<?php

namespace App\Services;

use App\Models\Erp\Cliente;

use App\Models\Erp\ReservaAU;
use App\Models\Erp\ReservaY;
use App\Models\Erp\ReservaAD;

use App\Models\Erp\CFDIComprobante;
use App\Models\ClienteSaldo;

use Illuminate\Support\Collection;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class EstadoCuentaService
{
    private $dateStart;
    private $dateNow;
    /**
     * Obtener estado de cuenta de todos los clientes con saldos pendientes
     */

    public function __construct()
    {
        $this->dateStart = Carbon::parse('2024-01-01')->format('Y-m-d');
        $this->dateNow = Carbon::now()->addDays(1)->format('Y-m-d');
    }

    /**
     * Obtener estado de cuenta rápido desde cache
     */
    public function obtenerEstadoCuentaRapido(array $filtros = []): Collection
    {
        // Intentar obtener desde cache de base de datos primero
        $query = ClienteSaldo::with('cliente')->conSaldo();
        //->actualizado(24); // Datos de máximo 24 horas

        if (!empty($filtros['cliente_id'])) {
            $query->where('cliente_id', $filtros['cliente_id']);
        }

        $resultadosCache = $query->get();

        return $resultadosCache->map(function ($cache) {
            return [
                'cliente' => $cache->cliente,
                'actividades' => [
                    'saldo_usd' => $cache->saldo_actividades_usd,
                    'saldo_mxn' => $cache->saldo_actividades_mxn,
                    'total' => count($cache->detalles['actividades']),
                    'detalles' => $cache->detalles['actividades'] ?? [],
                ],
                'yates' => [
                    'saldo_usd' => $cache->saldo_yates_usd,
                    'saldo_mxn' => $cache->saldo_yates_mxn,
                    'total' => count($cache->detalles['yates']),
                    'detalles' => $cache->detalles['yates'] ?? [],
                ],
                'servicios' => [
                    'saldo_usd' => 0, // Servicios deshabilitados
                    'saldo_mxn' => 0,
                    'total' => 0,
                    'detalles' => [],
                ],
                'facturas' => [
                    'saldo_usd' => $cache->saldo_facturas_usd ?? 0,
                    'saldo_mxn' => $cache->saldo_facturas_mxn ?? 0,
                    'total' => count($cache->detalles['facturas']),
                    'detalles' => $cache->detalles['facturas'] ?? [],
                ],
                'saldo_total_usd' => $cache->saldo_total_usd,
                'saldo_total_mxn' => $cache->saldo_total_mxn,
                'total_servicios' => $cache->total_servicios,
            ];
        });
    }

    /**
     * Actualizar cache de un cliente específico
     */
    public function actualizarClienteCache($clienteId): void
    {
        $cliente = Cliente::find($clienteId);
        if (!$cliente) {
            return;
        }

        $estadoCuenta = $this->calcularEstadoCuentaCliente($cliente);

        ClienteSaldo::updateOrCreate(
            ['cliente_id' => $clienteId],
            [
                'saldo_actividades_usd' => $estadoCuenta['actividades']['saldo_usd'],
                'saldo_actividades_mxn' => $estadoCuenta['actividades']['saldo_mxn'],
                'saldo_yates_usd' => $estadoCuenta['yates']['saldo_usd'],
                'saldo_yates_mxn' => $estadoCuenta['yates']['saldo_mxn'],
                'saldo_servicios_usd' => 0, // Servicios deshabilitados
                'saldo_servicios_mxn' => 0,
                'saldo_facturas_usd' => $estadoCuenta['facturas']['saldo_usd'] ?? 0,
                'saldo_facturas_mxn' => $estadoCuenta['facturas']['saldo_mxn'] ?? 0,
                'saldo_total_usd' => $estadoCuenta['saldo_total_usd'],
                'saldo_total_mxn' => $estadoCuenta['saldo_total_mxn'],
                'total_servicios' => $estadoCuenta['total_servicios'],
                'detalles' => [
                    'actividades' => $estadoCuenta['actividades']['detalles'] ?? [],
                    'yates' => $estadoCuenta['yates']['detalles'] ?? [],
                    'servicios' => [], // Servicios vacíos
                    'facturas' => $estadoCuenta['facturas']['detalles'] ?? [],
                ],
                'actualizado_en' => now(),
            ],
        );
    }

    public function obtenerEstadoCuentaClientes(array $filtros = []): Collection
    {
        $query = Cliente::query()
            ->where('edo', true) // Solo clientes activos
            ->orderBy('nombreComercial');

        // Aplicar filtros
        if (!empty($filtros['cliente_id'])) {
            $query->where('idCliente', $filtros['cliente_id']);
        }

        $clientes = $query->get();

        return $clientes
            ->map(function ($cliente) {
                $estadoCuenta = $this->calcularEstadoCuentaCliente($cliente);
                // Solo incluir clientes con saldos pendientes
                if ($estadoCuenta['saldo_total_usd'] > 0 || $estadoCuenta['saldo_total_mxn'] > 0) {
                    return $estadoCuenta;
                }

                return null;
            })
            ->filter()
            ->values();
    }

    /**
     * Calcular estado de cuenta para un cliente específico
     */
    public function calcularEstadoCuentaCliente(Cliente $cliente): array
    {
        $saldosActividades = $this->calcularSaldosActividades($cliente->idCliente);
        $saldosYates = $this->calcularSaldosYates($cliente->idCliente);
        $facturasPendientes = $this->calcularFacturasPendientes($cliente->idCliente);

        return [
            'cliente' => $cliente,
            'actividades' => $saldosActividades,
            'yates' => $saldosYates,
            'servicios' => ['saldo_usd' => 0, 'saldo_mxn' => 0, 'total' => 0, 'detalles' => []], // Servicios vacíos
            'facturas' => $facturasPendientes,
            'saldo_total_usd' => $saldosActividades['saldo_usd'] + $saldosYates['saldo_usd'] + $facturasPendientes['saldo_usd'],
            'saldo_total_mxn' => $saldosActividades['saldo_mxn'] + $saldosYates['saldo_mxn'] + $facturasPendientes['saldo_mxn'],
            'total_servicios' => $saldosActividades['total'] + $saldosYates['total'] + $facturasPendientes['total'],
        ];
    }

    /**
     * Calcular saldos de actividades para un cliente
     */
    private function calcularSaldosActividades(int $clienteId): array
    {
        try {
            $actividades = ReservaAU::whereBetween('reservas_a_u.start', [$this->dateStart, $this->dateNow])
                ->whereNotIn('status', [0, 1, 3, 6])
                ->where('reservas_a_u.edoFacturado', false)
                ->whereIn('reservas_a_u.reserva_a_idRA', function ($query) use ($clienteId) {
                    return $query
                        ->select('reservas_a.idRA')
                        ->from('reservas_a')
                        ->whereIn('reservas_a.reserva_idReserva', function ($query) use ($clienteId) {
                            return $query->select('reservas.idReserva')->from('reservas')->where('reservas.idCliente', $clienteId);
                        });
                })
                ->get();

            $saldoUsd = 0;
            $saldoMxn = 0;
            $detalles = [];

            $actividades->each(function ($actividad) use (&$detalles, &$saldoUsd, &$saldoMxn) {
                try {
                    $saldo = 0;
                    $pagada = false;
                    $importeTotal = 0;
                    if ($actividad->isCambio) {
                        $saldo = $actividad->original->Saldo;
                        $pagada = $actividad->original->Pagada;
                        $importeTotal = $actividad->original->ImporteTotal;
                    } else {
                        $saldo = $actividad->Saldo;
                        $pagada = $actividad->Pagada;
                        $importeTotal = $actividad->ImporteTotal;
                    }

                    if ($pagada == false && $saldo > 0) {
                        $moneda = $actividad->c_moneda ?? 'USD';

                        if ($moneda == 'USD') {
                            $saldoUsd += $saldo;
                        } else {
                            $saldoMxn += $saldo;
                        }

                        $detalles[] = [
                            'tipo' => 'Actividad',
                            'id' => $actividad->idAU,
                            'descripcion' => $actividad->ActividadDisplay . ' - ' . $actividad->PaqueteDisplay,
                            'folio' => $actividad->FolioDisplay,
                            'fecha' => Carbon::parse($actividad->start)->format('d-m-Y H:i:s'),
                            'total' => $importeTotal,
                            'saldo' => $saldo,
                            'moneda' => $moneda,
                            'pax' => $actividad->PaxDisplay ?? 0,
                            'cupon' => $actividad->CuponDisplay,
                            'cliente' => $actividad->ClienteDisplay,
                            'vendedor' => $actividad->VendedorDisplay,
                            'locacion' => $actividad->LocacionDisplay,
                            'status' => $actividad->Badge,
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Error procesando actividad individual', [
                        'error' => $e->getMessage(),
                    ]);
                }
            });

            return [
                'saldo_usd' => $saldoUsd,
                'saldo_mxn' => $saldoMxn,
                'total' => count($detalles),
                'detalles' => $detalles,
            ];
        } catch (\Exception $e) {
            Log::error('Error calculando saldos de actividades', [
                'cliente_id' => $clienteId,
                'error' => $e->getMessage(),
            ]);

            return [
                'saldo_usd' => 0,
                'saldo_mxn' => 0,
                'total' => 0,
                'detalles' => [],
            ];
        }
    }

    /**
     * Calcular saldos de yates para un cliente
     */
    private function calcularSaldosYates(int $clienteId): array
    {
        try {
            $yates = ReservaY::whereBetween('reservas_y.start', [$this->dateStart, $this->dateNow])
                ->whereNotIn('status', [0, 1, 3, 6])
                ->where('reservas_y.edoFacturado', false)
                ->whereIn('reservas_y.reserva_idReserva', function ($query) use ($clienteId) {
                    return $query->select('reservas.idReserva')->from('reservas')->where('reservas.idCliente', $clienteId);
                })
                ->get();

            $saldoUsd = 0;
            $saldoMxn = 0;
            $detalles = [];

            $yates->each(function ($yate) use (&$detalles, &$saldoUsd, &$saldoMxn) {
                try {
                    $saldo = 0;
                    $pagada = false;
                    $importeTotal = 0;
                 
                    $saldo = $yate->Saldo;
                    $pagada = $yate->Pagada;
                    $importeTotal = $yate->ImporteTotal;
                    

               

                    if ($pagada == false && $saldo > 0) {
                        $moneda = $yate->c_moneda ?? 'USD';

                        if ($moneda == 'USD') {
                            $saldoUsd += $saldo;
                        } else {
                            $saldoMxn += $saldo;
                        }

                        $detalles[] = [
                            'tipo' => 'Yate',
                            'descripcion' => $yate->yate->nombreYate . ' - ' . $yate->PaqueteDisplay,
                            'id' => $yate->idRY,
                            'folio' => $yate->idRY,
                            'fecha' => Carbon::parse($yate->start)->format('d-m-Y H:i:s'),
                            'total' => $importeTotal,
                            'saldo' => $saldo,
                            'moneda' => $moneda,
                            'pax' => $yate->PaxDisplay ?? 0,
                            'cupon' => $yate->CuponDisplay,
                            'cliente' => $yate->ClienteDisplay,
                            'vendedor' => $yate->VendedorDisplay,
                            'locacion' => $yate->LocacionDisplay,
                            'status' => $yate->Badge,
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Error procesando yate individual', [
                        'yate_id' => $yate->id ?? 'unknown',
                        'error' => $e->getMessage(),
                    ]);
                }
            });

            return [
                'saldo_usd' => $saldoUsd,
                'saldo_mxn' => $saldoMxn,
                'total' => count($detalles),
                'detalles' => $detalles,
            ];
        } catch (\Exception $e) {
            Log::error('Error calculando saldos de yates', [
                'cliente_id' => $clienteId,
                'error' => $e->getMessage(),
            ]);

            return [
                'saldo_usd' => 0,
                'saldo_mxn' => 0,
                'total' => 0,
                'detalles' => [],
            ];
        }
    }

    /**
     * Calcular saldos de servicios adicionales para un cliente
     */
    private function calcularSaldosServicios(int $clienteId): array
    {
        try {
            $servicios = ReservaAD::whereBetween('created_at', [$this->dateStart, $this->dateNow])
                ->where('edoFacturado', false)
                ->whereNotIn('status', [0, 1, 6]) // Excluir canceladas y no show
                ->whereIn('reservas_ad.reserva_idReserva', function ($query) use ($clienteId) {
                    return $query->select('reservas.idReserva')->from('reservas')->where('reservas.idCliente', $clienteId)->get();
                })
                ->get();

            $saldoUsd = 0;
            $saldoMxn = 0;
            $detalles = [];

            //  foreach ($servicios as $servicio) {
            $servicios->each(function ($servicio) use (&$detalles, &$saldoUsd, &$saldoMxn) {
                //if ($servicio->Pagada == false && $servicio->reserva->Saldo > 0) {
                if ($servicio->Pagada == false && $servicio->Saldo > 0) {
                    // $saldo = $servicio->isCredito ? $servicio->TotalCredito : $servicio->TotalBalance;
                    $saldo = $servicio->Saldo;
                    if ($saldo > 0) {
                        $moneda = $servicio->c_moneda ?? 'USD';

                        if ($moneda == 'USD') {
                            $saldoUsd += $saldo;
                        } else {
                            $saldoMxn += $saldo;
                        }

                        $detalles[] = [
                            'tipo' => 'Servicio',
                            'descripcion' => $servicio->nombreServicio ?? 'Servicio',
                            'id' => $servicio->idAD,
                            'folio' => $servicio->idAD,
                            'fecha' => $servicio->created_at,
                            'saldo' => $saldo,
                            'moneda' => $moneda,
                            'pax' => 0,
                            'status' => $servicio->Badge ?? '',
                        ];
                    }
                }
            });
            // }

            return [
                'saldo_usd' => $saldoUsd,
                'saldo_mxn' => $saldoMxn,
                'total' => count($detalles),
                'detalles' => $detalles,
            ];
        } catch (\Exception $e) {
            Log::error('Error calculando saldos de servicios', [
                'cliente_id' => $clienteId,
                'error' => $e->getMessage(),
            ]);
        }

        return [];
    }

    /**
     * Calcular facturas pendientes de pago para un cliente
     */
    private function calcularFacturasPendientes(int $clienteId): array
    {
        try {
            $facturas = CFDIComprobante::whereBetween('cfdi_comprobantes.fechaCreacion', [$this->dateStart, $this->dateNow])
                ->whereIn('cfdi_comprobantes.idComprobante', function ($q) use ($clienteId) {
                    return $q
                        ->select('cfdi_receptores.comprobante_idComprobante')
                        ->from('cfdi_receptores')
                        ->whereIn('cfdi_receptores.cliente_rs_idcltRS', function ($q) use ($clienteId) {
                            return $q->select('clientes_razonessociales.idcltRS')->from('clientes_razonessociales')->where('clientes_razonessociales.cliente_idCliente', $clienteId);
                        });
                })
                ->where('tipoComprobante', 'I') // Solo facturas
                ->where('status', 2) // Facturas timbradas pero no pagadas completamente
                ->get();

            $saldoUsd = 0;
            $saldoMxn = 0;
            $detalles = [];

            $facturas->each(function ($factura) use (&$detalles, &$saldoUsd, &$saldoMxn) {
                try {
                    $saldo = $factura->Saldo;
                    if ($saldo > 0) {
                        $moneda = $factura->moneda ?? 'USD';
                        if ($moneda == 'USD') {
                            $saldoUsd += $saldo;
                        } else {
                            $saldoMxn += $saldo;
                        }
                        $detalles[] = [
                            'tipo' => 'Factura',
                            'descripcion' => $factura->receptor->rfc . ' - ' . $factura->receptor->nombre ?? 'Factura',
                            'id' => $factura->idComprobante,
                            'folio' => $factura->FolioDisplay,
                            'fecha' => $factura->fechaCreacion,
                            'total' => $factura->Total ?? 0,
                            'abono' => $factura->totalPagos ?? 0,
                            'saldo' => $saldo,
                            'moneda' => $moneda,
                            'locacion' => $factura->locacion->nombreLocacion ?? 'N/A',
                            'status' => $factura->Badge,
                        ];
                    }
                } catch (\Exception $e) {
                    Log::warning('Error procesando factura individual', [
                        'factura_id' => $factura->id ?? 'unknown',
                        'error' => $e->getMessage(),
                    ]);
                }
            });

            return [
                'saldo_usd' => $saldoUsd,
                'saldo_mxn' => $saldoMxn,
                'total' => count($detalles),
                'detalles' => $detalles,
            ];
        } catch (\Exception $e) {
            Log::error('Error calculando facturas pendientes', [
                'cliente_id' => $clienteId,
                'error' => $e->getMessage(),
            ]);

            return [
                'saldo_usd' => 0,
                'saldo_mxn' => 0,
                'total' => 0,
                'detalles' => [],
            ];
        }
    }

    /**
     * Exportar estado de cuenta a Excel/CSV
     */
    public function exportarEstadoCuenta(array $filtros = []): Collection
    {
        $estadoCuentas = $this->obtenerEstadoCuentaClientes($filtros);

        $exportData = collect();

        foreach ($estadoCuentas as $estadoCuenta) {
            $cliente = $estadoCuenta['cliente'];

            // Agregar todas las líneas de detalle
            $tiposServicios = ['actividades', 'yates', 'facturas']; // Quitar servicios

            foreach ($tiposServicios as $tipo) {
                foreach ($estadoCuenta[$tipo]['detalles'] as $detalle) {
                    $exportData->push([
                        'cliente' => $cliente->nombreComercial,
                        'empresa' => $cliente->empresa->nombreComercial ?? '',
                        'tipo_servicio' => $detalle['tipo'],
                        'descripcion' => $detalle['descripcion'],
                        'folio' => $detalle['folio'],
                        'fecha' => $detalle['fecha'],
                        'saldo' => $detalle['saldo'],
                        'moneda' => $detalle['moneda'],
                        'pax' => $detalle['pax'],
                    ]);
                }
            }
        }

        return $exportData;
    }

    /**
     * Exportar estado de cuenta a CSV
     */ public function obtenerFiltrosDisponibles(): array
    {
        return [
            'clientes' => Cliente::where('edo', true)->pluck('nombreComercial', 'idCliente')->toArray(),
        ];
    }
}
