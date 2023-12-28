<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('pay salary')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('pay salary list') }} -
                    <span class="text-amber-600">{{ date('F Y') }}</span>
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('no') }} </x-table.heading>
            <x-table.heading> {{ __('employee name') }} </x-table.heading>
            <x-table.heading> {{ __('month') }} </x-table.heading>
            <x-table.heading> {{ __('salary') }} </x-table.heading>
            <x-table.heading> {{ __('advance paid') }} </x-table.heading>
            <x-table.heading> {{ __('due') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($employees as $key => $employee)
            @php
                $dueAmount = $employee->salary - ($employee->advanceSalary->amount ?? 0);
            @endphp

            <x-table.row wire:key="{{ $employee->id }}">
                <x-table.cell> {{ $key + 1 }} </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white"> {{ $employee->name }}
                </x-table.cell>
                <x-table.cell>
                    <span class="rounded-full bg-primary px-2.5 py-1 text-sm text-white">
                        {{ date('F', strtotime('-1 month')) }}
                    </span>
                </x-table.cell>
                <x-table.cell class="font-bold"> {{ number_format($employee->salary) }} </x-table.cell>
                <x-table.cell>
                    @if ($employee->advanceSalary)
                        {{ number_format($employee->advanceSalary->amount) ?? '' }}
                    @endif
                </x-table.cell>
                <x-table.cell> {{ number_format($dueAmount) }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($employee->paySalary)
                        <button class="capitalize cursor-not-allowed text-danger">{{ __('full paid') }}</button>
                    @else
                        @can('create', App\Models\PaySalary::class)
                            <x-button size="small" :href="route('admin.pay.salary.now', $employee)">
                                {{ __('pay now') }}
                            </x-button>
                        @endcan
                    @endif
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="7" />
        @endforelse
    </x-table>
</div>
