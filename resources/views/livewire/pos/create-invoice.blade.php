<div>
    <div class="grid grid-cols-1 p-4 lg:grid-cols-12 gap-4 dark:bg-gray-900 lg:mt-1.5">
        <div class="mb-1 col-span-full print:hidden">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('pos')" :href="route('admin.pos.index')" />
                    <x-breadcrumb.item :label="__('generate invoice')" />
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
                    <a href="javascript:window.print()"
                        class="inline-flex gap-x-1.5 font-semibold uppercase transition ease-in-out rounded items-center active:outline-none active:ring-2 active:ring-offset-2 px-4 py-2 text-sm tracking-widest text-white bg-primary/90 hover:bg-primary focus:bg-primary active:bg-primary/90 focus:ring-primary/90 border-transparent">
                        <x-heroicon-m-printer />
                        {{ __('print') }}
                    </a>
                    <x-button x-on:click.prevent="$dispatch('open-modal', 'generate-invoice')">
                        {{ __('generate invoice') }} </x-button>
                </div>
            </div>
        </div>

        {{-- Generate Invoice Modal --}}
        <x-modal maxWidth="xl" name="generate-invoice">
            <form wire:submit.prevent="generateInvoice" class="grid grid-cols-6 gap-5 p-6 py-8">
                <x-input.group class="sm:col-span-full" for="payment_method" label="{{ __('payment method') }}"
                    :error="$errors->first('payment_method')">
                    <x-input.select wire:model.change="payment_method">
                        <option value="" disabled>-- {{ __('payment method') }} --</option>
                        <option value="cashe"> {{ __('cashe') }} </option>
                        <option value="bkash"> {{ __('bkash') }} </option>
                        <option value="bank"> {{ __('bank') }} </option>
                    </x-input.select>
                </x-input.group>

                @if ($payment_method === 'bkash')
                    <x-input.group for="transaction_id" label="{{ __('bkash transaction id') }}" :error="$errors->first('transaction_id')">
                        <x-input wire:model="transaction_id" id="transaction_id" required />
                    </x-input.group>
                @endif

                @if ($payment_method === 'bank')
                    <x-input.group class="sm:col-span-full" for="bank_details" label="{{ __('bkash details') }}"
                        :error="$errors->first('bank_details')">
                        <x-input.textarea wire:model="bank_details" id="bank_details"></x-input.textarea>
                    </x-input.group>
                @endif

                <x-input.group for="paid_amount" label="{{ __('paid amount') }}" :error="$errors->first('paid_amount')">
                    <x-input wire:model.blur="paid_amount" id="paid_amount" type="number" />
                </x-input.group>

                <x-input.group for="due" label="{{ __('due') }}" :error="$errors->first('due')">
                    <x-input wire:model="due" id="due" disabled="true" />
                </x-input.group>

                <div class="flex items-center justify-center gap-3 pt-2 md:justify-end col-span-full sm:col-span-full">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        cancel
                    </x-secondary-button>

                    <x-button.primary wire:loading.attr="disabled" wire:target="generateInvoice"
                        wire:loading.class="opacity-40">
                        {{ __('submit') }}
                    </x-button.primary>
                </div>
            </form>
        </x-modal>
    </div>
</div>
