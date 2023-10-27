@props([
    'type' => 'primary',
    'size' => 'default',
    'href' => null,
    'flat' => null,
])

@php
    switch ($type) {
        case 'secondary':
            $type = 'text-black bg-secondary hover:bg-secondary/90 focus:bg-secondary/90 active:bg-secondary focus:ring-secondary';
            break;

        case 'danger':
            $type = 'text-white bg-danger/90 hover:bg-danger focus:bg-danger active:bg-danger/90 focus:ring-danger/90';
            break;

        case 'success':
            $type = 'text-white bg-[#059669]/80 hover:bg-[#059669]/90 focus:bg-[#059669]/90 active:bg-[#059669]/80 focus:ring-[#059669]/80';
            break;

        case 'primary':
        default:
            $type = 'text-white bg-primary/90 hover:bg-primary focus:bg-primary active:bg-primary/90 focus:ring-primary/90';
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
        class="inline-flex gap-x-1.5 {{ $size }} {{ $type }} font-semibold capitalize transition ease-in-out rounded items-center active:outline-none active:ring-2 active:ring-offset-2">
        {{ $slot }}
    </a>
@elseif (empty($href) && $flat)
    <button {{ $attributes->merge(['type' => 'submit']) }}
        class="inline-flex gap-x-1 {{ $size }} {{ $type }} font-semibold capitalize transition focus:underline underline-offset-2 ease-in-out items-center">
        {{ $slot }}
    </button>
@elseif ($href && $flat)
    <a wire:navigate href="{{ $href }}"
        class="inline-flex gap-x-1 {{ $size }} {{ $type }} font-semibold capitalize focus:underline transition ease-in-out items-center">
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit']) }}
        class="inline-flex gap-x-1.5 {{ $size }} {{ $type }} font-semibold uppercase transition ease-in-out border border-transparent rounded items-center focus:outline-none focus:ring-2 focus:ring-offset-2">
        {{ $slot }}
    </button>
@endif
