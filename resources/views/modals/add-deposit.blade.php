<x-mary-modal wire:model="showModal" :title="__('add deposit')">
    <div class="absolute top-4 right-6">
        <x-mary-button @click="$wire.showModal = false" icon="o-x-mark" class="btn-circle btn-ghost" />
    </div>

    <form wire:submit="addDeposit">
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="col-span-2">
                <x-input.group for="deposit_amount" label="{{ __('amount *') }}" :error="$errors->first('deposit_amount')">
                    <x-input wire:model="deposit_amount" id="deposit_amount" />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="details" label="{{ __('details') }}" :error="$errors->first('details')">
                    <x-input.textarea wire:model="details" id="details" rows="3" />
                </x-input.group>
            </div>
        </div>

        <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40" wire:target="addDeposit"
            style="width: 100%; justify-content: center">
            {{ __('submit') }}
        </x-button>
    </form>
</x-mary-modal>
