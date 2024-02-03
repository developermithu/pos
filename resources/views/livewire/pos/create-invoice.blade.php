<div>
    <div class="grid grid-cols-1 p-4 lg:grid-cols-12 gap-4 dark:bg-gray-900 lg:mt-1.5">
        <div class="mb-1 col-span-full print:hidden">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="pos" :href="route('admin.pos.index')" />
                    <x-breadcrumb.item label="generate invoice" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('generate invoice') }}
                </h1>
            </div>
        </div>

        <div class="w-full m-auto lg:w-9/12 col-span-full">
            <div
                class="p-5 mb-4 space-y-8 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 lg:p-12 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <h1 class="order-2 text-lg font-semibold uppercase sm:text-xl md:text-2xl md:order-1">
                        {{ __('invoice no') }} #{{ $sale->invoice_no }}</h1>

                    <div class="order-1 md:order-2">
                        <h3 class="text-xl font-semibold md:text-2xl text-primary"> {{ config('app.name') }} </h3>
                        <p class="text-gray-500"> {{ date('d M, Y') }} </p>
                    </div>
                </div>

                <div class="capitalize">
                    <h3 class="pb-2 text-xl font-bold"> {{ __('bill to') }} </h3>
                    <address class="text-gray-500">
                        {{ $sale->customer?->name }}, <br>
                        {{ $sale->customer?->address }}, <br>
                        {{ $sale->customer?->phone_number }}
                    </address>
                </div>

                <x-table>
                    <x-slot name="heading">
                        <x-table.heading> {{ __('item') }} </x-table.heading>
                        <x-table.heading> {{ __('price') }} </x-table.heading>
                        <x-table.heading> {{ __('qty') }} </x-table.heading>
                        <x-table.heading> {{ __('total') }} </x-table.heading>
                    </x-slot>

                    @foreach ($sale->items as $item)
                        <x-table.row wire:key="{{ $item->id }}"
                            class="hover:bg-transparent dark:hover:bg-bg-transparent">
                            <x-table.cell class="font-semibold"> {{ $item->product?->name }} </x-table.cell>
                            <x-table.cell> {{ $item->price }} </x-table.cell>
                            <x-table.cell> {{ $item->qty }} </x-table.cell>
                            <x-table.cell> {{ $item->price * $item->qty }} </x-table.cell>
                        </x-table.row>
                    @endforeach

                    <x-table.row class="hover:bg-transparent dark:hover:bg-bg-transparent">
                        <td colspan="4" class="pt-4 text-gray-500">
                            <div class="flex flex-col gap-1 text-right">
                                <div> {{ __('subtotal') }}: <strong> {{ $sale->subtotal }} </strong></div>
                                <div> {{ __('tax') }}: <strong> {{ $sale->tax }} </strong></div>
                                <div class="text-lg"> {{ __('total') }}: <strong> {{ $sale->total }} </strong>
                                </div>
                            </div>
                        </td>
                    </x-table.row>
                </x-table>

                <div class="flex flex-wrap items-center justify-end gap-3 print:hidden">
                    <x-button type="secondary" :href="route('admin.pos.index')">
                        {{ __('go back') }} </x-button>

                    <a href="javascript:window.print()"
                        class="inline-flex gap-x-1.5 font-semibold uppercase transition ease-in-out rounded items-center active:outline-none active:ring-2 active:ring-offset-2 px-4 py-2 text-sm tracking-widest text-white bg-primary/90 hover:bg-primary focus:bg-primary active:bg-primary/90 focus:ring-primary/90 border-transparent">
                        <x-heroicon-m-printer />
                        {{ __('print') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
