<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="accounts" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('account list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Account::class)
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
    @include('modals.create-account', ['size' => 'xl'])

    <x-table>
        <x-slot name="heading">
            <x-table.heading> {{ __('account no') }} </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('initial balance') }} </x-table.heading>
            <x-table.heading> {{ __('credit') }} </x-table.heading>
            <x-table.heading> {{ __('debit') }} </x-table.heading>
            <x-table.heading> {{ __('total balance') }} </x-table.heading>
            <x-table.heading> {{ __('active') }} </x-table.heading>
            <x-table.heading> {{ __('details') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($accounts as $key => $account)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $account->id }}"
                wire:target="search, filterByTrash, clear, deleteSelected, destroy, forceDelete, restore">
                <x-table.cell> {{ $account->account_no }} </x-table.cell>
                <x-table.cell> {{ $account->name }} </x-table.cell>
                <x-table.cell> {{ Number::format($account->initial_balance) }} </x-table.cell>
                <x-table.cell class="!text-success">
                    @if ($account->totalCredit())
                        +{{ Number::format($account->totalCredit()) }}
                    @else
                    @endif
                </x-table.cell>
                <x-table.cell class="!text-danger">
                    @if ($account->totalDebit())
                        -{{ Number::format($account->totalDebit()) }}
                    @else
                    @endif
                </x-table.cell>
                <x-table.cell class="!text-primary">
                    @if ($account->totalBalance())
                        {{ Number::format($account->totalBalance()) }}
                    @else
                    @endif
                </x-table.cell>
                <x-table.cell>
                    @if ($account->is_active)
                        <x-mary-icon name="o-check-circle" class='text-success' />
                    @else
                        <x-mary-icon name="o-x-circle" class='text-danger' />
                    @endif
                </x-table.cell>
                <x-table.cell> {{ Str::limit($account->details, 80, '..') }} </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($account->trashed())
                        <x-button flat="primary" wire:click="restore({{ $account->id }})">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $account->id }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $account])
                    @else
                        <x-button flat="secondary"
                            x-on:click.prevent="$dispatch('open-modal', 'view-account-transactions-{{ $account->id }}')">
                            <x-heroicon-o-eye /> {{ __('view') }}
                        </x-button>

                        @can('update', $account)
                            <x-button flat="warning" :href="route('admin.accounts.edit', $account)">
                                <x-heroicon-o-pencil-square /> {{ __('edit') }}
                            </x-button>
                        @endcan

                        @can('delete', $account)
                            <x-button flat="danger"
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $account->id }}')">
                                <x-heroicon-o-trash /> {{ __('delete') }}
                            </x-button>

                            {{-- View Payments --}}
                            @include('modals.view-account-transactions', ['data' => $account])
                            @include('partials.delete-modal', ['data' => $account])
                        @endcan
                    @endif
                </x-table.cell>
            </x-table.row>

        @empty
            <x-table.data-not-found colspan="8" />
        @endforelse
    </x-table>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $accounts->links() }}
    </div>
</div>
