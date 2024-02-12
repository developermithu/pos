@props(['label'])

@php
    $name = $attributes->wire('model')->value();
    $error = $errors->has($name) ? $errors->first($name) : null;
@endphp

<div>
    <label for="{{ $name }}"> {{ $label }} </label>

    <input type="text" id="{{ $name }}" {{ $attributes }} @class(['border', 'border-danger' => $error])>

    @if ($error)
        <p class="text-sm text-red-500">{{ $error }}</p>
    @endif
</div>

{{-- Uses like mary ui --}}
{{-- <x-input label="name" wire:model="name"> --}}
