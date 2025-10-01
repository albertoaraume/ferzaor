<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use DB;
class CuentaTerminal extends Model
{
    protected $table = 'cuentas_terminales';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTerminal';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idTerminal', 'numSerie', 'nombreTerminal', 'edo', 'cuenta_idCuenta'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

     public function locaciones(){     
     return $this->belongsToMany('App\Models\Erp\Locacion', 'locaciones_terminales')->withPivot('cuenta_terminal_idTerminal','locacion_idLocacion');
     }

     public function cuenta(){                 
        return $this->hasOne('App\Models\Erp\Cuenta', 'idCuenta', 'cuenta_idCuenta');
    }


   
    public function monedas(){     
        return $this->belongsToMany('App\Models\Erp\Moneda', 'terminales_monedas')->withPivot('cuenta_terminal_idTerminal','moneda_id');
        }
}
