<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CajaSalida extends Model
{
      protected $table = 'cajas_salidas';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCS';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCS', 'monto', 'c_moneda', 'status', 'tipo', 'motivo', 'recibe', 'id', 'caja_idCaja', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function caja(){                 
        return $this->hasOne('App\Models\Erp\Caja', 'idCaja', 'caja_idCaja');
    }
      

    public function fondossalidas()
    {
        return $this->hasMany('App\Models\Erp\CajaFondoSalida','caja_salida_idCS', 'idCS');
    }
  

}
