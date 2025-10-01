@extends('layouts.admin.app')
@section('title')
    Rerporte de ENM's
@endsection

@push('styles')
 <style>
        .progress {
            border-radius: 10px;
        }

        .card-title {
            color: #495057;
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

          /* Estilos específicos para las tarjetas de resumen con gradientes */
    .tarjeta-resumen {
        border-radius: 15px !important;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out !important;
        border: none !important;
        position: relative;
        overflow: hidden;
        color: white !important;
    }

    .tarjeta-pasajeros {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    .tarjeta-pagaron {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
    }

    .tarjeta-no-pagaron {
        background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%) !important;
    }

    .tarjeta-ingresos {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%) !important;
    }

    .tarjeta-resumen:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25) !important;
    }

    /* Forzar color blanco en todos los elementos de las tarjetas */
    .tarjeta-resumen,
    .tarjeta-resumen h3,
    .tarjeta-resumen p,
    .tarjeta-resumen small,
    .tarjeta-resumen i {
        color: white !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) !important;
    }

    .tarjeta-resumen .opacity-85 {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    /* Animaciones escalonadas para las tarjetas */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .col-md-3:nth-child(1) .tarjeta-resumen {
        animation: slideInUp 0.6s ease-out 0.1s both;
    }

    .col-md-3:nth-child(2) .tarjeta-resumen {
        animation: slideInUp 0.6s ease-out 0.2s both;
    }

    .col-md-3:nth-child(3) .tarjeta-resumen {
        animation: slideInUp 0.6s ease-out 0.3s both;
    }

    .col-md-3:nth-child(4) .tarjeta-resumen {
        animation: slideInUp 0.6s ease-out 0.4s both;
    }

    /* Estilos para el progreso general */
    .progress-bar-custom {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        border-radius: 15px !important;
    }

    /* Otros estilos generales */
    .bg-pink {
        background-color: #e91e63 !important;
    }

    .cursor-pointer {
        cursor: pointer;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 1.5s ease-in-out;
    }

    .card-header:hover {
        background-color: #f8f9fa !important;
    }

    /* Estilos para los modales */
    .modal-xl {
        max-width: 1200px;
    }

    .table-success {
        --bs-table-bg: rgba(25, 135, 84, 0.1);
    }

    .table-warning {
        --bs-table-bg: rgba(255, 193, 7, 0.1);
    }

    .modal-header.bg-info {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .modal-header.bg-warning {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    /* Estilos para la tabla de pasajeros */
    .modal .table th {
        border-bottom: 2px solid #dee2e6;
    }

    .modal .table td {
        vertical-align: middle;
    }

    .modal .card-body p {
        margin-bottom: 0.5rem;
    }

    .modal .progress {
        height: 8px;
    }

    /* Estilos adicionales para cards */
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .badge {
        border-radius: 8px;
        font-weight: 600;
    }

    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Efectos para las cards de distribución */
    .card.border-0:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out;
    }

    /* Animación para la barra de progreso */
    .progress-bar-animated {
        animation: progress-bar-stripes 1s linear infinite;
    }

    /* Mejores colores para los badges */
    .badge.bg-success {
        background: linear-gradient(45deg, #28a745, #20c997) !important;
    }

    .badge.bg-warning {
        background: linear-gradient(45deg, #ffc107, #fd7e14) !important;
    }

    .badge.bg-primary {
        background: linear-gradient(45deg, #007bff, #6f42c1) !important;
    }

    .badge.bg-danger {
        background: linear-gradient(45deg, #dc3545, #e83e8c) !important;
    }

    .badge.bg-info {
        background: linear-gradient(45deg, #17a2b8, #6f42c1) !important;
    }

    /* Responsivo para dispositivos móviles */
    @media (max-width: 768px) {
        .modal-xl {
            max-width: 95%;
        }

        .modal .table-responsive {
            font-size: 0.875rem;
        }

        .tarjeta-resumen h3 {
            font-size: 1.5rem !important;
        }

        .tarjeta-resumen p {
            font-size: 0.875rem !important;
        }

        .tarjeta-resumen {
            padding: 1rem !important;
        }
    }

    /* Animaciones suaves globales */
    .card,
    .btn,
    .progress-bar {
        transition: all 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
    }

    /* Efecto especial de brillo en hover para las tarjetas de resumen */
    .tarjeta-resumen::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.8s ease;
        z-index: 1;
    }

    .tarjeta-resumen:hover::before {
        left: 100%;
    }

    .tarjeta-resumen>* {
        position: relative;
        z-index: 2;
    }

    /* Estilos para íconos específicos */
    .tarjeta-resumen i.fa-users {
        color: rgba(255, 255, 255, 0.95) !important;
    }

    .tarjeta-resumen i.fa-check-circle {
        color: rgba(255, 255, 255, 0.95) !important;
    }

    .tarjeta-resumen i.fa-times-circle {
        color: rgba(255, 255, 255, 0.95) !important;
    }

    .tarjeta-resumen i.fa-dollar-sign {
        color: rgba(255, 255, 255, 0.95) !important;
    }
    </style>
	@endpush

@section('content')
    <div class="content">

          @livewire('admin.reportes.ventas.vta-enms')


    </div>
@endsection
@once
    @push('scripts')

@vite(['resources/js/pages/reportes/ventas/enm.js'])
    @endpush
@endonce

            <!-- Componente Livewire -->

