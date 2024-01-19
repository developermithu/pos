<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item :label="__('customers')" :href="route('admin.customers.index')" />
            <x-breadcrumb.item :label="__('add deposit')" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('add deposit') }}
        </h1>
    </div>

    <div class="w-full m-auto lg:max-w-3xl col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="addDeposit">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <x-input.group for="amount" label="{{ __('amount *') }}" :error="$errors->first('amount')">
                            <x-input type="number" wire:model="amount" id="amount" required />
                        </x-input.group>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-input.group for="account_id" label="{{ __('account name *') }}" :error="$errors->first('account_id')">
                            <x-input.select wire:model="account_id" :options="$accounts" required />
                        </x-input.group>
                    </div>

                    <x-input.group for="note" label="{{ __('note') }}" :error="$errors->first('note')"
                        class="sm:col-span-full">
                        <x-input.textarea wire:model="note" id="note" rows="3" />
                    </x-input.group>

                    <div class="col-span-6 sm:col-full">
                        <x-button.primary wire:loading.attr="disabled" wire:target="addDeposit"
                            wire:loading.class="opacity-40">
                            {{ __('submit') }}
                        </x-button.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
