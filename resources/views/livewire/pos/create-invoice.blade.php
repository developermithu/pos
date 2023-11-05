<div>
    <div class="grid grid-cols-1 p-4 lg:grid-cols-12 gap-4 dark:bg-gray-900 lg:mt-1.5">
        <div class="mb-1 col-span-full print:hidden">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                {{-- Breadcrumb --}}
                <nav class="flex order-2">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a wire:navigate href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-gray-400 capitalize hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                                <x-heroicon-s-home class="mr-2.5" />
                                {{ __('dashboard') }}
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                                <a wire:navigate href="{{ route('admin.pos.index') }}"
                                    class="ml-1 text-gray-400 capitalize md:ml-2 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-300">
                                    {{ __('pos') }}
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <x-heroicon-m-chevron-right class="w-6 h-6 text-gray-400" />
                                <span class="ml-1 text-gray-500 capitalize md:ml-2 dark:text-gray-300">
                                    {{ __('generate invoice') }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('generate invoice') }}
                </h1>
            </div>

            <x-status :status="session('status')" />
        </div>

        <div class="w-9/12 m-auto col-span-full">
            <div
                class="p-12 mb-4 space-y-8 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between">
                    <h1 class="text-3xl font-semibold">Invoice #0586</h1>

                    <div>
                        <h3 class="text-xl font-semibold text-primary"> {{ config('app.name') }} </h3>
                        <p class="text-gray-500"> {{ date('d M, Y') }} </p>
                    </div>
                </div>

                <div>
                    <h3 class="pb-2 text-xl font-bold">Bill To</h3>
                    <address class="text-gray-500">
                        {{ session('customer_name') }}, <br>
                        {{ session('customer_address') }}, <br>
                        {{ session('customer_phone_number') }}
                    </address>
                </div>

                <x-table>
                    <x-slot name="heading">
                        <x-table.heading> {{ __('item') }} </x-table.heading>
                        <x-table.heading> {{ __('price') }} </x-table.heading>
                        <x-table.heading> {{ __('qty') }} </x-table.heading>
                        <x-table.heading> {{ __('total') }} </x-table.heading>
                    </x-slot>

                    @foreach (Cart::content() as $item)
                        <x-table.row wire:key="{{ $item->id }}"
                            class="hover:bg-transparent dark:hover:bg-bg-transparent">
                            <x-table.cell class="font-semibold"> {{ $item->name }} </x-table.cell>
                            <x-table.cell> {{ $item->price }} </x-table.cell>
                            <x-table.cell> {{ $item->qty }} </x-table.cell>
                            <x-table.cell> {{ $item->total }} </x-table.cell>
                        </x-table.row>
                    @endforeach

                    <x-table.row class="hover:bg-transparent dark:hover:bg-bg-transparent">
                        <td colspan="4" class="pt-4 text-gray-500">
                            <div class="flex flex-col gap-1 text-right">
                                <div>Subtotal: <strong>{{ Cart::subtotal() }}</strong></div>
                                <div>Tax: <strong>{{ Cart::tax() }}</strong></div>
                                <div class="text-lg">Total: <strong>{{ Cart::total() }}</strong></div>
                            </div>
                        </td>
                    </x-table.row>
                </x-table>

                <div class="flex items-center justify-end gap-3 print:hidden">
                    <a href="javascript:window.print()"
                        class="inline-flex gap-x-1.5 font-semibold uppercase transition ease-in-out rounded items-center active:outline-none active:ring-2 active:ring-offset-2 px-4 py-2 text-sm tracking-widest text-white bg-primary/90 hover:bg-primary focus:bg-primary active:bg-primary/90 focus:ring-primary/90 border-transparent">
                        <x-heroicon-m-printer />
                        {{ __('print') }}
                    </a>
                    <x-button> {{ __('generate invoice') }} </x-button>
                </div>
            </div>
        </div>
    </div>
</div>
