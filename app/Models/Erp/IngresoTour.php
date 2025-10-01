<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class IngresoTour extends Model
{
    protected $table = 'ingresos_tours';
protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idIT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idIT', 'importe_ingresado', 'importe', 'ID', 'method', 'expires', 'url',
        'payment_intent', 'ingreso_idIngreso', 'tour_venta_idTVenta', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function ingreso()
    {
        return $this->belongsTo('App\Models\Erp\Ingreso', 'ingreso_idIngreso', 'idIngreso');
    }

    public function tour()
    {
        return $this->belongsTo('App\Models\Erp\TourVenta', 'tour_venta_idTVenta', 'idTVenta');
    }

}
