<div>
    <div class="grid grid-cols-1 p-4 lg:grid-cols-12 gap-4 dark:bg-gray-900 lg:mt-1.5">
        <div class="mb-1 col-span-full">
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
                                    {{ __('pos') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('pos management') }}
                </h1>
            </div>


        </div>

        <!-- Right Content -->
        <div class="lg:col-span-6 col-span-full ">
            <div
                class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="p-4 text-xl font-semibold sm:pt-6 dark:text-white">{{ __('sale items') }}</h3>
                <x-table>
                    <x-slot name="heading">
                        <x-table.heading style="padding: 12px"> {{ __('product') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('qty') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('price') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('subtotal') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('actions') }} </x-table.heading>
                    </x-slot>

                    @forelse (Cart::content() as $key => $item)
                        <x-table.row wire:loading.class="opacity-50" wire:key="{{ $item->id }}"
                            wire:target="addToCart, increaseQty, decreaseQty, removeFromCart"
                            class="hover:bg-transparent dark:hover:bg-bg-transparent">
                            <x-table.cell class="p-0" style="padding: 12px">
                                {{ Str::limit($item->name, 15, '..') }} </x-table.cell>
                            <x-table.cell style="padding: 12px">
                                <div>
                                    <label for="Quantity" class="sr-only"> Quantity </label>
                                    <div class="flex items-center justify-between border border-gray-200 rounded">
                                        <button wire:loading.attr="disabled" type="button"
                                            wire:click="decreaseQty('{{ $item->rowId }}')"
                                            class="flex items-center justify-center w-10 h-10 leading-10 text-danger bg-danger/10">
                                            <x-heroicon-m-minus class="w-5 h-5" />
                                        </button>

                                        <input type="number" value="{{ $item->qty }}"
                                            class="h-10 w-16 border-transparent text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none focus:ring-primary"
                                            readonly />

                                        <button wire:loading.attr="disabled" type="button"
                                            wire:click="increaseQty('{{ $item->rowId }}')"
                                            class="flex items-center justify-center w-10 h-10 leading-10 bg-success/10 text-success">
                                            <x-heroicon-m-plus class="w-5 h-5" />
                                        </button>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell style="padding: 12px"> {{ $item->price }} </x-table.cell>
                            <x-table.cell style="padding: 12px"> {{ $item->total }} </x-table.cell>
                            <x-table.cell style="padding: 12px">
                                <button wire:click="removeFromCart('{{ $item->rowId }}')"
                                    class="p-2 rounded-full hover:bg-danger/10 text-danger hover:duration-200">
                                    <x-heroicon-m-trash class="w-5 h-5" />
                                </button>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.data-not-found colspan="5" />
                    @endforelse
                </x-table>

                <div class="p-4 space-y-4">
                    @if (Cart::count() >= 1)
                        <div class="flex flex-col gap-1 text-right">
                            <div>Subtotal: <strong>{{ Cart::subtotal() }}</strong></div>
                            <div>Tax: <strong>{{ Cart::tax() }}</strong></div>
                            <div class="text-lg">Total: <strong>{{ Cart::total() }}</strong></div>
                        </div>
                    @endif

                    @if (Cart::count() >= 1)
                        <div class="flex">
                            <label for="customers" class="sr-only">Choose a customer</label>
                            <select wire:model='customer_id' id="customers"
                                class="shadow-sm bg-gray-50 border border-gray-300  text-gray-900 rounded-l text-sm focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 transition ease-in-out dark:text-white dark:focus:ring-primary dark:focus:border-primary capitalize">
                                <option value="">-- {{ __('select customer') }} --</option>
                                @foreach (App\Models\Customer::pluck('name', 'id') as $key => $name)
                                    <option value="{{ $key }}"> {{ $name }} </option>
                                @endforeach
                            </select>

                            <button
                                class="flex-shrink-0 z-10 inline-flex items-center gap-x-1 py-2.5 px-3 text-sm font-medium text-center transition ease-in-out border rounded-r focus:outline-none focus:ring-2 focus:ring-offset-2 text-white bg-primary/90 hover:bg-primary focus:bg-primary active:bg-primary/90 focus:ring-primary/90 border-transparent"
                                type="button">
                                <x-heroicon-m-plus /> {{ __('add') }}
                            </button>
                        </div>

                        @error('customer_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror

                        <div class="text-center">
                            <x-button wire:click="createInvoice">
                                {{ __('create invoice') }}
                            </x-button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-6 col-span-full">
            <div
                class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex flex-wrap items-center justify-between gap-3 p-4">
                    <div class="flex items-center gap-3">
                        <div>{{ __('per page') }}</div>
                        <x-input.select wire:model.change="perPage" style="width: 72px">
                            <option value="10" selected>10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </x-input.select>
                    </div>

                    <form>
                        <label for="employees-search" class="sr-only">Search</label>
                        <div class="relative w-48 sm:w-64 xl:w-96">
                            <x-input wire:model.live.debounce.300ms="search"
                                placeholder="{{ __('search by name, product code') }}.." />
                        </div>
                    </form>
                </div>

                <x-table>
                    <x-slot name="heading">
                        <x-table.heading style="padding: 12px"> {{ __('no') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('name') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('product code') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('selling price') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('actions') }} </x-table.heading>
                    </x-slot>

                    @forelse ($products as $key => $product)
                        <x-table.row wire:loading.class="opacity-50" wire:key="{{ $product->id }}"
                            wire:target="search, perPage" class="hover:bg-transparent dark:hover:bg-bg-transparent">
                            <x-table.cell style="padding: 12px"> {{ $key + 1 }} </x-table.cell>
                            <x-table.cell style="padding: 12px"> {{ Str::limit($product->name, 20, '..') }}
                            </x-table.cell>
                            <x-table.cell style="padding: 12px"> {{ $product->sku }} </x-table.cell>
                            <x-table.cell style="padding: 12px"> {{ $product->selling_price }} </x-table.cell>
                            <x-table.cell style="padding: 12px">
                                <x-button wire:click="addToCart({{ $product }})" size="small">
                                    <x-heroicon-o-plus /> {{ __('add') }}
                                </x-button>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.data-not-found colspan="5" />
                    @endforelse
                </x-table>

                {{-- Pagination --}}
                <div class="p-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
