<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('sales')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('sale list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('invoice no') }} </x-table.heading>
            <x-table.heading> {{ __('customer') }} </x-table.heading>
            <x-table.heading> {{ __('payment method') }} </x-table.heading>
            <x-table.heading> {{ __('due') }} </x-table.heading>
            <x-table.heading> {{ __('advanced paid') }} </x-table.heading>
            <x-table.heading> {{ __('total') }} </x-table.heading>
            <x-table.heading> {{ __('status') }} </x-table.heading>
            <x-table.heading> {{ __('date') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($sales as $sale)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $sale->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $sale->id }}" id="{{ $sale->id }}"
                        for="{{ $sale->id }}" />
                </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white"> {{ $sale->invoice_no }}
                </x-table.cell>
                <x-table.cell> {{ $sale->customer->name ?? '' }} </x-table.cell>
                <x-table.cell> {{ $sale->payment_method }} </x-table.cell>
                <x-table.cell> {{ $sale->due }} </x-table.cell>
                <x-table.cell> {{ $sale->advanced_paid }} </x-table.cell>
                <x-table.cell> {{ $sale->total }} </x-table.cell>
                <x-table.cell> {!! $sale->status->getLabelHTML() !!} </x-table.cell>
                <x-table.cell> {{ $sale->date->format('d M, Y') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    <x-button size="small" :href="route('admin.sales.show', $sale)">
                        {{ __('details') }}
                    </x-button>

                    {{-- <x-button flat="danger"
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $sale->id }}')">
                        <x-heroicon-o-trash /> {{ __('delete') }}
                    </x-button>

                    @include('partials.delete-modal', ['data' => $sale]) --}}
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="10" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $sales->links() }}
    </div>
</div>
