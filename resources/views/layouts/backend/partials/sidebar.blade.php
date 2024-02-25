<aside
    class="fixed top-0 left-0 z-20 flex-col flex-shrink-0 w-64 h-full pt-16 overflow-y-auto font-normal duration-75 lg:flex transition-width print:hidden"
    :class="sidebarVisible ? '' : 'hidden'">
    <div
        class="relative flex flex-col flex-1 min-h-full pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">
                    <x-sidebar.link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <x-slot name="icon"><x-heroicon-s-home class="w-6 h-6" /></x-slot>
                        {{ __('dashboard') }}
                    </x-sidebar.link>

                    @can('posManagement', App\Models\Product::class)
                        <x-sidebar.link :href="route('admin.pos.index')" :active="request()->routeIs('admin.pos.*')">
                            <x-slot name="icon"><x-heroicon-m-squares-2x2 class="w-6 h-6" /></x-slot>
                            {{ __('pos') }} <x-mary-badge :value="__('updated')"
                                class="pl-1.5 badge-warning animate-pulse badge-sm" />
                        </x-sidebar.link>
                    @endcan

                    {{-- Product Management --}}
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.units.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-list-bullet class="w-6 h-6" /></x-slot>
                                {{ __('products') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                            {{ __('product list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.units.index')" :active="request()->routeIs('admin.units.*')">
                            {{ __('unit list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('category list') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    {{-- Purchase Management --}}
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.purchases.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-credit-card class="w-6 h-6" /></x-slot>
                                {{ __('purchases') }} 
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.purchases.index')" :active="request()->routeIs('admin.purchases.index') ||
                            request()->routeIs('admin.purchases.show') ||
                            request()->routeIs('admin.purchases.add-payment') ||
                            request()->routeIs('admin.purchases.generate.invoice')">
                            {{ __('purchase list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.purchases.create')" :active="request()->routeIs('admin.purchases.create')">
                            {{ __('add purchase') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    {{-- Sale Management --}}
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.sales.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-shopping-cart class="w-6 h-6" /></x-slot>
                                {{ __('sales') }} 
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.sales.index')" :active="request()->routeIs('admin.sales.index') ||
                            request()->routeIs('admin.sales.show') ||
                            request()->routeIs('admin.sales.add-payment')">
                            {{ __('sale list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.pos.index')" :active="request()->routeIs('admin.sales.create')">
                            {{ __('add sale') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    <x-sidebar.link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">
                        <x-slot name="icon"><x-heroicon-m-user class="w-6 h-6" /></x-slot>
                        {{ __('customers') }}
                    </x-sidebar.link>

                    <x-sidebar.link :href="route('admin.suppliers.index')" :active="request()->routeIs('admin.suppliers.*')">
                        <x-slot name="icon"><x-heroicon-m-user class="w-6 h-6" /></x-slot>
                        {{ __('suppliers') }} 
                    </x-sidebar.link>

                    {{-- Employee Management --}}
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.employees.*') || request()->routeIs('admin.attendance.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-user-group class="w-6 h-6" /></x-slot>
                                {{ __('employees') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*') &&
                            !request()->routeIs('admin.employees.list.advance.payment') &&
                            !request()->routeIs('admin.employees.manage-overtime')">
                            {{ __('employee list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.attendance.index')" :active="request()->routeIs('admin.attendance.*') &&
                            !request()->routeIs('admin.attendance.last-month')">
                            {{ __('attendances') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.employees.manage-overtime')" :active="request()->routeIs('admin.employees.manage-overtime')">
                            {{ __('manage overtime') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.employees.list.advance.payment')" :active="request()->routeIs('admin.employees.list.advance.payment')">
                            {{ __('advance payment list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.attendance.last-month')" :active="request()->routeIs('admin.attendance.last-month')">
                            {{ __('last month attendances') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    {{-- Account Management --}}
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.accounts.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-currency-dollar class="w-6 h-6" /></x-slot>
                                {{ __('accounting') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.accounts.index')" :active="request()->routeIs('admin.accounts.index') ||
                            request()->routeIs('admin.accounts.create') ||
                            request()->routeIs('admin.accounts.edit')">
                            {{ __('account list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.accounts.money-transfer')" :active="request()->routeIs('admin.accounts.money-transfer')">
                            {{ __('money transfer') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.accounts.balance-adjustment')" :active="request()->routeIs('admin.accounts.balance-adjustment') ||
                            request()->routeIs('admin.accounts.balance-adjustment.*')">
                            {{ __('balance adjustment') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.accounts.all-transactions')" :active="request()->routeIs('admin.accounts.all-transactions')">
                            {{ __('all transactions') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    {{-- Reports Management --}}
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-o-document class="w-6 h-6" /></x-slot>
                                {{ __('reports') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.reports.customer-due-report')" :active="request()->routeIs('admin.reports.customer-due-report')">
                            {{ __('customer due report') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.reports.supplier-due-report')" :active="request()->routeIs('admin.reports.supplier-due-report')">
                            {{ __('supplier due report') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    {{-- Expense Management --}}
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.expenses.*') || request()->routeIs('admin.expense.category.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-banknotes class="w-6 h-6" /></x-slot>
                                {{ __('expenses') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.expense.category.index')" :active="request()->routeIs('admin.expense.category.index')">
                            {{ __('expense categories') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.expenses.create')" :active="request()->routeIs('admin.expenses.create')">
                            {{ __('add expense') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.expenses.index')" :active="request()->routeIs('admin.expenses.index')">
                            {{ __('expense list') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    {{-- Cashbooks Management --}}
                    <x-collapsible x-data="{ expanded: {{ request()->routeIs('admin.stores.*') || request()->routeIs('admin.cashbooks.*') ? 'true' : 'false' }} }">
                        <x-slot name="trigger">
                            <x-collapsible.button>
                                <x-slot name="icon"><x-heroicon-m-banknotes class="w-6 h-6" /></x-slot>
                                {{ __('cashbooks') }}
                            </x-collapsible.button>
                        </x-slot>

                        <x-collapsible.item :href="route('admin.cashbooks.index')" :active="request()->routeIs('admin.cashbooks.index')">
                            {{ __('cashbook list') }}
                        </x-collapsible.item>

                        <x-collapsible.item :href="route('admin.stores.index')" :active="request()->routeIs('admin.stores.*')">
                            {{ __('store list') }}
                        </x-collapsible.item>
                    </x-collapsible>

                    {{-- Settings Management --}}
                    <x-sidebar.link :href="route('admin.dashboard')" :active="request()->routeIs('settings')">
                        <x-slot name="icon"><x-heroicon-s-cog-6-tooth class="w-6 h-6" /></x-slot:icon>
                        {{ __('settings') }}
                    </x-sidebar.link>
                </ul>
            </div>
        </div>
    </div>
    </div>
</aside>
