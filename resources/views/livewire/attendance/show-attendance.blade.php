<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
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
                                <a wire:navigate href="{{ route('admin.attendance.index') }}"
                                    class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                                    {{ __('attendance list') }}
                                </a>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('employee attendance') }}
                </h1>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('No.') }} </x-table.heading>
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
