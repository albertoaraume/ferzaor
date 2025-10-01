<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ServicioPrecioVolumen extends Model
{
      protected $table = 'servicios_precios_volumen';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idSPV';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'name', 'minimo', 'maximo', 'margen', 'precio', 'edo', 'servicio_idServicio'
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
