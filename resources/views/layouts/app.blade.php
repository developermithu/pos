<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" class="bg-gray-50 dark:bg-gray-800">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (isset($title))
            {{ ucwords(__($title)) }} | Zihad Plastic
        @else
            {{ ucwords(config('app.name')) }} | জিহাদ প্লাস্টিক
        @endif
    </title>

    @include('partials.website-meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- flag icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" />

    @stack('css')

    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/anchor@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarVisible: false }">
    @livewire('layout.navigation')

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('layouts.backend.partials.sidebar')

        {{-- overlay in mobile --}}
        <div x-cloak x-show="sidebarVisible" class="fixed inset-0 z-10 bg-gray-900/50 dark:bg-gray-900/90"></div>

        <div class="relative h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            <main class="lg:min-h-[80vh] min-h-[75vh]">
                {{ $slot }}
            </main>

            <p class="my-5 text-xs text-center text-gray-500 lg:my-10 sm:text-sm">
                © 2024-{{ date('Y') }} Zihad Plastic. Developed by <a href="https://developermithu.com"
                    target="_blank" rel="noopener noreferrer"
                    class="text-teal-600 hover:underline underline-offset-1">Developer Mithu</a>
            </p>
        </div>
    </div>

    <x-mary-toast />

    @stack('js')
</body>

</html>
