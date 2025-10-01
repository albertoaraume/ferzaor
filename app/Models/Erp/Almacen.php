<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
      protected $table = 'almacenes';


          protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idAlmacen';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'nombreAlmacen', 'fechaCreacion', 'edo', 'empresa_sucursal_idempSucursal', 'empresa_idEmpresa'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];



     public function sucursal(){                 
        return $this->hasOne('App\Models\Erp\EmpresaSucursal', 'idempSucursal', 'empresa_sucursal_idempSucursal');

    }

    public function empresa(){                 
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');

    }

}
