<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Erp\Cliente;




use App\Services\EstadoCuentaService;
use Illuminate\Support\Facades\Log;
use App\Models\ClienteSaldo;





class ProcesarClienteSaldoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
  protected $signature = 'ferzaor:cliente-saldo {--cliente= : ID del cliente específico}';
    protected $description = 'Actualizar saldos de clientes individuales o todos los clientes activos';



    public function handle(EstadoCuentaService $estadoCuentaService)
    {
        $clienteId = $this->option('cliente');
        $cliente = Cliente::where('idCliente', $clienteId)->first();

            // Calcular estado de cuenta con timeout
        $estadoCuenta = $estadoCuentaService->calcularEstadoCuentaCliente($cliente);



    }
}
