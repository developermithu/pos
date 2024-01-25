<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item :label="__('employees')" :href="route('admin.employees.index')" />
            <x-breadcrumb.item :label="__('edit')" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('update employee') }}
        </h1>
    </div>

    <div class="col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit="save">
                <div class="grid grid-cols-6 gap-6">
                    <x-input.group for="name" label="{{ __('name') }}" :error="$errors->first('form.name')">
                        <x-input wire:model="form.name" id="name" />
                    </x-input.group>

                    <x-input.group for="father_name" label="{{ __('father name') }}" :error="$errors->first('form.father_name')">
                        <x-input wire:model="form.father_name" id="father_name" />
                    </x-input.group>

                    <x-input.group for="address" label="{{ __('address') }}" :error="$errors->first('form.address')">
                        <x-input wire:model="form.address" id="address" />
                    </x-input.group>

                    <x-input.group for="phone_number" label="{{ __('phone number') }}" :error="$errors->first('form.phone_number')">
                        <x-input wire:model="form.phone_number" id="phone_number" />
                    </x-input.group>

                    {{-- Update employees salary --}}
                    <div x-data="{ isChecked: false }" class="col-span-6 sm:col-span-3">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-sm font-medium text-gray-700 capitalize dark:text-gray-300">
                                <div x-cloak x-show="isChecked">
                                    {{ __('new basic salary') }}
                                </div>

                                <div x-cloak x-show="isChecked === false">
                                    {{ __('basic salary') }}
                                    @if ($employee->old_basic_salary)
                                        <span class="!text-xs !font-normal">
                                            ({{ __('old basic salary') }} - {{ $employee->old_basic_salary }} TK)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-x-2">
                                <span class="text-sm font-medium"
                                    :class="{ 'text-gray-400': !isChecked, 'text-primary': isChecked }">
                                    {{ __('update salary') }} </span>
                                <label for="updateSalary"
                                    class="relative h-8 w-14 cursor-pointer [-webkit-tap-highlight-color:_transparent]">
                                    <input x-model="isChecked" type="checkbox" id="updateSalary" class="sr-only peer" />

                                    <span
                                        :class="{
                                            'bg-gray-300': !
                                                isChecked,
                                            'bg-primary': isChecked
                                        }"
                                        class="absolute inset-0 transition rounded-full"></span>

                                    <span :class="{ 'start-0': !isChecked, 'start-6': isChecked }"
                                        class="absolute inset-y-0 w-6 h-6 m-1 transition-all bg-white rounded-full"></span>
                                </label>
                            </div>
                        </div>

                        <div x-cloak x-show="isChecked === false">
                            <x-input type="number" wire:model="form.basic_salary" id="basic_salary" disabled />
                        </div>

                        <div x-cloak x-show="isChecked">
                            <x-input type="number" wire:model="form.new_basic_salary" id="new_basic_salary"
                                placeholder="00" />
                        </div>

                        @error('form.new_basic_salary')
                            <div class="mt-1 text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- Update employees salary --}}

                    <x-input.group for="joined_at" label="{{ __('joining date') }}" :error="$errors->first('form.joined_at')">
                        <x-input type="date" wire:model="form.joined_at" id="joined_at" />
                    </x-input.group>

                    <x-radio.group title="{{ __('gender') }}" :error="$errors->first('form.gender')">
                        <x-input.radio wire:model="form.gender" name="gender" value="male"
                            label="{{ __('male') }}" for="male" id="male" />
                        <x-input.radio wire:model="form.gender" name="gender" value="female"
                            label="{{ __('female') }}" for="female" id="female" />
                    </x-radio.group>

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
