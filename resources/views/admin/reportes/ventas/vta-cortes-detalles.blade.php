@extends('layouts.admin.app')
@section('title')
   Corte
@endsection

@push('styles')



@endpush
@section('content')
    <div class="content">


        @livewire('admin.reportes.ventas.corte-detalle', ['guid' => $guid])

    </div>
@endsection
@once
    @push('scripts')


    @endpush
  @push('scripts-custom')   
  
@vite(['resources/js/pages/reportes/ventas/corte-detalle.js'])
    @endpush
@endonce
