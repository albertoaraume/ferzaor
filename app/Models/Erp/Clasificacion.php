<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    protected $table = 'clasificaciones';

    protected $connection= 'mysqlerp';
 
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idClasificacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idClasificacion', 'tipo', 'descripcion', 'clave',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',

    ];

    public function actividades()
    {
        return $this->hasMany('App\Models\Erp\Actividad', 'idClasificacion', 'idClasificacion');
    }

    public function percaps()
    {
        return $this->hasMany('App\Models\Erp\ClasificacionLocacion', 'clasificacion_idClasificacion', 'idClasificacion');
    }

   

}
