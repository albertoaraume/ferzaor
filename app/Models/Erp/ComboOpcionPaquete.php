<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ComboOpcionPaquete extends Model
{
    protected $table = 'combos_opciones_paquetes';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idopcPaquete';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'actividad_idActividad',  'actividad_paquete_idactPaquete', 'paquete_tarifa_idpaqTarifa', 'combo_opcion_idOpcion', 'isUpdate'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function opcion(){        
          return $this->hasOne('App\Models\Erp\ComboOpcion', 'idOpcion', 'combo_opcion_idOpcion');      
    }

    public function actividad(){        
        return $this->hasOne('App\Models\Erp\Actividad', 'idActividad', 'actividad_idActividad');      
    }

    public function paquete(){        
        return $this->hasOne('App\Models\Erp\ActividadPaquete', 'idactPaquete', 'actividad_paquete_idactPaquete');      
    }

    public function tarifa(){        
        return $this->hasOne('App\Models\Erp\PaqueteTarifa', 'idpaqTarifa', 'paquete_tarifa_idpaqTarifa');      
    }
    
}
