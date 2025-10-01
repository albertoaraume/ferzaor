<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class FotoVentaPaquete extends Model
{
  protected $table = 'fotos_venta_paquetes';

protected $connection= 'mysqlerp';
  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'idFVPaquete';



  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'idFVPaquete', 'foto_idFoto', 'nombrePaquete', 'precio', 'cantidad', 'importe', 'comision', 'descripcion', 'foto_venta_idFVenta', 'id', 'tipoPaquete', 'isCredito',  'concepto_vendedorConcepto', 'concepto_proveedorConcepto',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'created_at', 'updated_at'
  ];

  public function fotoventa()
  {
    return $this->belongsTo('App\Models\Erp\FotoVenta', 'foto_venta_idFVenta', 'idFVenta');
  }



  public function conceptocomision()
  {
    return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_vendedorConcepto');
  }

  public function conceptoproveedor()
  {
    return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_proveedorConcepto');
  }


  public function unidad()
  {
    return $this->hasOne('App\Models\Erp\ReservaAU', 'idAU', 'id');
  }

  public function yate()
  {
    return $this->hasOne('App\Models\Erp\ReservaY', 'idRY', 'id');
  }


}
