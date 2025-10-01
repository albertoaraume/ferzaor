<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Erp\UserERP;
class ReservaM extends Model
{
     protected $table = 'reservas_m';

protected $connection= 'mysqlerp';
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idRM';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idRM', 'id', 'tipo', 'user', 'date', 'motivo', 'status', 'reserva_idReserva', 
      ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'created_at','updated_at'
    ];

    public function usuario(){        
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user')->select(['id', 'name', 'clave']);
    }

    public function getUsuarioAuthAttribute()
{    
    if ($this->status !== 'Cancelacion') {
        return '';
    }

 
    if (!$this->relationLoaded('usuarioAutenticador')) {
        $this->load('usuarioAutenticador');
    }

    return $this->usuarioAutenticador?->name ?? '';
}


public function usuarioAutenticador()
{
    return $this->hasOneThrough(
        UserERP::class,
        'App\Models\Erp\Autentificador', // Asumiendo que existe este modelo
        'id_registro', // Foreign key en autentificadores
        'id', // Foreign key en users
        'id', // Local key en reservas_m
        'id_auth' // Local key en autentificadores
    )->where('autentificadores.tipo', $this->tipo);
}
   
}
