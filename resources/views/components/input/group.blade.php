@props(['label', 'for', 'error'])

@php
    // Check if the label contains '*'
    $hasStar = strpos($label, '*') !== false;

    // Set required color class for '*'
    $starClass = $hasStar ? 'text-red-500' : '';
@endphp

<div {{ $attributes->merge(['class' => 'col-span-6 sm:col-span-3']) }}>
    <label for="{{ $for }}" class="block mb-2 text-sm font-medium text-gray-700 capitalize dark:text-gray-300">
        @if ($hasStar)
            {!! str_replace('*', '<span class="' . $starClass . '">*</span>', $label) !!}
        @else
            {{ $label }}
        @endif
    </label>

    {{ $slot }}

    @if ($error)
        <div class="mt-1 text-sm text-danger">{{ $error }}</div>
    @endif
</div>
