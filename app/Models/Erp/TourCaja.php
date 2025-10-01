<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TourCaja extends Model
{
    protected $table = 'tours_cajas';
protected $connection= 'mysqlerp';
/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idTCaja';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idTCaja', 'folio', 'fechaApertura', 'fechaCierre', 'status', 'user_id',
        'impresora_idImpresora', 'locacion_idLocacion', 'empresa_idEmpresa', 'tour_caja_idTCaja',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function empresa()
    {

        return $this->belongsTo('App\Models\Erp\Empresa', 'empresa_idEmpresa', 'idEmpresa');
    }

    public function cajero()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user_id');
    }

    public function impresora()
    {
        return $this->hasOne('App\Models\Erp\Impresora', 'idImpresora', 'impresora_idImpresora');
    }

    public function ventas()
    {
        return $this->hasMany('App\Models\Erp\TourVenta', 'tour_caja_idTCaja', 'idTCaja');
    }

}
