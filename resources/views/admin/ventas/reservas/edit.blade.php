@extends('layouts.admin.app')

@section('title', 'Editar Reserva')

@section('content')
 <div class="content">
    <livewire:admin.ventas.reservas.reserva-editar :guid="$guid" />

    </div>
@endsection
@once
    @push('scripts')


    @endpush
 @push('scripts-custom')

    @endpush
@endonce
