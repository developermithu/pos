<x-modal maxWidth="{{ $size ?? 'xl' }}" name="create">
    <!-- Modal header -->
    <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 capitalize dark:text-white">
            {{ __('add new money transfer') }}
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
            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="from_account_id" label="{{ __('from account *') }}" :error="$errors->first('from_account_id')">
                    <x-input.select wire:model="from_account_id" :options="App\Models\Account::active()->pluck('name', 'id')" id="from_account_id" />
                </x-input.group>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <x-input.group for="to_account_id" label="{{ __('to account *') }}" :error="$errors->first('to_account_id')">
                    <x-input.select wire:model="to_account_id" :options="App\Models\Account::active()->pluck('name', 'id')" id="to_account_id" />
                </x-input.group>
            </div>

            <div class="col-span-2">
                <x-input.group for="amount" label="{{ __('amount *') }}" :error="$errors->first('amount')">
                    <x-input type="number" wire:model="amount" id="amount" />
                </x-input.group>
            </div>
        </div>

        <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40" wire:target="create"
            style="width: 100%; justify-content: center">
            {{ __('submit') }}
        </x-button>
    </form>
</x-modal>
