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
                        <a wire:navigate href="{{ route('admin.suppliers.index') }}"
                            class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                            {{ __('suppliers') }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                        <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                            {{ __('create') }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('add new supplier') }}
        </h1>
    </div>

    <div class="col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="name" label="{{ __('name') }}" :error="$errors->first('form.name')">
                        <x-input.text wire:model="form.name" id="name" />
                    </x-input.group>

                    <x-input.group for="address" label="{{ __('address') }}" :error="$errors->first('form.address')">
                        <x-input.text wire:model="form.address" id="address" />
                    </x-input.group>

                    <x-input.group for="phone_number" label="{{ __('phone number') }}" :error="$errors->first('form.phone_number')">
                        <x-input.text wire:model="form.phone_number" id="phone_number" />
                    </x-input.group>

                    <x-input.group for="bank_name" label="{{ __('bank name') }}" :error="$errors->first('form.bank_name')">
                        <x-input.text wire:model="form.bank_name" id="bank_name" />
                    </x-input.group>

                    <x-input.group for="bank_branch" label="{{ __('bank branch') }}" :error="$errors->first('form.bank_branch')">
                        <x-input.text wire:model="form.bank_branch" id="bank_branch" />
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
