<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';

protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idSerie';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idSerie', 'serie', 'folioInicial', 'tipo', 'locacion_idLocacion', 
        'ejercicio_idEjercicio', 'empresa_sucursal_idempSucursal', 'edo', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];


    public function polizas()
    {
        return $this->hasMany('App\Models\Erp\Poliza', 'serie_idSerie', 'idSerie');
    }
}
