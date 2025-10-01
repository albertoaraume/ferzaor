<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ServicioPrecioLista extends Model
{
      protected $table = 'servicios_precios_listas';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idSPL';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'idSPL', 'precio', 'minimo', 'edo', 'isComisionable', 'locacion_idLocacion',
             'lista_precio_idLP', 'servicio_idServicio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];



     public function listaprecio(){                 
        return $this->hasOne('App\Models\Erp\ListaPrecio', 'idLP', 'lista_precio_idLP');

    }

    public function servicio(){                 
        return $this->hasOne('App\Models\Erp\Servicio', 'idServicio', 'servicio_idServicio');

    }

    public function locacion(){                 
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');

    }

}
