<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="balance adjustment" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('balance adjustment list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                </div>

                <div class="flex items-center gap-3">
                    @can('create', App\Models\BalanceAdjustment::class)
                        <x-button :href="route('admin.accounts.balance-adjustment.create')">
                            <x-heroicon-m-plus class="w-4 h-4" />
                            {{ __('add new') }}
                        </x-button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('account name') }} </x-table.heading>
            <x-table.heading> {{ __('account no') }} </x-table.heading>
            <x-table.heading> {{ __('amount') }} </x-table.heading>
            <x-table.heading> {{ __('type') }} </x-table.heading>
            <x-table.heading> {{ __('details') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($balanceAdjustments as $key => $balanceAdjustment)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $balanceAdjustment->id }}"
                wire:target="search, filterByTrash, clear, deleteSelected, destroy, forceDelete, restore">
                <x-table.cell> {{ $balanceAdjustment->payment?->account?->name }} </x-table.cell>
                <x-table.cell> {{ $balanceAdjustment->payment?->account?->account_no }} </x-table.cell>
                <x-table.cell> {{ Number::format($balanceAdjustment->amount) }} </x-table.cell>
                <x-table.cell>
                    {!! $balanceAdjustment->type->getLabelHtml() !!}
                </x-table.cell>
                <x-table.cell>
                    {{ Str::limit($balanceAdjustment->payment?->details, 50, '..') }}
                </x-table.cell>
                <x-table.cell class="space-x-2">
                    @can('update', $balanceAdjustment)
                        <x-button flat="warning" :href="route('admin.accounts.balance-adjustment.edit', $balanceAdjustment->ulid)">
                            <x-heroicon-o-pencil-square /> {{ __('edit') }}
                        </x-button>
                    @endcan

                    @can('delete', $balanceAdjustment)
                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $balanceAdjustment->ulid }}')">
                            <x-heroicon-o-trash /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $balanceAdjustment])
                    @endcan
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="6" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $balanceAdjustments->links() }}
    </div>
</div>
