<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="suppliers" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('supplier list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <x-table.search />
                    <x-table.bulk-action />
                </div>

                <div class="flex items-center gap-3">
                    <x-table.filter-action />

                    @can('create', App\Models\Supplier::class)
                        <x-button :href="route('admin.suppliers.create')">
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

        @forelse ($suppliers as $supplier)
            <x-table.row wire:loading.class="opacity-50" wire:key="{{ $supplier->id }}">
                <x-table.cell>
                    <x-input.checkbox wire:model="selected" value="{{ $supplier->id }}" id="{{ $supplier->id }}"
                        for="{{ $supplier->id }}" />
                </x-table.cell>
                <x-table.cell class="font-medium text-gray-800 dark:text-white">
                    {{ Str::limit($supplier->name, 25, '..') }}
                </x-table.cell>
                <x-table.cell>
                    {{ $supplier->phone_number }}
                </x-table.cell>
                <x-table.cell>
                    {{ $supplier?->company_name }} <br>
                    {{ $supplier?->address }}
                </x-table.cell>
                <x-table.cell @class([
                    'font-semibold',
                    '!text-success' => $supplier->depositBalance() > 0,
                    '!text-danger' => $supplier->depositBalance() < 0,
                ])>
                    {{ $supplier->depositBalance() }} TK
                </x-table.cell>

                <x-table.cell @class(['font-semibold', '!text-danger' => $supplier?->initial_due])>
                    {{ number_format($supplier?->initial_due) }} TK
                </x-table.cell>

                <x-table.cell @class(['font-semibold', '!text-danger' => $supplier->totalDue()])>
                    {{ Number::format($supplier->totalDue()) }} TK
                </x-table.cell>

                <x-table.cell class="space-x-2">
                    @if ($supplier->trashed())
                        <x-button flat="primary" wire:click="restore('{{ $supplier->ulid }}')">
                            <x-heroicon-o-arrow-path /> {{ __('restore') }}
                        </x-button>

                        <x-button flat="danger"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-forever-{{ $supplier->ulid }}')">
                            <x-heroicon-o-archive-box-x-mark /> {{ __('delete forever') }}
                        </x-button>

                        @include('partials.delete-forever-modal', ['data' => $supplier])
                    @else
                        <div x-data="{ open: false }">
                            <x-mary-button x-ref="button" icon="o-ellipsis-vertical" @click.outside="open = false"
                                x-on:click="open = !open" class="btn-circle" />

                            <x-mary-menu x-cloak x-show="open" x-anchor.bottom-end.offset.5="$refs.button"
                                class="bg-white border">

                                <x-mary-menu-item :title="__('view')" :link="route('admin.suppliers.show', $supplier)" icon="o-eye" />

                                @can('update', $supplier)
                                    <x-mary-menu-item :title="__('edit')" :link="route('admin.suppliers.edit', $supplier)" icon="o-pencil-square" />
                                @endcan

                                @if ($supplier->deposit > 0)
                                    <x-mary-menu-item :title="__('view deposits')" icon="o-banknotes"
                                        @click.prevent="$dispatch('open-modal', 'view-deposits-{{ $supplier->id }}')" />
                                @endif

                                @can('create', App\Models\Deposit::class)
                                    <x-mary-menu-item :title="__('add deposit')" wire:click="showDepositModal({{ $supplier->id }})"
                                        icon="o-plus" />
                                @endcan

                                @if ($supplier->totalDue())
                                    <x-mary-menu-item :title="__('clear due')" icon="o-arrow-uturn-left"
                                        wire:click="showDueModal({{ $supplier->id }})" />
                                @endif

                                @can('delete', $supplier)
                                    <x-mary-menu-item :title="__('delete')"
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-deletion-{{ $supplier->ulid }}')"
                                        icon="o-trash" class="text-danger" />
                                @endcan
                            </x-mary-menu>
                        </div>
                    @endif

                    @include('modals.view-deposits', ['data' => $supplier])
                    @include('partials.delete-modal', ['data' => $supplier])
                </x-table.cell>
            </x-table.row>
        @empty
            <x-table.data-not-found colspan="7" />
        @endforelse
    </x-table>

    @include('modals.add-deposit')
    @include('modals.clear-due', ['data' => 'supplier'])

    {{-- Pagination --}}
    <div class="p-4">
        {{ $suppliers->links() }}
    </div>
</div>
