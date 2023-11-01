@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'type' => 'text',
        'class' =>
            'shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-md focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary disabled:bg-slate-100 disabled:cursor-not-allowed disabled:dark:bg-slate-800 dark:focus:border-primary',
    ]) }}>
