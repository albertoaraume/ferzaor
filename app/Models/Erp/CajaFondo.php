<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CajaFondo extends Model
{
      protected $table = 'cajas_fondos';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCF';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCF', 'c_moneda', 'descripcionMoneda', 'montoInicial', 'montoCobrado',  'montoFinal', 'caja_idCaja',
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
      

    public function salidas()
    {
        return $this->hasMany('App\Models\Erp\CajaFondoSalida','caja_fondo_idCF', 'idCF');
    }
  

}
