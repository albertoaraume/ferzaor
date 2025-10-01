<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Erp\VentaReserva;
use App\Models\Erp\IngresoFactura;
use Illuminate\Support\Facades\Log;

class Reserva extends Model
{
    protected $table = 'reservas';

    protected $connection = 'mysqlerp';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idReserva';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idReserva', 'guid', 'folio', 'fechaCompra', 'status', 'nombre', 'email', 'telefono', 'idHotel', 'nombreHotel', 'comentarios', 'alimentos', 'bebidas', 'impuestos', 'idCliente', 'nombreCliente', 'tipoCliente', 'cargoHabitacion', 'idVendedor', 'nombreVendedor', 'showVendedor', 'showServicios', 'impCupon', 'tipoReserva', 'nombretipoReserva', 'c_moneda', 'descripcionMoneda', 'subTotal', 'totalDescuento', 'totalComision', 'totalBalance', 'totalCredito', 'total', 'edo', 'checkin', 'toBlock', 'users_id', 'locacion_idLocacion', 'empresa_idEmpresa', 'created_at', 'updated_at', 'id_update', 'date_update', 'motivo_update', 'aplicaENMAct', 'aplicaENMYat', 'cobroComision'];

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

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function cliente()
    {
        return $this->hasOne('App\Models\Erp\Cliente', 'idCliente', 'idCliente');
    }

    public function vendedor()
    {
        return $this->hasOne('App\Models\Erp\Vendedor', 'idVendedor', 'idVendedor');
    }

    public function moneda()
    {
        return $this->hasOne('App\Models\Erp\Moneda', 'c_moneda', 'c_moneda');
    }

    public function allactividades()
    {
        return $this->hasMany('App\Models\Erp\ReservaA', 'reserva_idReserva', 'idReserva')->with('unidades.cupon');
    }

    public function actividades()
    {
        return $this->hasMany('App\Models\Erp\ReservaA', 'reserva_idReserva', 'idReserva')->where('tipo', 'ACT')->with('unidades.cupon');
    }

    public function tours()
    {
        return $this->hasMany('App\Models\Erp\ReservaTR', 'reserva_idReserva', 'idReserva')->with('cupon');
    }

    public function combos()
    {
        return $this->hasMany('App\Models\Erp\ReservaC', 'reserva_idReserva', 'idReserva')->with('cupon')->with('actividades.unidades.unidad');
    }

    public function traslados()
    {
        return $this->hasMany('App\Models\Erp\ReservaT', 'reserva_idReserva', 'idReserva');
    }

    public function yates()
    {
        return $this->hasMany('App\Models\Erp\ReservaY', 'reserva_idReserva', 'idReserva')->with('cupon');
    }

    public function agente()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'users_id');
    }

    public function cupones()
    {
        return $this->hasMany('App\Models\Erp\ReservaCP', 'reserva_idReserva', 'idReserva')->with('ticket');
    }

    public function adicionales()
    {
        return $this->hasMany('App\Models\Erp\ReservaAD', 'reserva_idReserva', 'idReserva');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Erp\ReservaPayMent', 'reserva_idReserva', 'idReserva');
    }

    public function ventasReserva()
    {
        return $this->hasMany(VentaReserva::class, 'idReserva', 'idReserva')->where('edo', true);
    }

    public function getFacturasRelacionadasAttribute()
{
    $facturas = collect();

    // Actividades
    foreach ($this->actividades as $actividad) {
       /* if ($actividad->cfdi) {
            $facturas->push($actividad->cfdi);
        }*/
        // Si las unidades también tienen CFDI
        foreach ($actividad->unidades as $unidad) {
            if ($unidad->cfdi) {
                $facturas->push($unidad->cfdi);
            }
        }
    }

    // Combos
    foreach ($this->combos as $combo) {
        if ($combo->cfdi) {
            $facturas->push($combo->cfdi);
        }
        /*foreach ($combo->actividades as $actividad) {
            foreach ($actividad->unidades as $unidad) {
                if ($unidad->cfdi) {
                    $facturas->push($unidad->cfdi);
                }
            }
        }*/
    }

    // Traslados
    foreach ($this->traslados as $traslado) {
        if ($traslado->cfdi) {
            $facturas->push($traslado->cfdi);
        }
    }

    // Yates
    foreach ($this->yates as $yate) {
        if ($yate->cfdi) {
            $facturas->push($yate->cfdi);
        }
    }

    // Adicionales
    foreach ($this->adicionales as $adicional) {
        if ($adicional->cfdi) {
            $facturas->push($adicional->cfdi);
        }
    }

    // Opcional: eliminar duplicados por folio o id
    return $facturas->unique('idComprobante');
}

   
    #region Metodos para calcular saldos y pagos

      public function getTotalComisionAttribute()
    {
        $comision = 0;
        $actividades = $this->allactividades();
        $actividades->each(function ($actividad) use (&$comision) {
            $comision += $actividad->unidades
                ->filter(function ($unidad) {
                    return $unidad->isActivo == true;
                })
                ->sum(function ($unidad) {
                    return $unidad->TotalComision;
                });
        });

        $yates = $this->yates;
        $yates->each(function ($yate) use (&$comision) {
            $comision += $yate->isActivo ? $yate->TotalComision : 0;
        });

        $traslados = $this->traslados;
        $traslados->each(function ($traslado) use (&$comision) {
            $comision += $traslado->isActivo ? $traslado->TotalComision : 0;
        });

        $adicionales = $this->adicionales;
        $adicionales->each(function ($adicional) use (&$comision) {
            $comision += $adicional->isActivo ? $adicional->TotalComision : 0;
        });

        return (float) $comision;
    }

    public function getTotalCreditoAttribute()
    {
        $credito = 0;
        $actividades = $this->allactividades();
        $actividades->each(function ($actividad) use (&$credito) {
            $credito += $actividad->unidades
                ->filter(function ($unidad) {
                    return $unidad->isActivo == true;
                })
                ->sum(function ($unidad) {
                    return $unidad->TotalCredito;
                });
        });

        $yates = $this->yates;
        $yates->each(function ($yate) use (&$credito) {
            $credito += $yate->isActivo ? $yate->TotalCredito : 0;
        });

        $traslados = $this->traslados;
        $traslados->each(function ($traslado) use (&$credito) {
            $credito += $traslado->isActivo ? $traslado->TotalCredito : 0;
        });

        $adicionales = $this->adicionales;
        $adicionales->each(function ($adicional) use (&$credito) {
            $credito += $adicional->isActivo ? $adicional->TotalCredito : 0;
        });

        return (float) $credito;
    }

    public function getTotalBalanceAttribute()
    {
        $balance = 0;
        $actividades = $this->allactividades();
        $actividades->each(function ($actividad) use (&$balance) {
            $balance += $actividad->unidades
                ->filter(function ($unidad) {
                    return $unidad->isActivo == true;
                })
                ->sum(function ($unidad) {
                    return $unidad->TotalBalance;
                });
        });

        $yates = $this->yates;
        $yates->each(function ($yate) use (&$balance) {
            $balance += $yate->isActivo ? $yate->TotalBalance : 0;
        });

        $traslados = $this->traslados;
        $traslados->each(function ($traslado) use (&$balance) {
            $balance += $traslado->isActivo ? $traslado->TotalBalance : 0;
        });

        $adicionales = $this->adicionales;
        $adicionales->each(function ($adicional) use (&$balance) {
            $balance += $adicional->isActivo ? $adicional->TotalBalance : 0;
        });

        return (float) $balance;
    }

    public function getImporteTotalAttribute()
    {
        return (float) ($this->TotalCredito + $this->TotalBalance);
    }

    public function getPagoCreditoAttribute()
    {
        $credito = 0;
        $actividades = $this->actividades;
        $actividades->each(function ($actividad) use (&$credito) {
            $credito += $actividad->unidades
                ->filter(function ($unidad) {
                    return $unidad->isActivo == true;
                })
                ->sum(function ($unidad) {
                    return $unidad->PagoCredito;
                });
        });

        $yates = $this->yates;
        $yates->each(function ($yate) use (&$credito) {
            $credito += $yate->isActivo ? $yate->PagoCredito : 0;
        });

        $combos = $this->combos;
        $combos->each(function ($combo) use (&$credito) {
            $credito += $combo->isActivo ? $combo->PagoCredito : 0;
        });

        $traslados = $this->traslados;
        $traslados->each(function ($traslado) use (&$credito) {
            $credito += $traslado->isActivo ? $traslado->PagoCredito : 0;
        });

        $adicionales = $this->adicionales;
        $adicionales->each(function ($adicional) use (&$credito) {
            $credito += $adicional->isActivo ? $adicional->PagoCredito : 0;
        });

        return (float) $credito;
    }

      public function getPagoBalanceAttribute()
    {
        return (float) $this->ventasReserva->where('edo', true)->sum('importe');
    }

        public function getSaldoAttribute()
    {
        $pagoTotal = $this->PagoCredito + $this->PagoBalance;
        return (float) bcdiv($this->ImporteTotal - $pagoTotal, '1', 2);
    }


    #endregion

    // Método para verificar si está completamente pagada
    public function getPagadaAttribute()
    {
        return $this->Saldo <= 0;
    }




    // Método para obtener badge HTML del status
    public function getBadgePagadaAttribute()
    {
                $color = 'danger';
                $text = 'Pendiente';
           
          if($this->Pagada){
                $color = 'success';
                $text = 'Pagada';          
            }

        return '<span class="badge bg-' . $color . '"><i class="ti ti-point-filled me-1"></i> ' . $text . '</span>';
    }

    public function getBadgeAttribute()
    {
        switch ($this->edo) {
            case 0:
                $color = 'danger';
                $text = 'Cancelada';
                break;
            case 1:
                $color = 'warning';
                $text = 'En Proceso';
                break;
            case 2:
                $color = 'success';
                $text = 'Activa';
                break;
        }

        return '<span class="badge bg-' . $color . '">' . $text . '</span>';
    }

    public function getBadgeCheckInAttribute()
    {
        $color = 'warning';
        $text = 'Pendiente';
        if ($this->checkin) {
            $color = 'success';
            $text = 'Realizado';
        }

        return '<span class="badge bg-' . $color . '">' . $text . '</span>';
    }
}
