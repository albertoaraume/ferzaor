<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class YatePaqueteTarifa extends Model
{
    protected $table = 'yates_paquetes_tarifas';
  protected $connection= 'mysqlerp';

/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idytPaqTarifa';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idclYate', 'nombreClYate', 'tarifa', 'porcentaje', 'comision', 'balance', 'c_moneda', 'idCliente', 'idYate', 'idytPaquete', 'idytPaqTarifa', 'edo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function paquete(){        
          return $this->hasOne('App\Models\Erp\YatePaquete', 'idytPaquete', 'idytPaquete');
      
    }

   
}
