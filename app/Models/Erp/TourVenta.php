<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Erp\CajaCheckin;
class TourVenta extends Model
{
    protected $table = 'tours_ventas';

    protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTVenta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idTVenta', 'guid', 'folio', 'folioPre', 'confirmacion',
         'fecha', 'nombre', 'telefono', 'email', 'habitacion', 
         'hotel_idHotel', 'nombreHotel', 'cliente_idCliente',
          'nombreCliente', 'tipoCliente', 'vendedor_idVendedor',
           'nombreVendedor', 'locacion_idLocacion', 'create_id', 
           'c_moneda', 'descripcionMoneda', 'status', 'tipoVenta',
            'nombretipoVenta', 'cupon_idCupon', 'empresa_idEmpresa',
         'tour_caja_idTCaja', 'forKiosco', 'forPayment', 'toBlock', 'user_id', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function caja()
    {
        return $this->hasOne('App\Models\Erp\TourCaja', 'idTCaja', 'tour_caja_idTCaja');
    }

    public function agente()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'create_id');
    }

    public function paquetes()
    {
        return $this->hasMany('App\Models\Erp\TourVentaPaquete', 'tour_venta_idTVenta', 'idTVenta');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Models\Erp\Cliente', 'cliente_idCliente', 'idCliente');
    }

    public function vendedorag()
    {
        return $this->hasOne('App\Models\Erp\ClienteVendedor', 'idVendedor', 'vendedor_idVendedor');
    }

    public function vendedordt()
    {
        return $this->hasOne('App\Models\Erp\Vendedor', 'idVendedor', 'vendedor_idVendedor');
    }

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function cupon()
    {
        return $this->hasOne('App\Models\Erp\Cupon', 'idCupon', 'cupon_idCupon');
    }


}
