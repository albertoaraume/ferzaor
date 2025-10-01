<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    protected $table = 'cupones';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idCupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCupon', 'folio', 'fechaVenta', 'nombre', 'habitacion', 'email', 'telefono', 'tipoCupon', 'hotel_idHotel', 'nombreHotel', 'cliente_idCliente', 'vendedor_idVendedor', 'status', 'locacion_idLocacion', 'create_id', 'update_id', 'update_motivo',
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
        return $this->belongsTo('App\Models\Erp\Locacion', 'locacion_idLocacion', 'idLocacion');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Erp\Cliente', 'cliente_idCliente', 'idCliente');
    }


    public function reserva()
    {
        return $this->hasOne('App\Models\Erp\ReservaCP', 'cupon_idCupon', 'idCupon');
    }

    public function foto()
    {
        return $this->hasOne('App\Models\Erp\FotoVenta', 'cupon_idCupon', 'idCupon')->with('reserva');
    }

    public function tour()
    {
        return $this->hasOne('App\Models\Erp\TourVentaPaquete', 'cupon_idCupon', 'idCupon')->with('tourventa');
    }

    public function venta()
    {
        return $this->hasOne('App\Models\Erp\VentaCupon', 'cupon_idCupon', 'idCupon');
    }

    public function vendedorag()
    {
        return $this->hasOne('App\Models\Erp\ClienteVendedor', 'idVendedor', 'vendedor_idVendedor');
    }

    public function vendedordt()
    {
        return $this->hasOne('App\Models\Erp\Vendedor', 'idVendedor', 'vendedor_idVendedor');
    }

    public function agente()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'create_id');
    }

    public function hotel()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'hotel_idHotel');
    }

}
