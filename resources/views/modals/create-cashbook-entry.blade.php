<x-modal maxWidth="{{ $size ?? 'xl' }}" name="create">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 capitalize dark:text-white">
            {{ __('add new cashbook entry') }}
        </h3>

        <button type="button" x-on:click="$dispatch('close')"
            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white">
            <x-mary-icon name="o-x-mark" />
            <span class="sr-only">Close modal</span>
        </button>
    </div>

    <!-- Modal body -->
    <form wire:submit="create" class="p-4 md:p-5">
        <div class="grid grid-cols-2 gap-5 mb-5">
            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="store_id" label="{{ __('store') }}" :error="$errors->first('form.store_id')">
                    <x-input.select :options="App\Models\Store::pluck('name', 'id')" wire:model="form.store_id" />
                </x-input.group>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="amount" label="{{ __('amount') }}" :error="$errors->first('form.amount')">
                    <x-input wire:model="form.amount" id="amount" placeholder="00" />
                </x-input.group>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="type" label="{{ __('type') }}" :error="$errors->first('form.type')">
                    <x-input.select wire:model="form.type">
                        <option value="" disabled>-- {{ __('select type') }} --</option>
                        @foreach (App\Enums\CashbookEntryType::forSelect() as $value => $name)
                            <option value="{{ $value }}"> {{ $name }} </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="date" label="{{ __('date') }}" :error="$errors->first('form.date')">
                    <x-input type="date" wire:model="form.date" id="date" />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="note" label="{{ __('note') }}" :error="$errors->first('form.note')">
                    <x-input.textarea wire:model="form.note" id="note" rows="3" />
                </x-input.group>
            </div>
        </div>

        <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40" wire:target="create"
            style="width: 100%; justify-content: center">
            {{ __('submit') }}
        </x-button>
    </form>
</x-modal>
