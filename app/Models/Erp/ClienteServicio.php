<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteServicio extends Model
{
    protected $table = 'clientes_servicios';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idclServicio';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idclServicio', 'nombreServicio', 'precio', 'pax_maximo', 'pax_adicional', 'porcentaje', 'comision', 'balance', 'c_moneda', 'idSPL', 'idLP', 'nombreLista', 'cliente_idCliente', 'locacion_idLocacion', 'servicio_idServicio', 'edo', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


    public function servicio(){        
        return $this->hasOne('App\Models\Erp\Servicio', 'idServicio', 'servicio_idServicio');    
    }

    public function cliente(){        
      return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');

    }

    
    

    
}
