<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
  protected $table = 'cat_conceptos';

protected $connection= 'mysqlerp';
  /**
   * The primary key for the model.
   *
   * @var string
   */
  protected $primaryKey = 'idConcepto';


  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'idConcepto', 'nombreConcepto', 'aplicaEgreso', 'aplicaIngreso', 'cuentaContable',
    'empresa_idEmpresa'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [];

  public function categorias()
  {
    return $this->hasMany('App\Models\Erp\ConceptoCategoria', 'concepto_idConcepto', 'idConcepto');
  }
}
