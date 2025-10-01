<?php
namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table = 'formasPago';
    
    protected $connection= 'mysqlerp';
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idformaPago';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
             'nombreFormaPago', 'c_formaPago', 'reserva', 'ingreso', 'egreso'
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            
        ];
    
    
       
       
}
