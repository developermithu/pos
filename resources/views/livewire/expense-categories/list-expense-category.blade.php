<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="expense categories" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('expense category list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\ExpenseCategory::class)
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
    @include('modals.create-expense-category', ['size' => 'md'])

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('no') }} </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('details') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($expenseCategories as $key => $expenseCategory)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $expenseCategory->id }}"
                wire:target="search, filterByTrash, clear, deleteSelected, destroy, forceDelete, restore">
                <x-table.cell> {{ $key + 1 }} </x-table.cell>
                <x-table.cell> {{ $expenseCategory->name }} </x-table.cell>
                <x-table.cell> {{ $expenseCategory->description }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($expenseCategory->trashed())
                        <x-button flat="primary" wire:click="restore({{ $expenseCategory->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $expenseCategory->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $expenseCategory])
                    @else
                        @can('update', $expenseCategory)
                            <x-button flat="warning" :href="route('admin.expense.category.edit', $expenseCategory)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $expenseCategory)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $expenseCategory->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>

                            @include('partials.delete-modal', ['data' => $expenseCategory])
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
        {{ $expenseCategories->links() }}
    </div>
</div>
