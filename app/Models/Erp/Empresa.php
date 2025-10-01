<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    
 protected $table = 'empresas';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idEmpresa';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rfc', 'razonSocial', 'razonSocial40', 'nombreComercial', 'c_regimenFiscal', 'logo', 'curp', 'tipoPersona', 'edo', 'fechaCreacion', 'sitioWeb', 'key', 'timbres', 'smsS', 'versionCFDI', 'keySMS', 'colorLetra', 'colorHeader', 'colorLetraHeader', 'numregIdtrib', 'esExtranjero', 'reservas', 'userPac', 'pwdPac', 'user_id', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

      public function users(){      
        return $this->belongsToMany('App\Models\Erp\UserERP', 'users_empresas_sucursales')->withPivot('empresa_idEmpresa', 'user_id')->distinct();
     }


         
      public function sucursales()
    {
        return $this->hasMany('App\Models\Erp\EmpresaSucursal','empresa_idEmpresa', 'idEmpresa');
    }

     public function clientes()
    {
        return $this->hasMany('App\Models\Erp\Cliente','empresa_idEmpresa', 'idEmpresa');
    }

     public function locaciones()
    {
        return $this->hasMany('App\Models\Erp\Locacion','empresa_idEmpresa', 'idEmpresa');
    }

     public function agencias()
    {
        return $this->hasMany('App\Models\Erp\Agencia','empresa_idEmpresa', 'idEmpresa');
    }

     public function parametro(){        
          return $this->hasOne('App\Models\Erp\EmpresaParametro',  'empresa_idEmpresa', 'idEmpresa');
       
    }
    
}
