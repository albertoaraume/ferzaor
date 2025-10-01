<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Poliza extends Model
{
  protected $table = 'polizas';

protected $connection= 'mysqlerp';
  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'idPoliza';
  protected $appends = array(
    'Total',  'Devolucion', 'Comprobados', 'pendientePago',
    'retIVA', 'retISR', 'Ieps', 'IVA', 'Descuento', 'Sub', 'totalPagos'
  );
   protected $with = ['userCreate'];


  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'idPoliza', 'folio', 'c_moneda', 'status', 'tipopoliza_idTP', 'observaciones', 'diasCredito', 'create_id', 'create_fecha', 'autoriza_id',
    'autoriza_fecha', 'cancela_id', 'cancela_fecha', 'motivo_', 'serie_idSerie', 'locacion_idLocacion', 'empresa_sucursal_idempSucursal',
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

  public function conceptos()
  {
    return $this->hasMany('App\Models\Erp\PolizaConcepto', 'poliza_idPoliza', 'idPoliza');
  }

  public function archivos()
  {
    return $this->hasMany('App\Models\Erp\PolizaArchivo', 'poliza_idPoliza', 'idPoliza');
  }


  public function pagos()
  {
    return $this->hasMany('App\Models\Erp\EgresoPoliza', 'poliza_idPoliza', 'idPoliza');
  }

  public function devoluciones()
  {
    return $this->hasMany('App\Models\Erp\IngresoPoliza', 'poliza_idPoliza', 'idPoliza');
  }

  public function userCreate()
  {
    return $this->hasOne('App\Models\Erp\UserERP', 'id', 'create_id');
  }

  public function userAutoriza()
  {
    return $this->hasOne('App\Models\Erp\UserERP', 'id', 'autoriza_id');
  }

  public function userCancela()
  {
    return $this->hasOne('App\Models\Erp\UserERP', 'id', 'cancela_id');
  }

  
  public function serie()
  {
    return $this->belongsTo('App\Models\Erp\Serie',  'serie_idSerie', 'idSerie');
  }


  public function sucursal()
  {
    return $this->belongsTo('App\Models\Erp\EmpresaSucursal',  'empresa_sucursal_idempSucursal', 'idempSucursal');
  }

  public function proveedor()
  {
    return $this->hasOne('App\Models\Erp\Proveedor', 'idProveedor', 'proveedor_idProveedor');
  }



  public function getSubAttribute()
  {
    $deps = $this->conceptos->where('status', '>', 0)->sum('importe');

    return round($deps, 2);
  }
  public function getDescuentoAttribute()
  {
    $deps = $this->conceptos->where('status', '>', 0)->sum('descuento');

    return round($deps, 2);
  }

  public function getIvaAttribute()
  {
    $deps = $this->conceptos->where('status', '>', 0)->sum('iva');

    return round($deps, 2);
  }


  public function getIepsAttribute()
  {
    $deps = $this->conceptos->where('status', '>', 0)->sum('ieps');

    return round($deps, 2);
  }


  public function getretISRAttribute()
  {
    $deps = $this->conceptos->where('status', '>', 0)->sum('retISR');

    return round($deps, 2);
  }


  public function getretIVAAttribute()
  {
    $deps = $this->conceptos->where('status', '>', 0)->sum('retIVA');

    return round($deps, 2);
  }



  public function getTotalAttribute()
  {
    $subTotal = $this->Sub;

    $total = (($subTotal + $this->Iva + $this->Ieps) - ($this->Descuento + $this->retISR + $this->retIVA));

    return round($total, 2);
  }


  public function getpendientePagoAttribute()
  {
    $pagos = $this->pagos->where('status', 1)->sum('monto');

    $total = $this->Total;
    $totalPagos = 0;
    if($total > $pagos){
     $totalPagos = $total - $pagos;
    }

    return round($totalPagos, 2);
  }

  public function gettotalPagosAttribute()
  {
    $pagos = $this->pagos->where('status', 1)->sum('monto');

    

    return round($pagos, 2);
  }

  public function getComprobadosAttribute()
  {

    

    $comprobado = $this->conceptos->where('status', 3)->sum('Total');

    return round($comprobado, 2);
  }


  public function getDevolucionAttribute()
  {

    $pagos = $this->pagos->where('status', 1)->sum('monto');
    $devoluciones = $this->devoluciones->where('status','>', 0)->sum('importe');
    
    $comprobado = $this->Comprobados;

     $devolucion = $pagos - $comprobado;  
   
    return round($devolucion - $devoluciones, 2);
  }
}
