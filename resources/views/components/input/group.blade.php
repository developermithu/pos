@props(['label', 'for', 'error'])

<div {{ $attributes->merge(['class' => 'col-span-6 sm:col-span-3']) }}>
    <label for="{{ $for }}" class="block mb-2 text-sm font-medium text-gray-700 capitalize dark:text-gray-300">
        {{ $label }}
    </label>

    {{ $slot }}

    @if ($error)
        <div class="mt-1 text-sm text-danger">{{ $error }}</div>
    @endif
</div>
