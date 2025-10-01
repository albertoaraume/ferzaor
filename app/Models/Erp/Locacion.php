<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Locacion extends Model
{
    protected $table = 'locaciones';
protected $connection= 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idLocacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idLocacion', 'nombreLocacion',
         'alias', 'clave', 'contacto', 'telefono',
          'email', 'fechaCreacion', 'lon', 'lat',
           'isHotel', 'c_pais', 'edo', 'monday', 'monday1',
            'monday2', 'monday3', 'monday4', 'tuesday',
             'tuesday1', 'tuesday2', 'tuesday3', 'tuesday4', 
             'wednesday', 'wednesday1', 'wednesday2', 'wednesday3',
              'wednesday4', 'thursday', 'thursday1', 'thursday2', 
              'thursday3', 'thursday4', 'friday', 'friday1', 'friday2',
               'friday3', 'friday4', 'saturday', 'saturday1', 'saturday2',
                'saturday3', 'saturday4', 'sunday', 'sunday1', 'sunday2', 
                'sunday3', 'sunday4', 'backgroundColor', 'borderColor', 'zona_idZona',
                 'destino_idDestino', 'impTickets', 'impRetiro', 'impCuponFoto', 
                 'impCuponTour', 'impCuponCredit', 'impCuponRest', 'impPassports', 
                 'impCupon', 'showCheckIn', 'showPOS', 'showPassports', 'reimpPassport',
                  'fpEfectivo', 'fpTarjeta', 'fpTransferencia',
         'fpBillpocket', 'fpPaypal', 'comisionSD', 'comisionMenor', 'comisionMayor',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function empresa()
    {
        return $this->hasOne('App\Models\Erp\Empresa', 'idEmpresa', 'empresa_idEmpresa');
    }

    public function zona()
    {
        return $this->hasOne('App\Models\Erp\Zona', 'idZona', 'zona_idZona');
    }

    public function destino()
    {
        return $this->hasOne('App\Models\Erp\Destino', 'idDestino', 'destino_idDestino');
    }

    public function actividades()
    {
        return $this->hasMany('App\Models\Erp\Actividad', 'locacion_idLocacion', 'idLocacion');
    }

    public function unidades()
    {
        return $this->hasMany('App\Models\Erp\Unidad', 'locacion_idLocacion', 'idLocacion');
    }

    public function usuarios()
    {
        return $this->belongsToMany('App\Models\Erp\UserERP', 'users_l')->withPivot('locacion_idLocacion', 'user_id');
    }

    public function impresoras()
    {
        return $this->belongsToMany('App\Models\Erp\Impresora', 'locaciones_impresoras')->withPivot('locacion_idLocacion', 'impresora_idImpresora');
    }

    public function monedas()
    {
        return $this->belongsToMany('App\Models\Erp\Moneda', 'locaciones_monedas')->withPivot('locacion_idLocacion', 'moneda_id');
    }

    public function modulos()
    {
        return $this->hasMany('App\Models\Erp\LocacionModulo', 'locacion_idLocacion', 'idLocacion');
    }
}
