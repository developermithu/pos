<div>
    <div class="grid grid-cols-1 p-4 lg:grid-cols-12 gap-4 dark:bg-gray-900 lg:mt-1.5">
        <div class="mb-1 col-span-full print:hidden">
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
                                <a wire:navigate href="{{ route('admin.pos.index') }}"
                                    class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                                    {{ __('pos') }}
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                                <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                                    {{ __('generate invoice') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('generate invoice') }}
                </h1>
            </div>
        </div>

        @if (Cart::count() >= 1)
            <div class="w-9/12 m-auto col-span-full">
                <div
                    class="p-12 mb-4 space-y-8 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-start justify-between">
                        <h1 class="text-3xl font-semibold">Invoice #{{ session('invoice_no') }}</h1>

                        <div>
                            <h3 class="text-xl font-semibold text-primary"> {{ config('app.name') }} </h3>
                            <p class="text-gray-500"> {{ date('d M, Y') }} </p>
                        </div>
                    </div>

                    <div>
                        <h3 class="pb-2 text-xl font-bold">Bill To</h3>
                        <address class="text-gray-500">
                            {{ session('customer')['name'] ?? '' }}, <br>
                            {{ session('customer')['address'] ?? '' }}, <br>
                            {{ session('customer')['phone_number'] ?? '' }}
                        </address>
                    </div>

                    <x-table>
                        <x-slot name="heading">
                            <x-table.heading> {{ __('item') }} </x-table.heading>
                            <x-table.heading> {{ __('price') }} </x-table.heading>
                            <x-table.heading> {{ __('qty') }} </x-table.heading>
                            <x-table.heading> {{ __('total') }} </x-table.heading>
                        </x-slot>

                        @foreach (Cart::content() as $item)
                            <x-table.row wire:key="{{ $item->id }}"
                                class="hover:bg-transparent dark:hover:bg-bg-transparent">
                                <x-table.cell class="font-semibold"> {{ $item->name }} </x-table.cell>
                                <x-table.cell> {{ $item->price }} </x-table.cell>
                                <x-table.cell> {{ $item->qty }} </x-table.cell>
                                <x-table.cell> {{ $item->total }} </x-table.cell>
                            </x-table.row>
                        @endforeach

                        <x-table.row class="hover:bg-transparent dark:hover:bg-bg-transparent">
                            <td colspan="4" class="pt-4 text-gray-500">
                                <div class="flex flex-col gap-1 text-right">
                                    <div>Subtotal: <strong>{{ Cart::subtotal() }}</strong></div>
                                    <div>Tax: <strong>{{ Cart::tax() }}</strong></div>
                                    <div class="text-lg">Total: <strong>{{ Cart::total() }}</strong></div>
                                </div>
                            </td>
                        </x-table.row>
                    </x-table>

                    <div class="flex items-center justify-end gap-3 print:hidden">
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
        @endif

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

                <div class="flex items-center justify-end gap-3 pt-2 sm:col-span-full">
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
