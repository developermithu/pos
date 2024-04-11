<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="sales" />
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

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Sale::class)
                        <x-button :href="route('admin.pos.index')">
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
            <x-table.heading> {{ __('invoice no') }} </x-table.heading>
            <x-table.heading> {{ __('customer') }} </x-table.heading>
            <x-table.heading> {{ __('paid') }} </x-table.heading>
            <x-table.heading> {{ __('due') }} </x-table.heading>
            <x-table.heading> {{ __('total') }} </x-table.heading>
            <x-table.heading> {{ __('status') }} </x-table.heading>
            <x-table.heading> {{ __('payment status') }} </x-table.heading>
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
                <x-table.cell> {{ Number::currency($sale->paid_amount, 'BDT') }} </x-table.cell>
                <x-table.cell>
                    @php
                        $due = $sale->total - $sale->paid_amount;
                    @endphp

                    @if ($due)
                        <span class="text-danger">
                            {{ Number::currency($due, 'BDT') }}
                        </span>
                    @else
                        {{ Number::format($due, 2) }}
                    @endif
                </x-table.cell>
                <x-table.cell> {{ Number::currency($sale->total, 'BDT') }} </x-table.cell>
                <x-table.cell> {!! $sale->status->getLabelHTML() !!} </x-table.cell>
                <x-table.cell> {!! $sale->payment_status->getLabelHTML() !!} </x-table.cell>
                <x-table.cell> {{ $sale->date->format('d M, Y') }} </x-table.cell>
                <x-table.cell class="space-x-2">
                    @if ($sale->trashed())
                        <x-button flat="primary" wire:click="restore({{ $sale->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $sale->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        {{-- Delete Forever Modal --}}
                        @include('partials.delete-forever-modal', ['data' => $sale])
                    @else
                        <div x-data="{ open: false }">
                            <x-mary-button x-ref="button" icon="o-ellipsis-vertical" @click.outside="open = false"
                                @click="open = !open" class="btn-circle" />

                            <x-mary-menu x-cloak x-show="open" x-anchor.bottom-end.offset.5="$refs.button"
                                class="bg-white border">
                                <x-mary-menu-item :title="__('view')" :link="route('admin.sales.show', $sale)" icon="o-eye" />
                                <x-mary-menu-item :title="__('edit')" icon="o-pencil-square" />

                                @if ($sale->payments->count() >= 1)
                                    <x-mary-menu-item :title="__('view payments')" icon="o-banknotes"
                                        x-on:click.prevent="$dispatch('open-modal', 'view-payments-{{ $sale->id }}')" />
                                @endif

                                @if ($sale->payments_sum_amount < $sale->total)
                                    <x-mary-menu-item :title="__('add payment')" icon="o-plus" :link="route('admin.sales.add-payment', $sale)" />
                                @endif
                                <x-mary-menu-item :title="__('delete')"
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $sale->id }}')"
                                    icon="o-trash" class="text-danger" />
                            </x-mary-menu>
                        </div>
                    @endif

                    {{-- View Payments --}}
                    @include('modals.view-payments', ['data' => $sale])
                    @include('partials.delete-modal', ['data' => $sale])
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="10" />
        @endforelse
    </x-table>

    {{-- Add Payments --}}
    @include('modals.add-payment', ['size' => '2xl'])

    {{-- Pagination --}}
    <div class="p-4">
        {{ $sales->links() }}
    </div>
</div>
