<nav class="flex order-2">
    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
        <li class="inline-flex items-center">
            <a wire:navigate href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center text-gray-400 capitalize hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                <x-heroicon-m-home class="mr-2.5 w-5 h-5 text-gray-400" />
                {{ __('dashboard') }}
            </a>
        </li>
        
        {{ $slot }}
        
    </ol>
</nav>
