<aside
    class="fixed top-0 left-0 z-20 flex-col flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
    :class="sidebarVisible ? '' : 'hidden'">
    <div
        class="relative flex flex-col flex-1 min-h-full pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">
                    <li>
                        <form action="#" method="GET" class="lg:hidden">
                            <label for="mobile-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <x-heroicon-m-magnifying-glass class="w-5 h-5 text-gray-500" />
                                </div>
                                <input type="text" name="email" id="mobile-search"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="{{ __('search') }}">
                            </div>
                        </form>
                    </li>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" wire:navigate
                            class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                            <x-heroicon-s-home
                                class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                            <span class="ml-3">{{ __('dashboard') }}</span>
                        </a>
                    </li>

                    {{-- category --}}
                    {{-- <li x-data="{ expanded: {{ request()->routeIs('admin.categories.index') || request()->routeIs('admin.categories.create') || request()->routeIs('admin.categories.edit') ? 'true' : 'false' }} }">
                        <button @click="expanded = !expanded" type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                            <x-heroicon-m-folder-plus
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('Categories') }}</span>
                            <x-heroicon-m-chevron-down class="w-6 h-6" />
                        </button>
                        <ul x-cloak x-show="expanded" x-collapse.duration.300ms class="py-2 space-y-2">
                            <li>
                                <a wire:navigate href="{{ route('admin.categories.index') }}"
                                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.categories.index') ? 'bg-gray-100 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}">
                                    {{ __('Category list') }}
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('admin.categories.create') }}"
                                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.categories.create') ? 'bg-gray-100 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}">
                                    {{ __('Add category') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    --}}

                    <li x-data="{ expanded: {{ request()->routeIs('admin.suppliers.index') || request()->routeIs('admin.suppliers.create') || request()->routeIs('admin.suppliers.edit') ? 'true' : 'false' }} }">
                        <button @click="expanded = !expanded" type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                            <x-heroicon-m-folder-plus
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ __('supplier management') }}</span>
                            <x-heroicon-m-chevron-down class="w-6 h-6" />
                        </button>
                        <ul x-cloak x-show="expanded" x-collapse.duration.300ms class="py-2 space-y-2">
                            <li>
                                <a wire:navigate href="{{ route('admin.suppliers.index') }}"
                                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.suppliers.index') ? 'bg-gray-100 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}">
                                    {{ __('supplier list') }}
                                </a>
                            </li>
                            <li>
                                <a wire:navigate href="{{ route('admin.suppliers.create') }}"
                                    class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700 {{ request()->routeIs('admin.suppliers.create') ? 'bg-gray-100 dark:bg-gray-700' : 'bg-transparent dark:bg-transparent' }}">
                                    {{ __('add supplier') }}
                                </a>
                            </li>
                        </ul>
                    </li> 

                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700 ">
                            <x-heroicon-s-cog-8-tooth
                                class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                            <span class="ml-3">Settings</span>
                        </a>
                    </li>
                </ul>

                <div class="pt-2 space-y-2">
                    <a href="https://github.com/themesberg/flowbite-admin-dashboard" target="_blank"
                        class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                        <x-heroicon-m-link
                            class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        <span class="ml-3">GitHub Repository</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</aside>
