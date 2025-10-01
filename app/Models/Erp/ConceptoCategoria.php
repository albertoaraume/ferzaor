<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ConceptoCategoria extends Model
{
	protected $table = 'cat_conceptos_categorias';

protected $connection= 'mysqlerp';
	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'idCCategoria';


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'idCCategoria', 'nombreCCategoria', 'concepto_idConcepto'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
}
