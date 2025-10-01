@extends('layouts.admin.app')
@section('title')
    Dashboard de Ventas
@endsection

@push('styles')
 {{-- DataTables CSS --}}


    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
.toggle-agencias {
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.toggle-agencias:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.2) !important;
}
</style>
	@endpush

@section('content')
    <div class="content">


      <livewire:admin.dashboards.ventas.ventas-index />


    </div>
@endsection
@once
    @push('scripts')

    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>


@vite(['resources/js/pages/dashboards/ventas/index.js'])

    @endpush
@endonce
