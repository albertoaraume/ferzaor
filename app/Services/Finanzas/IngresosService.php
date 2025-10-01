<?php

namespace App\Services\Finanzas;

use App\Models\Erp\Ingreso;
use App\Models\Erp\Cliente;
use App\Models\Erp\Locacion;
use App\Models\Erp\CFDIComprobante;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class IngresosService
{
    /**
     * Obtener ingresos filtrados por rango de fechas y otros criterios
     */
    public function obtenerIngresosFiltrados(array $filtros = []): Collection
        {
        try {


            $query = Ingreso::with([
                'conceptos',
                'facturas',
                'membresias',
                'polizas',
                'tours',
                'ventas',
                'cliente',
                'cajero',
                'locacion',
                'sucursal'
            ]);

            // Aplicar filtros
            $this->aplicarFiltros($query, $filtros);

            $ingresos = $query->orderBy('fechaRegistro', 'desc')->get();

            return $ingresos;

        } catch (\Exception $e) {
            Log::error('Error al obtener ingresos filtrados: ' . $e->getMessage());
            throw $e;
        }
    }




    /**
     * Aplicar filtros al query
     */
    private function aplicarFiltros($query, array $filtros)
    {

        // Filtrar por fecha de inicio
        if (!empty($filtros['fecha_inicio'])) {
            $query->where('fechaRegistro', '>=', $filtros['fecha_inicio']);
        }

        // Filtrar por fecha fin
        if (!empty($filtros['fecha_fin'])) {
            $query->where('fechaRegistro', '<=', $filtros['fecha_fin'] . ' 23:59:59');
        }


      // Filtro por estado
        if (!empty($filtros['estado'])) {
            $query
                ->when($filtros['estado'] == 'cancelado', function ($q) use ($filtros) {
                    $q->where('ingresos.status', 0);
                })
                ->when($filtros['estado'] == 'activos', function ($q) use ($filtros) {
                    $q->whereNotIn('ingresos.status', [0,1]);
                })
                ->when($filtros['estado'] == 'sinconfirmacion', function ($q) use ($filtros) {
                    $q->where('ingresos.status', 3);
                })
                ->when($filtros['estado'] == 'confirmados', function ($q) {
                    $q->where('ingresos.status', 4); // Excluir cancelados y no show
                });
        }

        // Filtrar por cliente
        if (!empty($filtros['cliente_id'])) {
            $query->where('cliente_idCliente', $filtros['cliente_id']);
        }

        // Filtrar por locación
        if (!empty($filtros['locacion_id'])) {
            $query->where('locacion_idLocacion', $filtros['locacion_id']);
        }


    }

       public function obtenerIngresoDetalle(int $ingresoId): ?Ingreso
    {
        return Ingreso::with([
            'conceptos',
            'facturas',
            'membresias',
            'polizas',
            'tours',
            'ventas',
            'cliente',
            'cajero',
            'locacion',
            'sucursal'
        ])->find($ingresoId);
    }

    /**
     * Obtener estadísticas de los ingresos
     */
    public function obtenerEstadisticas($resultados): array
    {
        try {


            $estadisticas = [
                'total_registros' => $resultados->count(),
                'suma_total' => $resultados->sum('total'),
                'suma_importe' => $resultados->sum('importe'),
                'suma_comisiones' => $resultados->sum('comision'),
                'promedio' => $resultados->avg('total'),
            ];





            return $estadisticas;
        } catch (\Exception $e) {
            Log::error('Error al obtener estadísticas de ingresos: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Cambiar status de un ingreso
     */
    public function cambiarStatus(int $ingresoId, string $nuevoStatus): array
    {
        try {
            DB::beginTransaction();

            $ingreso = Ingreso::findOrFail($ingresoId);

            // Dependiendo del status, agregar información adicional
           if ($nuevoStatus === 'cancelado') {
                $ingreso->status = 0; // Cancelado
                $ingreso->id_cancela = auth()->user()->id;
                $ingreso->date_cancela = Carbon::now();
                $ingreso->motivo_cancela = '';
            }

            $ingreso->save();


            DB::commit();

            return [
                'success' => true,
                'message' => "Status cambiado exitosamente de a {$nuevoStatus}",
                'ingreso' => $ingreso
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cambiar status de ingreso: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Error al cambiar el status del ingreso: ' . $e->getMessage()
            ];
        }
    }





        public function obtenerFiltrosDisponibles(): array
    {
        return [
            'estados' => [
                'activos' => 'Activos',
                'sinconfirmacion' => 'Pendientes de confirmación',
                'confirmados' => 'Confirmados',
                'cancelado' => 'Cancelados',
            ],
            'locaciones' => Locacion::where('edo', true)->where('isHotel', false)->pluck('nombreLocacion', 'idLocacion')->toArray(),
            'clientes' => Cliente::where('edo', true)->orderBy('nombreComercial')->pluck('nombreComercial', 'idCliente')->toArray(),
        ];
    }

    /**
     * Confirmar múltiples ingresos de forma masiva
     */
    public function confirmarIngresosMasivo(array $ingresosIds): array
    {
        try {
            DB::beginTransaction();

            $confirmados = 0;
            $errores = [];

            foreach ($ingresosIds as $ingresoId) {
                try {
                    // Verificar que el ingreso existe y no está ya confirmado
                    $ingreso = Ingreso::find($ingresoId);

                    if (!$ingreso) {
                        $errores[] = "Ingreso ID {$ingresoId} no encontrado";
                        continue;
                    }

                    if ($ingreso->estado === 'confirmado') {
                        $errores[] = "Ingreso ID {$ingresoId} ya está confirmado";
                        continue;
                    }

                    // Confirmar el ingreso
                    $ingreso->update([
                        'status' => 4,
                        'fechaAplica' => Carbon::now(),
                        'date_valida' => Carbon::now(),
                        'id_valida' => auth()->user()->id
                    ]);

                     $ingreso->facturas()->where('status', 3)->update(['status' => 4]);
                     $ingreso->conceptos()->where('status', 3)->update(['status' => 4]);
                     $ingreso->venta()->where('status', 3)->update(['status' => 4]);

                foreach ($ingreso->facturas as $cfdi) {
                    $cfdiUpdate = CFDIComprobante::find($cfdi->comprobante_idComprobante);
                    if ($cfdiUpdate->totalPendiente == 0) {
                        $cfdiUpdate->status = 3;
                        $cfdiUpdate->save();
                    }

                    //Generar proceso para la validacion de l status de los conceptos
                }

                    $confirmados++;

                } catch (\Exception $e) {
                    $errores[] = "Error en ingreso ID {$ingresoId}: " . $e->getMessage();
                }
            }

            DB::commit();

            return [
                'success' => $confirmados > 0,
                'confirmados' => $confirmados,
                'errores' => $errores,
                'message' => $confirmados > 0
                    ? "Se confirmaron {$confirmados} ingresos"
                    : "No se pudo confirmar ningún ingreso"
            ];

        } catch (\Exception $e) {
            DB::rollback();

            return [
                'success' => false,
                'confirmados' => 0,
                'errores' => [$e->getMessage()],
                'message' => 'Error al procesar la confirmación masiva'
            ];
        }
    }
}
