<?php

namespace App\Http\Controllers\Admin\Ayuda;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AyudaController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function monitoreo()
    {

        return view('admin.ayuda.monitoreo');
    }
}
