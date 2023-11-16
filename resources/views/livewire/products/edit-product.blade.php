<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        {{-- Breadcrumb --}}
        <nav class="flex order-2">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                <li class="inline-flex items-center">
                    <a wire:navigate href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center text-gray-400 capitalize hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                        <x-heroicon-s-home class="mr-2.5" />
                        {{ __('dashboard') }}
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                        <a wire:navigate href="{{ route('admin.products.index') }}"
                            class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                            {{ __('products') }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                        <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                            {{ __('edit') }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('update product') }}
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

                    <x-input.group for="sku" label="{{ __('product code') }}" :error="$errors->first('sku')">
                        <x-input wire:model="sku" id="sku" disabled="true" />
                    </x-input.group>

                    <x-input.group for="supplier_id" label="{{ __('supplier name') }}" :error="$errors->first('supplier_id')">
                        <x-input.select wire:model="supplier_id">
                            <option value="" disabled>-- select supplier --</option>
                            @foreach ($suppliers as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="qty" label="{{ __('quantity') }}" :error="$errors->first('qty')">
                        <x-input type="number" wire:model="qty" id="qty" />
                    </x-input.group>

                    <x-input.group for="buying_price" label="{{ __('buying price') }}" :error="$errors->first('buying_price')">
                        <x-input type="number" wire:model="buying_price" id="buying_price" />
                    </x-input.group>

                    <x-input.group for="selling_price" label="{{ __('selling price') }}" :error="$errors->first('selling_price')">
                        <x-input type="number" wire:model="selling_price" id="selling_price" />
                    </x-input.group>

                    <x-input.group for="buying_date" label="{{ __('buying date') }}" :error="$errors->first('buying_date')">
                        <x-input type="date" wire:model="buying_date" id="buying_date" />
                    </x-input.group>

                    <x-input.group for="expired_date" label="{{ __('expired date') }}" :error="$errors->first('expired_date')">
                        <x-input type="date" wire:model="expired_date" id="expired_date" />
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
