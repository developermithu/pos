<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('attendances')" :href="route('admin.attendance.index')" />
                    <x-breadcrumb.item :label="__('last month')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('last month attendance list') }} -
                    (<span class="text-amber-600">
                        @php
                            $firstDayOfMonth = now()
                                ->subMonth()
                                ->startOfMonth()
                                ->format('d M');

                            $lastDayOfMonth = now()
                                ->subMonth()
                                ->endOfMonth()
                                ->format('d M');
                        @endphp

                        {{ $firstDayOfMonth }} - {{ $lastDayOfMonth }}
                    </span>)
                </h1>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('employee name') }} </x-table.heading>
            <x-table.heading> {{ __('present') }} </x-table.heading>
            <x-table.heading> {{ __('absent') }} </x-table.heading>
            <x-table.heading> {{ __('month') }} </x-table.heading>
        </x-slot>

        @forelse ($employees as $key => $employee)
            <x-table.row wire:key="{{ $employee->id }}">
                <x-table.cell> {{ $employee->name }} </x-table.cell>

                <x-table.cell class="!text-success">
                    <span class="font-semibold">
                        {{ $employee->lastMonthTotalPresent() }}
                    </span>
                    {{ Str::plural('day', $employee->lastMonthTotalPresent()) }}
                </x-table.cell>

                <x-table.cell class="!text-danger">
                    <span class="font-semibold">
                        {{ $employee->lastMonthTotalAbsent() }}
                    </span>
                    {{ Str::plural('day', $employee->lastMonthTotalAbsent()) }}
                </x-table.cell>

                <x-table.cell>
                    <span class="rounded-full bg-primary px-2.5 py-1 text-xs text-white">
                        {{ date('F', strtotime('-1 month')) }}
                    </span>
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="4" />
        @endforelse
    </x-table>
</div>
