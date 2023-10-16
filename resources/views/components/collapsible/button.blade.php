<button @click="expanded = !expanded" type="button"
    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">

    <div
        class="flex-shrink-0 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
        {{ $icon }}
    </div>

    <span class="flex-1 ml-3 text-left capitalize whitespace-nowrap">
        {{ $slot }}
    </span>

    <x-heroicon-m-chevron-down class="w-6 h-6" />
</button>
