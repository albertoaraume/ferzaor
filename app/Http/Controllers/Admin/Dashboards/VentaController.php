<?php

namespace App\Http\Controllers\Admin\Dashboards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class VentaController extends Controller
{

    public function index()
    {
        return view('admin.dashboards.ventas');
    }

}
