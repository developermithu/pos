@props(['id', 'label' => 'label'])

<div class="flex items-center">
    <input type="checkbox" id="{{ $id }}"
        {{ $attributes->merge(['class' => 'w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary focus:ring-primary focus:ring-2 dark:focus:ring-primary dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600']) }} />

    <label for="{{ $id }}" class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-100 capitalize">
        {{ $label }}
    </label>
</div>
