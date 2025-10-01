<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class MembresiaVenta extends Model
{
    protected $table = 'membresias_ventas';

protected $connection= 'mysqlerp';

/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idMV';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idMV', 'guid', 'folio', 'nombre', 'email', 'telefono', 'status', 'membresia_idMembresia', 'porcentaje', 'vigencia',
        'cliente_idCliente', 'vendedor_idVendedor', 'create_id', 'user_id', 'empresa_idEmpresa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function contrato()
    {
        return $this->hasOne('App\Models\Erp\MembresiaVentaContrato', 'membresia_idMV', 'idMV')->where('status', 2);
    }

    public function membresia()
    {
        return $this->hasOne('App\Models\Erp\Membresia', 'idMembresia', 'membresia_idMembresia');
    }

    public function contratos()
    {
        return $this->hasMany('App\Models\Erp\MembresiaVentaContrato', 'membresia_idMV', 'idMV');
    }

    public function agente()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'create_id');
    }

    public function agencia()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');
    }



}
