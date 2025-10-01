<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class IngresoPoliza extends Model
{
    protected $table = 'ingresos_polizas';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idIP';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idIP', 'importe_ingresado', 'importe', 
        'ingreso_idIngreso', 'poliza_idPolica', 'status'
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

    public function poliza()
    {
        return $this->belongsTo('App\Models\Erp\Poliza',  'poliza_idPoliza', 'idPoliza');
    }

    
}
