<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClasificacionLocacion extends Model
{
    protected $table = 'clasificaciones_locaciones';

    protected $connection= 'mysqlerp';
 
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'clasificacion_idClasificacion', 'locacion_idLocacion', 'type', 'importe',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',

    ];

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function clasificacion()
    {
        return $this->hasOne('App\Models\Erp\Clasificacion', 'idClasificacion', 'clasificacion_idClasificacion');
    }

}
