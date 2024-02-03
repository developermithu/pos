@assets
    {{-- Flatpickr  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endassets

<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="customers" :href="route('admin.customers.index')" />
                    <x-breadcrumb.item label="due report" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('customer due report') }}
                </h1>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-5 dark:divide-gray-700">
                {{-- Search --}}
                <div class="flex items-center gap-5">
                    <x-mary-input wire:model.live.debounce.300ms="search" placeholder="{{ __('search') }}.."
                        class="w-48 border-2 border-gray-100 focus:outline-none focus:border-gray-300 sm:w-64 xl:w-96" />

                    @if ($status || $search || $start_date || $end_date || $customer_id)
                        <x-mary-button wire:click="clear" icon="o-x-mark"
                            class="btn-circle btn-ghost text-danger hover:bg-danger/10" />
                    @endif
                </div>

                {{-- Start and End Date --}}
                <div class="flex flex-wrap items-center gap-5 pb-0 sm:pb-6 lg:pb-4">
                    @php
                        $config = ['dateFormat' => 'Y-m-d', 'altFormat' => 'd M Y'];
                    @endphp

                    <x-mary-datepicker wire:model.live="start_date" icon="o-calendar" :config="$config"
                        :placeholder="__('start date')" :label="__('start date')"
                        class="border-2 border-gray-100 focus:outline-none focus:border-gray-300" />

                    <x-mary-datepicker wire:model.live="end_date" icon="o-calendar" :config="$config" :placeholder="__('end date')"
                        :label="__('end date')" class="border-2 border-gray-100 focus:outline-none focus:border-gray-300" />

                    <x-input.group label="customer">
                        <x-input.select wire:model.change="customer_id" id="customer" class="!w-64">
                            <option value=""> {{ __('all customer') }} </option>
                            @foreach (App\Models\Customer::pluck('name', 'id') as $key => $name)
                                <option value="{{ $key }}"> {{ $name }} </option>
                            @endforeach
                        </x-input.select>
                    </x-input.group>
                </div>

                {{-- status --}}
                <div class="flex items-center gap-3">
                    <x-mary-dropdown>
                        <x-slot:trigger>
                            <x-mary-button :label="__('status')" icon-right="o-chevron-down" />
                        </x-slot:trigger>

                        @foreach (App\Enums\SaleStatus::forselect() as $value => $name)
                            <x-mary-menu-item @click.stop="">
                                <x-mary-checkbox value="{{ $value }}" wire:model.live="status"
                                    :label="$name" />
                            </x-mary-menu-item>
                        @endforeach
                    </x-mary-dropdown>
                </div>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('customer') }} </x-table.heading>
            <x-table.heading> {{ __('invoice_no') }} </x-table.heading>
            <x-table.heading> {{ __('products') }} </x-table.heading>
            <x-table.heading> {{ __('total') }} </x-table.heading>
            <x-table.heading> {{ __('paid') }} </x-table.heading>
            <x-table.heading> {{ __('due') }} </x-table.heading>
            <x-table.heading> {{ __('date') }} </x-table.heading>
            <x-table.heading> {{ __('sale status') }} </x-table.heading>
        </x-slot>

        @php
            $totalSale = 0;
            $totalPaid = 0;
            $totalDue = 0;
        @endphp

        @forelse ($sales as $key => $sale)
            @php
                $totalSale += $sale->total;
                $totalPaid += $sale->paid_amount;
                $totalDue += $sale->total - $sale->paid_amount;
            @endphp

            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $sale->id }}">
                <x-table.cell> {{ $sale->customer?->name }} </x-table.cell>
                <x-table.cell> {{ $sale->invoice_no }} </x-table.cell>
                <x-table.cell>
                    @foreach ($sale->items as $item)
                        {{ $item->product?->name }} - {{ $item->qty }}
                        {{ $item->product?->unit?->short_name }} <br>
                    @endforeach
                </x-table.cell>
                <x-table.cell class="!text-primary"> {{ Number::format($sale->total) }} TK </x-table.cell>
                <x-table.cell class="!text-success">
                    @if ($sale->paid_amount)
                        {{ Number::format($sale->paid_amount) }} TK
                    @else
                    @endif
                </x-table.cell>
                <x-table.cell class="!text-danger">
                    {{ Number::format($sale->total - $sale->paid_amount) }} TK
                </x-table.cell>
                <x-table.cell> {{ $sale->date->format('d M Y, g:i A') }} </x-table.cell>
                <x-table.cell> {!! $sale->status->getLabelHTML() !!} </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="8" />
        @endforelse

        @if ($sales->count() > 0)
            <x-table.row class="font-semibold" wire:loading.class="opacity-50">
                <x-table.cell colspan="3"> {{ __('total') }} </x-table.cell>
                <x-table.cell colspan="1" class="!text-primary"> {{ Number::format($totalSale) }} TK </x-table.cell>
                <x-table.cell colspan="1" class="!text-success"> {{ Number::format($totalPaid) }} TK </x-table.cell>
                <x-table.cell colspan="3" class="!text-danger"> {{ Number::format($totalDue) }} TK </x-table.cell>
            </x-table.row>
        @endif
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $sales->links() }}
    </div>
</div>
