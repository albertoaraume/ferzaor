<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteSucursal extends Model
{
     protected $table = 'clientes_sucursales';
protected $connection= 'mysqlerp';

/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idcltSucursal';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'nombreSucursal', 'calle', 'estado', 'municipio','localidad', 'contacto', 'telefono', 'email', 'movil', 'c_codigoPostal',
         'numExterior' , 'colonia' , 'numInterior', 'c_pais', 'referencia', 'fechaCreacion',
        'edo', 'cliente_rs_idcltRS',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function razonSocial(){        
          return $this->hasOne('App\Models\Erp\ClienteRS', 'idcltRS', 'cliente_rs_idcltRS');
      
    }

    
}
