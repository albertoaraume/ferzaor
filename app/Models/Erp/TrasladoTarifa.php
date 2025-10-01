<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TrasladoTarifa extends Model
{
    protected $table = 'traslados_tarifas';
protected $connection= 'mysqlerp';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idtTarifa';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cantMinima', 'cantMaxima', 'ow', 'rt', 'detalles', 'edo', 'traslado_tipo_idTT',
        'transportacion_idTransportacion', 'costo_rt', 'costo_rt_moneda',
        'costo_ow', 'costo_ow_moneda', 'conActividad'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];


    public function trasladotipo()
    {
        return $this->hasOne('App\Models\Erp\TrasladoTipo', 'idTT', 'traslado_tipo_idTT');
    }

    public function transportacion()
    {
        return $this->hasOne('App\Models\Erp\Transportacion', 'idTransportacion', 'transportacion_idTransportacion');
    }
}
