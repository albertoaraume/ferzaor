<?php

namespace App\Models\Erp;

use Illuminate\Database\Eloquent\Model;
use Helper;
use App\Models\Erp\IngresoTour;

class TourVentaPaquete extends Model
{
    protected $table = 'tours_ventas_paquetes';

    protected $connection = 'mysqlerp';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'idTVPaquete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['idTVPaquete', 'folioPre', 'confirmacion', 'tipoTarifa', 'tipoPax', 'tarifa', 'pax', 'descuento', 'comision', 'comisionCompartida', 'balance', 'importe', 'costo', 'c_moneda', 'start', 'status', 'idtourPaquete', 'nombrePaquete', 'isCredito', 'contacto_nombre', 'contacto_email', 'contacto_telefono', 'tiempo', 'created_at', 'updated_at', 'id_update', 'date_update', 'motivo_update', 'tipo', 'tipoCancelacion', 'edoFacturado', 'concepto_cfdiConcepto', 'concepto_proveedorConcepto', 'concepto_vendedorConcepto', 'tour_venta_idTVenta', 'venta_tour_idVT', 'cupon_idCupon', 'locacion_idLocacion', 'version'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    public function tourventa()
    {
        return $this->belongsTo('App\Models\Erp\TourVenta', 'tour_venta_idTVenta', 'idTVenta');
    }

    public function venta()
    {
        return $this->belongsTo('App\Models\Erp\VentaTour', 'venta_tour_idVT', 'idVT');
    }

    public function conceptocomision()
    {
        return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_vendedorConcepto');
    }

    public function conceptoproveedor()
    {
        return $this->hasOne('App\Models\Erp\PolizaConcepto', 'idPC', 'concepto_proveedorConcepto');
    }

    public function paquete()
    {
        return $this->hasOne('App\Models\Erp\TourPaquete', 'idtourPaquete', 'idtourPaquete');
    }

    public function cupon()
    {
        return $this->hasOne('App\Models\Erp\Cupon', 'idCupon', 'cupon_idCupon');
    }

    public function cfdi()
    {
        return $this->hasOne('App\Models\Erp\CFDIConcepto', 'noIdentificacion', 'idTVPaquete')->where('tipo', 'TOUR')->where('edo', true);
    }

    public function locacion()
    {
        return $this->hasOne('App\Models\Erp\Locacion', 'idLocacion', 'locacion_idLocacion');
    }

    public function getTotalVentaAttribute()
    {
        return $this->comision + $this->balance;
    }

    public function getSubTotalAttribute()
    {
        return round($this->TotalVenta / 1.16, 2);
    }

    public function getCostoTotalAttribute()
    {
        return $this->ComisionProveedor + $this->ComisionHotel + $this->ComisionaPagadora + $this->ComisionVendedor + $this->FeeAdmin + $this->FeeSuper;
    }

    public function getComisionTotalAttribute()
    {
        return $this->ComisionProveedor + $this->ComisionHotel + $this->ComisionaPagadora + $this->ComisionVendedor;
    }

    public function getCostoPaxAttribute()
    {
        return $this->tipoPax == 'A' ? $this->paquete->costo : $this->paquete->costoMenor;
    }

    public function getComisionProveedorAttribute()
    {
        return $this->CostoPax * $this->pax;
    }

    public function getComisionHotelAttribute()
    {
        $comisionHotel = 0;

        if ($this->tourventa->locacion_idLocacion == 438) {
            $comisionHotel = round($this->TotalVenta * 0.3, 2);
        } elseif ($this->tourventa->locacion_idLocacion == 454) {
            $comisionHotel = round($this->TotalVenta * 0.05, 2);
        } elseif ($this->tourventa->locacion_idLocacion == 434) {
            $comisionHotel = round(0, 2);
        } elseif ($this->tourventa->locacion_idLocacion == 1) {
            $comisionHotel = round(0, 2);
        } else {
            $comisionHotel = round($this->TotalVenta * 0.15, 2);
        }

        return $comisionHotel;
    }

    public function getFeeAdminAttribute()
    {
        return round($this->Subtotal * 0.02, 2);
    }

    public function getFeeSuperAttribute()
    {
        return round($this->Subtotal * 0.05, 2);
    }

    public function getComisionVendedorAttribute()
    {
        $comision = 0;

        if ($this->status >= 2) {
            if ($this->tourVenta->locacion_idLocacion == 434) {
                $comision = round($this->Subtotal * (10 / 100), 2);
            } elseif ($this->tourVenta->locacion_idLocacion == 438) {
                $comision = round($this->Subtotal * (15 / 100), 2);
            } else {
                if ($this->descuento == 0) {
                    //Sin descuento
                    $comision = round($this->Subtotal * ($this->paquete->comision1 / 100), 2);
                } else {
                    $porcentajeDesc = ($this->descuento * 100) / $this->importe;
                    if ($porcentajeDesc > 0 && $porcentajeDesc <= 9.99 && $this->paquete->comision2 > 0) {
                        // Hasta 9.99
                        $comision = round($this->Subtotal * ($this->paquete->comision2 / 100), 2);
                    } elseif ($porcentajeDesc >= 10 && $porcentajeDesc <= 14.99 && $this->paquete->comision3 > 0) {
                        //Hasta 14.99
                        $comision = round($this->Subtotal * ($this->paquete->comision3 / 100), 2);
                    } elseif ($porcentajeDesc >= 15 && $porcentajeDesc <= 24.99 && $this->paquete->comision4 > 0) {
                        //Hasta 24.99
                        $comision = round($this->Subtotal * ($this->paquete->comision4 / 100), 2);
                    } elseif ($porcentajeDesc >= 25 && $this->paquete->comision5 > 0) {
                        //Mayor a 25
                        $comision = round($this->Subtotal * ($this->paquete->comision5 / 100), 2);
                    }
                }
            }
        }

        return $comision;
    }

    public function getComisionPagadoraAttribute()
    {
        return ($this->FeeAdmin + $this->FeeSuper + $this->ComisionVendedor) / 0.955 - ($this->FeeAdmin + $this->FeeSuper + $this->ComisionVendedor);
    }

    public function getUtilidadAttribute()
    {
        return $this->TotalVenta - ($this->ComisionProveedor + $this->ComisionHotel + $this->ComisionVendedor + $this->ComisionPagadora + $this->FeeAdmin + $this->FeeSuper);
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
                $text = 'Reservado';
                break;
        }

        return '<span class="badge rounded-pill bg-' . $color . '"><i class="ti ti-point-filled me-1"></i>' . $text . '</span>';
    }

    public function getBadgeFacturaAttribute()
    {
        // Si está cancelada o no show, no aplica
        if (in_array($this->status, [0, 1])) {
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
        if (in_array($this->status, [0, 1])) {
            return '<span class="badge bg-light">N/A</span>';
        }

        // Si está pagada
        if ($this->Pagada) {
            return '<span class="badge bg-success">Pagada</span>';
        }

        // Por defecto, pendiente
        return '<span class="badge bg-warning">Pendiente</span>';
    }

    public function getFolioDisplayAttribute()
    {
        return 'TVP-' . $this->idTVPaquete;
    }

    public function getCuponDisplayAttribute()
    {
        // Early return para cupón directo
        return $this->cupon->folio ?? '';
    }

    public function getAgenciaDisplayAttribute()
    {
        if ($this->tourventa->cliente) {
            return $this->tourventa->nombreCliente ?? '';
        }

        // Si no hay agencia, retornar un valor por defecto
        return 'Sin Agencia';
    }

    public function getVendedorDisplayAttribute()
    {
        return $this->tourventa->nombreVendedor ?? '';
    }

    public function getClienteDisplayAttribute()
    {
        return $this->tourventa->nombre ?? 'Sin Cliente';
    }

    public function getLocacionDisplayAttribute()
    {
        return $this->tourventa->locacion->nombreLocacion ?? 'Sin Locación';
    }

    public function getProveedorDisplayAttribute()
    {
        return $this->paquete->tour->proveedor->nombreComercial ?? 'N/A';
    }

    public function getFacturaAttribute()
    {
        if ($this->cfdi != null && $this->cfdi->comprobante->status > 0) {
            return $this->cfdi->comprobante->folio;
        } else {
            return '';
        }
    }
    public function getPagadaAttribute()
    {
        if (in_array($this->status, [0, 1])) {
            return false;
        }

        // Verificar si hay pago desde factura (CFDI)
        if ($this->cfdi?->comprobante?->status == 2) {
            return true;
        }

        return false;
    }

    public function getFormaPagoDisplayAttribute()
    {
        // Busca el ingreso relacionado usando Eloquent si tienes la relación
        $pago = IngresoVenta::join('ventas', 'ventas.idVenta', '=', 'ingresos_ventas.venta_idVenta')->join('ventas_tours', 'ventas_tours.venta_idVenta', '=', 'ventas.idVenta')->where('ventas.status', '>', 0)->where('ventas_tours.tour_venta_idTVenta', '=', $this->tour_venta_idTVenta)->first();

        if ($pago && $pago->ingreso) {
            return $pago->ingreso->descripcionFormaPago;
        }

        if (!empty($this->Pagada) && $this->Pagada == true) {
            return 'Credito';
        }

        if ($this->status == 0) {
            return 'N/A';
        }

        return 'Pendiente';
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
