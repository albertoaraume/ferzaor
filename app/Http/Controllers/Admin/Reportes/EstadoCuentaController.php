<?php

namespace App\Http\Controllers\Admin\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstadoCuentaController extends Controller
{


    public function clientes()
    {
        return view('admin.reportes.estado-cuenta-clientes');
    }
}
