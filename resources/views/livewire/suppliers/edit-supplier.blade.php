<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item label="suppliers" :href="route('admin.suppliers.index')" />
            <x-breadcrumb.item label="edit" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('update supplier') }}
        </h1>
    </div>

    <div class="col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="name" label="{{ __('name *') }}" :error="$errors->first('form.name')">
                        <x-input wire:model="form.name" id="name" required />
                    </x-input.group>

                    <x-input.group for="company_name" label="{{ __('company name') }}" :error="$errors->first('form.company_name')">
                        <x-input wire:model="form.company_name" id="company_name" />
                    </x-input.group>

                    <x-input.group for="address" label="{{ __('address') }}" :error="$errors->first('form.address')">
                        <x-input wire:model="form.address" id="address" />
                    </x-input.group>

                    <x-input.group for="phone_number" label="{{ __('phone number *') }}" :error="$errors->first('form.phone_number')">
                        <x-input wire:model="form.phone_number" id="phone_number" required />
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
