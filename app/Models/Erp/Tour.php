<?php

namespace App\Models\Erp;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $table = 'tours';
protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTour';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idTour', 'nombreTour', 'slug', 'descripcion', 'color',
        'edo', 'isTop', 'showWeb', 'proveedor_idProveedor',
        'isSubrogada', 'feeADL', 'feeMEN', 'c_moneda', 'empresa_idEmpresa',
        'level_en', 'level_es', 'video', 'ubication',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function empresa()
    {
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'idEmpresa');
    }

    public function paquetes()
    {
        return $this->hasMany('App\Models\Erp\TourPaquete', 'idTour', 'idTour')->with('tarifas');
    }

    public function proveedor()
    {
        return $this->hasOne('App\Models\Erp\Proveedor', 'idProveedor', 'proveedor_idProveedor');
    }

}
