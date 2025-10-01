<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class YatePaquete extends Model
{
    protected $table = 'yates_paquetes';
  protected $connection= 'mysqlerp';

/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idytPaquete';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idytPaquete', 'nombrePaquete', 'tipoCosto', 'costo', 
        'c_moneda', 'comisionVendedor', 'comisionSupervisor', 'comisionGerencia', 
        'comisionReserva', 'comisionOtra', 'horas', 'minutos', 'edo', 'libre', 'idYate',
       
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at' 
    ];

     public function yate(){        
          return $this->hasOne('App\Models\Erp\Yate', 'idYate', 'idYate');
      
    }

    public function tarifas()
    {
        return $this->hasMany('App\Models\Erp\YatePaqueteTarifa','idytPaquete', 'idytPaquete');
    }

   

   
}
