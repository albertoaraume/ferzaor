<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TourPaqueteTarifa extends Model
{
	protected $table = 'tours_paquetes_tarifas';

protected $connection= 'mysqlerp';
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'idtourpaqTarifa';


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'idtourpaqTarifa', 'titulo', 'detalles', 'edo', 'tarifa', 'c_moneda', 'paquete_idtourPaquete',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function paquete()
	{
		return $this->hasOne('App\Models\Erp\TourPaquete', 'idtourPaquete', 'paquete_idtourPaquete');
	}

	public function locaciones()
	{
		return $this->belongsToMany('App\Models\Erp\Locacion', 'tours_tarifas_locaciones')->withPivot('tour_paquete_tarifa_idtourpaqTarifa', 'locacion_idLocacion');
	}

	public function clientes()
	{
		return $this->hasMany('App\Models\Erp\ClienteTourTarifa', 'tour_paquete_tarifa_idtourpaqTarifa', 'idtourpaqTarifa');
	}
}
