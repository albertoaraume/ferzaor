<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ActividadPaquete extends Model
{
    protected $table = 'actividades_paquetes';

        protected $connection= 'mysqlerp';

/**
 * The primary key for the model.
 *
 * @var string
 */
    protected $primaryKey = 'idactPaquete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idactPaquete', 'nombrePaquete', 'slug', 'tipoCosto', 'costo',
        'c_moneda', 'comisionVendedor', 'comisionGerencia', 'comisionSupervisor',
        'tiempoMontaje', 'tiempoActivo', 'tiempoDesmontaje', 'descripcion',
        'fechaCreacion', 'libre', 'paxCompartido', 'edo', 'horarioFijo',
        'conTraslado', 'actividad_idActividad',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function actividad()
    {
        return $this->hasOne('App\Models\Erp\Actividad', 'idActividad', 'actividad_idActividad');

    }

    public function tarifas()
    {
        return $this->hasMany('App\Models\Erp\PaqueteTarifa', 'paquete_idactPaquete', 'idactPaquete');
    }

    public function horarios()
    {
        return $this->hasMany('App\Models\Erp\PaqueteHorario', 'paquete_idactPaquete', 'idactPaquete');
    }

}
