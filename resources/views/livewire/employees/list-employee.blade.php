<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('employees')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('employee list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Employee::class)
                        <x-button :href="route('admin.employees.create')">
                            <x-heroicon-m-plus class="w-4 h-4" />
                            {{ __('add new') }}
                        </x-button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('gender') }} </x-table.heading>
            <x-table.heading> {{ __('father name') }} </x-table.heading>
            <x-table.heading> {{ __('address') }} </x-table.heading>
            <x-table.heading> {{ __('phone number') }} </x-table.heading>
            <x-table.heading> {{ __('basic salary') }} </x-table.heading>
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
                <x-table.cell> {{ $employee->address }} </x-table.cell>
                <x-table.cell> {{ $employee->phone_number }} </x-table.cell>
                <x-table.cell>
                    ৳ {{ $employee->basic_salary }} <br>

                    @if ($employee->old_basic_salary)
                        <span class="text-[10px] lg:text-xs text-danger/80">
                            {{ __('increased') }} {{ $employee->salary_updated_at() }}
                        </span>
                    @endif
                </x-table.cell>
                <x-table.cell> {{ $employee->joined_at->format('d M Y') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($employee->trashed())
                        <x-button flat="primary" wire:click="restore({{ $employee->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $employee->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $employee])
                    @else
                        <div x-data="{ open: false }">
                            <x-mary-button x-ref="button" icon="o-ellipsis-vertical" @click.outside="open = false"
                                x-on:click="open = !open" class="btn-circle" />

                            <x-mary-menu x-cloak x-show="open" x-anchor.bottom-end.offset.5="$refs.button"
                                class="bg-white border">

                                <x-mary-menu-item :title="__('view')" icon="o-eye" />

                                @can('update', $employee)
                                    <x-mary-menu-item :title="__('edit')" :link="route('admin.employees.edit', $employee)" icon="o-pencil-square" />
                                @endcan

                                @if ($employee->advancePayments->count() > 0)
                                    <x-mary-menu-item :title="__('view advance payments')" icon="o-banknotes"
                                        x-on:click.prevent="$dispatch('open-modal', 'view-advance-payments-{{ $employee->id }}')" />
                                @endif

                                <x-mary-menu-item :title="__('add advance payment')" icon="o-plus" :link="route('admin.employees.add-advance-payment', $employee)" />

                                @can('delete', $employee)
                                    <x-mary-menu-item :title="__('delete')"
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $employee->id }}')"
                                        icon="o-trash" class="text-danger" />
                                @endcan
                            </x-mary-menu>
                        </div>
                    @endif

                    {{-- View Deposits --}}
                    @include('modals.view-advance-payments', ['data' => $employee])
                    @include('partials.delete-modal', ['data' => $employee])
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
