<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item :label="__('accounts')" :href="route('admin.accounts.index')" />
                    <x-breadcrumb.item :label="__('money transfer')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('account list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\MoneyTransfer::class)
                        <x-button x-on:click.prevent="$dispatch('open-modal', 'create')">
                            <x-heroicon-m-plus class="w-4 h-4" />
                            {{ __('add new') }}
                        </x-button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- Create Modal --}}
    @include('modals.create-money-transfer', ['size' => 'xl'])

    <x-table>
        <x-slot name="heading">
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('from account') }} </x-table.heading>
            <x-table.heading> {{ __('to account') }} </x-table.heading>
            <x-table.heading> {{ __('amount') }} </x-table.heading>
            <x-table.heading> {{ __('created') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($moneyTransfers as $key => $moneyTransfer)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $moneyTransfer->id }}"
                wire:target="search, filterByTrash, clear, deleteSelected, destroy, forceDelete, restore">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $moneyTransfer->id }}"
                        id="{{ $moneyTransfer->id }}" for="{{ $moneyTransfer->id }}" />
                </x-table.cell>
                <x-table.cell> {{ $moneyTransfer->fromAccount?->name }} </x-table.cell>
                <x-table.cell> {{ $moneyTransfer->toAccount?->name }} </x-table.cell>
                <x-table.cell> {{ Number::format($moneyTransfer->amount) }} </x-table.cell>
                <x-table.cell> {{ $moneyTransfer->created_at->format('d M Y') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($moneyTransfer->trashed())
                        <x-button flat="primary" wire:click="restore({{ $moneyTransfer->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $moneyTransfer->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $moneyTransfer])
                    @else
                        @can('delete', $moneyTransfer)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $moneyTransfer->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>

                            @include('partials.delete-modal', ['data' => $moneyTransfer])
                        @endcan
                    @endif
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="6" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $moneyTransfers->links() }}
    </div>
</div>
