<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class TourPaqueteHorario extends Model
{
	protected $table = 'tours_paquetes_horarios';

protected $connection= 'mysqlerp';
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'idtourpaqHorario';


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'idtourpaqHorario', 'start', 'idLocacion', 'edo', 'paquete_idtourPaquete'
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


	public function locacion()
	{
		return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'idLocacion');
	}
}
