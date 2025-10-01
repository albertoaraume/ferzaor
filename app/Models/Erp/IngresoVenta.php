<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class IngresoVenta extends Model
{
    protected $table = 'ingresos_ventas';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idIV';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idIV', 'subTotal', 'comision', 'total', 'status',
         'ingreso_idIngreso', 'venta_idVenta', 'caja_idCaja'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];



    public function ingreso()
    {
        return $this->belongsTo('App\Models\Erp\Ingreso',  'ingreso_idIngreso', 'idIngreso');
    }

    public function venta()
    {
        return $this->belongsTo('App\Models\Erp\Venta',  'venta_idVenta', 'idVenta');
    }

    public function caja()
    {
        return $this->belongsTo('App\Models\Erp\Caja',  'caja_idCaja', 'idCaja');
    }
}
