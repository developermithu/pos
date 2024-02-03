<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="expenses" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('expense list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="relative inline-flex flex-wrap p-1 mb-4 bg-gray-100 border-gray-100 rounded-lg sm:mb-0">
                    <div class="absolute font-semibold -top-5 lg:-top-7 left-1/2 text-amber-600">
                        @if ($selectedTimePeriod === 'todays')
                            ৳ {{ number_format($todaysTotalExpense ?? 0) }}
                        @elseif ($selectedTimePeriod === 'monthly')
                            ৳ {{ number_format($monthlyTotalExpense ?? 0) }}
                        @elseif ($selectedTimePeriod === 'yearly')
                            ৳ {{ number_format($yearlyTotalExpense ?? 0) }}
                        @else
                            ৳ {{ number_format($totalExpense ?? 0) }}
                        @endif
                    </div>

                    <button wire:click="filterByTimePeriod('')"
                        class="inline-block px-4 py-2 capitalize text-sm rounded-md hover:text-gray-700 focus:relative {{ $selectedTimePeriod === '' ? 'text-primary bg-white' : 'text-gray-500' }}">
                        {{ __('all') }}
                    </button>

                    <button wire:click="filterByTimePeriod('todays')"
                        class="inline-block px-4 py-2 capitalize text-sm rounded-md hover:text-gray-700 focus:relative  {{ $selectedTimePeriod === 'todays' ? 'text-primary bg-white' : 'text-gray-500' }}">
                        {{ __('todays expenses') }}
                    </button>

                    <button wire:click="filterByTimePeriod('monthly')"
                        class="inline-block px-4 py-2 capitalize text-sm rounded-md hover:text-gray-700 focus:relative  {{ $selectedTimePeriod === 'monthly' ? 'text-primary bg-white' : 'text-gray-500' }}">
                        {{ __('monthly expenses') }}
                    </button>

                    <button wire:click="filterByTimePeriod('yearly')"
                        class="inline-block px-4 py-2 capitalize text-sm rounded-md shadow-sm focus:relative {{ $selectedTimePeriod === 'yearly' ? 'text-primary bg-white' : 'text-gray-500' }}">
                        {{ __('yearly expenses') }}
                    </button>
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Expense::class)
                        <x-button :href="route('admin.expenses.create')">
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
            <x-table.heading> {{ __('expense category') }} </x-table.heading>
            <x-table.heading> {{ __('details') }} </x-table.heading>
            <x-table.heading> {{ __('amount') }} </x-table.heading>
            <x-table.heading> {{ __('created at') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($expenses as $expense)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $expense->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $expense->id }}" id="{{ $expense->id }}"
                        for="{{ $expense->id }}" />
                </x-table.cell>
                <x-table.cell>
                    {{ $expense->expenseCategory?->name }}
                </x-table.cell>
                <x-table.cell>
                    {{ Str::limit($expense->details, 50, '..') }}
                </x-table.cell>
                <x-table.cell class="font-semibold"> {{ number_format($expense->amount) }} ৳ </x-table.cell>
                <x-table.cell> {{ $expense->created_at->format('d M, Y') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($expense->trashed())
                        <x-button flat="primary" wire:click="restore({{ $expense->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $expense->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        {{-- Delete Forever Modal --}}
                        @include('partials.delete-forever-modal', ['data' => $expense])
                    @else
                        @can('update', $expense)
                            <x-button flat="warning" :href="route('admin.expenses.edit', $expense)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $expense)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $expense->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>

                            {{-- Delete Modal --}}
                            @include('partials.delete-modal', ['data' => $expense])
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
        {{ $expenses->links() }}
    </div>
</div>
