<?php

namespace App\Console\Commands;

use App\Jobs\ProcesarClienteSaldoJob;
use Illuminate\Console\Command;
use App\Models\Erp\Cliente;
use Illuminate\Support\Facades\Cache;

class ProcesarClientesSaldosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
  protected $signature = 'ferzaor:clientes-saldos {--user= : ID del usuario que inicia el proceso} {--cliente= : ID del cliente específico}';
    protected $description = 'Actualizar saldos de clientes individuales o todos los clientes activos';



    public function handle()
    {
        $clienteId = $this->option('cliente');
        if ($clienteId) {
            $clientes = Cliente::where('idCliente', $clienteId)->get();
        } else {
            $clientes = Cliente::where('edo', true)->get();
        }

          foreach($clientes as $index => $cliente){
               // Cache::put('progreso_actualizacion_' . $this->option('user'), $index + 1);
                ProcesarClienteSaldoJob::dispatch($this->option('user'), $index, $cliente->idCliente);

          }

          
    }
}
