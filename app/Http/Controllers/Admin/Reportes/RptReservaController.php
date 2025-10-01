<?php

namespace App\Http\Controllers\Admin\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class RptReservaController extends Controller
{

     public function showGeneral()
    {

       
        return view('admin.reportes.reservas.general');
    }

    public function showActividades()
    {
        
        return view('admin.reportes.reservas.actividades');
    }  

      public function showYates()
    {
        
        return view('admin.reportes.reservas.yates');
    }  

    public function showTours()
    {
        
        return view('admin.reportes.reservas.tours');
    }

    public function showTransportacion()
    {

        return view('admin.reportes.reservas.transportaciones');
    }


     public function showAdicionales()
    {

        return view('admin.reportes.reservas.adicionales');
    }

}