<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        {{-- Breadcrumb --}}
        <x-breadcrumb>
            <x-breadcrumb.item :label="__('products')" :href="route('admin.products.index')" />
            <x-breadcrumb.item :label="__('create')" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('add new product') }}
        </h1>
    </div>

    <div class="col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="name" :label="__('name *')" :error="$errors->first('name')">
                        <x-input wire:model="name" id="name" required />
                    </x-input.group>

                    <x-input.group for="category_id" :label="__('category name')" :error="$errors->first('category_id')">
                        <x-input.select wire:model="category_id" :options="App\Models\Category::pluck('name', 'id')">
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="unit_id" :label="__('unit name *')" :error="$errors->first('unit_id')">
                        <x-input.select wire:model="unit_id" :options="App\Models\Unit::pluck('short_name', 'id')" class="!lowercase" required>
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="qty" :label="__('quantity')" :error="$errors->first('qty')">
                        <x-input type="number" wire:model="qty" id="qty" placeholder="0" />
                    </x-input.group>

                    <x-input.group for="cost" :label="__('cost')" :error="$errors->first('cost')">
                        <x-input type="number" wire:model="cost" id="cost" placeholder="00" />
                    </x-input.group>

                    <x-input.group for="price" :label="__('price *')" :error="$errors->first('price')">
                        <x-input type="number" wire:model="price" id="price" placeholder="00" required />
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
