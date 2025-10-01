<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;


class Cuenta extends Model
{
      protected $table = 'cuentas';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCuenta';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
     'numCuenta', 'tipo', 'c_clave', 'balanceInicial', 'c_moneda', 'titulo', 'clabe', 'fechaInicial', 'pGastos', 'pCostos', 'cFacturas', 
     'descripcion', 'edo', 'empresa_sucursal_idempSucursal', 'empresa_idEmpresa'
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

     public function terminales()
    {
        return $this->hasMany('App\Models\Erp\CuentaTerminal','cuenta_idCuenta', 'idCuenta');
    }

    
}
