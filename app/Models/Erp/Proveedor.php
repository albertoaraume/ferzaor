<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

    protected $table = 'proveedores';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idProveedor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idProveedor', 'rfc', 'razonSocial', 'nombreComercial', 'calle', 'estado', 'municipio', 'localidad', 'c_codigoPostal', 'numExterior', 'colonia',
        'numInterior', 'c_pais', 'referencia', 'contacto', 'telefono', 'email', 'movil', 'fechaCreacion', 'edo', 'diasCredito', 'montoCredito', 'requiereOrden',
        'compras', 'gastos', 'contacto_telefono', 'contacto_email', 'tipoProveedor_idTPro', 'empresa_idEmpresa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function empresa()
    {
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');

    }

    public function tipo()
    {
        return $this->belongsTo('App\Models\Erp\TipoProveedor', 'tipoProveedor_idTPro', 'idTPro');
    }

    public function actividades()
    {
        return $this->hasMany('App\Models\Erp\Actividad', 'proveedor_idProveedor', 'idProveedor');
    }

    public function tours()
    {
        return $this->hasMany('App\Models\Erp\Tour', 'proveedor_idProveedor', 'idProveedor');
    }

    public function yates()
    {
        return $this->hasMany('App\Models\Erp\Yate', 'idProveedor', 'idProveedor');
    }

}
