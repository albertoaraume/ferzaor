<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class PolizaConcepto extends Model
{
  protected $table = 'polizas_conceptos';

protected $connection= 'mysqlerp';
  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'idPC';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'idPC', 'concepto_idConcepto', 'categoria_idCCategoria', 'descripcion', 'numDocumento', 'cantidad', 'costo', 'importe', 'descuento', 'iva', 'ieps',
    'retISR_tipo', 'retISR', 'retIVA', 'status', 'origen', 'comprueba_id', 'comprueba_date',
    'proveedor_idProveedor', 'unidadnegocio_idUN', 'poliza_idPoliza', 'create_id', 'update_id',  'updated_id',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ['created_at', 'updated_at'];

  public function poliza()
  {
    return $this->belongsTo('App\Models\Erp\Poliza',  'poliza_idPoliza', 'idPoliza');
  }

  public function concepto()
  {
    return $this->hasOne('App\Models\Erp\Concepto', 'idConcepto', 'concepto_idConcepto');
  }


  public function categoria()
  {
    return $this->hasOne('App\Models\Erp\ConceptoCategoria', 'idCCategoria', 'categoria_idCCategoria');
  }

  public function proveedor()
  {
    return $this->hasOne('App\Models\Erp\Proveedor', 'idProveedor', 'proveedor_idProveedor');
  }

  public function unidadnegocio()
  {
    return $this->hasOne('App\Models\Erp\UnidadNegocio', 'idUN', 'unidadnegocio_idUN');
  }


  public function movimientos()
  {
    return $this->hasMany('App\Models\Erp\PolizaConceptoM', 'poliza_concepto_idPC', 'idPC');
  }

}
