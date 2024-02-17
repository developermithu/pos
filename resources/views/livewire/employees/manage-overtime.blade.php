<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full pr-4 mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="employees" :href="route('admin.employees.index')" />
                    <x-breadcrumb.item label="overtimes" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('manage overtime works') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                </div>

                <div class="flex items-center gap-3">
                    @can('create', App\Models\Overtime::class)
                        <x-button @click="$wire.showDrawer = true">
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
            <x-table.heading> {{ __('employee name') }} </x-table.heading>
            <x-table.heading> {{ __('rate per hour') }} </x-table.heading>
            <x-table.heading> {{ __('hours worked') }} </x-table.heading>
            <x-table.heading> {{ __('total amount') }} </x-table.heading>
            <x-table.heading> {{ __('date') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($overtimes as $overtime)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $overtime->id }}">
                <x-table.cell> {{ $overtime->employee?->name }} </x-table.cell>
                <x-table.cell> {{ $overtime->rate_per_hour }} TK </x-table.cell>
                <x-table.cell> {{ $overtime->hours_worked }} hour </x-table.cell>
                <x-table.cell class="font-semibold"> {{ Number::format($overtime->total_amount) }} TK </x-table.cell>
                <x-table.cell> {{ $overtime->date->format('d M Y') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @can('update', $overtime)
                        <x-button flat="warning" wire:click="showEditModal({{ $overtime->id }})">
                            <x-heroicon-o-pencil-square /> {{ __('edit') }}
                        </x-button>
                    @endcan

                    @can('delete', $overtime)
                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $overtime->id }}')">
                            <x-heroicon-o-trash /> {{ __('delete') }}
                        </x-button>
                    @endcan

                    @include('partials.delete-forever-modal', ['data' => $overtime])
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="6" />
        @endforelse
    </x-table>

    {{-- Overtime Create and Edit Form --}}
    @include('modals.overtime-form')

    {{-- Pagination --}}
    <div class="p-4">
        {{ $overtimes->links() }}
    </div>
</div>
