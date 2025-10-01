<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $table = 'clientes';

    protected $connection= 'mysqlerp';
 
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idCliente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombreComercial',
        'contacto', 'telefono', 'email', 'movil', 'tipo', 'showVendedor', 'cargoHabitacion', 'showServicios',
        'showUpgrade', 'showDescuento', 'cobroComision', 'showLibre', 'porcentaje', 'diasCredito',
        'montoCredito', 'notas', 'isProspecto', 'impCupon', 'edo', 'fechaCreacion',
        'empresa_idEmpresa', 'user_id',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\Erp\UserERP', 'users_empresas')->withPivot('empresa_idEmpresa', 'user_id');
    }

    public function empresa()
    {
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');

    }

    /*public function sucursales()
    {
        return $this->hasMany('App\Models\Erp\ClienteSucursal', 'cliente_idCliente', 'idCliente');
    }*/

    public function tarifas()
    {
        return $this->hasMany('App\Models\Erp\ClienteTarifa', 'cliente_idCliente', 'idCliente');
    }

    public function combos()
    {
        return $this->hasMany('App\Models\Erp\ClienteCombo', 'cliente_idCliente', 'idCliente');
    }

    public function servicios()
    {
        return $this->hasMany('App\Models\Erp\ClienteServicio', 'cliente_idCliente', 'idCliente');
    }
    
    public function membresias()
    {
        return $this->hasMany('App\Models\Erp\ClienteMembresia', 'cliente_idCliente', 'idCliente');
    }

    public function cupones()
    {
        return $this->hasMany('App\Models\Erp\ClienteCupon', 'cliente_idCliente', 'idCliente');
    }
}
