<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ReservaPayMent extends Model
{
    protected $table = 'reservas_payment';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idRPay';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idRPay', 'orderID',  'amount', 'currency', 'method', 'type',  'expires', 'url', 'payment_reference', 'payment_id', 'payment_intent',  'payment_date', 'status', 'reserva_idReserva',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function reserva()
    {
        return $this->hasOne('App\Models\Erp\Reserva', 'idReserva', 'reserva_idReserva');
    }

}
