<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ServicioImpuesto extends Model
{
      protected $table = 'servicios_impuestos';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idSI';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'idSI', 'c_tipoImpuesto', 'c_impuesto', 'base', 'c_tipoFactor', 'valor', 'importe', 'servicio_idServicio'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


    public function servicio(){                 
        return $this->hasOne('App\Models\Erp\Servicio', 'idServicio', 'servicio_idServicio');

    }

}
