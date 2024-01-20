<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('suppliers')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('supplier list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Supplier::class)
                        <x-button :href="route('admin.suppliers.create')">
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
            <x-table.heading> {{ __('phone number') }} </x-table.heading>
            <x-table.heading> {{ __('details') }} </x-table.heading>
            <x-table.heading> {{ __('due') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($suppliers as $supplier)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $supplier->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $supplier->id }}" id="{{ $supplier->id }}"
                        for="{{ $supplier->id }}" />
                </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white">
                    {{ Str::limit($supplier->name, 25, '..') }}
                </x-table.cell>
                <x-table.cell>
                    {{ $supplier->phone_number }}
                </x-table.cell>
                <x-table.cell>
                    {{ $supplier?->company_name }} <br>
                    {{ $supplier?->address }}
                </x-table.cell>
                <x-table.cell>
                    @if ($supplier->totalDue())
                        <span class="text-danger">
                            {{ Number::format($supplier->totalDue()) }} TK
                        </span>
                    @else
                        0
                    @endif
                </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($supplier->trashed())
                        <x-button flat="primary" wire:click="restore({{ $supplier->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $supplier->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $supplier])
                    @else
                        @can('update', $supplier)
                            <x-button flat="warning" :href="route('admin.suppliers.edit', $supplier)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $supplier)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $supplier->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>

                            @include('partials.delete-modal', ['data' => $supplier])
                        @endcan
                    @endif
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="6" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $suppliers->links() }}
    </div>
</div>
