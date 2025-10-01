<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReservaT extends Model
{
    protected $table = 'reservas_t';
    protected $connection = 'mysqlerp';
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idRT';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idRT', 'idtTarifa', 'idTT', 'idZonaPickUp', 'nombreZonaPickUp', 'tipoTraslado', 'idZonaDropOff', 'nombreZonaDropOff', 'idLocacionPickUp', 'nombreLocacionPickUp', 'idLocacionDropOff', 'nombreLocacionDropOff', 'fechaArrival', 'horaArrival', 'vueloArrival', 'aerolineaArrival', 'fechaDeparture', 'horaDeparture', 'vueloDeparture', 'aerolineaDeparture', 'cantPax', 'tarifa', 'descuento', 'comision', 'balance', 'c_moneda', 'isCredito', 'detalles', 'reserva_idReserva', 'id_create', 'date_create', 'id_update', 'date_update', 'motivo_update', 'status', 'tipo', 'tipoCancelacion', 'idTransportacion', 'edoFacturado', 'concepto_cfdiConcepto', 'concepto_proveedorConcepto', 'concepto_vendedorConcepto', 'notificacion'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function reserva()
    {
        return $this->hasOne('App\Models\Erp\Reserva', 'idReserva', 'reserva_idReserva');
    }

    public function transportacion()
    {
        return $this->hasOne('App\Models\Erp\Transportacion', 'idTransportacion', 'idTransportacion');
    }

    public function paquete()
    {
        return $this->hasOne('App\Models\Erp\TrasladoTarifa', 'idtTarifa', 'idtTarifa');
    }

    public function cambio()
    {
        return $this->hasOne('App\Models\Erp\ReservaT', 'idRT', 'idRT_cambio');
    }

    public function cupon()
    {
        return $this->hasOne('App\Models\Erp\ReservaCPA', 'idCA', 'idRT')->where('tipo', 'TRA')->where('actual', true)->with('cupon');
    }

    public function pasajeros()
    {
        return $this->hasMany('App\Models\Erp\ReservaP', 'id', 'idRT')->where('tipo', 'TRA');
    }

    public function movimientos()
    {
        return $this->hasMany('App\Models\Erp\ReservaM', 'id', 'idRT')->where('tipo', 'TRA')->with('usuario');
    }

    public function passport()
    {
        return $this->hasOne('App\Models\Erp\Passport', 'id', 'idRT')->where('tipo', 'TRA');
    }

    public function cfdi()
    {
        return $this->hasOne('App\Models\Erp\CFDIConcepto', 'noIdentificacion', 'idRT')->where('tipo', 'TRA')->with('comprobante');
    }

    public function conceptocomision()
    {
        return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_vendedorConcepto');
    }

    public function conceptoproveedor()
    {
        return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_proveedorConcepto');
    }

    public function usernotificacion()
    {
        return $this->hasOne('App\Models\Erp\UserERP', 'id', 'notificacion_idsend');
    }

    public function getisActivoAttribute()
    {
        return !in_array($this->status, [0, 1, 6]);
    }

    public function getFolioReservaDisplayAttribute()
    {
        return Str::upper($this->reserva?->folio) ?? 'Sin Reserva';
    }

    public function getFolioDisplayAttribute()
    {
        return $this->idRT;
    }

    public function getCuponDisplayAttribute()
    {
        // Early return para cupón directo
        return $this->cupon->cupon->cupon ?? '';
    }

    public function getAgenciaDisplayAttribute()
    {
        if ($this->reserva->cliente) {
            return $this->reserva->nombreCliente ?? '';
        }

        // Si no hay agencia, retornar un valor por defecto
        return 'Directa';
    }
    public function getClienteDisplayAttribute()
    {
        return $this->reserva->nombre ?? 'Sin Cliente';
    }

    public function getVendedorDisplayAttribute()
    {
        return $this->reserva->nombreVendedor ?? '';
    }

    public function getTipoDisplayAttribute()
    {
        return $this->tipoTraslado == 'RT' ? 'Redondo' : 'Sencillo';
    }

    public function getPaqueteDisplayAttribute()
    {
        return $this->paquete?->nombrePaquete ?? '';
    }

    public function getPaxDisplayAttribute()
    {
        if ($this->status <= 0 || $this->status == 3) {
            return 0;
        }

        return $this->cantPax ?? 0;
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

    public function getImporteAttribute()
    {
        return $this->balance;
    }

    public function getTotalComisionAttribute()
    {
        if (in_array($this->status, [0, 1, 6])) {
            return 0;
        }
        if ($this->reserva->cobroComision == false) {
            return $this->comision;
        }

        return 0;
    }

    public function getTotalCreditoAttribute()
    {
        if (in_array($this->status, [0, 1, 6])) {
            return 0;
        }

        if ($this->isCredito == true && $this->reserva->cobroComision == false) {
            return $this->balance;
        }

        return 0;
    }

    public function getTarifaDisplayAttribute()
    {
        if (in_array($this->status, [0, 1, 6])) {
            return 0;
        }

        return $this->tarifa;
    }

    public function getTotalBalanceAttribute()
    {
        if (in_array($this->status, [0, 1, 6])) {
            return 0;
        }

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

    /*  public function getPagoBalanceAttribute()
    {
        $importe = 0;
        $pagoBalance = $this->reserva->PagoBalance;

        if ($pagoBalance > 0) {
            $proporcion = $this->TotalBalance / $pagoBalance;
            $importe = $pagoBalance * $proporcion;
        }

        return (float) $importe;
    }*/

    public function getPagosAttribute()
    {
        $importe = 0;
        if ($this->isCredito) {
            $pagoCfdi = $this->cfdi?->comprobante?->ingresos->where('status', '>=', 3)->sum('importe') ?? 0;
            if ($pagoCfdi >= $this->ImporteTotal) {
                $importe += $this->ImporteTotal;
            }
        }

        if (!$this->isCredito) {
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

        if ($this->pagado) {
            return true;
        }

        if ($this->ImporteTotal == 0) {
            return true;
        }

        if ($this->ImporteTotal > 0 && $this->Saldo <= 0) {
            return true;
        }

        // Verificar si hay pago desde factura (CFDI)
        /* if ($this->cfdi?->comprobante?->status == 3) {
            return true;
        }*/

        /*if ($this->isCredito == true) {

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
        if (in_array($this->status, [0, 1, 6])) {
            return '<span class="badge bg-light">N/A</span>';
        }

        // Si está facturada y el status es válido
        if ($this->edoFacturado) {
            $folio = $this->cfdi?->comprobante?->FolioDisplay ?? 'Facturada';
            return '<span class="badge bg-success">' . $folio . '</span>';
        }

        // Por defecto, pendiente
        return '<span class="badge bg-warning">Pendiente</span>';
    }

    public function getBadgePagadaAttribute()
    {
        // Si está cancelada o no show, no aplica
        if (in_array($this->status, [0, 1, 6])) {
            return '<span class="badge bg-light">N/A</span>';
        }

        // Si está pagada
        if ($this->Pagada) {
            return '<span class="badge bg-success">Pagada</span>';
        }

        // Por defecto, pendiente
        return '<span class="badge bg-warning">Pendiente</span>';
    }

    public function scopePagoConcepto($tipo)
    {
        $con = null;
        $link = '';
        $status = 0;
        $color = 'soft-secondary';
        $text = 'Pendiente';

        if ($tipo == 'vendedor') {
            if ($this->conceptocomision != null) {
                $con = $this->conceptocomision;
                $status = $this->conceptocomision->poliza->status;
            }
        } else {
            if ($this->conceptoproveedor != null) {
                $con = $this->conceptoproveedor;
                $status = $this->conceptoproveedor->poliza->status;
            }
        }

        if ($con != null) {
            switch ($con->status) {
                case 0:
                    $color = 'danger';
                    $text = 'Cancelado';
                    break;
                case 1:
                    $color = 'secondary';
                    $text = 'En proceso';
                    break;
                case 2:
                    switch ($status) {
                        case 0:
                            $color = 'danger';
                            $text = 'Pago Cancelado';
                            break;
                        case 1:
                            $color = 'warning';
                            $text = 'En Proceso';
                            break;
                        case 2:
                            $color = 'info';
                            $text = 'Pendiente de Autorización';
                            break;
                        case 3:
                            $color = 'primary';
                            $text = 'Pendiente de Pago';
                            break;
                        case 4:
                            $color = 'success';
                            $text = 'Pagada Parcialmente';
                            break;
                        case 5:
                            $color = 'dark';
                            $text = 'Pagada';
                            break;
                        case 6:
                            $color = 'danger';
                            $text = 'Comprobado';
                            break;
                        case 7:
                            $color = 'info';
                            $text = 'Cerrado';
                    }
                    break;
                case 3:
                    $color = 'success';
                    $text = 'Comprobado';
                    break;
            }
        }

        return '<span class="badge rounded-pill bg-' . $color . '"><i class="ti ti-point-filled me-1"></i>' . $text . '</span>';
    }
}
