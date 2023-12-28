<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('attendances')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('attendance list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="attendances-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <x-input wire:model.live.debounce.250ms="search" placeholder="{{ __('search') }}.." />
                        </div>
                    </form>

                    <div class="flex items-center w-full sm:justify-end">
                        <div class="flex pl-2 space-x-1">
                            <a href="#" wire:click="deleteSelected" title="Delete Selected"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-s-trash class="w-6 h-6" />
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-s-information-circle class="w-6 h-6" />
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-m-ellipsis-vertical class="w-6 h-6" />
                            </a>
                        </div>
                    </div>
                </div>

                @can('create', App\Models\Attendance::class)
                    <x-button :href="route('admin.attendance.add')">
                        <x-heroicon-m-plus class="w-4 h-4" />
                        {{ __('add attendance') }}
                    </x-button>
                @endcan
            </div>
        </div>


    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('date') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($attendances as $attendance)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $attendance->id }}">
                <x-table.cell> {{ $attendance->date->format('d M, Y') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @can('update', App\Models\Attendance::class)
                        <x-button flat="warning" :href="route('admin.attendance.edit', $attendance->date->format('Y-m-d'))">
                            <x-heroicon-o-pencil-square /> {{ __('edit') }}
                        </x-button>
                    @endcan

                    <x-button flat="secondary" :href="route('admin.attendance.show', $attendance->date->format('Y-m-d'))">
                        <x-heroicon-o-eye /> {{ __('view') }}
                    </x-button>
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="9" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $attendances->links() }}
    </div>
</div>
