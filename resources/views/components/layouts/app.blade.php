{{-- <!DOCTYPE HTML> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="!bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Birthdays') }}</title>

    @stack('head-scripts')

    <!-- Scripts -->

    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Favicon -->
    <link rel="icon" href="{{ url('img/favicon.svg') }}">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    @stack('styles')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>

    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="overflow-x-hidden bg-white">
<div id="app">
    <main class="flex flex-col h-full">
        {{ $slot }}
    </main>
</div>

@livewireScripts

@stack('post-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@yield('scripts')
</body>
</html>
