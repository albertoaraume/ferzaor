<?php

namespace App\Console\Commands;

use App\Models\Erp\ReservaAU;
use Illuminate\Console\Command;

class ReservaAUCommand extends Command
{
   protected $signature = 'ferzaor:reservaau {--id= : ID de lar eserva specífico}';
    protected $description = 'Consultar o procesar reservas específicas';

    public function handle()
    {
        $actId = $this->option('id');
        if ($actId) {
            $actividad = ReservaAU::find($actId);

            $this->info('Total Credito: ' . $actividad->TotalCredito);
            $this->info('Total Balance: ' . $actividad->TotalBalance);
            //$this->info('Total: ' . $actividad->ImporteTotal);

            $this->info('Pagos Creditos: ' . $actividad->PagoCredito);
         
             $this->info('Saldo: ' . $actividad->Saldo);
             $this->info('Pagado: ' . $actividad->Pagada);


        }else {
            $this->error('Debe proporcionar un ID de reserva válido.');
            return;
        }

    }



}
