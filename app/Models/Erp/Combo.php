<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
      protected $table = 'combos';

protected $connection= 'mysqlerp';
   
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCombo';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'idCombo', 'nombreCombo', 'slug', 'tipoCosto', 'costo', 'costoMoneda', 'descripcion',
     'fechaCreacion', 'tarifa', 'c_moneda', 'comisionVendedor', 'comisionSupervisor', 'comisionGerencia', 'edo', 'locacion_idLocacion', 'empresa_idEmpresa', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
      ];


    public function locacion(){                 
      return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
  }

     public function empresa(){                 
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
    }

    public function opciones()
    {
        return $this->hasMany('App\Models\Erp\ComboOpcion','combo_idCombo', 'idCombo');
    }

    public function clientes()
    {
        return $this->hasMany('App\Models\Erp\ClienteCombo','combo_idCombo', 'idCombo');
    }

}
