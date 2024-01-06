<div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
    <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
        <x-breadcrumb>
            <x-breadcrumb.item :label="__('purchases')" :href="route('admin.purchases.index')" />
            <x-breadcrumb.item :label="__('create')" />
        </x-breadcrumb>

        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('add new purchase') }}
        </h1>
    </div>

    <div class="col-span-full">
        <div
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div>
                <div class="grid grid-cols-6 gap-6">
                    {{-- supplier --}}
                    <div class="col-span-3">
                        <label for="supplier_id"
                            class="block mb-2 text-sm font-medium text-gray-700 capitalize dark:text-gray-300">
                            {{ __('supplier') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="flex">
                            <select wire:model='supplier_id'
                                class="shadow-sm bg-gray-50 border border-gray-300  text-gray-900 rounded-l text-sm focus:ring-primary focus:border-primary block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 transition ease-in-out dark:text-white dark:focus:ring-primary dark:focus:border-primary capitalize"
                                id="supplier_id" required>
                                <option value="" disabled>-- {{ __('select supplier') }} --</option>
                                @foreach (App\Models\Supplier::pluck('name', 'id') as $key => $name)
                                    <option value="{{ $key }}"> {{ $name }} </option>
                                @endforeach
                            </select>

                            <button x-on:click="$dispatch('open-modal', 'create')"
                                class="flex-shrink-0 z-10 inline-flex items-center gap-x-1 py-2.5 px-3 text-sm font-medium text-center transition ease-in-out border rounded-r focus:outline-none focus:ring-2 focus:ring-offset-2 text-white bg-primary/90 hover:bg-primary focus:bg-primary active:bg-primary/90 focus:ring-primary/90 border-transparent"
                                type="button">
                                <x-heroicon-m-plus /> {{ __('add') }}
                            </button>
                        </div>

                        @error('supplier_id')
                            <div class="text-sm text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- date --}}
                    {{-- <x-input.group for="date" label="{{ __('date') }}" :error="$errors->first('date')">
                        <x-input type="date" wire:model="date" id="date" />
                    </x-input.group> --}}

                    {{-- Serach content --}}
                    <div
                        class="divide-y rounded-lg bg-slate-100 sm:col-span-6 dark:bg-dark-primary divide-gray dark:divide-white/10">
                        <div
                            class="w-full text-gray-900 border border-gray-300 divide-y rounded-md shadow-sm dark:bg-dark-primary divide-gray dark:divide-white/10 bg-gray-50 sm:text-sm focus:ring-primary focus:border-primary">
                            <div class="relative flex items-center px-4 py-1.5" @click.away="searchModal = false">
                                <x-mary-icon name="o-magnifying-glass" class="text-gray-600" />

                                <input x-ref="searchInput" type="text" wire:model.live="search"
                                    placeholder="{{ __('Search product by name or code..') }}"
                                    class="w-full flex-1 py-1.5 border-none focus:ring-0 bg-transparent dark:text-white/80">

                                <button @click="searchModal = false" type="button"
                                    class="text-[10px] font-medium  py-0.5 rounded bg-gray dark:bg-dark-secondary dark:text-white/75">
                                    ESC
                                </button>
                            </div>

                            <!-- Serach Results -->
                            @if ($search)
                                <div x-transition.opacity="" class="px-3 py-2 overflow-y-auto max-h-64 bg-gray-50">
                                    <ul class="space-y-1">
                                        @forelse ($products as $product)
                                            <li>
                                                <button wire:click="addToCart({{ $product }})"
                                                    wire:loading.attr="disabled" wire:target="addToCart" type="button"
                                                    class="flex items-center bg-gray-50 gap-x-2 block w-full hover:bg-gray-200 dark:hover:bg-dark-secondary text-gray-500 hover:duration-100 hover:transition-colors py-1.5 rounded px-2 text-sm lg:text-base dark:text-white/80">
                                                    <x-mary-icon name="o-plus" />
                                                    <span class="font-medium truncate">
                                                        {{ $product->name }}
                                                    </span>
                                                </button>
                                            </li>
                                        @empty
                                            <li class="px-2 text-2xl font-semibold text-center py-1.5"> Nothings found!
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Cart Items -->
                    <div class="lg:col-span-6 col-span-full ">
                        <div
                            class="mb-4 p-4 lg:p-6 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 dark:bg-gray-800">
                            <h3 class="pb-4 text-xl font-semibold dark:text-white">{{ __('purchase items') }}</h3>

                            {{-- Cart Items --}}
                            <x-table>
                                <x-slot name="heading">
                                    <x-table.heading class="!p-4"> {{ __('product') }} </x-table.heading>
                                    <x-table.heading class="!p-4"> {{ __('qty') }} </x-table.heading>
                                    <x-table.heading class="!p-4"> {{ __('price') }} </x-table.heading>
                                    <x-table.heading class="!p-4"> {{ __('subtotal') }} </x-table.heading>
                                    <x-table.heading class="!p-4"> {{ __('actions') }} </x-table.heading>
                                </x-slot>

                                @forelse (Cart::instance('purchases')->content() as $key => $item)
                                    <x-table.row wire:key="{{ $item->id }}"
                                        class="hover:bg-transparent dark:hover:bg-bg-transparent">
                                        <x-table.cell class="!p-4">
                                            {{ Str::limit($item->name, 100, '..') }} </x-table.cell>
                                        <x-table.cell class="!p-4">
                                            <div>
                                                <label for="Quantity" class="sr-only"> Quantity </label>
                                                <div
                                                    class="flex items-center justify-between border border-gray-200 rounded">
                                                    <button wire:loading.attr="disabled" type="button"
                                                        wire:click="decreaseQty('{{ $item->rowId }}')"
                                                        class="flex items-center justify-center w-10 h-10 leading-10 text-danger bg-danger/10">
                                                        <x-heroicon-m-minus class="w-5 h-5" />
                                                    </button>

                                                    <input type="number" value="{{ $item->qty }}"
                                                        class="h-10 w-16 border-transparent text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none focus:ring-primary"
                                                        readonly />

                                                    <button wire:loading.attr="disabled" type="button"
                                                        wire:click="increaseQty('{{ $item->rowId }}')"
                                                        class="flex items-center justify-center w-10 h-10 leading-10 bg-success/10 text-success">
                                                        <x-heroicon-m-plus class="w-5 h-5" />
                                                    </button>
                                                </div>
                                            </div>
                                        </x-table.cell>
                                        <x-table.cell class="!p-4"> {{ $item->price }} </x-table.cell>
                                        <x-table.cell class="!p-4"> {{ $item->total }} </x-table.cell>
                                        <x-table.cell class="!p-4">
                                            <button wire:click="removeFromCart('{{ $item->rowId }}')"
                                                class="p-2 rounded-full hover:bg-danger/10 text-danger hover:duration-200">
                                                <x-heroicon-m-trash class="w-5 h-5" />
                                            </button>
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.data-not-found colspan="5" />
                                @endforelse
                            </x-table>

                            <div class="p-4 space-y-4">
                                @if (Cart::instance('purchases')->count() >= 1)
                                    <div class="flex flex-col gap-1 text-right">
                                        <div>Subtotal: <strong>{{ Cart::instance('purchases')->subtotal() }}</strong>
                                        </div>
                                        <div>Tax: <strong>{{ Cart::instance('purchases')->tax() }}</strong></div>
                                        <div class="text-lg">Total:
                                            <strong>{{ Cart::instance('purchases')->total() }}</strong>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if (Cart::instance('purchases')->count() >= 1)
                                <div class="p-4">
                                    <div class="grid grid-cols-6 gap-4 mb-5">
                                        <div class="col-span-6 sm:col-span-3">
                                            <x-input.group for="note" label="{{ __('note') }}"
                                                :error="$errors->first('note')">
                                                <x-input.textarea wire:model="note" id="note" />
                                            </x-input.group>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3 space-y-4">
                                            <div class="col-span-6 sm:col-span-3">
                                                <x-input.group for="status" label="{{ __('purchase status *') }}"
                                                    :error="$errors->first('status')">
                                                    <x-input.select wire:model="status" required>
                                                        @foreach (App\Enums\PurchaseStatus::forSelect() as $value => $name)
                                                            <option value="{{ $value }}">
                                                                {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </x-input.select>
                                                </x-input.group>
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <x-input.group for="payment_status"
                                                    label="{{ __('payment status *') }}" :error="$errors->first('payment_status')">
                                                    <x-input.select wire:model.change="payment_status" required>
                                                        <option value="" disabled>--
                                                            {{ __('select payment status') }} --
                                                        </option>
                                                        @foreach (App\Enums\PurchasePaymentStatus::forSelect() as $value => $name)
                                                            <option value="{{ $value }}"> {{ $name }}
                                                            </option>
                                                        @endforeach
                                                    </x-input.select>
                                                </x-input.group>
                                            </div>

                                            @if (
                                                $payment_status === App\Enums\PurchasePaymentStatus::PARTIAL->value ||
                                                    $payment_status === App\Enums\PurchasePaymentStatus::PAID->value)
                                                <div class="col-span-6 sm:col-span-3">
                                                    <x-input.group for="paid_by" label="{{ __('paid by *') }}"
                                                        :error="$errors->first('paid_by')">
                                                        <x-input.select wire:model="paid_by" required>
                                                            <option value="cash">cash</option>
                                                            <option value="bank">bank</option>
                                                            <option value="cheque">cheque</option>
                                                            <option value="bkash">bkash</option>
                                                        </x-input.select>
                                                    </x-input.group>
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <x-input.group for="paid_amount"
                                                        label="{{ __('paying amount *') }}" :error="$errors->first('paid_amount')">
                                                        <x-input type="text" wire:model="paid_amount"
                                                            id="paid_amount" required />
                                                    </x-input.group>
                                                </div>
                                            @endif

                                            <div class="sm:col-span-3 mr-auto">
                                                <x-button wire:click.prevent="createPurchase"
                                                    wire:loading.attr="disabled" wire:loading.class="opacity-40"
                                                    wire:target="createPurchase"
                                                    style="width: 100%; display: flex; justify-content: center">
                                                    {{ __('submit') }}
                                                </x-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
