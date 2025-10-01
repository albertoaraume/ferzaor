<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class IngresoFactura extends Model
{
    protected $table = 'ingresos_facturas';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idIF';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idIF', 'importe_ingresado', 'importe', 
        'ingreso_idIngreso', 'comprobante_idComprobante', 'status'
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

    public function comprobante()
    {
        return $this->belongsTo('App\Models\Erp\CFDIComprobante',  'comprobante_idComprobante', 'idComprobante');
    }

    
}
