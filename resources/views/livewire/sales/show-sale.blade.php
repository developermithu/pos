<div>
    <div class="grid grid-cols-12 gap-5 px-4 py-6 lg:gap-y-10 dark:bg-gray-900">
        <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
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
                            <a wire:navigate href="{{ route('admin.sales.index') }}"
                                class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                                {{ __('sales') }}
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                            <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                                {{ __('details') }}
                            </span>
                        </div>
                    </li>
                </ol>
            </nav>

            <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                {{ __('sales details') }}
            </h1>
        </div>

        <!-- Right Content -->
        <div class="xl:col-span-4 md:col-span-6 col-span-full">
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
                <div class="flow-root">
                    <h3 class="text-xl font-semibold capitalize dark:text-white"> {{ __('sale details') }} </h3>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('invoice no') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    #{{ $sale->invoice_no }}
                                </p>
                            </div>
                        </li>

                        {{-- <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('subtotal') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->subtotal }}
                                </p>
                            </div>
                        </li> --}}

                        {{-- <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('vat') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->tax ?? 0 }}
                                </p>
                            </div>
                        </li> --}}

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('total') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->total }} ৳
                                </p>
                            </div>
                        </li>

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('status') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {!! $sale->status->getLabelHtml() !!}
                                </p>
                            </div>
                        </li>

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('selling date') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->date->format('d M, Y') }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="xl:col-span-4 md:col-span-6 col-span-full">
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flow-root">
                    <h3 class="text-xl font-semibold capitalize dark:text-white"> {{ __('transaction details') }} </h3>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="capitalize text-gray-900 mb-0.5 dark:text-white">
                                    {{ __('payment method') }} :
                                </h2>
                                <p @class([
                                    'flex-1 font-medium text-gray-900 mb-0.5',
                                    'text-[#E2136E]' => $sale->transaction->method === 'bkash',
                                    'text-primary' => $sale->transaction->method === 'bank',
                                ])>
                                    {{ $sale->transaction->method }}
                                </p>
                            </div>
                        </li>

                        @if ($sale->transaction->method === 'bkash')
                            <li class="py-3">
                                <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                    <h2 class="capitalize text-gray-900 mb-0.5 dark:text-white">
                                        {{ __('transaction id') }} :
                                    </h2>
                                    <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                        {{ $sale->transaction->transaction_id }}
                                    </p>
                                </div>
                            </li>
                        @endif

                        @if ($sale->transaction->method === 'bank')
                            <li class="py-3">
                                <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                    <h2 class="capitalize text-gray-900 mb-0.5 dark:text-white">
                                        {{ __('details') }} :
                                    </h2>
                                    <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                        {{ $sale->transaction->details }}
                                    </p>
                                </div>
                            </li>
                        @endif

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="capitalize text-gray-900 mb-0.5 dark:text-white">
                                    {{ __('status') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {!! $sale->transaction->status->getLabelHtml() !!}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="xl:col-span-4 md:col-span-6 col-span-full">
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-4 dark:bg-gray-800">
                <div class="flow-root">
                    <h3 class="text-xl font-semibold capitalize dark:text-white"> {{ __('customer details') }} </h3>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('name') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->customer->name }}
                                </p>
                            </div>
                        </li>

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('address') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->customer->address }}
                                </p>
                            </div>
                        </li>

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('phone number') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->customer->phone_number }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{--  sale items product --}}
        <div class="col-span-full">
            <x-table>
                <x-slot name="heading">
                    <x-table.heading> {{ __('product code') }} </x-table.heading>
                    <x-table.heading> {{ __('name') }} </x-table.heading>
                    <x-table.heading> {{ __('qty') }} </x-table.heading>
                    <x-table.heading> {{ __('price') }} </x-table.heading>
                    <x-table.heading> {{ __('total') }} </x-table.heading>
                </x-slot>

                @forelse ($sale->items as $item)
                    <x-table.row wire:key="{{ $item->id }}" class="hover:bg-transparent dark:hover:bg-transparent">
                        <x-table.cell class="font-medium text-gray-800 dark:text-white"> {{ $item->product->sku }}
                        </x-table.cell>
                        <x-table.cell> {{ $item->product->name }} </x-table.cell>
                        <x-table.cell> {{ $item->qty }} </x-table.cell>
                        <x-table.cell> {{ $item->price }} </x-table.cell>
                        <x-table.cell> {{ $item->qty * $item->price }} </x-table.cell>

                        {{-- <x-table.cell class="space-x-2">
                        <x-button size="small" :href="route('admin.items.show', $item)">
                            {{ __('details') }}
                        </x-button>
                    </x-table.cell> --}}
                    </x-table.row>

                @empty
                    <x-table.data-not-found colspan="5" />
                @endforelse
            </x-table>
        </div>
    </div>
</div>
