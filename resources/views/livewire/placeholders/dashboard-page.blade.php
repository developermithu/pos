<div>
    <div class="px-4 py-6 space-y-6">
        <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
            {{ __('welcome') }}, {{ Auth::user()->name }}
        </h1>

        @if (auth()->user()->isSuperadmin())
            <ul class="grid grid-cols-1 gap-5 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-5 lg:gap-x-10">
                <template x-for="x in 10">
                    {{-- skeleton --}}
                    <li class="w-full h-[76px] skeleton"></li>
                </template>
            </ul>

            <ul class="grid grid-cols-12 gap-5">
                <div
                    class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 col-span-full lg:col-span-8">
                    <div class="-mt-2 text-lg font-semibold text-center capitalize">
                        {{ __('monthly sales') }} ({{ date('Y') }})
                    </div>

                    {{-- skeleton --}}
                    <li class="w-full h-[500px] mt-2 skeleton"></li>
                </div>

                <div
                    class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm lg:col-span-4 col-span-full dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <div class="-mt-2 text-lg font-semibold text-center capitalize">
                        {{ __('top 5 customers') }} ({{ date('Y') }})
                    </div>

                    {{-- skeleton --}}
                    <li class="w-full h-[500px] mt-2 skeleton"></li>
                </div>
            </ul>
        @endif
    </div>
</div>
