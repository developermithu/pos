<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item :label="__('customers')" :href="route('admin.customers.index')" />
            <x-breadcrumb.item :label="__('create')" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('add new customer') }}
        </h1>
    </div>

    <div class="col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="name" label="{{ __('name') }}" :error="$errors->first('name')">
                        <x-input wire:model="name" id="name" />
                    </x-input.group>

                    <x-input.group for="address" label="{{ __('address') }}" :error="$errors->first('address')">
                        <x-input wire:model="address" id="address" />
                    </x-input.group>

                    <x-input.group for="phone_number" label="{{ __('phone number') }}" :error="$errors->first('phone_number')">
                        <x-input wire:model="phone_number" id="phone_number" />
                    </x-input.group>

                    <x-input.group for="due" label="{{ __('due amount') }}" :error="$errors->first('due')">
                        <x-input type="number" wire:model="due" id="due" />
                    </x-input.group>

                    <x-input.group for="advanced_paid" label="{{ __('advanced paid') }}" :error="$errors->first('advanced_paid')">
                        <x-input type="number" wire:model="advanced_paid" id="advanced_paid" />
                    </x-input.group>

                    <div class="col-span-6 sm:col-full">
                        <x-button.primary wire:loading.attr="disabled" wire:target="save"
                            wire:loading.class="opacity-40">
                            {{ __('submit') }}
                        </x-button.primary>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
