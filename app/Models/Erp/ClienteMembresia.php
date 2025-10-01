<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteMembresia extends Model
{
    protected $table = 'clientes_membresias';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idclMembresia';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idclMembresia', 'nombreMembresia', 'precio', 'porcentaje', 'comision', 'balance', 'c_moneda', 'vigencia', 'membresia_idMembresia', 'membresia_idMP', 'cliente_idCliente', 'locacion_idLocacion', 'edo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


    public function membresia(){        
        return $this->hasOne('App\Models\Erp\Membresia', 'idMembresia', 'membresia_idMembresia');    
    }

    public function cliente(){        
      return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');

    }

    
    

    
}
