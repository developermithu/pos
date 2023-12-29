<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item :label="__('accounts')" :href="route('admin.accounts.index')" />
            <x-breadcrumb.item :label="__('edit')" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('update account') }}
        </h1>
    </div>

    <div class="w-full m-auto lg:max-w-3xl col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="name" label="{{ __('name') }}" :error="$errors->first('form.name')" class="sm:col-span-full">
                        <x-input wire:model="form.name" id="name" />
                    </x-input.group>

                    <div class="col-span-6 sm:col-span-3">
                        <x-input.group for="account_no" label="{{ __('account no') }}" :error="$errors->first('form.account_no')">
                            <x-input wire:model="form.account_no" id="account_no" />
                        </x-input.group>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-input.group for="initial_balance" label="{{ __('initial balance') }}" :error="$errors->first('form.initial_balance')">
                            <x-input type="number" wire:model="form.initial_balance" id="initial_balance" />
                        </x-input.group>
                    </div>

                    <x-input.group for="details" label="{{ __('details') }}" :error="$errors->first('form.details')"
                        class="sm:col-span-full">
                        <x-input.textarea wire:model="form.details" id="details" />
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
