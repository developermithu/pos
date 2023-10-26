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
                        <a wire:navigate href="{{ route('admin.advanced.salary.index') }}"
                            class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                            {{ __('advanced salaries') }}
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
            {{ __('update employee') }}
        </h1>
    </div>

    <div class="col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="employee_id" label="{{ __('employee name') }}" :error="$errors->first('form.employee_id')">
                        <x-input.select wire:model="form.employee_id">
                            <option value="" disabled>-- select employee --</option>
                            @foreach ($employees as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="amount" label="{{ __('amount') }}" :error="$errors->first('form.amount')">
                        <x-input type="number" wire:model="form.amount" id="amount" />
                    </x-input.group>

                    <x-input.group for="month" label="{{ __('select month') }}" :error="$errors->first('form.month')">
                        <x-input.select wire:model="form.month">
                            <option value="" disabled>-- select month --</option>
                            <option value="january"> {{ __('january') }} </option>
                            <option value="february"> {{ __('february') }} </option>
                            <option value="march"> {{ __('march') }} </option>
                            <option value="april"> {{ __('april') }} </option>
                            <option value="may"> {{ __('may') }} </option>
                            <option value="june"> {{ __('june') }} </option>
                            <option value="july"> {{ __('july') }} </option>
                            <option value="August"> {{ __('August') }} </option>
                            <option value="september"> {{ __('september') }} </option>
                            <option value="october"> {{ __('october') }} </option>
                            <option value="november"> {{ __('november') }} </option>
                            <option value="december"> {{ __('december') }} </option>
                        </x-input.select>
                    </x-input.group>

                    <x-input.group for="year" label="{{ __('select year') }}" :error="$errors->first('form.year')">
                        <x-input.select wire:model="form.year">
                            <option value="" disabled>-- select year --</option>
                            <option value="2023"> {{ __('2023') }} </option>
                            <option value="2024"> {{ __('2024') }} </option>
                            <option value="2025"> {{ __('2025') }} </option>
                            <option value="2026"> {{ __('2026') }} </option>
                            <option value="2027"> {{ __('2027') }} </option>
                            <option value="2028"> {{ __('2028') }} </option>
                            <option value="2029"> {{ __('2029') }} </option>
                            <option value="2030"> {{ __('2030') }} </option>
                        </x-input.select>
                    </x-input.group>
                    
                    <x-input.group for="paid_at" label="{{ __('paid at') }}" :error="$errors->first('form.paid_at')">
                        <x-input wire:model="form.paid_at" disabled="true" class="bg-gray-300 dark:bg-gray-800"/>
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
