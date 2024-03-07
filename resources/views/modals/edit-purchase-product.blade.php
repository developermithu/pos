<x-mary-modal wire:model="productEditModal" :title="__('edit product')" class="backdrop-blur">
    <div class="absolute top-4 right-6">
        <x-mary-button @click="$wire.productEditModal = false" icon="o-x-mark" class="btn-circle btn-ghost" />
    </div>

    <form wire:submit="editProduct">
        <div class="grid grid-cols-6 gap-6">
            <x-input.group label="product type *" :error="$errors->first('type')" class="lg:col-span-3">
                <x-input.select wire:model="type" disabled>
                    <option value="" disabled>-- {{ __('choose product type') }} --</option>
                    @foreach (App\Enums\ProductType::forSelect() as $value => $name)
                        <option value="{{ $value }}"> {{ $name }} </option>
                    @endforeach
                </x-input.select>
            </x-input.group>

            <x-input.group for="cost" label="cost *" :error="$errors->first('cost')" class="lg:col-span-3">
                <x-input type="number" wire:model="cost" id="cost" placeholder="00" disabled />
            </x-input.group>

            <x-input.group label="purchase unit *" :error="$errors->first('purchase_unit_id')" class="lg:col-span-3">
                <x-input.select wire:model="purchase_unit_id" class="!lowercase">
                    <option value="">-- {{ __('choose purchase unit') }} --</option>
                    @foreach ($purchase_units as $key => $name)
                        <option value="{{ $key }}"> {{ $name }} </option>
                    @endforeach
                </x-input.select>
            </x-input.group>

            <div class="col-span-6 mt-2 sm:col-span-full">
                <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40" wire:target="editProduct"
                    style="width: 100%; justify-content: center">
                    {{ __('save') }}
                </x-button>
            </div>
        </div>
    </form>
</x-mary-modal>
