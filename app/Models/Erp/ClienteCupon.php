<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteCupon extends Model
{
    protected $table = 'clientes_cupones';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idcltCupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idcltCupon', 'tipoCupon', 'codigo', 'descuento', 'locacion_idLocacion', 'fechaInicio', 'fechaFin', 'aplicaTiempo', 'cliente_idCliente', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function cliente()
    {
        return $this->belongsTo('App\Models\Erp\Cliente', 'cliente_idCliente', 'idCliente');

    }

    public function actividades()
    {
        return $this->belongsToMany('App\Models\Erp\Actividad', 'clientes_cupones_actividades')->withPivot('actividad_idActividad', 'cliente_cupon_idclCupon');
    }

}
