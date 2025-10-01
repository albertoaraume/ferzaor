<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteVendedor extends Model
{
     
      
 protected $table = 'clientes_vendedores';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idVendedor';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idVendedor', 'nombreVendedor', 'movil', 'email', 'isUser', 'user_id', 'edo', 'cliente_idCliente',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

      
     public function cliente(){                 
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');

    }

     public function locaciones(){     
         return $this->belongsToMany('App\Models\Erp\Locacion', 'clientes_vendedores_locaciones')->withPivot('cliente_vendedor_idVendedor','locacion_idLocacion');
     }

     public function user(){                 
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user_id');

    }
     
}
