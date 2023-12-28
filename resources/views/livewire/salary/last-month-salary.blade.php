<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('last month salary') }}
                </h1>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('no') }} </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('month') }} </x-table.heading>
            <x-table.heading> {{ __('salary') }} </x-table.heading>
            <x-table.heading> {{ __('status') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($paidSalaries as $key => $paidSalary)
            <x-table.row wire:key="{{ $paidSalary->id }}">
                <x-table.cell> {{ $key + 1 }} </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white"> {{ $paidSalary->employee->name }}
                </x-table.cell>
                <x-table.cell> {{ $paidSalary->month }} </x-table.cell>
                <x-table.cell class="font-bold"> {{ number_format($paidSalary->amount) }} </x-table.cell>
                <x-table.cell>
                    <span class="rounded-full bg-success px-2.5 py-1 text-sm text-white">
                        {{ __('full paid') }}
                    </span>
                </x-table.cell>
                <x-table.cell class="space-x-2">
                    <x-button flat="primary"
                        x-on:click.prevent="$dispatch('open-modal', 'history-{{ $paidSalary->id }}')">
                        <x-heroicon-o-eye /> {{ __('history') }}
                    </x-button>
                </x-table.cell>

                {{-- History Modal --}}
                <x-modal maxWidth="2xl" name="history-{{ $paidSalary->id }}">
                    <div class="grid grid-cols-12 gap-3 p-3 md:p-6">
                        <div class="text-base capitalize col-span-full md:col-span-6 md:text-lg">
                            <span> {{ __('employee name') }} : </span>
                            <strong>{{ $paidSalary->employee->name }}</strong>
                        </div>

                        <div class="text-base capitalize col-span-full md:col-span-6 md:text-lg">
                            <span> {{ __('month') }} : </span>
                            <strong>{{ $paidSalary->month }}</strong>
                        </div>

                        <div class="text-base capitalize md:text-lg col-span-full md:col-span-6">
                            <span> {{ __('employee salary') }} : </span>
                            <strong>{{ $paidSalary->amount }}</strong>
                        </div>

                        <div class="text-base capitalize md:text-lg col-span-full md:col-span-6">
                            <span> {{ __('advance paid') }} : </span>
                            <strong>{{ $paidSalary->advance_paid }}</strong>
                        </div>

                        <div class="text-base capitalize md:text-lg col-span-full md:col-span-6">
                            <span> {{ __('due') }} : </span>
                            <strong>{{ $paidSalary->due }}</strong>
                        </div>

                        <div class="flex items-center justify-end col-span-full">
                            <x-button type="secondary" x-on:click="$dispatch('close')">
                                cancel
                            </x-button>
                        </div>
                    </div>
                </x-modal>
                {{-- History Modal --}}
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="6" />
        @endforelse
    </x-table>
</div>
