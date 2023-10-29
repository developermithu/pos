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
                        <a wire:navigate href="{{ route('admin.pay.salary.index') }}"
                            class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                            {{ __('pay salary') }}
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                        <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                            {{ __('now') }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('pay salary now') }}
        </h1>
    </div>

    <x-status :status="session('status')" class="col-span-full" />

    <div class="w-full m-auto lg:max-w-3xl col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <form wire:submit.prevent="paidSalary">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="text-base capitalize md:text-lg">
                        <span> {{ __('employee name') }} : </span>
                        <strong>{{ $employee->name }}</strong>
                    </div>

                    <div class="text-base capitalize md:text-lg">
                        <span> {{ __('month') }} : </span>
                        <strong>{{ date('F', strtotime('-1 month')) }}</strong>
                    </div>

                    <div class="text-base capitalize md:text-lg">
                        <span> {{ __('employee salary') }} : </span>
                        <strong>{{ number_format($employee->salary) }}</strong>
                    </div>

                    <div class="text-base capitalize md:text-lg">
                        <span> {{ __('advance salary paid') }} : </span>
                        <strong>
                            @if ($employee->advanceSalary)
                                {{ number_format($employee->advanceSalary->amount) ?? '' }}
                            @endif
                        </strong>
                    </div>

                    <div class="text-base capitalize md:text-lg">
                        <span> {{ __('due salary') }} : </span>
                        <strong>
                            @php
                                $dueAmount = $employee->salary - ($employee->advanceSalary->amount ?? 0);
                            @endphp

                            {{ number_format($dueAmount) }}
                        </strong>
                    </div>

                    <div class="flex justify-end gap-3 col-span-full">
                        @if ($employee->paySalary)
                            <x-button :href="route('admin.pay.salary.index')" flat="danger"> {{ __('go back') }} </x-button>
                            <x-button.primary disabled="disabled" class="cursor-not-allowed opacity-40">
                                <x-heroicon-o-credit-card /> {{ __('paid') }}
                            </x-button.primary>
                        @else
                            <x-button :href="route('admin.pay.salary.index')" flat="danger"> {{ __('go back') }} </x-button>
                            <x-button.primary wire:loading.attr="disabled" wire:target="paidSalary"
                                wire:loading.class="opacity-40">
                                <x-heroicon-o-credit-card /> {{ __('paid salary') }}
                            </x-button.primary>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
