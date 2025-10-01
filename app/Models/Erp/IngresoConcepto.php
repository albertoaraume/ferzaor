<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class IngresoConcepto extends Model
{
    protected $table = 'ingresos_conceptos';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idIC';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idIC', 'importe_ingresado', 'importe', 
        'ingreso_idIngreso', 'concepto_idConcepto', 'status'
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

    public function concepto()
    {
        return $this->belongsTo('App\Models\Erp\Concepto',  'concepto_idConcepto', 'idConcepto');
    }

    
}
