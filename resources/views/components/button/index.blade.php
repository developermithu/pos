@props([
    'type' => 'primary',
    'size' => 'default',
    'href' => null,
    'flat' => null,
    'as' => 'submit',
])

@php
    switch ($type) {
        case 'secondary':
            $type = 'text-black/80 bg-transparent border-gray-300 focus:bg-gray-50 focus:ring-primary';
            break;

        case 'danger':
            $type = 'text-white bg-danger/90 hover:bg-danger focus:bg-danger active:bg-danger/90 focus:ring-danger/90 border-transparent';
            break;

        case 'success':
            $type = 'text-white bg-[#059669]/80 hover:bg-[#059669]/90 focus:bg-[#059669]/90 active:bg-[#059669]/80 focus:ring-[#059669]/80 border-transparent';
            break;

        default:
            $type = 'text-white bg-primary/90 hover:bg-primary focus:bg-primary active:bg-primary/90 focus:ring-primary/90 border-transparent';
            break;
    }

    if ($flat) {
        if ($flat === 'primary') {
            $type = 'text-primary hover:underline active:text-primary';
        }

        if ($flat === 'secondary') {
            $type = 'text-gray-500 hover:underline active:text-gray-500';
        }

        if ($flat === 'danger') {
            $type = 'text-danger hover:underline active:text-danger';
        }

        if ($flat === 'warning') {
            $type = 'text-amber-600 hover:underline active:text-amber-600';
        }

        switch ($size) {
            case 'small':
                $size = 'text-xs tracking-normal';
                break;

            case 'large':
                $size = 'text-base tracking-wider';
                break;

            case 'default':
            default:
                $size = 'text-sm tracking-wide';
                break;
        }
    } else {
        switch ($size) {
            case 'small':
                $size = 'px-3 py-1.5 text-xs tracking-wider';
                break;

            case 'large':
                $size = 'px-5 py-2.5 text-base tracking-widest';
                break;

            case 'default':
            default:
                $size = 'px-4 py-2 text-sm tracking-widest';
                break;
        }
    }
@endphp

@if ($href && empty($flat))
    <a wire:navigate href="{{ $href }}"
        class="inline-flex gap-x-1.5 font-semibold capitalize transition ease-in-out rounded items-center active:outline-none active:ring-2 active:ring-offset-2 {{ $size }} {{ $type }}">
        {{ $slot }}
    </a>
@elseif (empty($href) && $flat)
    <button {{ $attributes->merge(['type' => "$as"]) }}
        class="inline-flex items-center font-semibold capitalize transition ease-in-out gap-x-1 focus:underline underline-offset-2 {{ $size }} {{ $type }}">
        {{ $slot }}
    </button>
@elseif ($href && $flat)
    <a wire:navigate href="{{ $href }}"
        class="inline-flex items-center font-semibold capitalize transition ease-in-out gap-x-1 focus:underline {{ $size }} {{ $type }}">
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => "$as"]) }}
        class="inline-flex gap-x-1.5 font-semibold uppercase transition ease-in-out border rounded items-center focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $size }} {{ $type }}">
        {{ $slot }}
    </button>
@endif
