<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class IngresoMembresia extends Model
{
    protected $table = 'ingresos_membresias';

    protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idIM';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idIM', 'importe_ingresado', 'importe', 'ID', 'method', 'expires', 'url', 'payment_intent', 'ingreso_idIngreso', 'membresia_idMembresia', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function ingreso()
    {
        return $this->belongsTo('App\Models\Erp\Ingreso', 'ingreso_idIngreso', 'idIngreso');
    }

    public function membresia()
    {
        return $this->belongsTo('App\Models\Erp\Membresia', 'membresia_idMembresia', 'idMembresia');
    }

}
