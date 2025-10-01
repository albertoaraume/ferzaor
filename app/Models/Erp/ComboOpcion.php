<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ComboOpcion extends Model
{
    protected $table = 'combos_opciones';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idOpcion';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'nombreOpcion', 'pax', 'combo_idCombo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function combo(){        
          return $this->hasOne('App\Models\Erp\Combo', 'idCombo', 'combo_idCombo');      
    }

    public function paquetes()
    {
        return $this->hasMany('App\Models\Erp\ComboOpcionPaquete','combo_opcion_idOpcion', 'idOpcion');
    }
   
}
