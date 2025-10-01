<?php

namespace App\Console\Commands;

use App\Models\Erp\Reserva;
use Illuminate\Console\Command;

class ReservaCommand extends Command
{
   protected $signature = 'ferzaor:reserva {--reserva= : ID de lar eserva specífico}';
    protected $description = 'Consultar o procesar reservas específicas';

    public function handle()
    {
        $reservaId = $this->option('reserva');
        if ($reservaId) {
            $reserva = Reserva::find($reservaId);

            $this->info('Total Credito: ' . $reserva->TotalCredito);
            $this->info('Total Balance: ' . $reserva->TotalBalance);
            $this->info('Total: ' . $reserva->ImporteTotal);
            $this->info('Pagos Creditos: ' . $reserva->PagoCredito);
            $this->info('Pagos Balance: ' . $reserva->PagoBalance);
            $this->info('Saldo: ' . $reserva->Saldo);
            $this->info('Pagada: ' . ($reserva->Pagada ? 'Sí' : 'No'));
            $this->info('Facturas: ' . $reserva->FacturasRelacionadas->count());


        }else {
            $this->error('Debe proporcionar un ID de reserva válido.');
            return;
        }

    }



}
