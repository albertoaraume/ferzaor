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
        <x-layouts.header></x-layouts.header>
        <x-layouts.sidebar></x-layouts.sidebar>
        <div class="page-wrapper">
             @yield('content')
            <x-layouts.footer></x-layouts.footer>
        </div>
    </div>

  
  
        <!-- /Main Wrapper -->
    <x-layouts.scripts-js></x-layouts.scripts-js>   
      @stack('scripts') 
    @livewireScripts
    @stack('scripts-custom')   
</body>
</html>
