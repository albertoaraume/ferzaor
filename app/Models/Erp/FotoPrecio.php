<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class FotoPrecio extends Model
{
      protected $table = 'fotos_precios';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idFPrecio';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [    
     'idFPrecio', 'locacion_idLocacion', 'precio_min', 'precio_max', 'typeComision', 'comision', 'c_moneda', 'foto_idFoto', 'edo', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

  

    public function foto(){                 
        return $this->belongsTo('App\Models\Erp\Foto', 'foto_idFoto', 'idFoto');
    }

   public function locacion(){                 
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

}
