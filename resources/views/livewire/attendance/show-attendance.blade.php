<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="attendance list" :href="route('admin.attendance.index')" />
                    <x-breadcrumb.item label="show" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('show attendance') }}
                </h1>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('no') }} </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('date') }} </x-table.heading>
            <x-table.heading> {{ __('status') }} </x-table.heading>
        </x-slot>

        @forelse ($attendances as $key => $attendance)
            <x-table.row wire:key="{{ $attendance->id }}" class="hover:bg-transparent dark:hover:bg-bg-transparent">
                <x-table.cell> {{ $key + 1 }} </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white">
                    {{ $attendance->employee->name }}
                </x-table.cell>
                <x-table.cell> {{ $attendance->date->format('d M, Y') }} </x-table.cell>
                <x-table.cell> {!! $attendance->status->getLabelHTML() !!} </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="4" />
        @endforelse

        <x-table.row class="hover:bg-transparent dark:hover:bg-bg-transparent">
            <x-table.cell colspan="4">
                <x-button :href="route('admin.attendance.index')">
                    {{ __('go back') }}
                </x-button>
            </x-table.cell>
        </x-table.row>
    </x-table>
</div>
