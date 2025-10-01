<?php

namespace App\Services;

use App\Models\Erp\Cliente;

class ClienteService
{

     public function clientesActivos(): int
    {
        return Cliente::where('edo', true)->count();
    }

}
