<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item label="purchases" :href="route('admin.purchases.index')" />
            <x-breadcrumb.item label="add payment" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('add payment') }}
        </h1>
    </div>

    <div class="w-full m-auto lg:max-w-3xl col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="addPayment">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <x-input.group for="received_amount" label="{{ __('received amount') }}" :error="$errors->first('received_amount')">
                            <x-input wire:model="received_amount" id="received_amount" />
                        </x-input.group>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-input.group for="paid_amount" label="{{ __('paying amount *') }}" :error="$errors->first('paid_amount')">
                            <x-input wire:model="paid_amount" id="paid_amount" required />
                        </x-input.group>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-input.group for="account_id" label="{{ __('account name *') }}" :error="$errors->first('account_id')">
                            <x-input.select wire:model="account_id" :options="$accounts" placeholder="choose account"
                                required />
                        </x-input.group>
                    </div>

                    <x-input.group for="note" label="{{ __('note') }}" :error="$errors->first('note')"
                        class="sm:col-span-full">
                        <x-input.textarea wire:model="note" id="note" rows="3" />
                    </x-input.group>

                    <div class="col-span-6 sm:col-full">
                        <x-button.primary wire:loading.attr="disabled" wire:target="addPayment"
                            wire:loading.class="opacity-40">
                            {{ __('submit') }}
                        </x-button.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
