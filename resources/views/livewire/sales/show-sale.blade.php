<div>
    <div class="grid grid-cols-12 gap-5 px-4 py-6 lg:gap-y-10 dark:bg-gray-900">
        <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
            <x-breadcrumb>
                <x-breadcrumb.item label="sales" :href="route('admin.sales.index')" />
                <x-breadcrumb.item label="details" />
            </x-breadcrumb>

            <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                {{ __('sale details') }}
            </h1>
        </div>

        <!-- Sale Details -->
        <div class="md:col-span-6 col-span-full">
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
                                    {{ __('paid amount') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->paid_amount }} ৳
                                </p>
                            </div>
                        </li>

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('due') }} :
                                </h2>
                                <p class="flex-1 font-medium text-danger mb-0.5">
                                    {{ $sale->total - $sale->paid_amount }} ৳
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

        {{-- Customer Details --}}
        <div class="md:col-span-6 col-span-full">
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
                                    {{ $sale->customer?->name }}
                                </p>
                            </div>
                        </li>

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('address') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->customer?->address }}
                                </p>
                            </div>
                        </li>

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('phone number') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->customer?->phone_number }}
                                </p>
                            </div>
                        </li>

                        <li class="py-3">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class=" text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('company name') }} :
                                </h2>
                                <p class="flex-1 font-medium text-gray-900 mb-0.5 dark:text-white">
                                    {{ $sale->customer?->company_name }}
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
                    <x-table.heading> {{ __('product') }} </x-table.heading>
                    <x-table.heading> {{ __('price') }} </x-table.heading>
                    <x-table.heading> {{ __('qty') }} </x-table.heading>
                    <x-table.heading> {{ __('total') }} </x-table.heading>
                </x-slot>

                @forelse ($sale->items as $item)
                    <x-table.row wire:key="{{ $item->id }}" class="hover:bg-transparent dark:hover:bg-transparent">
                        <x-table.cell class="font-medium text-gray-800 dark:text-white">
                            {{ $item->product?->name }} ({{ $item->product?->sku }})
                        </x-table.cell>
                        <x-table.cell> {{ $item->price }} TK </x-table.cell>
                        <x-table.cell class="!lowercase"> {{ $item->qty }} {{ $item->saleUnit?->short_name }}
                        </x-table.cell>
                        <x-table.cell> {{ $item->qty * $item->price }} TK </x-table.cell>
                        {{-- <x-table.cell class="space-x-2">
                        <x-button size="small" :href="route('admin.items.show', $item)">
                            {{ __('details') }}
                        </x-button>
                    </x-table.cell> --}}
                    </x-table.row>
                @empty
                    <x-table.data-not-found colspan="5" />
                @endforelse

                @if ($sale->items->count() > 0)
                    <x-table.row class="text-lg font-bold">
                        <td colspan="2"></td>
                        <x-table.cell colspan="1"> {{ __('total') }} </x-table.cell>
                        <x-table.cell colspan="1" class="!text-primary"> {{ Number::format($sale->total) }} TK
                        </x-table.cell>
                    </x-table.row>
                @endif
            </x-table>
        </div>
    </div>
</div>
