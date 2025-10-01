<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteComboOpcion extends Model
{
    protected $table = 'clientes_combos_opciones';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCCO';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCCO', 'idclCombo', 'tarifa', 'comision', 'balance', 'c_moneda',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'created_at', 'updated_at'
    ];


    public function clientecombo(){        
      
       return $this->belongsTo('App\Models\Erp\ClienteCombo', 'idclCombo', 'idclCombo');
    }

    public function opcion(){        
       return $this->belongsTo('App\Models\Erp\ComboOpcion', 'idOpcion', 'idOpcion');
    }


    

    
}
