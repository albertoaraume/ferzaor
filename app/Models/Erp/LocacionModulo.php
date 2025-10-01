<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class LocacionModulo extends Model
{
    protected $table = 'locaciones_modulos';
protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idModulo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idLM', 'nombreModulo', 'locacion_idLocacion', 'edo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function locacion()
    {
        return $this->belongsTo('App\Models\Erp\Locacion', 'locacion_idLocacion', 'idLocacion');
    }

}
