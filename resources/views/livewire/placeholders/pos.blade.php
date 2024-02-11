<div>
    <div class="grid grid-cols-1 p-4 lg:grid-cols-12 gap-4 dark:bg-gray-900 lg:mt-1.5">
        <div class="mb-1 col-span-full">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="pos" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('pos management') }}
                </h1>
            </div>
        </div>

        <!-- Cart Items -->
        @if (Cart::count() > 0)
            <div class="lg:col-span-6 col-span-full skeleton h-[636px]">
            </div>
        @else
            <div class="lg:col-span-6 col-span-full skeleton h-[300px]">
            </div>
        @endif

        <div class="lg:col-span-6 col-span-full skeleton h-[735px]">
        </div>
    </div>
</div>
