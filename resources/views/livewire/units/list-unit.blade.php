<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="units" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('unit list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Unit::class)
                        <x-button x-on:click.prevent="$dispatch('open-modal', 'create')">
                            <x-heroicon-m-plus class="w-4 h-4" />
                            {{ __('add new') }}
                        </x-button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    @include('modals.create-unit', ['size' => 'md'])

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('short name') }} </x-table.heading>
            <x-table.heading> {{ __('base unit') }} </x-table.heading>
            <x-table.heading> {{ __('operator') }} </x-table.heading>
            <x-table.heading> {{ __('operation value') }} </x-table.heading>
            <x-table.heading> {{ __('active') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($units as $key => $unit)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $unit->id }}"
                wire:target="search, filterByTrash, clear, deleteSelected, destroy, forceDelete, restore">
                <x-table.cell> {{ $unit->name }} </x-table.cell>
                <x-table.cell class="!lowercase "> {{ $unit->short_name }} </x-table.cell>
                <x-table.cell> {{ $unit->baseUnit?->name }} </x-table.cell>
                <x-table.cell> {{ $unit?->operator }} </x-table.cell>
                <x-table.cell> {{ $unit?->operation_value }} </x-table.cell>
                <x-table.cell>
                    <div x-data="{ isActive: {{ $unit->is_active ? 'true' : 'false' }} }" class="flex items-center justify-center space-x-2">
                        <input id="thisId" type="checkbox" name="switch" class="hidden" :checked="isActive">

                        <button wire:click="toggleUnitStatus({{ $unit->id }})" wire:loading.attr="disabled"
                            wire:target="toggleUnitStatus" x-ref="switchButton" type="button"
                             :class="isActive ? 'bg-primary' : 'bg-neutral-200'"
                            class="relative inline-flex h-6 py-0.5 disabled:cursor-not-allowed ml-4 focus:outline-none rounded-full w-10"
                            x-cloak>
                            <span :class="isActive ? 'translate-x-[18px]' : 'translate-x-0.5'"
                                class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                        </button>

                        <label @click="$refs.switchButton.click(); $refs.switchButton.focus()" :id="$id('switch')"
                            :class="{ 'text-primary': isActive, 'text-gray-400': !isActive }"
                            class="text-sm select-none" x-cloak>
                            Active
                        </label>
                    </div>
                </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($unit->trashed())
                        <x-button flat="primary" wire:click="restore({{ $unit->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $unit->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>
                        @include('partials.delete-forever-modal', ['data' => $unit])
                    @else
                        @can('update', $unit)
                            <x-button flat="warning" :href="route('admin.units.edit', $unit)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $unit)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $unit->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>
                            @include('partials.delete-modal', ['data' => $unit])
                        @endcan
                    @endif
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="8" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $units->links() }}
    </div>
</div>
