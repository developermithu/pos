<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="stores" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('store list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Store::class)
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
    @include('modals.create-store', ['size' => 'md'])

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('no') }} </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('location') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($stores as $key => $store)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $store->id }}"
                wire:target="search, filterByTrash, clear, deleteSelected, destroy, forceDelete, restore">
                <x-table.cell> {{ $key + 1 }} </x-table.cell>
                <x-table.cell> {{ $store->name }} </x-table.cell>
                <x-table.cell> {{ $store->location }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($store->trashed())
                        <x-button flat="primary" wire:click="restore({{ $store->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $store->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>
                        @include('partials.delete-forever-modal', ['data' => $store])
                    @else
                        @can('update', $store)
                            <x-button flat="warning" :href="route('admin.stores.edit', $store)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $store)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $store->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>
                            @include('partials.delete-modal', ['data' => $store])
                        @endcan
                    @endif
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="4" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $stores->links() }}
    </div>
</div>
