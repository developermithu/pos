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
                    <x-breadcrumb.item :label="__('transactions')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('transaction list') }}
                </h1>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-5 dark:divide-gray-700">
                {{-- Search --}}
                <div class="flex items-center gap-5">
                    <x-mary-input wire:model.live.debounce.250ms="search" placeholder="{{ __('search') }}.."
                        class="w-48 border-2 border-gray-100 focus:outline-none focus:border-gray-300 sm:w-64 xl:w-96" />

                    @if ($type || $search || $start_date || $end_date)
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
                </div>

                {{-- Type --}}
                <div class="flex items-center gap-3">
                    <x-mary-dropdown>
                        <x-slot:trigger>
                            <x-mary-button :label="__('Type')" icon-right="o-chevron-down" />
                        </x-slot:trigger>

                        <x-mary-menu-item @click.stop="">
                            <x-mary-checkbox value="credit" wire:model.live="type" :label="__('credit')" />
                        </x-mary-menu-item>
                        <x-mary-menu-item @click.stop="">
                            <x-mary-checkbox value="debit" wire:model.live="type" :label="__('debit')" />
                        </x-mary-menu-item>
                    </x-mary-dropdown>
                </div>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('account info') }} </x-table.heading>
            <x-table.heading> {{ __('reference') }} </x-table.heading>
            <x-table.heading> {{ __('amount') }} </x-table.heading>
            <x-table.heading> {{ __('note') }} </x-table.heading>
            <x-table.heading> {{ __('created') }} </x-table.heading>
        </x-slot>

        @forelse ($transactions as $key => $transaction)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $transaction->id }}"
                wire:target="search, filterByTrash, clear">
                <x-table.cell>
                    {{ $transaction->account?->name }}
                    (<span class="font-semibold ">{{ $transaction->account?->account_no }}</span>)
                </x-table.cell>
                <x-table.cell> {{ $transaction->reference }} </x-table.cell>
                <x-table.cell>
                    @if ($transaction->type->isCredit())
                        <spna class="text-success">
                            +{{ Number::format($transaction->amount) }} TK
                        </spna>
                    @else
                        <spna class="text-danger">
                            -{{ Number::format($transaction->amount) }} TK
                        </spna>
                    @endif
                </x-table.cell>
                <x-table.cell> {{ Str::limit($transaction->note, 100, '..') }} </x-table.cell>
                <x-table.cell> {{ $transaction->created_at->format('d M Y, g:i A') }} </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="8" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $transactions->links() }}
    </div>
</div>
