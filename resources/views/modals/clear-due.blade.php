@php
    if ($data === 'supplier') {
        $subtitle = 'Supplier purchases payments will automatically update and clear based on the input amount. Payments will be recorded in the cashbook account.';
    } elseif ($data === 'customer') {
        $subtitle = 'Customer sales payments will automatically update and clear based on the input amount. Payments will be recorded in the cashbook account.';
    }
@endphp

<x-mary-drawer wire:model="showDrawer" :title="__('clear due')" :subtitle="__($subtitle)" class="w-full md:w-6/12 lg:w-3/12"
    with-close-button separator right>
    <form wire:submit="clearDue">
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="col-span-2">
                <x-input.group for="amount" label="{{ __('amount *') }}" :error="$errors->first('amount')">
                    <x-input wire:model="amount" id="amount" />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="note" label="{{ __('note') }}" :error="$errors->first('note')">
                    <x-input.textarea wire:model="note" id="note" rows="3" />
                </x-input.group>
            </div>
        </div>

        <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40" wire:target="clearDue"
            style="width: 100%; justify-content: center">
            {{ __('submit') }}
        </x-button>
    </form>
</x-mary-drawer>
