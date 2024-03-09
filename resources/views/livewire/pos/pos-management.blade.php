<div>
    <div class="grid grid-cols-1 p-4 lg:grid-cols-12 gap-4 dark:bg-gray-900 lg:mt-1.5">
        <div class="mb-1 col-span-full">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="pos" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('pos management') }}
                </h1>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="lg:col-span-6 col-span-full ">
            <div
                class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="p-4 text-xl font-semibold sm:pt-6 dark:text-white">{{ __('sale items') }}</h3>

                {{-- Cart Items --}}
                <x-table>
                    <x-slot name="heading">
                        <x-table.heading style="padding: 12px"> {{ __('product') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('qty') }} </x-table.heading>
                        {{-- <x-table.heading style="padding: 12px"> {{ __('unit') }} </x-table.heading> --}}
                        <x-table.heading style="padding: 12px"> {{ __('sale price') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('subtotal') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('actions') }} </x-table.heading>
                    </x-slot>

                    @forelse (Cart::content() as $key => $item)
                        <x-table.row wire:loading.class="opacity-50" wire:key="{{ $item->id }}"
                            wire:target="addToCart, removeFromCart"
                            class="hover:bg-transparent dark:hover:bg-bg-transparent">
                            <x-table.cell class="p-0" style="padding: 12px">
                                {{ Str::limit($item->name, 75, '..') }} </x-table.cell>

                            <x-table.cell style="padding: 12px">
                                <x-mary-input type="number" value="{{ $item->qty }}"
                                    wire:change="updateQty('{{ $item->rowId }}', $event.target.value)"
                                    suffix="{{ $item->model?->saleUnit?->short_name ?? $item->model?->unit?->short_name }}"
                                    hint="Available quantity: {{ $item->model?->qty }}
                                    {{ $item->model?->unit?->short_name }}" />
                            </x-table.cell>

                            @php
                                $saleUnit = $item->model?->saleUnit?->name ?? $item->model?->unit?->name;
                            @endphp

                            <x-table.cell style="padding: 12px">
                                <x-mary-input type="number" value="{{ $item->price }}"
                                    wire:change="updatePrice('{{ $item->rowId }}', $event.target.value)"
                                    suffix="TK"
                                    hint="Per {{ $saleUnit }} = {{ $item->price }} TK " />
                            </x-table.cell>

                            <x-table.cell style="padding: 12px"> {{ $item->total }} </x-table.cell>

                            <x-table.cell style="padding: 12px">
                                <button
                                    wire:click="showProductEditModal('{{ $item->rowId }}', {{ $item->model?->id }})"
                                    class="p-2 rounded-full text-primary hover:bg-primary/10 hover:duration-200">
                                    <x-heroicon-m-pencil-square class="w-5 h-5" />
                                </button>

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
                            <div> {{ __('subtotal') }}: <strong>{{ Cart::subtotal() }}</strong></div>
                            <div> {{ __('tax') }}: <strong>{{ Cart::tax() }}</strong></div>
                            <div class="text-lg"> {{ __('total') }}: <strong>{{ Cart::total() }}</strong></div>
                        </div>
                    @endif
                </div>

                @if (Cart::count() >= 1)
                    <form wire:submit.prevent="createInvoice" class="p-4">
                        <div class="grid grid-cols-6 gap-4 mb-5">
                            <div class="col-span-6">
                                <div class="flex">
                                    <select wire:model.change='customer_id' required
                                        class="shadow-sm bg-gray-50 border border-gray-300  text-gray-900 rounded-l text-sm focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 transition ease-in-out dark:text-white dark:focus:ring-primary dark:focus:border-primary capitalize"
                                        id="customer_id">
                                        <option value="" disabled>-- {{ __('select customer') }} --</option>
                                        @foreach (App\Models\Customer::pluck('name', 'id') as $key => $name)
                                            <option value="{{ $key }}"> {{ $name }} </option>
                                        @endforeach
                                    </select>

                                    <button x-on:click="$dispatch('open-modal', 'create')"
                                        class="flex-shrink-0 z-10 inline-flex items-center gap-x-1 py-2.5 px-3 text-sm font-medium text-center transition ease-in-out border rounded-r focus:outline-none focus:ring-2 focus:ring-offset-2 text-white bg-primary/90 hover:bg-primary focus:bg-primary active:bg-primary/90 focus:ring-primary/90 border-transparent"
                                        type="button">
                                        <x-heroicon-m-plus /> {{ __('add') }}
                                    </button>
                                </div>

                                @error('customer_id')
                                    <div class="text-sm text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <x-input.group for="status" label="{{ __('sale status *') }}" :error="$errors->first('status')">
                                    <x-input.select wire:model="status" required>
                                        @foreach (App\Enums\SaleStatus::forSelect() as $value => $name)
                                            <option value="{{ $value }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </x-input.select>
                                </x-input.group>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <x-input.group for="payment_status" label="{{ __('payment status *') }}"
                                    :error="$errors->first('payment_status')">
                                    <x-input.select wire:model.change="payment_status">
                                        <option value="" disabled>-- {{ __('choose payment status') }} --
                                        </option>
                                        @foreach (App\Enums\SalePaymentStatus::forSelect() as $value => $name)
                                            <option value="{{ $value }}"> {{ $name }} </option>
                                        @endforeach
                                    </x-input.select>
                                </x-input.group>
                            </div>

                            @if (
                                $payment_status === App\Enums\SalePaymentStatus::PARTIAL->value ||
                                    $payment_status === App\Enums\SalePaymentStatus::PAID->value)
                                <div class="col-span-6 sm:col-span-3">
                                    <x-input.group for="paid_by" label="paid by *" :error="$errors->first('paid_by')">
                                        <x-input.select wire:model="paid_by">
                                            <option value="" disabled>-- {{ __('choose payment method') }} --
                                            </option>
                                            @foreach (App\Enums\PaymentPaidBy::forSelect() as $value => $name)
                                                <option value="{{ $value }}"> {{ $name }} </option>
                                            @endforeach
                                        </x-input.select>
                                    </x-input.group>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-input.group for="account_id" label="account name *" :error="$errors->first('account_id')">
                                        <x-input.select wire:model="account_id">
                                            <option value="" disabled>-- {{ __('choose account') }} --
                                            </option>
                                            @foreach ($accounts as $key => $name)
                                                <option value="{{ $key }}"> {{ $name }} </option>
                                            @endforeach
                                        </x-input.select>
                                    </x-input.group>
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <x-input.group for="paid_amount" label="{{ __('paying amount *') }}"
                                        :error="$errors->first('paid_amount')">
                                        <x-input type="text" wire:model="paid_amount" id="paid_amount" />
                                    </x-input.group>
                                </div>
                            @endif

                            <div class="col-span-6">
                                <x-input.group for="details" label="{{ __('details') }}" :error="$errors->first('details')">
                                    <x-input.textarea wire:model="details" id="details" rows="3" />
                                </x-input.group>
                            </div>
                        </div>

                        <x-button wire:loading.attr="disabled" wire:loading.class="opacity-40"
                            wire:target="createInvoice">
                            {{ __('submit') }}
                        </x-button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Create Modal --}}
        @include('modals.create-customer', ['size' => 'lg'])

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
                        <x-table.heading style="padding: 12px"> {{ __('product code') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('name') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('price') }} </x-table.heading>
                        <x-table.heading style="padding: 12px"> {{ __('actions') }} </x-table.heading>
                    </x-slot>

                    @forelse ($products as $key => $product)
                        <x-table.row wire:loading.class="opacity-50" wire:key="{{ $product->id }}"
                            wire:target="search, perPage" class="hover:bg-transparent dark:hover:bg-bg-transparent">
                            <x-table.cell style="padding: 12px"> {{ $product->sku }} </x-table.cell>
                            <x-table.cell style="padding: 12px"> {{ Str::limit($product->name, 20, '..') }}
                            </x-table.cell>
                            <x-table.cell style="padding: 12px"> {{ Number::currency($product->price, 'BDT') }}
                            </x-table.cell>
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

    @include('modals.edit-sale-product')
</div>
