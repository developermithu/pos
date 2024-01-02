<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item :label="__('cashbook entries')" :href="route('admin.cashbooks.index')" />
            <x-breadcrumb.item :label="__('edit')" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('update cashbook entry') }}
        </h1>
    </div>

    <div class="w-full m-auto lg:max-w-3xl col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="store_id" :label="__('store')" :error="$errors->first('form.store_id')">
                        <x-input.select :options="App\Models\Store::pluck('name', 'id')" wire:model="form.store_id" />
                    </x-input.group>

                    <x-input.group for="amount" :label="__('amount')" :error="$errors->first('form.amount')">
                        <x-input wire:model="form.amount" id="amount" required />
                    </x-input.group>

                    <x-input.group for="type" label="{{ __('type') }}" :error="$errors->first('form.type')">
                        <x-input.select wire:model="form.type">
                            <option value="" disabled>-- {{ __('select type') }} --</option>
                            @foreach (App\Enums\CashbookEntryType::forSelect() as $value => $name)
                                <option value="{{ $value }}"> {{ $name }} </option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="date" label="{{ __('date') }}" :error="$errors->first('form.date')">
                        <x-input type="date" wire:model="form.date" id="date" />
                    </x-input.group>

                    <x-input.group for="note" label="{{ __('note') }}" :error="$errors->first('form.note')">
                        <x-input.textarea wire:model="form.note" id="note" rows="3" />
                    </x-input.group>

                    <div class="col-span-6 sm:col-full">
                        <x-button.primary wire:loading.attr="disabled" wire:target="save"
                            wire:loading.class="opacity-40">
                            {{ __('save') }}
                        </x-button.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
