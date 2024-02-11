<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="products" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('product list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0 skeleton w-full max-w-[508px] h-[46px]"></div>

                <div class="flex items-center gap-3">
                    <div class="skeleton rounded w-[110px] h-[34px]"></div>
                    <div class="skeleton rounded w-[124px] h-[34px]"></div>
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
            <x-table.heading> {{ __('code') }} </x-table.heading>
            <x-table.heading> {{ __('category') }} </x-table.heading>
            <x-table.heading> {{ __('quantity') }} </x-table.heading>
            <x-table.heading> {{ __('unit') }} </x-table.heading>
            <x-table.heading> {{ __('cost') }} </x-table.heading>
            <x-table.heading> {{ __('price') }} </x-table.heading>
            <x-table.heading> {{ __('created at') }} </x-table.heading>
            <x-table.heading> {{ __('actions') }} </x-table.heading>
        </x-slot>

        <template x-for="x in 8">
            <x-table.row class="w-full h-[57px] skeleton">
                <template x-for="x in 10">
                    <x-table.cell></x-table.cell>
                </template>
            </x-table.row>
        </template>
    </x-table>
</div>
