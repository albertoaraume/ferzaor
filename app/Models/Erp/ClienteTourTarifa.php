<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteTourTarifa extends Model
{
    protected $table = 'clientes_tours_tarifas';
protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idclTourTarifa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idclTourTarifa', 'nombreClTourTarifa', 'tarifa', 'porcentaje', 'comision', 'comisionCompartida', 'balance', 'c_moneda', 'detalles', 'cliente_idCliente', 'locacion_idLocacion', 'tour_idTour', 'tour_paquete_idtourPaquete', 'tour_paquete_tarifa_idtourpaqTarifa', 'edo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function cliente()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');
    }

    public function tour()
    {
        return $this->hasOne('App\Models\Erp\Tour', 'idTour', 'tour_idTour');
    }

    public function paquete()
    {
        return $this->hasOne('App\Models\Erp\TourPaquete', 'idtourPaquete', 'tour_paquete_idtourPaquete');
    }

    public function paqtarifa()
    {
        return $this->hasOne('App\Models\Erp\TourPaqueteTarifa', 'idtourpaqTarifa', 'tour_paquete_tarifa_idtourpaqTarifa');
    }
}
