<?php

namespace App\Console\Commands;

use App\Models\Erp\ReservaY;
use Illuminate\Console\Command;

class ReservaYCommand extends Command
{
   protected $signature = 'ferzaor:reservay {--id= : ID de la reserva específica}';
    protected $description = 'Consultar o procesar reservas específicas';

    public function handle()
    {
        $actId = $this->option('id');
        if ($actId) {
            $actividad = ReservaY::find($actId);

         
     
            $this->info('Total Credito: ' . $actividad->TotalCredito);
            $this->info('Total Balance: ' . $actividad->TotalBalance);
         $this->info('Importe Total: ' . $actividad->ImporteTotal);

            $this->info('Pagos Recibidos: ' . $actividad->Pagos);

            $this->info('Pagos Creditos: ' . $actividad->PagoCredito);
 
            $this->info('Saldo: ' . $actividad->Saldo);

      
        }else {
            $this->error('Debe proporcionar un ID de reserva válido.');
            return;
        }

    }



}
