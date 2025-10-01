<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
      protected $table = 'ingresos';

protected $connection= 'mysqlerp';
    
/**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idIngreso';


      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idIngreso', 'folio', 'referencia', 'user_id', 'comentarios', 
    'importe', 'comision', 'total', 'c_moneda', 'fechaAplica', 'fechaRegistro',
     'cliente_idCliente', 'cuenta_idCuenta', 'cuenta_terminal_idTerminal', 
     'c_formaPago', 'descripcionFormaPago', 'tipoCambio', 'status', 'id_cancela', 
     'date_cancela', 'motivo_cancela', 'id_valida', 'date_valida', 'id_auth', 'caja_idCaja', 
     'tipoIngreso', 'locacion_idLocacion', 'archivo', 'empresa_sucursal_idempSucursal',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


  
    public function cajero(){                 
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'user_id');
    }

    public function usercancela(){                 
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_cancela');
    }

    public function userauth()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_auth');
    }
    public function uservalida()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'id_valida');
    }

    

   /* public function caja(){                 
        return $this->hasOne('App\Models\Erp\Caja', 'idCaja', 'caja_idCaja');
    }*/

    public function cliente(){                 
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'cliente_idCliente');
    }

    public function cuenta(){                 
        return $this->belongsTo('App\Models\Erp\Cuenta', 'cuenta_idCuenta', 'idCuenta');
    }
     public function sucursal(){                 
        return $this->belongsTo('App\Models\Erp\EmpresaSucursal', 'empresa_sucursal_idempSucursal', 'idempSucursal');
    }

    public function locacion()
    {
        return $this->belongsTo('App\Models\Erp\Locacion', 'locacion_idLocacion', 'idLocacion');
    }

    public function terminal(){                 
        return $this->hasOne('App\Models\Erp\CuentaTerminal', 'idTerminal', 'cuenta_terminal_idTerminal');
    }


    public function venta()
    {
        return $this->hasOne('App\Models\Erp\IngresoVenta',  'ingreso_idIngreso', 'idIngreso');
    }


    public function facturas(){                 
        return $this->hasMany('App\Models\Erp\IngresoFactura', 'ingreso_idIngreso', 'idIngreso');
    }

    public function conceptos(){                 
        return $this->hasMany('App\Models\Erp\IngresoConcepto', 'ingreso_idIngreso', 'idIngreso');
    }


    public function polizas(){                 
        return $this->hasMany('App\Models\Erp\IngresoPoliza', 'ingreso_idIngreso', 'idIngreso');
    }

    public function membresias(){                 
        return $this->hasMany('App\Models\Erp\IngresoMembresia', 'ingreso_idIngreso', 'idIngreso');
    }

    public function tours(){                 
        return $this->hasMany('App\Models\Erp\IngresoTour', 'ingreso_idIngreso', 'idIngreso');
    }

    public function ventas(){                 
        return $this->hasMany('App\Models\Erp\IngresoVenta', 'ingreso_idIngreso', 'idIngreso');
    }

       public function getSelectAttribute(){
        return false;
        }

    public function getBadgeAttribute()
    {
        switch ($this->status) {
            case 0:
                $color = 'danger';
                $text = 'Cancelada';
                break;
            case 1:
                $color = 'dark';
                $text = 'En Proceso';
                break;
            case 2:
                $color = 'success';
                $text = 'Activa';
                break;
              case 3:
                $color = 'warning';
                $text = 'Sin Confirma';
                break;
              case 4:
                $color = 'success';
                $text = 'Confirmada';
                break;
      
        }

   
        return '<span class="badge bg-' . $color . '">' . $text . '</span>';
    }
   
}
