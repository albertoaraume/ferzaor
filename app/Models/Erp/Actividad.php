<?php

namespace App\Models\Erp;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';

        protected $connection= 'mysqlerp';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idActividad';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idActividad', 'nombreActividad', 'slug', 'descripcion', 'color', 'fechaCreacion', 'edo', 'proveedor_idProveedor', 'idUN', 'isSubrogada', 'feeADL', 'feeMEN', 'c_moneda', 'idClasificacion', 'empresa_idEmpresa', 'isTop', 'showWeb', 'level_en', 'level_es', 'video', 'aplicaPercap',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function unidades()
    {
        return $this->belongsToMany('App\Models\Erp\Unidad', 'actividades_unidades')->withPivot('actividad_idActividad', 'unidad_idUnidad');
    }

    public function empresa()
    {
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
    }

    public function clasificacion()
    {
        return $this->hasOne('App\Models\Erp\Clasificacion', 'idClasificacion', 'idClasificacion');
    }

    public function paquetes()
    {
        return $this->hasMany('App\Models\Erp\ActividadPaquete', 'actividad_idActividad', 'idActividad')->with('tarifas');
    }


    public function proveedor()
    {
        return $this->hasOne('App\Models\Erp\Proveedor', 'idProveedor', 'proveedor_idProveedor');
    }

    public function unidadnegocio()
    {
        return $this->hasOne('App\Models\Erp\UnidadNegocio', 'idUN', 'idUN');
    }

}
