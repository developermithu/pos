<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ucwords($title ?? config('app.name')) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @filamentStyles
    @stack('css')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-800" x-data="{ sidebarVisible: false }">
    @livewire('layout.navigation')

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('layouts.backend.partials.sidebar')

        {{-- overlay in mobile --}}
        <div x-cloak x-show="sidebarVisible" class="fixed inset-0 z-10 bg-gray-900/50 dark:bg-gray-900/90"></div>

        <div class="relative h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">

            <main>
                {{ $slot }}
            </main>
            
        </div>
    </div>

    @stack('js')
    @filamentScripts
</body>

</html>
