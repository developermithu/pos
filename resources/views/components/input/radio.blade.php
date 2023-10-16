@props(['label', 'for'])

<div class="flex items-center mr-4">

    <input type="radio"
        {{ $attributes->merge(['class' => 'w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600']) }}>

    <label for="{{ $for }}" class="ml-2 text-sm font-medium text-gray-900 capitalize dark:text-gray-300">
        {{ $label }}
    </label>

</div>
