<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Erp\CajaCheckin;
class FotoVenta extends Model
{
  protected $table = 'fotos_venta';

protected $connection= 'mysqlerp';
  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'idFVenta';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'idFVenta', 'guid', 'folio', 'fecha', 'fechaEntrega', 'cliente_idCliente',
    'vendedor_idVendedor', 'locacion_idLocacion', 'reserva_idReserva', 'user_id', 'c_moneda', 'status', 'tipoVenta', 'cupon_idCupon', 'link', 'toBlock',
    'isCredito', 'foto_caja_idFCaja', 'concepto_cfdiConcepto',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'created_at', 'updated_at'
  ];


  public function caja()
  {
    return $this->hasOne('App\Models\Erp\FotoCaja', 'idFCaja', 'foto_caja_idFCaja');
  }


  public function agente()
  {
    return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user_id');
  }

  public function ventafoto()
  {
    return $this->hasOne('App\Models\Erp\VentaFoto', 'idFVenta', 'idFVenta');
  }


  public function paquetes()
  {
    return $this->hasMany('App\Models\Erp\FotoVentaPaquete', 'foto_venta_idFVenta', 'idFVenta');
  }


  public function envios()
  {
    return  $this->hasMany('App\Models\Erp\FotoVentaEnvio', 'foto_venta_idFVenta', 'idFVenta');
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
    return $this->hasOne('App\Models\Erp\Vendedor',  'idVendedor', 'vendedor_idVendedor');
  }

  public function reserva()
  {
    return $this->hasOne('App\Models\Erp\Reserva', 'idReserva', 'reserva_idReserva');
  }

  public function locacion()
  {
    return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
  }

  public function cupon()
  {
    return $this->hasOne('App\Models\Erp\Cupon', 'idCupon', 'cupon_idCupon');
  }


  public function emails()
  {
    return  $this->hasMany('App\Models\Erp\FotoVentaEnvio', 'foto_venta_idFVenta', 'idFVenta');
  }





  public function cfdi()
  {
    return $this->hasOne('App\Models\Erp\CFDIConcepto', 'c_cfdiConcepto', 'concepto_cfdiConcepto')->with('comprobante');
  }



}
