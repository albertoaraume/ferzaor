<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteRS extends Model
{
    
      
 protected $table = 'clientes_razonessociales';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idcltRS';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'idcltRS', 'rfc', 'razonSocial', 'tipoPersona', 'contacto', 'telefono', 
        'movil', 'email', 'esExtranjero', 'c_usoCFDI', 'cliente_idCliente', 'edo'
       
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    

     public function cliente(){                 
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');

    }


    public function sucursales()
    {
        return $this->hasMany('App\Models\Erp\ClienteSucursal','cliente_rs_idcltRS', 'idcltRS');
    }
   
}
