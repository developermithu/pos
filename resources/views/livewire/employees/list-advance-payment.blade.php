<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="employees" :href="route('admin.employees.index')" />
                    <x-breadcrumb.item label="advance payments" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('advance payment list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    {{-- <x-table.bulk-action /> --}}
                </div>

                <div class="relative inline-flex flex-wrap p-1 mb-4 bg-gray-100 border-gray-100 rounded-lg sm:mb-0">
                    <button wire:click="filterByTimePeriod('')"
                        class="inline-block px-4 py-2 capitalize text-sm rounded-md hover:text-gray-700 focus:relative {{ $selectedTimePeriod === '' ? 'text-primary bg-white' : 'text-gray-500' }}">
                        {{ __('all') }}
                    </button>

                    <button wire:click="filterByTimePeriod('todays')"
                        class="inline-block px-4 py-2 capitalize text-sm rounded-md hover:text-gray-700 focus:relative  {{ $selectedTimePeriod === 'todays' ? 'text-primary bg-white' : 'text-gray-500' }}">
                        {{ __('todays payments') }}
                    </button>

                    <button wire:click="filterByTimePeriod('current-month')"
                        class="inline-block px-4 py-2 capitalize text-sm rounded-md hover:text-gray-700 focus:relative  {{ $selectedTimePeriod === 'current-month' ? 'text-primary bg-white' : 'text-gray-500' }}">
                        {{ __('current month payments') }}
                    </button>

                    <button wire:click="filterByTimePeriod('last-month')"
                        class="inline-block px-4 py-2 capitalize text-sm rounded-md shadow-sm focus:relative {{ $selectedTimePeriod === 'last-month' ? 'text-primary bg-white' : 'text-gray-500' }}">
                        {{ __('last month payments') }}
                    </button>
                </div>

                <div class="flex items-center gap-3">
                    {{-- <x-table.filter-action /> --}}

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
            <x-table.heading> {{ __('employee name') }} </x-table.heading>
            <x-table.heading> {{ __('details') }} </x-table.heading>
            <x-table.heading> {{ __('amount') }} </x-table.heading>
            <x-table.heading> {{ __('created at') }} </x-table.heading>
        </x-slot>

        @php
            $totalAmount = 0;
        @endphp

        @forelse ($advancePayments as $payment)
            @php
                $totalAmount += $payment->amount;
            @endphp

            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $payment->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $payment->id }}" id="{{ $payment->id }}"
                        for="{{ $payment->id }}" />
                </x-table.cell>
                <x-table.cell>
                    {{ $payment->employee?->name }}
                </x-table.cell>
                <x-table.cell>
                    {{ Str::limit($payment->note, 50, '..') }}
                </x-table.cell>
                <x-table.cell class="font-semibold"> {{ number_format($payment->amount) }} TK </x-table.cell>
                <x-table.cell> {{ $payment->created_at->format('d M, Y, g:i A') }} </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="5" />
        @endforelse

        @if ($advancePayments->count() > 0)
            <x-table.row class="font-semibold" wire:loading.class="opacity-50">
                <x-table.cell colspan="1"> </x-table.cell>
                <x-table.cell colspan="2"> {{ __('total') }} </x-table.cell>
                <x-table.cell colspan="2" class="!text-primary"> {{ Number::format($totalAmount) }} TK
                </x-table.cell>
            </x-table.row>
        @endif
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $advancePayments->links() }}
    </div>
</div>
