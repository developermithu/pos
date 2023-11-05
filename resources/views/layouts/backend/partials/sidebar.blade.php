<aside
    class="fixed top-0 left-0 z-20 flex-col flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width print:hidden"
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

                    <x-sidebar.link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <x-slot name="icon"><x-heroicon-s-home class="w-6 h-6" /></x-slot>
                        {{ __('dashboard') }}
                    </x-sidebar.link>

                    <x-sidebar.link :href="route('admin.pos.index')" :active="request()->routeIs('admin.pos.*')">
                        <x-slot name="icon"><x-heroicon-m-squares-2x2 class="w-6 h-6" /></x-slot>
                        {{ __('pos') }}
                    </x-sidebar.link>

                    <x-sidebar.link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                        <x-slot name="icon"><x-heroicon-m-shopping-bag class="w-6 h-6" /></x-slot>
                        {{ __('products') }}
                    </x-sidebar.link>

                    <x-sidebar.link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">
                        <x-slot name="icon"><x-heroicon-m-user class="w-6 h-6" /></x-slot>
                        {{ __('customers') }}
                    </x-sidebar.link>

                    <x-sidebar.link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')">
                        <x-slot name="icon"><x-heroicon-m-user-group class="w-6 h-6" /></x-slot>
                        {{ __('employees') }}
                    </x-sidebar.link>

                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.suppliers.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-user class="w-6 h-6" /></x-slot>
                                {{ __('manage supplier') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.suppliers.index')" :active="request()->routeIs('admin.suppliers.index') ||
                            request()->routeIs('admin.suppliers.edit')">
                            {{ __('supplier list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.suppliers.create')" :active="request()->routeIs('admin.suppliers.create')">
                            {{ __('add supplier') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.advanced.salary.*') || request()->routeIs('admin.pay.salary.*') || request()->routeIs('admin.last.month.salary') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-currency-dollar class="w-6 h-6" /></x-slot>
                                {{ __('employees salary') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.advanced.salary.index')" :active="request()->routeIs('admin.advanced.salary.index') ||
                            request()->routeIs('admin.advanced.salary.edit')">
                            {{ __('advanced salary list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.advanced.salary.add')" :active="request()->routeIs('admin.advanced.salary.add')">
                            {{ __('add advanced salary') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.pay.salary.index')" :active="request()->routeIs('admin.pay.salary.*')">
                            {{ __('pay salary') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.last.month.salary')" :active="request()->routeIs('admin.last.month.salary')">
                            {{ __('last month salary') }}
                        </x-collapsible.item>
                    </x-collapsible>


                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.attendance.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-check-badge class="w-6 h-6" /></x-slot>
                                {{ __('manage attendance') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.attendance.add')" :active="request()->routeIs('admin.attendance.add')">
                            {{ __('add attendance') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.attendance.index')" :active="request()->routeIs('admin.attendance.index') ||
                            request()->routeIs('admin.attendance.edit')">
                            {{ __('attendance list') }}
                        </x-collapsible.item>
                    </x-collapsible>
                </ul>

                <ul class="pt-2 space-y-2">
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.expenses.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-banknotes class="w-6 h-6" /></x-slot>
                                {{ __('manage expenses') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.expenses.create')" :active="request()->routeIs('admin.expenses.create')">
                            {{ __('add expense') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.expenses.todays')" :active="request()->routeIs('admin.expenses.todays') ||
                            request()->routeIs('admin.expenses.edit')">
                            {{ __('todays expense') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.expenses.monthly')" :active="request()->routeIs('admin.expenses.monthly')">
                            {{ __('monthly expense') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.expenses.yearly')" :active="request()->routeIs('admin.expenses.yearly')">
                            {{ __('yearly expense') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    <x-sidebar.link href="https://flowbite-admin-dashboard.vercel.app" :active="request()->routeIs('settings')"
                        target="_blank">
                        <x-slot name="icon"><x-heroicon-s-link class="w-6 h-6" /></x-slot>
                        flowbite dashboard
                    </x-sidebar.link>

                    <x-sidebar.link :href="route('admin.dashboard')" :active="request()->routeIs('settings')">
                        <x-slot name="icon"><x-heroicon-s-cog-6-tooth class="w-6 h-6" /></x-slot:icon>
                        {{ __('settings') }}
                    </x-sidebar.link>
            </div>
        </div>
    </div>
    </div>
</aside>
