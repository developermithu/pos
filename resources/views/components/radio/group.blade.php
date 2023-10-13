@props(['error', 'title'])

<div {{ $attributes->merge(['class' => 'col-span-6 sm:col-span-3']) }}>
    <div class="block mb-2 text-sm font-medium text-gray-700 capitalize dark:text-gray-300">
        {{ $title }}
    </div>
    
    <div class="flex flex-wrap">
        {{ $slot }}
    </div>

    @if ($error)
        <div class="mt-1 text-sm text-danger">{{ $error }}</div>
    @endif
</div>
