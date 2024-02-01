<x-modal maxWidth="{{ $size ?? 'xl' }}" name="create">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 capitalize dark:text-white">
            {{ __('add new unit') }}
        </h3>

        <button type="button" x-on:click="$dispatch('close')"
            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white">
            <x-mary-icon name="o-x-mark" />
            <span class="sr-only">Close modal</span>
        </button>
    </div>

    <!-- Modal body -->
    <form wire:submit="create" class="p-4 md:p-5">
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="col-span-2">
                <x-input.group for="name" label="{{ __('name') }}" :error="$errors->first('form.name')">
                    <x-input wire:model="form.name" id="name" required />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="short_name" label="{{ __('short name') }}" :error="$errors->first('form.short_name')">
                    <x-input wire:model="form.short_name" id="short_name" required />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="unit_id" :label="__('base unit')" :error="$errors->first('form.unit_id')">
                    <x-input.select wire:model="form.unit_id">
                        <option value=""> {{ __('select base unit') }} </option>
                        @foreach (App\Models\Unit::pluck('name', 'id') as $key => $name)
                            <option value="{{ $key }}"> {{ $name }} </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </div>
        </div>

        <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40" wire:target="create"
            style="width: 100%; justify-content: center">
            {{ __('submit') }}
        </x-button>
    </form>
</x-modal>
