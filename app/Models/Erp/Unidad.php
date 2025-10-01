<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidades';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idUnidad';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idUnidad', 'alias', 'detalles', 'tipo', 'pax', 'edo', 'numSerie', 'numPlaca', 'minimoHoras', 'locacion_idLocacion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function actividades(){     
     return $this->belongsToMany('App\Models\Erp\Actividad', 'actividades_unidades')->withPivot('unidad_idUnidad','actividad_idActividad');
     }

     public function empresa(){                 
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
    }

     public function locacion(){                 
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }
}
