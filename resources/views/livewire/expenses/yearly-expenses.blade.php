<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('yearly expenses')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('yearly expenses') }} -
                    <span class="text-amber-500">{{ number_format($yearlyTotalExpense) }} ৳</span>
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>
                
                <div class="px-4 py-1.5 text-white rounded-full bg-amber-500"> {{ date('Y') }} </div>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('details') }} </x-table.heading>
            <x-table.heading> {{ __('amount') }} </x-table.heading>
            <x-table.heading> {{ __('date') }} </x-table.heading>
        </x-slot>

        @forelse ($yearlyExpenses as $yearlyExpense)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $yearlyExpense->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $yearlyExpense->id }}"
                        id="{{ $yearlyExpense->id }}" for="{{ $yearlyExpense->id }}" />
                </x-table.cell>
                <x-table.cell>
                    {{ Str::limit($yearlyExpense->details, 50, '..') }}
                </x-table.cell>
                <x-table.cell class="font-semibold"> {{ number_format($yearlyExpense->amount) }} ৳ </x-table.cell>
                <x-table.cell> {{ $yearlyExpense->date->format('d M, Y') }} </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="4" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $yearlyExpenses->links() }}
    </div>
</div>
