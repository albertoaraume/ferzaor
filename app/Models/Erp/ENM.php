<?php
namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class ENM extends Model
{
    protected $table = 'enm';
    protected $connection= 'mysqlerp';
    
    /**
         * The primary key for the model.
         *
         * @var string
         */
        protected $primaryKey = 'idENM';
    
    
          /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'idENM', 'descripcion', 'c_moneda', 'tarifa', 'locacion_idLocacion', 'empresa_idEmpresa', 'edo',
        ];
    
        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'created_at','updated_at'
        ];
    
    
      public function locacion(){                 
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }
       
}
