<?php

namespace App\Jobs;

use App\Services\EstadoCuentaService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\ClienteSaldo;
use App\Models\Erp\Cliente;

class ProcesarClienteSaldoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300; // 5 minutos máximo
    public $tries = 2; // Solo 2 intentos
    public $maxExceptions = 1;
    private $clienteId;

    private $user_id;

    private $index;



    public function __construct($user_id, $index, $clienteId)
    {
        // Solo guardar el ID, no el objeto completo para evitar problemas de serialización
        $this->user_id = $user_id;
        $this->index = $index;
        $this->clienteId = is_object($clienteId) ? $clienteId->idCliente : $clienteId;
    }

    public function handle(EstadoCuentaService $estadoCuentaService)
    {
        // Establecer límite de memoria
        ini_set('memory_limit', '1024M');
        set_time_limit(300); // 5 minutos máximo

        try {
            //Log::info('Iniciando procesamiento de estado de cuenta', ['cliente_id' => $this->clienteId]);

            // Obtener el cliente fresh desde la DB
            $cliente = Cliente::find($this->clienteId);
            if (!$cliente) {
                Log::warning('Cliente no encontrado', ['cliente_id' => $this->clienteId]);
                return;
            }

           // Log::info('Calculando estado de cuenta para cliente', ['cliente' => $cliente->nombreComercial]);

            // Calcular estado de cuenta con timeout
            $estadoCuenta = $estadoCuentaService->calcularEstadoCuentaCliente($cliente);

            if (!$estadoCuenta) {
                Log::warning('No se pudo calcular estado de cuenta', ['cliente_id' => $this->clienteId]);
                return;
            }

           // Log::info('Guardando en cache de base de datos');

            // Guardar en cache de base de datos
            ClienteSaldo::updateOrCreate(
                ['cliente_id' => $this->clienteId],
                [
                    'saldo_actividades_usd' => $estadoCuenta['actividades']['saldo_usd'] ?? 0,
                    'saldo_actividades_mxn' => $estadoCuenta['actividades']['saldo_mxn'] ?? 0,
                    'saldo_yates_usd' => $estadoCuenta['yates']['saldo_usd'] ?? 0,
                    'saldo_yates_mxn' => $estadoCuenta['yates']['saldo_mxn'] ?? 0,
                    'saldo_servicios_usd' => 0, // Servicios deshabilitados
                    'saldo_servicios_mxn' => 0,
                    'saldo_facturas_usd' => $estadoCuenta['facturas']['saldo_usd'] ?? 0,
                    'saldo_facturas_mxn' => $estadoCuenta['facturas']['saldo_mxn'] ?? 0,
                    'saldo_total_usd' => $estadoCuenta['saldo_total_usd'] ?? 0,
                    'saldo_total_mxn' => $estadoCuenta['saldo_total_mxn'] ?? 0,
                    'total_servicios' => $estadoCuenta['total_servicios'] ?? 0,
                    'detalles' => $this->prepararDetalles($estadoCuenta),
                    'actualizado_en' => now(),
                ]
            );



          Cache::put('progreso_actualizacion_' . $this->user_id, $this->index + 1);

                     

            // Liberar memoria
            unset($estadoCuenta, $cliente);

        } catch (\Exception $e) {
            Log::error('Error procesando estado de cuenta', [
                'cliente_id' => $this->clienteId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // No re-lanzar la excepción para evitar que se reintente infinitamente
            $this->fail($e);
        }
    }

    private function prepararDetalles($estadoCuenta): array
    {
        try {
            return [
                'actividades' => $this->limitarDetalles($estadoCuenta['actividades']['detalles'] ?? []),
                'yates' => $this->limitarDetalles($estadoCuenta['yates']['detalles'] ?? []),
                'servicios' => [], // Servicios vacíos
                'facturas' => $this->limitarDetalles($estadoCuenta['facturas']['detalles'] ?? []),
            ];
        } catch (\Exception $e) {
            Log::warning('Error preparando detalles', ['error' => $e->getMessage()]);
            return [
                'actividades' => [],
                'yates' => [],
                'servicios' => [],
                'facturas' => [],
            ];
        }
    }

    private function limitarDetalles($detalles): array
    {
        // Limitar a 200 elementos máximo para evitar problemas de memoria
       // if (is_array($detalles) && count($detalles) > 200) {
          //  return array_slice($detalles, 0, 200);
        //}
        return $detalles ?? [];
    }

    public function failed(\Throwable $exception)
    {
        Log::error('Job de estado de cuenta falló definitivamente', [
            'cliente_id' => $this->clienteId,
            'error' => $exception->getMessage()
        ]);
    }
}
