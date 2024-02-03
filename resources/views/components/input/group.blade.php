@props(['label', 'for' => null, 'error' => null])

@php
    // Remove extra space & make label lowercase
    $label = trim(Str::lower($label));

    // Check if the label contains '*'
    $hasStar = strpos($label, '*') !== false;

    // Remove '*' from the label for translation
    $labelWithoutStar = rtrim($label, ' *');
@endphp

<div {{ $attributes->merge(['class' => 'col-span-6 sm:col-span-3']) }}>
    <label for="{{ $for }}" class="block mb-2 text-sm font-medium text-gray-700 capitalize dark:text-gray-300">

        {{ __($labelWithoutStar) }}

        @if ($hasStar)
            <span class="text-red-500">*</span>
        @endif
    </label>

    {{ $slot }}

    @if ($error)
        <div class="mt-1 text-sm text-danger">{{ $error }}</div>
    @endif
</div>
