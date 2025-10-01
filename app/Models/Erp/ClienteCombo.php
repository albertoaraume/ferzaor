<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteCombo extends Model
{
    protected $table = 'clientes_combos';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idclCombo';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'idclCombo', 'nombreClCombo','tarifa',  'porcentaje',  'comision', 'balance', 'c_moneda',  'detalles', 
      'cliente_idCliente', 'combo_idCombo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'created_at', 'updated_at'
    ];


    public function combo(){        
        //return $this->hasOne('App\Models\Erp\Combo', 'idCombo', 'combo_idCombo');   
       return $this->belongsTo('App\Models\Erp\Combo', 'combo_idCombo', 'idCombo');
    }

    public function cliente(){              
      return $this->belongsTo('App\Models\Erp\Cliente', 'cliente_idCliente', 'idCliente');

    }

    public function opciones()
    {
        return $this->hasMany('App\Models\Erp\ClienteComboOpcion', 'idclCombo', 'idclCombo');
    }

    
    

    
}
