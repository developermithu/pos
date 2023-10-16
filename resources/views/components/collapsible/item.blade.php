@props(['active'])

<li>
    <a @class([
        'flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 capitalize',
        'bg-gray-100 dark:bg-gray-700' => $active,
        'bg-transparent dark:bg-transparent' => !$active,
    ]) wire:navigate {{ $attributes }}>
        {{ $slot }}
    </a>
</li>
