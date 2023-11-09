<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                {{-- Breadcrumb --}}
                <nav class="flex order-2">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a wire:navigate href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-gray-400 capitalize hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                                <x-heroicon-s-home class="mr-2.5" />
                                {{ __('dashboard') }}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                                <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                                    {{ __('sales') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('sale list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="sales-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <x-input wire:model.live.debounce.250ms="search" placeholder="{{ __('search') }}.." />
                        </div>
                    </form>

                    <div class="flex items-center w-full sm:justify-end">
                        <div class="flex pl-2 space-x-1">
                            <a href="#" wire:click="deleteSelected" title="Delete Selected"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-s-trash class="w-6 h-6" />
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-s-information-circle class="w-6 h-6" />
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-m-ellipsis-vertical class="w-6 h-6" />
                            </a>
                        </div>
                    </div>
                </div>

                {{-- <x-button :href="route('admin.sales.create')">
                    <x-heroicon-m-plus class="w-4 h-4" />
                    {{ __('add sale') }}
                </x-button> --}}
            </div>
        </div>

        <x-status :status="session('status')" />
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('invoice no.') }} </x-table.heading>
            <x-table.heading> {{ __('customer') }} </x-table.heading>
            <x-table.heading> {{ __('payment method') }} </x-table.heading>
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
                <x-table.cell class="font-medium text-gray-800 dark:text-white"> {{ $sale->invoice_no }} </x-table.cell>
                <x-table.cell> {{ $sale->customer->name }} </x-table.cell>
                <x-table.cell> {{ $sale->payment_method }} </x-table.cell>
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
            <x-table.data-not-found colspan="8" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $sales->links() }}
    </div>
</div>
