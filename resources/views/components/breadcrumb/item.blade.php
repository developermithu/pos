@props(['label' => 'label', 'href' => null])

<li>
    <div class="flex items-center">
        <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />

        @if ($href != null)
            <a wire:navigate href="{{ $href }}"
                class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                {{ __($label) }}
            </a>
        @else
            <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                {{ __($label) }}
            </span>
        @endif
    </div>
</li>
