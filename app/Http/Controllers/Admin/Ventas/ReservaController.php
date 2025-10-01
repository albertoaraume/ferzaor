<?php

namespace App\Http\Controllers\Admin\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservaController extends Controller
{



    public function show($guid)
    {
        return view('admin.ventas.reservas.show', compact('guid'));
    }

    public function edit($guid)
    {
        return view('admin.ventas.reservas.edit', compact('guid'));
    }
}
