<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
     
      
 protected $table = 'vendedores';

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
        'idVendedor', 'nombreVendedor', 'movil', 'email', 'edo', 'empresa_idEmpresa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

      
    public function empresa()
    { 
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');

    }

     
}
