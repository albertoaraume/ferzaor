<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CajaFondoSalida extends Model
{
      protected $table = 'cajas_fondos_salidas';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCFS';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCFS', 'montoBase', 'tipoCambio', 'monto', 
        'caja_fondo_idCF', 'caja_salida_idCS', 'c_moneda',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function fondo(){                 
        return $this->hasOne('App\Models\Erp\CajaFondo', 'idCF', 'caja_fondo_idCF');
    }

    public function salida(){                 
        return $this->hasOne('App\Models\Erp\CajaSalida', 'idCS', 'caja_salida_idCS');
    }
      
  

}
