@extends('layouts.admin.app')

@section('title', 'Pendientes de Pago')
@section('css')
  <style>
        .saldo-positivo {
            color: #dc3545;
            font-weight: bold;
        }

        .detalle-row {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
        }

        .detalle-item {
            padding: 8px 12px;
            margin: 2px 0;
            border-radius: 4px;
            background-color: #ffffff;
            border-left: 3px solid #dee2e6;
        }

        .detalle-item.actividad {
            border-left-color: #17a2b8;
        }

        .detalle-item.yate {
            border-left-color: #007bff;
        }

        .detalle-item.servicio {
            border-left-color: #28a745;
        }

        .detalle-item.factura {
            border-left-color: #dc3545;
        }

        /* Estilos para las pestañas */
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            border: 1px solid transparent;
            border-radius: 0.375rem 0.375rem 0 0;
            transition: all 0.15s ease-in-out;
        }

        .nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6;
            background-color: #f8f9fa;
        }

        .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
            font-weight: 500;
        }

        .tab-content {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .table-responsive {
            border-radius: 0.375rem;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endsection
@section('content')
    <div class="content">
       @livewire('admin.reportes.estado-cuenta-clientes')
    </div>
@endsection

@once
    @push('scripts')

@vite(['resources/js/pages/reportes/estado-cuenta.js'])
    @endpush
@endonce
