<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClienteSaldo extends Model
{
    protected $table = 'clientes_saldos';

    protected $fillable = [
        'cliente_id',
        'saldo_actividades_usd',
        'saldo_actividades_mxn',
        'saldo_yates_usd',
        'saldo_yates_mxn',
        'saldo_servicios_usd',
        'saldo_servicios_mxn',
        'saldo_facturas_usd',
        'saldo_facturas_mxn',
        'saldo_total_usd',
        'saldo_total_mxn',
        'total_servicios',
        'detalles',
        'actualizado_en'
    ];

    protected $casts = [
        'detalles' => 'array',
        'actualizado_en' => 'datetime',
        'saldo_actividades_usd' => 'decimal:2',
        'saldo_actividades_mxn' => 'decimal:2',
        'saldo_yates_usd' => 'decimal:2',
        'saldo_yates_mxn' => 'decimal:2',
        'saldo_servicios_usd' => 'decimal:2',
        'saldo_servicios_mxn' => 'decimal:2',
        'saldo_facturas_usd' => 'decimal:2',
        'saldo_facturas_mxn' => 'decimal:2',
        'saldo_total_usd' => 'decimal:2',
        'saldo_total_mxn' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        // Usar la conexión correcta y la primary key del modelo Cliente
        return $this->belongsTo(\App\Models\Erp\Cliente::class, 'cliente_id', 'idCliente');
    }

    public function scopeConSaldo($query)
    {
        return $query->where(function($q) {
            $q->where('saldo_total_usd', '>', 0)
              ->orWhere('saldo_total_mxn', '>', 0);
        });
    }

    public function scopeActualizado($query, $horasMaximas = 24)
    {
        return $query->where('actualizado_en', '>=', now()->subHours($horasMaximas));
    }
}
