<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TarifaUpgrade extends Model
{
    protected $table = 'tarifas_upgrades';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idtarifUpgrade';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idtarifUpgrade', 'titulo', 'tarifa', 'c_moneda', 'locacion_idLocacion', 'idpaqTarifa_origen', 'edo', 'idactPaquete_destino',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function tarifaorigen(){        
          return $this->hasOne('App\Models\Erp\PaqueteTarifa', 'idpaqTarifa', 'idpaqTarifa_origen');
      
    }


        public function paquetedestino(){        
            return $this->hasOne('App\Models\Erp\ActividadPaquete', 'idactPaquete', 'idactPaquete_destino');

        }

        public function locacion(){        
            return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');

        }

   
}
