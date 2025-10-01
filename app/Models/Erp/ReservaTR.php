<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Erp\ReservaCPA;
use App\Models\Erp\CajaCheckin;
use Helper;

class ReservaTR extends Model
{
	protected $table = 'reservas_tours';

protected $connection= 'mysqlerp';
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'idTR';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [


		'idTR', 'idTarifa', 'tarifa', 'nombreTarifa', 'pax', 'descuento', 'comision', 'balance',
		'c_moneda', 'start', 'end', 'color', 'status', 'idopcPaquete', 'idtourPaquete',
		'nombrePaquete', 'tiempo', 'isCredito', 'id_create',
		'date_create', 'id_update', 'date_update', 'motivo_update', 'idTR_cambio', 'tipo',
		'tipoCancelacion', 'tipoDescuento', 'folioDescuento', 'stOrigen', 'idOrigen',
		'edoFacturado', 'concepto_cfdiConcepto', 'concepto_proveedorConcepto', 'concepto_vendedorConcepto'
	];
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'created_at', 'updated_at',
	];



	public function cupon()
	{
		return $this->belongsTo('App\Models\Erp\ReservaCPA',  'idTR', 'idCA')->where('tipo', 'TOUR')->where('actual', true)->with('cupon');
	}


	public function pasajeros()
	{
		return $this->hasMany('App\Models\Erp\ReservaP', 'id', 'idTR')->where('tipo', 'TOUR');
	}


	public function reservasTR()
	{
		return $this->hasMany('App\Models\Erp\ReservaTR', 'idOrigen', 'idTR')->where('stOrigen', '2');
	}


	public function usercreate()
	{
		return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_create');
	}

	public function useredit()
	{
		return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_update');
	}


	public function cambio()
	{
		return $this->hasOne('App\Models\Erp\ReservaTR', 'idTR', 'idTR_cambio');
	}

	public function movimientos()
	{
		return $this->hasMany('App\Models\Erp\ReservaM', 'id', 'idTR')->where('tipo', 'TOUR')->with('usuario');
	}

	public function passport()
	{
		return $this->hasOne('App\Models\Erp\Passport', 'id', 'idTR')->where('tipo', 'TOUR')->where('edo', true);
	}

	public function cfdi()
	{
		return $this->hasOne('App\Models\Erp\CFDIConcepto', 'c_cfdiConcepto', 'concepto_cfdiConcepto')->with('comprobante');
	}

	public function actpaquete()
	{
		return $this->hasOne('App\Models\Erp\ActividadPaquete', 'idactPaquete', 'idactPaquete')->with('actividad');
	}

	public function cmbpaquete()
	{
		return $this->hasOne('App\Models\Erp\ComboOpcionPaquete', 'idopcPaquete', 'idopcPaquete')->with('opcion.combo');
	}


	public function conceptocomision()
	{
		return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_vendedorConcepto');
	}

	public function conceptoproveedor()
	{
		return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_proveedorConcepto');
	}

}
