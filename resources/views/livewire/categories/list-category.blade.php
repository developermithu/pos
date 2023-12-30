<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('categories')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('category list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Category::class)
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
    @include('modals.create-category', ['size' => 'md'])

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('no') }} </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($categories as $key => $category)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $category->id }}"
                wire:target="search, filterByTrash, clear, deleteSelected, destroy, forceDelete, restore">
                <x-table.cell> {{ $key + 1 }} </x-table.cell>
                <x-table.cell> {{ $category->name }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($category->trashed())
                        <x-button flat="primary" wire:click="restore({{ $category->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $category->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>
                        @include('partials.delete-forever-modal', ['data' => $category])
                    @else
                        @can('update', $category)
                            <x-button flat="warning" :href="route('admin.categories.edit', $category)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $category)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $category->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>
                            @include('partials.delete-modal', ['data' => $category])
                        @endcan
                    @endif
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="3" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $categories->links() }}
    </div>
</div>
