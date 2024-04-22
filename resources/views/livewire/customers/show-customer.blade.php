<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="customers" :href="route('admin.customers.index')" />
                    <x-breadcrumb.item label="details" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('customer details') }}
                </h1>
            </div>

            <div class="grid w-full grid-cols-1 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
                {{-- Customer details --}}
                <div class="col-span-full xl:col-auto">
                    <div
                        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                        <div>
                            <img src="{{ asset('assets/male.webp') }}" alt="avatar"
                                class="w-20 h-20 lg:m-auto mix-blend-difference md:w-32 md:h-32">
                        </div>

                        <div>
                            <dl class="sm:divide-y sm:divide-gray-200">
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ __('name') }} :
                                    </dt>
                                    <dd class="mt-1 text-sm font-semibold text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $customer->name }}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ __('phone number') }} :
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $customer->phone_number }}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ __('company name') }} :
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $customer?->company_name }}
                                    </dd>
                                </div>
                                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-2">
                                    <dt class="text-sm font-medium text-gray-500">
                                        {{ __('address') }} :
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $customer?->address }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                {{-- Other info --}}
                <div class="col-span-2">
                    <div
                        class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                        <div
                            class="grid grid-cols-1 gap-5 mb-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4">
                            <x-mary-stat :title="__('total sales')" value="{{ Number::format($customer->totalSale()) }}"
                                icon="o-currency-bangladeshi" class="bg-primary/10" />
                            <x-mary-stat :title="__('total paid')" value="{{ Number::format($customer->totalPaid()) }}"
                                icon="o-currency-bangladeshi" class="bg-primary/10" />
                            <x-mary-stat :title="__('total due')" value="{{ Number::format($customer->totalDue()) }}"
                                icon="o-currency-bangladeshi" class="bg-primary/10" />
                            <x-mary-stat :title="__('deposit balance')" value="{{ Number::format($customer->depositBalance()) }}"
                                icon="o-currency-bangladeshi" class="bg-primary/10" />
                        </div>

                        <x-mary-tabs selected="sales-tab">
                            <x-mary-tab name="sales-tab" label="Sales" icon="o-shopping-cart">
                                <x-table>
                                    <x-slot name="heading">
                                        <x-table.heading> {{ __('#') }} </x-table.heading>
                                        <x-table.heading> {{ __('invoice no') }} </x-table.heading>
                                        <x-table.heading> {{ __('total') }} </x-table.heading>
                                        <x-table.heading> {{ __('paid amount') }} </x-table.heading>
                                        <x-table.heading> {{ __('due') }} </x-table.heading>
                                        <x-table.heading> {{ __('status') }} </x-table.heading>
                                        <x-table.heading> {{ __('payment status') }} </x-table.heading>
                                        <x-table.heading> {{ __('actions') }} </x-table.heading>
                                    </x-slot>

                                    @forelse ($customer->sales as $index => $sale)
                                        @php $due = $sale->total - $sale->paid_amount; @endphp
                                        <x-table.row wire:loading.class="opacity-50" wire:key="{{ $sale->id }}"
                                            wire:target="search, filterByTrash, clear">
                                            <x-table.cell> {{ $index + 1 }} </x-table.cell>
                                            <x-table.cell> #{{ $sale->invoice_no }} </x-table.cell>
                                            <x-table.cell> {{ number_format($sale->total) }} TK </x-table.cell>
                                            <x-table.cell> {{ number_format($sale->paid_amount) }} TK
                                                @if (
                                                    $sale->payment_status === App\Enums\SalePaymentStatus::PAID &&
                                                        $sale->paid_amount === $sale->total &&
                                                        $sale->payments->isEmpty())
                                                    <span class="text-xs text-success">(Deposit)</span>
                                                @endif </x-table.cell>
                                            <x-table.cell @class(['font-semibold', '!text-danger' => $due > 0])>
                                                {{ Number::format($due) }} TK
                                            </x-table.cell>
                                            <x-table.cell> {!! $sale->status->getLabelHtml() !!} </x-table.cell>
                                            <x-table.cell> {!! $sale->payment_status->getLabelHtml() !!} </x-table.cell>
                                            <x-table.cell>
                                                <x-button flat="secondary" :href="route('admin.sales.show', $sale->id)">
                                                    <x-heroicon-o-eye /> {{ __('view') }}
                                                </x-button>
                                            </x-table.cell>
                                        </x-table.row>
                                    @empty
                                        <x-table.data-not-found colspan="8" />
                                    @endforelse
                                </x-table>
                            </x-mary-tab>

                            <x-mary-tab name="payments-tab" label="Payments" icon="o-banknotes">
                                <x-table>
                                    <x-slot name="heading">
                                        <x-table.heading> {{ __('reference') }} </x-table.heading>
                                        <x-table.heading> {{ __('amount') }} </x-table.heading>
                                        <x-table.heading> {{ __('paid by') }} </x-table.heading>
                                        <x-table.heading> {{ __('account') }} </x-table.heading>
                                        <x-table.heading> {{ __('date') }} </x-table.heading>
                                    </x-slot>

                                    @forelse ($payments as $index => $payment)
                                        <x-table.row wire:key="{{ $payment->id }}">
                                            <x-table.cell> {{ $payment->reference }} </x-table.cell>
                                            <x-table.cell> {{ Number::format($payment->amount) }} TK </x-table.cell>
                                            <x-table.cell> {{ $payment->paid_by }} </x-table.cell>
                                            <x-table.cell> {{ $payment->account?->name }} </x-table.cell>
                                            <x-table.cell> {{ $payment->created_at->format('d M, Y') }} </x-table.cell>
                                        </x-table.row>
                                    @empty
                                        <x-table.data-not-found colspan="5" />
                                    @endforelse
                                </x-table>
                            </x-mary-tab>

                            <x-mary-tab name="deposits-tab" label="Deposits" icon="o-currency-bangladeshi">
                                @php
                                    $headers = [
                                        ['key' => 'amount', 'label' => 'Amount'],
                                        ['key' => 'details', 'label' => 'Details'], // nested
                                        ['key' => 'created_at', 'label' => 'Created At'],
                                    ];
                                @endphp

                                <x-mary-table :headers="$headers" :rows="$customer->deposits">
                                    @scope('cell_created_at', $deposit)
                                        {{ $deposit->created_at->format('d M, Y') }}
                                    @endscope
                                </x-mary-table>
                            </x-mary-tab>
                        </x-mary-tabs>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
