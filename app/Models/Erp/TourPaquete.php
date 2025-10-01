<?php

namespace App\Models\Erp;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

class TourPaquete extends Model
{
    protected $table = 'tours_paquetes';
protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idtourPaquete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'idtourPaquete', 'nombrePaquete', 'slug', 'costo', 'costoMenor',
       'comision1', 'comision2', 'comision3', 'comision4', 'comision5',
        'c_moneda', 'tiempo', 'descripcion', 'conTraslado', 'isTop', 'isTopTen', 
       'showWeb', 'video', 'photoPaquete', 'edo', 'tour_idTour', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function tour()
    {
        return $this->hasOne('App\Models\Erp\Tour', 'idTour', 'tour_idTour');
    }

    public function tarifas()
    {
        return $this->hasMany('App\Models\Erp\TourPaqueteTarifa', 'paquete_idtourPaquete', 'idtourPaquete');
    }

    public function horarios()
    {
        return $this->hasMany('App\Models\Erp\TourPaqueteHorario', 'paquete_idtourPaquete', 'idtourPaquete');
    }

}
