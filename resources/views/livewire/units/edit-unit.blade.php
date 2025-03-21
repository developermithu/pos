<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item label="units" :href="route('admin.units.index')" />
            <x-breadcrumb.item label="edit" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('update unit') }}
        </h1>
    </div>

    <div class="w-full m-auto lg:max-w-3xl col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="name" label="name *" :error="$errors->first('form.name')" class="sm:col-span-full">
                        <x-input wire:model="form.name" id="name" required />
                    </x-input.group>

                    <x-input.group for="short_name" label="short name *" :error="$errors->first('form.short_name')" class="sm:col-span-full">
                        <x-input wire:model="form.short_name" id="short_name" required />
                    </x-input.group>

                    <x-input.group for="unit_id" label="base unit" :error="$errors->first('form.unit_id')">
                        <x-input.select wire:model.change="form.unit_id" :options="$baseUnits" selected="true" />
                    </x-input.group>

                    @isset($base_unit_id)
                        <div class="col-span-2">
                            <x-input.group for="operator" label="operator *" :error="$errors->first('form.operator')">
                                <x-input wire:model="form.operator" id="operator" required />
                            </x-input.group>
                        </div>

                        <div class="col-span-2">
                            <x-input.group for="operation_value" label="operation value *" :error="$errors->first('form.operation_value')">
                                <x-input type="number" wire:model="form.operation_value" id="operation_value" required />
                            </x-input.group>
                        </div>
                    @endisset

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
