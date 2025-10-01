@extends('layouts.admin.app')
@section('title')
   Reserva
@endsection

@push('styles')



@endpush
@section('content')
    <div class="content">


        @livewire('admin.ventas.reservas.reservas-detalles', ['guid' => $guid])

    </div>
@endsection
@once
    @push('scripts')


    @endpush
 @push('scripts-custom')

    @endpush
@endonce

            <!-- Componente Livewire -->


