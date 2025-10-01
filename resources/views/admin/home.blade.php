@extends('layouts.app')
@section('title')
    Inicio
@endsection
@section('content')

        <div class="content">

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
                <div class="mb-3">
                    <h1 class="mb-1">Bienvenido, {{ auth()->user()->name }}</h1>

                </div>
                <div class="input-icon-start position-relative mb-3">
                    <span class="input-icon-addon fs-16 text-gray-9">
                        <i class="ti ti-calendar"></i>
                    </span>
                    <input type="text" class="form-control date-range bookingrange" placeholder="Search Product">
                </div>
            </div>





        </div>

@endsection
