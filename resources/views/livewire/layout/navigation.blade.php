<?php

use Livewire\Volt\Component;

new class extends Component {
    public function logout(): void
    {
        auth()
            ->guard('web')
            ->logout();

        session()->invalidate();
        session()->regenerateToken();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 print:hidden">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                {{-- open sidebar --}}
                <button @click="sidebarVisible = true"
                    class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    :class="sidebarVisible ? 'hidden' : ''">
                    <x-heroicon-m-bars-3-center-left class="w-6 h-6" />
                </button>

                {{-- close sidebar --}}
                <button x-cloak x-show="sidebarVisible" @click="sidebarVisible = false"
                    class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>

                <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex ml-2 md:mr-24">
                    {{-- <img src="https://flowbite-admin-dashboard.vercel.app/images/logo.svg" class="h-8 mr-3"
                        alt="FlowBite Logo"> --}}
                    <span
                        class="self-center font-serif text-xl font-bold sm:text-2xl whitespace-nowrap dark:text-white text-primary">
                        {{ config('app.name') }}
                    </span>
                </a>

                {{-- <form action="#" method="GET" class="hidden lg:block lg:pl-3.5">
                    <label for="topbar-search" class="sr-only">Search</label>
                    <div class="relative mt-1 lg:w-96">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <x-heroicon-m-magnifying-glass class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                        </div>
                        <input type="text" name="email" id="topbar-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded focus:ring-primary focus:border-primary block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary dark:focus:border-primary"
                            placeholder="{{ __('search') }}">
                    </div>
                </form> --}}
            </div>

            <div x-data="{ displayNotifications: false }" class="flex items-center">
                <div class="hidden mr-3 -mb-1 sm:block">
                    <span></span>
                </div>

                {{-- <button id="toggleSidebarMobileSearch" type="button"
                    class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Search</span>
                    <x-heroicon-m-magnifying-glass class="w-6 h-6" />
                </button> --}}

                {{-- language switcher --}}
                <x-dropdown align="right" width="">
                    <x-slot name="trigger">
                        <button type="button"
                            class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                            <span
                                class="fi fi-{{ config('app.supported_languages')[app()->getLocale()]['flag-icon'] }} "></span>
                            <span class="hidden sm:inline-block">{{ strtoupper(app()->getLocale()) }}</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @foreach (config('app.supported_languages') as $key => $lang)
                            <x-dropdown-link href="{{ route('setlocale', $key) }}"
                                class="inline-flex items-center text-base gap-x-2">
                                <span class="fi fi-{{ $lang['flag-icon'] }}"></span>
                                {{ $lang['name'] }}
                            </x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>

                {{-- Notifications --}}
                {{-- <button @click="displayNotifications = !displayNotifications" @click.away="displayNotifications = false"
                    type="button"
                    class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                    <span class="sr-only">View notifications</span>
                    <x-heroicon-o-bell class="w-6 h-6" />
                    <x-heroicon-o-bell-alert class="w-6 h-6" />
                </button>
    
                <div x-cloak x-show="displayNotifications" x-transition
                    class="absolute z-20 w-full max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg right-4 top-10 dark:divide-gray-600 dark:bg-gray-700">
                    <div
                        class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        Notifications
                    </div>
                    <div>
                        <a href="#"
                            class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                            <div class="flex-shrink-0">
                                <img class="rounded-full w-11 h-11"
                                    src="https://flowbite-admin-dashboard.vercel.app/images/users/bonnie-green.png"
                                    alt="Jese image">
                            </div>
                            <div class="w-full pl-3">
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">New message
                                    from <span class="font-semibold text-gray-900 dark:text-white">Bonnie Green</span>:
                                    "Hey, what's up? All set for the presentation?"</div>
                                <div class="text-xs font-medium text-primary-700 dark:text-primary-400">a few moments
                                    ago</div>
                            </div>
                        </a>
                        <a href="#"
                            class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                            <div class="flex-shrink-0">
                                <img class="rounded-full w-11 h-11"
                                    src="https://flowbite-admin-dashboard.vercel.app/images/users/jese-leos.png"
                                    alt="Jese image">
                            </div>
                            <div class="w-full pl-3">
                                <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400"><span
                                        class="font-semibold text-gray-900 dark:text-white">Jese leos</span> and <span
                                        class="font-medium text-gray-900 dark:text-white">5 others</span> started
                                    following you.</div>
                                <div class="text-xs font-medium text-primary-700 dark:text-primary-400">10 minutes ago
                                </div>
                            </div>
                        </a>
                    </div>
                    <a href="#"
                        class="block py-2 text-base font-normal text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline">
                        <div class="inline-flex items-center ">
                            <x-heroicon-m-eye class="w-5 h-5 mr-2" />
                            View all
                        </div>
                    </a>
                </div> --}}

                <!-- Settings Dropdown -->
                <div class="ml-3 sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button type="button"
                                class="flex text-sm rounded focus:ring-2 ring-offset-2 focus:ring-primary/40">
                                {{ Auth::user()->name }}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-left">
                                <x-dropdown-link>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>
