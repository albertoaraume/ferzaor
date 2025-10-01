<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteUpgrade extends Model
{
    protected $table = 'clientes_upgrades';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idclUpgrade';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idclUpgrade', 'nombreClUpgrade', 'tarifa', 'porcentaje', 'comision', 'balance', 'c_moneda', 'cliente_idCliente', 
       'locacion_idLocacion', 'upgrade_idtarifUpgrade', 'edo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];



    public function cliente(){        
      return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');

    }


    public function locacion(){        
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    
    }


    public function upgrade(){        
        return $this->hasOne('App\Models\Erp\TarifaUpgrade', 'idtarifUpgrade', 'upgrade_idtarifUpgrade')->with('tarifaorigen')->with('paquetedestino');
    
    }

    
}
