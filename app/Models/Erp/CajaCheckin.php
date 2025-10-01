<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class CajaCheckin extends Model
{
      protected $table = 'cajas_checkins';

      protected $connection= 'mysqlerp';

/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idCheckin';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idCheckin', 'idCaja', 'id', 'tipo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function caja(){                 
        return $this->hasOne('App\Models\Erp\Caja', 'idCaja', 'idCaja');
    }

      public function actividad()
    {
        return $this->belongsTo('App\Models\Erp\ReservaAU', 'id', 'idAU');
    }

    public function yate()
    {
        return $this->belongsTo('App\Models\Erp\ReservaY', 'id', 'idRY');
    }

    public function transportacion()
    {
        return $this->belongsTo('App\Models\Erp\ReservaT', 'id', 'idRT');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Models\Erp\ReservaAD', 'id', 'idAD');
    }

     public function foto()
    {
        return $this->belongsTo('App\Models\Erp\FotoVenta', 'id', 'idFVenta');
    }

}
