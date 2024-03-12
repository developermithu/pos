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
                    <x-breadcrumb.item label="suppliers" :href="route('admin.suppliers.index')" />
                    <x-breadcrumb.item label="due report" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('supplier due report') }}
                </h1>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-5 dark:divide-gray-700">
                {{-- Search --}}
                <div class="flex items-center gap-5">
                    <x-mary-input wire:model.live.debounce.300ms="search" placeholder="{{ __('search') }}.."
                        class="w-48 border-2 border-gray-100 focus:outline-none focus:border-gray-300 sm:w-64 xl:w-96" />

                    @if ($status || $search || $start_date || $end_date || $supplier_id)
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

                    <x-input.group label="supplier">
                        <x-input.select wire:model.change="supplier_id" id="supplier" class="!w-64">
                            <option value=""> {{ __('all supplier') }} </option>
                            @foreach (App\Models\Supplier::pluck('name', 'id') as $key => $name)
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

                        @foreach (App\Enums\PurchaseStatus::forselect() as $value => $name)
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
            <x-table.heading> {{ __('supplier') }} </x-table.heading>
            <x-table.heading> {{ __('invoice no') }} </x-table.heading>
            <x-table.heading> {{ __('products') }} </x-table.heading>
            <x-table.heading> {{ __('total') }} </x-table.heading>
            <x-table.heading> {{ __('paid') }} </x-table.heading>
            <x-table.heading> {{ __('due') }} </x-table.heading>
            <x-table.heading> {{ __('date') }} </x-table.heading>
            <x-table.heading> {{ __('purchase status') }} </x-table.heading>
        </x-slot>

        @php
            $totalPurchase = 0;
            $totalPaid = 0;
            $totalDue = 0;
        @endphp

        @forelse ($purchases as $key => $purchase)
            @php
                $totalPurchase += $purchase->total;
                $totalPaid += $purchase->paid_amount;
                $totalDue += $purchase->total - $purchase->paid_amount;
            @endphp

            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $purchase->id }}">
                <x-table.cell> {{ $purchase->supplier?->name }} </x-table.cell>
                <x-table.cell> {{ $purchase->invoice_no }} </x-table.cell>
                <x-table.cell>
                    @foreach ($purchase->items as $item)
                        {{ $item->product?->name }} - {{ $item->qty }}
                        {{ $item->product?->unit?->short_name }} <br>
                    @endforeach
                </x-table.cell>
                <x-table.cell class="!text-primary"> {{ Number::format($purchase->total) }} TK </x-table.cell>
                <x-table.cell class="!text-success">
                    @if ($purchase->paid_amount)
                        {{ Number::format($purchase->paid_amount) }} TK
                    @else
                    @endif
                </x-table.cell>
                <x-table.cell class="!text-danger">
                    {{ Number::format($purchase->total - $purchase->paid_amount) }} TK
                </x-table.cell>
                <x-table.cell> {{ $purchase->date->format('d M Y, g:i A') }} </x-table.cell>
                <x-table.cell> {!! $purchase->status->getLabelHTML() !!} </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="8" />
        @endforelse

        @if ($purchases->count() > 0)
            <x-table.row class="font-semibold" wire:loading.class="opacity-50">
                <x-table.cell colspan="3"> {{ __('total') }} </x-table.cell>
                <x-table.cell colspan="1" class="!text-primary"> {{ Number::format($totalPurchase) }} TK
                </x-table.cell>
                <x-table.cell colspan="1" class="!text-success"> {{ Number::format($totalPaid) }} TK </x-table.cell>
                <x-table.cell colspan="3" class="!text-danger"> {{ Number::format($totalDue) }} TK </x-table.cell>
            </x-table.row>
        @endif

        <x-table.row class="font-semibold" wire:loading.class="opacity-50">
            <x-table.cell colspan="5"> {{ __('total initial due') }} </x-table.cell>
            <x-table.cell colspan="1" class="!text-danger">
                @php
                    $totalInitialDue = App\Models\Supplier::sum('initial_due');
                @endphp

                {{ Number::format($totalInitialDue) }} TK
            </x-table.cell>
            <x-table.cell colspan="2"></x-table.cell>
        </x-table.row>
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $purchases->links() }}
    </div>
</div>
