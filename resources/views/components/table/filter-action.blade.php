<x-dropdown align="right" width="64" closeAfterClick="false">
    <x-slot name="trigger">
        <button
            class="inline-flex items-center text-primary bg-white border border-primary/30 focus:outline-none focus:ring-2 focus:ring-primary/20 font-medium rounded text-sm px-3 py-1.5 tracking-wider dark:bg-primary/80 dark:text-white dark:border-primary/60 gap-x-1.5 dark:focus:ring-primary/70 capitalize"
            type="button">
            {{ __('filter by') }}
            <x-heroicon-m-chevron-down class="w-5 h-5" />
        </button>
    </x-slot>

    <x-slot name="content">
        <!-- Dropdown menu -->
        <div class="z-10 block p-4 bg-white dark:bg-gray-700">
            <div
                class="flex items-center justify-between mb-3 text-sm font-medium text-gray-900 dark:text-white">
                <x-button wire:click="clear" flat="warning"> {{ __('clear') }} </x-button>
            </div>

            <x-input.select wire:model.change="filterByTrash" class="py-1.5 px-3 text-sm">
                <option value="">{{ __('without trash records') }}</option>
                <option value="withTrashed">{{ __('with trash records') }}</option>
                <option value="onlyTrashed">{{ __('only trash records') }}</option>
            </x-input.select>
        </div>
    </x-slot>
</x-dropdown>