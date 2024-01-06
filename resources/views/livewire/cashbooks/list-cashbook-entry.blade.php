<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('cashbooks')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('cashbook list') }}
                </h1>
            </div>

            <div class="pb-5 grid grid-cols-12 gap-5 lg:gap-10">
                <x-mary-stat :title="__('todays deposit')" icon="o-banknotes"
                    class="bg-gray-100 col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 capitalize"
                    value="{{ Number::forHumans($totalTodaysDeposits, '2') }} Taka" />

                <x-mary-stat :title="__('monthly deposit')" icon="o-banknotes"
                    class="bg-gray-100 col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 capitalize"
                    value="{{ Number::forHumans($totalMonthlyDeposits, '2') }} Taka" />

                <x-mary-stat :title="__('yearly deposit')" icon="o-banknotes"
                    class="bg-gray-100 col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 capitalize"
                    value="{{ Number::forHumans($totalYearlyDeposits, '2') }} Taka" />

                <x-mary-stat :title="__('todays expense')" icon="o-banknotes"
                    class="bg-gray-100 col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 capitalize"
                    value="{{ Number::forHumans($totalTodaysExpenses, '2') }} Taka" />
                <x-mary-stat :title="__('monthly expense')" icon="o-banknotes"
                    class="bg-gray-100 col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 capitalize"
                    value="{{ Number::forHumans($totalMonthlyExpenses, '2') }} Taka" />
                <x-mary-stat :title="__('yearly expense')" icon="o-banknotes"
                    class="bg-gray-100 col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-3 capitalize"
                    value="{{ Number::forHumans($totalYearlyExpenses, '2') }} Taka" />
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\CashbookEntry::class)
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
    @include('modals.create-cashbook-entry', ['size' => 'xl'])

    <x-table>
        <x-slot name="heading">
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('store') }} </x-table.heading>
            <x-table.heading> {{ __('type') }} </x-table.heading>
            <x-table.heading> {{ __('amount') }} </x-table.heading>
            <x-table.heading> {{ __('note') }} </x-table.heading>
            <x-table.heading> {{ __('date') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($cashbookEntries as $key => $entry)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $entry->id }}"
                wire:target="search, filterByTrash, clear, deleteSelected, destroy, forceDelete, restore">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $entry->id }}" id="{{ $entry->id }}"
                        for="{{ $entry->id }}" />
                </x-table.cell>
                <x-table.cell> {{ $entry->store?->name }} </x-table.cell>
                <x-table.cell> {!! $entry->type->getLabelHtml() !!} </x-table.cell>
                <x-table.cell> {{ $entry->amount }} </x-table.cell>
                <x-table.cell> {{ Str::limit($entry->note, 30, '..') }} </x-table.cell>
                <x-table.cell> {{ $entry->date->format('d M, Y') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($entry->trashed())
                        <x-button flat="primary" wire:click="restore({{ $entry->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $entry->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>
                        @include('partials.delete-forever-modal', ['data' => $entry])
                    @else
                        @can('update', $entry)
                            <x-button flat="warning" :href="route('admin.cashbooks.edit', $entry)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $entry)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $entry->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>
                            @include('partials.delete-modal', ['data' => $entry])
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
        {{ $cashbookEntries->links() }}
    </div>
</div>
