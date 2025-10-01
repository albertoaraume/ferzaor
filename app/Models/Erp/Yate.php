<?php

namespace App\Models\Erp;

use DB;
use Illuminate\Database\Eloquent\Model;

class Yate extends Model
{
    protected $table = 'yates';
  protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idYate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idYate', 'nombreYate', 'alias', 'slug', 'descripcion', 'color', 'numSerie', 'numPlaca', 'edo', 'pax', 'precioHora',
        'idProveedor', 'idUN', 'idEmpresa', 'idLocacion', 'showWeb', 'validaERP',
         'isTop', 'idClasificacion', 'feet', 'brand', 'year', 'ac', 'bathroom', 'room', 'version', 'concepto_idConcepto',
         'kitchen', 'deluxe', 'confortable', 'snorkeling', 'professional'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function empresa()
    {
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'idEmpresa');

    }

    public function paquetes()
    {
        return $this->hasMany('App\Models\Erp\YatePaquete', 'idYate', 'idYate')->with('tarifas');
    }

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'idLocacion');

    }

    public function proveedor()
    {
        return $this->hasOne('App\Models\Erp\Proveedor', 'idProveedor', 'idProveedor');
    }

    public function unidadnegocio()
    {
        return $this->hasOne('App\Models\Erp\UnidadNegocio', 'idUN', 'idUN');
    }


    public function comodidades(){
        return $this->belongsToMany('App\Models\Erp\CATComodidad', 'yates_comodidades')->withPivot('cat_comodidad_id','yates_idYate');
    }

    public function incluidos(){
            return $this->belongsToMany('App\Models\Erp\CATIncluido', 'yates_incluidos')->withPivot('cat_incluido_id','yates_idYate');
    }

    public function noincluidos(){
                return $this->belongsToMany('App\Models\Erp\CATNoIncluido', 'yates_noincluidos')->withPivot('cat_noincluido_id','yates_idYate');
    }

    public function extras(){
                    return $this->belongsToMany('App\Models\Erp\CATExtra', 'yates_extras')->withPivot('cat_extras_id','yates_idYate');
    }

}
