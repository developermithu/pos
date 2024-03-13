<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="customers" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('customer list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Customer::class)
                        <x-button :href="route('admin.customers.create')">
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
            <x-table.heading>
                <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll" for="selectAll" />
            </x-table.heading>
            <x-table.heading> {{ __('name') }} </x-table.heading>
            <x-table.heading> {{ __('phone number') }} </x-table.heading>
            <x-table.heading> {{ __('details') }} </x-table.heading>
            <x-table.heading> {{ __('deposit balance') }} </x-table.heading>
            <x-table.heading> {{ __('initial due') }} </x-table.heading>
            <x-table.heading> {{ __('due') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        @forelse ($customers as $customer)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $customer->id }}"
                wire:target="search, filterByTrash, deleteSelected, destroy, clear">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $customer->id }}" id="{{ $customer->id }}"
                        for="{{ $customer->id }}" />
                </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white">
                    {{ Str::limit($customer->name, 25, '..') }}
                </x-table.cell>
                <x-table.cell> {{ $customer->phone_number }} </x-table.cell>

                <x-table.cell>
                    {{ $customer?->company_name }} <br>
                    {{ $customer?->address }}
                </x-table.cell>

                <x-table.cell @class([
                    'font-semibold',
                    '!text-success' => $customer->depositBalance() > 0,
                    '!text-danger' => $customer->depositBalance() < 0,
                ])>
                    {{ $customer->depositBalance() }} TK
                </x-table.cell>

                <x-table.cell @class(['font-semibold', '!text-danger' => $customer?->initial_due])>
                    {{ number_format($customer?->initial_due) }} TK
                </x-table.cell>

                <x-table.cell @class(['font-semibold', '!text-danger' => $customer->totalDue()])>
                    {{ number_format($customer->totalDue()) }} TK
                </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($customer->trashed())
                        <x-button flat="primary" wire:click="restore('{{ $customer->ulid }}')">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $customer->ulid }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $customer])
                    @else
                        <div x-data="{ open: false }">
                            <x-mary-button x-ref="button" icon="o-ellipsis-vertical" @click.outside="open = false"
                                x-on:click="open = !open" class="btn-circle" />

                            <x-mary-menu x-cloak x-show="open" x-anchor.bottom-end.offset.5="$refs.button"
                                class="bg-white border">

                                <x-mary-menu-item :title="__('view')" :link="route('admin.customers.show', $customer)" icon="o-eye" />

                                @can('update', $customer)
                                    <x-mary-menu-item :title="__('edit')" :link="route('admin.customers.edit', $customer)" icon="o-pencil-square" />
                                @endcan

                                @if ($customer->totalDue())
                                    <x-mary-menu-item :title="__('clear due')" icon="o-arrow-uturn-left"
                                        wire:click="showDueModal({{ $customer->id }})" />
                                @endif

                                @if ($customer->deposit > 0)
                                    <x-mary-menu-item :title="__('view deposits')" icon="o-banknotes"
                                        x-on:click.prevent="$dispatch('open-modal', 'view-deposits-{{ $customer->id }}')" />
                                @endif

                                @can('create', App\Models\Deposit::class)
                                    <x-mary-menu-item :title="__('add deposit')" wire:click="showDepositModal({{ $customer->id }})"
                                        icon="o-plus" />
                                @endcan

                                @can('delete', $customer)
                                    <x-mary-menu-item :title="__('delete')"
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $customer->ulid }}')"
                                        icon="o-trash" class="text-danger" />
                                @endcan
                            </x-mary-menu>
                        </div>
                    @endif

                    {{-- View Deposits --}}
                    @include('modals.view-deposits', ['data' => $customer])
                    @include('partials.delete-modal', ['data' => $customer])
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="7" />
        @endforelse
    </x-table>

    @include('modals.add-deposit')
    @include('modals.clear-due', ['data' => 'customer'])

    {{-- Pagination --}}
    <div class="p-4">
        {{ $customers->links() }}
    </div>
</div>
