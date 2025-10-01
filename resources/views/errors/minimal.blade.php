<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

      <title> @yield('title') | {{ config('app.name') }}</title>
@cspMetaTag
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <x-layouts.head></x-layouts.head>

    @livewireStyles
    @vite([
        'resources/css/bootstrap.min.css',
        'resources/css/style.css',      
        'resources/js/script.js',
    ])
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @yield('css')
    </head>
<body>
    <x-loader></x-loader>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="error-box mt-5">
				<div class="error-img">
                    <img src="{{ asset('build/img/logos/logo-ferzaor.png') }}"   width="700px" alt="Img">
                </div>
				<h3 class="h2 mb-3">Ups, algo salió mal</h3>
				<p>Error del servidor @yield('code'). Nos disculpamos y estamos solucionando el problema.
                    Por favor, inténtelo de nuevo más tarde.</p>

                
                <a href="{{ route('admin.home') }}" class="btn btn-primary">Volver al Dashboard</a>
			</div>
    </div>
    <!-- /Main Wrapper -->
    <x-layouts.scripts-js></x-layouts.scripts-js>
    @stack('scripts')
    @livewireScripts
</body>
</html>
