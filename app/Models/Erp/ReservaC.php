<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Erp\Combo;
use App\Models\Erp\ClienteCombo;
use App\Models\Erp\IngresoVenta;
use Carbon\Carbon;
use Illuminate\Support\Str;
class ReservaC extends Model
{
    protected $table = 'reservas_c';

    protected $connection = 'mysqlerp';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idRC';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idRC', 'idCombo', 'nombreCombo', 'tarifa', 'descuento', 'comision', 'comisionCompartida', 'balance', 'isCredito', 'c_moneda', 'idLocacion', 'nombreLocacion', 'reserva_idReserva', 'id_create', 'date_create', 'id_update', 'date_update', 'motivo_update', 'status', 'tipo', 'tipoCancelacion', 'tipoDescuento', 'edoFacturado', 'concepto_cfdiConcepto'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function reserva()
    {
        return $this->hasOne('App\Models\Erp\Reserva', 'idReserva', 'reserva_idReserva');
    }

    public function actividades()
    {
        return $this->hasMany('App\Models\Erp\ReservaA', 'reserva_c_idRC', 'idRC')->with('unidades');
    }

    public function cupon()
    {
        return $this->hasOne('App\Models\Erp\ReservaCPA', 'idCA', 'idRC')->where('tipo', 'CMB')->where('actual', true)->with('cupon');
    }

    public function movimientos()
    {
        return $this->hasMany('App\Models\Erp\ReservaM', 'id', 'idRC')->where('tipo', 'CMB')->with('usuario');
    }
    public function comboCliente()
    {
        return $this->belongsTo(ClienteCombo::class, 'idCombo', 'idclCombo')->with('combo.opciones');
    }

    public function comboDirecto()
    {
        return $this->belongsTo(Combo::class, 'idCombo', 'idCombo')->with('opciones');
    }

    // Mantén el accessor pero usando las relaciones
    public function getComboOrigenAttribute()
    {
        if ($this->tipo == 'AG') {
            return $this->comboCliente?->combo;
        }

        return $this->comboDirecto;
    }

    // Scope para eager loading eficiente
    public function scopeWithComboOrigen($query)
    {
        return $query->with(['comboCliente.combo.opciones', 'comboDirecto.opciones']);
    }

    public function cfdi()
    {
        return $this->hasOne('App\Models\Erp\CFDIConcepto', 'c_cfdiConcepto', 'concepto_cfdiConcepto')->with('comprobante');
    }

    public function getFolioReservaDisplayAttribute()
    {
        return Str::upper($this->reserva?->folio) ?? 'Sin Reserva';
    }

    public function getFolioDisplayAttribute()
    {
        return $this->idRC;
    }

    public function getAgenciaDisplayAttribute()
    {
        if ($this->reserva->cliente) {
            return $this->reserva->nombreCliente ?? '';
        }

        // Si no hay agencia, retornar un valor por defecto
        return 'Directa';
    }

    public function getCuponDisplayAttribute()
    {
        return $this->cupon->cupon->cupon ?? '';
    }

    public function getVendedorDisplayAttribute()
    {
        return $this->reserva->nombreVendedor ?? '';
    }

    public function getClienteDisplayAttribute()
    {
        return $this->reserva->nombre ?? 'Sin Cliente';
    }

    public function getComboDisplayAttribute()
    {
        return $this->comboOrigen?->nombreCombo ?? '';
    }

    public function getHotelDisplayAttribute()
    {
        return $this->reserva->nombreHotel ?? 'Sin Hotel';
    }

    public function getLocacionDisplayAttribute()
    {
        return $this->reserva->locacion->nombreLocacion ?? 'Sin Locacion';
    }

    public function getFormaPagoAttribute()
    {
        $pago = IngresoVenta::join('ventas', 'ventas.idVenta', '=', 'ingresos_ventas.venta_idVenta')->join('ventas_reservas', 'ventas_reservas.venta_idVenta', '=', 'ventas.idVenta')->where('ventas.status', '>', 0)->where('ventas_reservas.idReserva', '=', $this->reserva_idReserva)->first();

        if ($pago != null) {
            return $pago->ingreso->descripcionFormaPago;
        } elseif ($this->isCredito == true) {
            return 'Credito';
        }

        return 'Pendiente';
    }

    public function getTotalCreditoAttribute()
    {
        if ($this->isCredito == true && $this->reserva->cobroComision == false) {
            return $this->balance;
        }

        return 0;
    }

    public function getTotalBalanceAttribute()
    {
        if ($this->reserva->cobroComision == true) {
            return $this->balance + $this->comision;
        }

        if ($this->isCredito == false) {
            return $this->balance;
        }

        return 0;
    }

    public function getImporteTotalAttribute()
    {
        return (float) ($this->TotalCredito + $this->TotalBalance);
    }

    public function getPagoCreditoAttribute()
    {
        $importe = 0;
        if ($this->cfdi?->comprobante?->status == 3) {
            $importe = $this->cfdi?->comprobante?->ingresos->where('status', '>=', 3)->sum('importe');
            if ($importe >= $this->TotalCredito) {
                $importe = $this->TotalCredito;
            }
        }
        return (float) $importe;
    }
    /*
       public function getPagoBalanceAttribute()
    {
        $importe = 0;
        $pagoBalance = $this->reserva->PagoBalance;

        if ($pagoBalance > 0) {
            $proporcion = $this->TotalBalance / $pagoBalance;
            $importe = $pagoBalance * $proporcion;
        }

        return (float) $importe;
    }
        */

    public function getPagosAttribute()
    {
        $importe = 0;
        if($this->isCredito){
        $pagoCfdi = $this->cfdi?->comprobante?->ingresos->where('status', '>=', 3)->sum('importe') ?? 0;
        if ($pagoCfdi >= $this->ImporteTotal) {
            $importe += $this->ImporteTotal;
        }
    }
 if(!$this->isCredito){
        $pagoBalance = $this->reserva->PagoBalance;
        if ($pagoBalance > 0) {
            $proporcion = $this->ImporteTotal / $pagoBalance;
            $importe = min($this->ImporteTotal, $pagoBalance * min($proporcion, 1));
        }
    }

        return (float) $importe;
    }

    public function getSaldoAttribute()
    {
        return round($this->ImporteTotal - $this->Pagos, 2);
    }

    public function getPagadaAttribute()
    {
        if (in_array($this->status, [0, 1, 6])) {
            return false;
        }

        if ($this->ImporteTotal == 0) {
            return true;
        }

        if ($this->ImporteTotal > 0 && $this->Saldo <= 0) {
            return true;
        }

        // Verificar si hay pago desde factura (CFDI)
        /*  if ($this->cfdi?->comprobante?->status == 3) {
            return true;
        }*/

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
                $color = 'secondary';
                $text = 'En proceso';
                break;
            case 2:
                $color = 'primary';
                $text = 'Rservado';
                break;
            case 3:
                if ($this->stOrigen == '1') {
                    $color = 'light';
                    $text = 'Original';
                } elseif ($this->stOrigen == '2') {
                    $color = 'light';
                    $text = 'Upgrade';
                } else {
                    $color = 'light';
                    $text = 'Cambio';
                }
                break;
            case 4:
                $color = 'primary';
                $text = 'Upgrade';
                break;
            case 5:
                $color = 'info';
                $text = 'Confirmada';
                break;
            case 6:
                $color = 'dark';
                $text = 'No Show';
                break;
            case 7:
                $color = 'info';
                $text = 'Con Pase';
                break;
            case 8:
                $color = 'info';
                $text = 'En Operación';
                break;
            case 9:
                $color = 'info';
                $text = 'Realizada';
                break;
        }

        return '<span class="badge rounded-pill bg-' . $color . '">' . $text . '</span>';
    }

    public function getBadgeFacturaAttribute()
    {
        // Si está cancelada o no show, no aplica
        if (in_array($this->status, [0, 6])) {
            return '<span class="badge bg-light">N/A</span>';
        }

        // Si está facturada y el status es válido
        if ($this->edoFacturado && $this->status >= 1) {
            $folio = $this->cfdi?->comprobante?->folio ?? 'Facturada';
            return '<span class="badge bg-success">' . $folio . '</span>';
        }

        // Por defecto, pendiente
        return '<span class="badge bg-warning">Pendiente</span>';
    }

    public function getBadgePagadaAttribute()
    {
        // Si está cancelada o no show, no aplica
        if (in_array($this->status, [0, 6])) {
            return '<span class="badge bg-light">N/A</span>';
        }

        // Si está pagada
        if ($this->Pagada) {
            return '<span class="badge bg-success">Pagada</span>';
        }

        // Por defecto, pendiente
        return '<span class="badge bg-warning">Pendiente</span>';
    }
}
