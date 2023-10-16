@props(['active'])

<li>
    <a @class([
        'flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 capitalize',
        'bg-gray-100 dark:bg-gray-700' => $active,
        ' bg-transparent dark:bg-transparent' => !$active,
    ]) {{ $attributes }} wire:navigate>

        <div
            class="text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
            {{ $icon }}
        </div>

        <span class="ml-3"> {{ $slot }} </span>
    </a>
</li>
