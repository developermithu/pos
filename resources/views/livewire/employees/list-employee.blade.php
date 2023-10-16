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
                                    {{ __('employees') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('employee list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="employees-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <x-input.text wire:model.live.debounce.250ms="search" placeholder="{{ __('search') }}.." />
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

                <x-primary-link href="{{ route('admin.employees.create') }}">
                    <x-heroicon-m-plus class="w-4 h-4" />
                    {{ __('add employee') }}
                </x-primary-link>
            </div>
        </div>

        <x-status :status="session('status')" />
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('gender') }} </x-table.heading>
            <x-table.heading> {{ __('father name') }} </x-table.heading>
            {{-- <x-table.heading> {{ __('address') }} </x-table.heading> --}}
            <x-table.heading> {{ __('phone number') }} </x-table.heading>
            <x-table.heading> {{ __('salary') }} </x-table.heading>
            <x-table.heading> {{ __('joining date') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($employees as $employee)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $employee->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $employee->id }}" id="{{ $employee->id }}"
                        for="{{ $employee->id }}" />
                </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white"> {{ $employee->name }} </x-table.cell>
                <x-table.cell> {{ $employee->gender }} </x-table.cell>
                <x-table.cell> {{ $employee->father_name }} </x-table.cell>
                {{-- <x-table.cell> {{ $employee->address }} </x-table.cell> --}}
                <x-table.cell> {{ $employee->phone_number }} </x-table.cell>
                <x-table.cell> {{ $employee->salary }} </x-table.cell>
                <x-table.cell> {{ $employee->joined_at->format('d M, Y') }} </x-table.cell>

                <x-table.cell class="space-x-1">
                    <x-primary-link :href="route('admin.employees.edit', $employee)" class="text-xs">
                        <x-heroicon-o-pencil-square />
                        {{ __('edit') }}
                    </x-primary-link>

                    <x-danger-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $employee->id }}')"
                        class="text-xs">
                        <x-heroicon-o-trash />
                        {{ __('delete') }}
                    </x-danger-button>

                    {{-- delete modal --}}
                    <x-modal maxWidth="md" name="confirm-deletion-{{ $employee->id }}">
                        <div class="p-6 text-center">
                            <x-heroicon-o-exclamation-circle
                                class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200" />
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ __('Are you sure you want to delete this?') }}
                            </h3>

                            <x-danger-button wire:click.prevent="destroy({{ $employee }})"
                                x-on:click="$dispatch('close')">
                                Yes, I'm sure
                            </x-danger-button>

                            <x-secondary-button x-on:click="$dispatch('close')" class="ml-3">
                                No, cancel
                            </x-secondary-button>
                        </div>
                    </x-modal>
                    {{-- delete modal --}}
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="9" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $employees->links() }}
    </div>
</div>
