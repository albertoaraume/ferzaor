<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteTarifa extends Model
{
    protected $table = 'clientes_tarifas';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idclTarifa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idclTarifa', 'nombreClTarifa', 'tarifa', 'porcentaje', 'comision', 'comisionCompartida',
        'balance', 'c_moneda', 'detalles', 'cliente_idCliente', 'locacion_idLocacion',
        'actividad_idActividad', 'actividad_paquete_idactPaquete',
        'paquete_tarifa_idpaqTarifa', 'edo',
        'conTraslado',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');

    }

    public function cliente()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');

    }

    public function actividad()
    {
        return $this->hasOne('App\Models\Erp\Actividad', 'idActividad', 'actividad_idActividad');
    }

    public function paquete()
    {
        return $this->hasOne('App\Models\Erp\ActividadPaquete', 'idactPaquete', 'actividad_paquete_idactPaquete');
    }

    public function paqtarifa()
    {
        return $this->hasOne('App\Models\Erp\PaqueteTarifa', 'idpaqTarifa', 'paquete_tarifa_idpaqTarifa');

    }

}
