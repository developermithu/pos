@props(['id', 'label' => 'label', 'name' => ''])

<div class="flex items-center">
    <input id="{{ $id }}" name="{{ $name }}" type="radio"
        {{ $attributes->merge(['class' => 'w-4 h-4 text-primary bg-gray-100 border-gray-300 focus:ring-primary/90 dark:focus:ring-primary dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500']) }}>

    <label for="{{ $id }}" class="w-full ml-3 text-sm font-medium text-gray-900 dark:text-gray-100 capitalize">
        {{ $label }}
    </label>
</div>
