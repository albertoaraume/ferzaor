<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
      protected $table = 'fotos';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idFoto';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [    
      'idFoto', 'nombreFoto', 'empresa_idEmpresa', 'edo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

  

    public function precios()
    {
        return $this->hasMany('App\Models\Erp\FotoPrecio','foto_idFoto', 'idFoto');
    }

      public function actividades(){     
         return $this->belongsToMany('App\Models\Erp\Actividad', 'fotos_actividades')->withPivot('foto_idFoto','actividad_idActividad');
     }

       public function yates(){     
         return $this->belongsToMany('App\Models\Erp\Yate', 'fotos_yates')->withPivot('foto_idFoto','yate_idYate');
     }

      public function servicios()
    {
        return $this->hasMany('App\Models\Erp\FotoServicio','foto_idFoto', 'idFoto');
    }

}
