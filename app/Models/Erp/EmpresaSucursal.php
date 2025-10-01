<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class EmpresaSucursal extends Model
{
     protected $table = 'empresas_sucursales';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idempSucursal';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'nombreSucursal', 'calle', 'estado', 'municipio','localidad', 'telefono', 'email', 'movil', 'c_codigoPostal',
        'alias', 'numExterior' , 'colonia' , 'numInterior', 'c_pais', 'referencia', 'iniciales', 'fechaCreacion',
        'edo', 'empresa_idEmpresa', 'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function empresa(){        
          return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
       
    }

     public function users(){      
        return $this->belongsToMany('App\Models\Erp\UserERP', 'users_empresas_sucursales')->withPivot('empresa_sucursal_idempSucursal', 'user_id');
     }
}
