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
                                <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                                    {{ __('advanced salary') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('advanced salary list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="advanced_salaries-search" class="sr-only">Search</label>
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

                @can('create', App\Models\AdvancedSalary::class)
                    <x-button :href="route('admin.advanced.salary.add')">
                        <x-heroicon-m-plus class="w-4 h-4" />
                        {{ __('add new') }}
                    </x-button>
                @endcan
            </div>
        </div>

        <x-status :status="session('status')" />
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('employee') }} </x-table.heading>
            <x-table.heading> {{ __('month') }} </x-table.heading>
            <x-table.heading> {{ __('year') }} </x-table.heading>
            <x-table.heading> {{ __('salary') }} </x-table.heading>
            <x-table.heading> {{ __('advanced paid') }} </x-table.heading>
            <x-table.heading> {{ __('paid at') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($advanced_salaries as $advanced_salary)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $advanced_salary->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $advanced_salary->id }}"
                        id="{{ $advanced_salary->id }}" for="{{ $advanced_salary->id }}" />
                </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white"> {{ $advanced_salary->employee->name }}
                </x-table.cell>
                <x-table.cell> {{ $advanced_salary->month }} </x-table.cell>
                <x-table.cell> {{ $advanced_salary->year }} </x-table.cell>
                <x-table.cell class="font-bold"> ৳ {{ $advanced_salary->employee->salary }} </x-table.cell>
                <x-table.cell> ৳ {{ $advanced_salary->amount }} </x-table.cell>
                <x-table.cell> {{ $advanced_salary->paid_at->format('d M, Y') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    <x-button flat="secondary"
                        x-on:click.prevent="$dispatch('open-modal', 'view-{{ $advanced_salary->id }}')">
                        <x-heroicon-o-eye /> {{ __('view') }}
                    </x-button>

                    @can('update', $advanced_salary)
                        <x-button flat="warning" :href="route('admin.advanced.salary.edit', $advanced_salary)">
                            <x-heroicon-o-pencil-square /> {{ __('edit') }}
                        </x-button>
                    @endcan

                    @can('delete', $advanced_salary)
                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $advanced_salary->id }}')">
                            <x-heroicon-o-trash /> {{ __('delete') }}
                        </x-button>
                    @endcan

                    {{-- View Modal --}}
                    <x-modal maxWidth="xl" name="view-{{ $advanced_salary->id }}">
                        <div class="grid grid-cols-6 gap-3 p-6">
                            <div class="flex items-center col-span-6 gap-2">
                                <h3 class="text-base font-semibold lg:text-lg">Employee Name:</h3>
                                <p>{{ $advanced_salary->employee->name }}</p>
                            </div>
                            <div class="flex items-center col-span-6 gap-2 lg:col-span-3">
                                <h3 class="text-base font-semibold lg:text-lg">Advanced Paid:</h3>
                                <p>{{ $advanced_salary->amount }} tk</p>
                            </div>
                            <div class="flex items-center col-span-6 gap-2 lg:col-span-3">
                                <h3 class="text-base font-semibold lg:text-lg">Paid at:</h3>
                                <p>{{ $advanced_salary->paid_at->format('d M, Y') }}</p>
                            </div>
                            <div class="flex items-center col-span-6 gap-2 lg:col-span-3">
                                <h3 class="text-base font-semibold lg:text-lg">Month:</h3>
                                <p>{{ $advanced_salary->month }}</p>
                            </div>
                            <div class="flex items-center col-span-6 gap-2 lg:col-span-3">
                                <h3 class="text-base font-semibold lg:text-lg">Year:</h3>
                                <p>{{ $advanced_salary->year }}</p>
                            </div>

                            <div class="flex items-center justify-end col-span-6 sm:col-full">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    cancel
                                </x-secondary-button>
                            </div>
                        </div>
                    </x-modal>
                    {{-- View Modal --}}

                    @include('partials.delete-modal', ['data' => $advanced_salary])
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="8" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $advanced_salaries->links() }}
    </div>
</div>
