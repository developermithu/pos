<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('products')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('product list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Product::class)
                        <x-button :href="route('admin.products.create')">
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
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('supplier') }} </x-table.heading>
            <x-table.heading> {{ __('product code') }} </x-table.heading>
            <x-table.heading> {{ __('quantity') }} </x-table.heading>
            <x-table.heading> {{ __('buying price') }} </x-table.heading>
            <x-table.heading> {{ __('selling price') }} </x-table.heading>
            <x-table.heading> {{ __('buying date') }} </x-table.heading>
            <x-table.heading> {{ __('expired date') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($products as $product)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $product->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $product->id }}" id="{{ $product->id }}"
                        for="{{ $product->id }}" />
                </x-table.cell>
                <x-table.cell class="font-medium">
                    {{ Str::limit($product->name, 20, '..') }}
                </x-table.cell>
                <x-table.cell> {{ $product->supplier->name ?? '' }} </x-table.cell>
                <x-table.cell class="font-semibold"> {{ $product->sku }} </x-table.cell>
                <x-table.cell> {{ $product->qty }} </x-table.cell>
                <x-table.cell> {{ number_format($product->buying_price) }} </x-table.cell>
                <x-table.cell> {{ number_format($product->selling_price) }} </x-table.cell>
                <x-table.cell> {{ $product->buying_date() }}
                </x-table.cell>
                <x-table.cell> {{ $product->expired_date() }}
                </x-table.cell>
                <x-table.cell class="space-x-2">
                    @if ($product->trashed())
                        <x-button flat="primary" wire:click="restore({{ $product->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $product->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $product])
                    @else
                        <x-button flat="secondary" :href="route('admin.products.show', $product)">
                            <x-heroicon-o-eye /> {{ __('view') }}
                        </x-button>

                        @can('update', $product)
                            <x-button flat="warning" :href="route('admin.products.edit', $product)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $product)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $product->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>

                            @include('partials.delete-modal', ['data' => $product])
                        @endcan
                    @endif
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="9" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $products->links() }}
    </div>
</div>
