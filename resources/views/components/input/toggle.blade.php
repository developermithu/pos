@props(['label' => null])

@php
    $name = $attributes->wire('model')->value();
    $error = $errors->has($name) ? $errors->first($name) : null;

    // Remove extra space & make label lowercase
    $label = trim(Str::lower($label));

    // Check if the label contains '*'
    $hasStar = strpos($label, '*') !== false;

    // Remove '*' from the label for translation
    $labelWithoutStar = rtrim($label, ' *');
@endphp

<label x-data="{ isChecked: false }" for="{{ $name }}"
    class="relative h-8 w-14 cursor-pointer rounded-full transition [-webkit-tap-highlight-color:_transparent]"
    :class="{ 'bg-danger': !isChecked, 'bg-primary/80': isChecked }">

    <input {{ $attributes->merge(['type' => 'checkbox']) }} x-model="isChecked" id="{{ $name }}" class="sr-only" />

    <span :class="{ 'text-gray-400 start-0': !isChecked, 'start-6 text-primary': isChecked }"
        class="absolute inset-y-0 inline-flex items-center justify-center m-1 transition-all bg-gray-200 rounded-full size-6">
        <svg xmlns="http://www.w3.org/2000/svg" x-show="!isChecked" class="w-4 h-4" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd" />
        </svg>

        <svg xmlns="http://www.w3.org/2000/svg" x-show="isChecked" class="w-4 h-4" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                clip-rule="evenodd" />
        </svg>
    </span>
</label>