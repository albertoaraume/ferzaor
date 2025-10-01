<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class PaqueteTarifa extends Model
{
    protected $table = 'paquetes_tarifas';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idpaqTarifa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idpaqTarifa', 'titulo', 'detalles', 'edo', 'tarifa', 'c_moneda', 'horas', 'horarioFijo', 'isCompartida', 'paquete_idactPaquete', 'conTraslado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function paquete()
    {
        return $this->hasOne('App\Models\Erp\ActividadPaquete', 'idactPaquete', 'paquete_idactPaquete');

    }

    public function locaciones()
    {
        return $this->belongsToMany('App\Models\Erp\Locacion', 'tarifas_locaciones')->withPivot('paquete_tarifa_idpaqTarifa', 'locacion_idLocacion');
    }

    public function clientes()
    {
        return $this->hasMany('App\Models\Erp\ClienteTarifa', 'paquete_tarifa_idpaqTarifa', 'idpaqTarifa');
    }

    public function horarios()
    {
        return $this->hasMany('App\Models\Erp\TarifaHorario', 'idpaqTarifa', 'idpaqTarifa');
    }
}
