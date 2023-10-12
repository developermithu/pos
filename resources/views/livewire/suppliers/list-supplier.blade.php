<div>
    <div
        class="p-4 block bg-white sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                {{-- Breadcrumb --}}
                <nav class="flex order-2">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a wire:navigate href="{{ route('admin.dashboard') }}" wire:navigate
                                class="inline-flex items-center text-gray-400 capitalize hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                                <x-heroicon-s-home class="mr-2.5" />
                                {{ __('dashboard') }}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                                <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                                    {{ __('suppliers') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('supplier list') }}
                </h1>
            </div>

            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <form class="sm:pr-3" action="#" method="GET">
                        <label for="suppliers-search" class="sr-only">Search</label>
                        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                            <x-input.text wire:model.live.debounce.250ms="search" placeholder="{{ __('search') }}.." />
                        </div>
                    </form>

                    <div class="flex items-center w-full sm:justify-end">
                        <div class="flex pl-2 space-x-1">
                            <a href="#" wire:click="deleteSelected" title="Delete Selected"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-s-trash class="w-6 h-6" />
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-s-information-circle class="w-6 h-6" />
                            </a>
                            <a href="#"
                                class="inline-flex justify-center p-1 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <x-heroicon-m-ellipsis-vertical class="w-6 h-6" />
                            </a>
                        </div>
                    </div>
                </div>

                <x-primary-link href="{{ route('admin.suppliers.create') }}">
                    <x-heroicon-m-plus class="w-4 h-4" />
                    {{ __('add supplier') }}
                </x-primary-link>
            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4">
                                    <x-input.checkbox wire:model="selectAll" value="selectALl" id="selectAll"
                                        for="selectAll" />
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    {{ __('name') }}
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    {{ __('address') }}
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    {{ __('phone number') }}
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    {{ __('bank name') }}
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    {{ __('bank branch') }}
                                </th>
                                <th scope="col"
                                    class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                    {{ __('actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($suppliers as $supplier)
                                <tr wire:loading.class="opacity-50" wire:key="row-{{ $supplier->id }}"
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="w-4 p-4">
                                        <x-input.checkbox wire:model="selected" value="{{ $supplier->id }}"
                                            id="{{ $supplier->id }}" for="{{ $supplier->id }}" />
                                    </td>
                                    <td
                                        class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        <div class="text-base font-semibold text-gray-900 dark:text-white">
                                            {{ $supplier->name }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-base text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ Str::limit($supplier->address, 30, '...') }}
                                    </td>
                                    <td class="p-4 text-base text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $supplier->phone_number }}
                                    </td>
                                    <td class="p-4 text-base text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $supplier->bank_name ?? '' }}
                                    </td>
                                    <td class="p-4 text-base text-gray-500 whitespace-nowrap dark:text-gray-400">
                                        {{ $supplier->bank_branch ?? '' }}
                                    </td>
                                    <td class="flex items-center p-4 space-x-2 whitespace-nowrap">
                                        <x-primary-link href="{{ route('admin.suppliers.edit', $supplier) }}"
                                            class="text-xs">
                                            <x-heroicon-o-pencil-square class="w-3 h-3" />
                                            {{ __('edit') }}
                                        </x-primary-link>

                                        <x-danger-button wire:click="destroy({{ $supplier }})" class="text-xs">
                                            <x-heroicon-o-trash class="w-4 h-4" />
                                            {{ __('delete') }}
                                        </x-danger-button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div
                                            class="py-10 text-3xl font-semibold text-center text-gray-900 dark:text-gray-300">
                                            Not Found
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="p-4">
        {{ $suppliers->links() }}
    </div>
</div>
