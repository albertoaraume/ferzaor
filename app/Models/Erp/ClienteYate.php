<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ClienteYate extends Model
{
    protected $table = 'clientes_yates';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idclYate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idclYate', 'nombreClYate', 'tipoTarifa', 'tarifa', 'pax_maximo', 'pax_adicional', 'porcentaje', 'comision', 'comisionCompartida', 'balance', 'c_moneda', 'idLocacion', 'idCliente', 'idYate', 'idytPaquete', 'idytPaqTarifa', 'edo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function cliente()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'idCliente');

    }

    public function yate()
    {
        return $this->hasOne('App\Models\Erp\Yate', 'idYate', 'idYate');
    }

    public function paquete()
    {
        return $this->hasOne('App\Models\Erp\YatePaquete', 'idytPaquete', 'idytPaquete');
    }

    public function yttarifa()
    {
        return $this->hasOne('App\Models\Erp\YatePaqueteTarifa', 'idytPaqTarifa', 'idytPaqTarifa');

    }

}
