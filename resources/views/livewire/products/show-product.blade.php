<div>
    <div class="grid grid-cols-12 gap-5 px-4 py-6 lg:gap-y-10 dark:bg-gray-900">
        <div class="flex flex-col mb-4 col-span-full md:flex-row md:items-center md:justify-between xl:mb-2">
            {{-- Breadcrumb --}}
            <x-breadcrumb>
                <x-breadcrumb.item :label="__('products')" :href="route('admin.products.index')" />
                <x-breadcrumb.item :label="__('details')" />
            </x-breadcrumb>

            <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                {{ __('product details') }}
            </h1>
        </div>

        <!-- Right Content -->
        <div class="w-full mx-auto lg:w-8/12 col-span-full">
            <div
                class="px-5 py-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 md:px-14 dark:bg-gray-800">
                <div class="flow-root">
                    {{-- <h3 class="text-xl font-semibold capitalize dark:text-white"> {{ __('product details') }} </h3> --}}

                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-4">
                            <div
                                class="flex justify-between text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                                    {{ __('product code') }} :
                                </h2>
                                <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                                    {{ $product->sku }}
                                </p>
                            </div>
                        </li>

                        <li class="py-4">
                            <div
                                class="flex justify-between text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="font-semibold text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('product name') }} :
                                </h2>
                                <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                                    {{ $product->name }}
                                </p>
                            </div>
                        </li>

                        <li class="py-4">
                            <div
                                class="flex justify-between text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="font-semibold  text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('supplier') }} :
                                </h2>
                                <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                                    {{ $product->supplier->name }}
                                </p>
                            </div>
                        </li>

                        <li class="py-4">
                            <div
                                class="flex justify-between text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="font-semibold  text-gray-900 capitalize mb-0.5 dark:text-white">
                                    {{ __('quantity') }} :
                                </h2>
                                <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                                    {{ $product->qty }}
                                </p>
                            </div>
                        </li>

                        <li class="py-4">
                            <div
                                class="flex justify-between text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                                    {{ __('buying price') }} :
                                </h2>
                                <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                                    {{ number_format($product->buying_price) ?? '' }}
                                </p>
                            </div>
                        </li>

                        <li class="py-4">
                            <div
                                class="flex justify-between text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                                    {{ __('selling price') }} :
                                </h2>
                                <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                                    {{ number_format($product->selling_price) ?? '' }}
                                </p>
                            </div>
                        </li>

                        <li class="py-4">
                            <div
                                class="flex justify-between text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                                    {{ __('buying date') }} :
                                </h2>
                                <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                                    {{ $product->buying_date() }}
                                </p>
                            </div>
                        </li>

                        <li class="py-4">
                            <div
                                class="flex justify-between text-base lg:text-lg xl:block 2xl:flex align-center 2xl:space-x-4">
                                <h2 class="font-semibold capitalize text-gray-900 mb-0.5 dark:text-white">
                                    {{ __('expired date') }} :
                                </h2>
                                <p class="flex-1 text-gray-600 mb-0.5 dark:text-white">
                                    {{ $product->expired_date() }}
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-3 text-right md:pt-5">
                <x-button type="danger" :href="route('admin.products.index')"> {{ __('go back') }} </x-button>
            </div>
        </div>
    </div>
</div>
