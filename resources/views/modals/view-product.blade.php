<x-modal maxWidth="2xl" name="view-{{ $product->id }}">
    <div class="p-5 lg:p-6">
        <div class="flow-root">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                <li class="py-3 lg:py-4">
                    <div
                        class="flex justify-between space-x-2 text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                        <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                            {{ __('product code') }} :
                        </h2>
                        <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                            {{ $product->sku }}
                        </p>
                    </div>
                </li>

                <li class="py-3 lg:py-4">
                    <div
                        class="flex justify-between space-x-2 text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                        <h2 class="font-semibold text-gray-900 capitalize mb-0.5 dark:text-white">
                            {{ __('name') }} :
                        </h2>
                        <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                            {{ $product->name }}
                        </p>
                    </div>
                </li>

                <li class="py-3 lg:py-4">
                    <div
                        class="flex justify-between space-x-2 text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                        <h2 class="font-semibold  text-gray-900 capitalize mb-0.5 dark:text-white">
                            {{ __('category') }} :
                        </h2>
                        <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                            {{ $product->category?->name }}
                        </p>
                    </div>
                </li>

                <li class="py-3 lg:py-4">
                    <div
                        class="flex justify-between space-x-2 text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                        <h2 class="font-semibold  text-gray-900 capitalize mb-0.5 dark:text-white">
                            {{ __('unit') }} :
                        </h2>
                        <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                            {{ $product->unit?->short_name }}
                        </p>
                    </div>
                </li>

                <li class="py-3 lg:py-4">
                    <div
                        class="flex justify-between space-x-2 text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                        <h2 class="font-semibold  text-gray-900 capitalize mb-0.5 dark:text-white">
                            {{ __('quantity') }} :
                        </h2>
                        <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                            {{ $product->qty }}
                        </p>
                    </div>
                </li>

                <li class="py-3 lg:py-4">
                    <div
                        class="flex justify-between space-x-2 text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                        <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                            {{ __('cost') }} :
                        </h2>
                        <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                            @if ($product->cost)
                                {{ Number::currency($product->cost, 'BDT') }}
                            @endif
                        </p>
                    </div>
                </li>

                <li class="py-3 lg:py-4">
                    <div
                        class="flex justify-between space-x-2 text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                        <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                            {{ __('price') }} :
                        </h2>
                        <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                            {{ Number::currency($product->price, 'BDT') }}
                        </p>
                    </div>
                </li>

                <li class="py-3 lg:py-4">
                    <div
                        class="flex justify-between space-x-2 text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                        <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                            {{ __('created at') }} :
                        </h2>
                        <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                            {{ $product->created_at() }}
                        </p>
                    </div>
                </li>
            </ul>
        </div>

        <div class="flex items-center justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                cancel
            </x-secondary-button>
        </div>
    </div>
</x-modal>
