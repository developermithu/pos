<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        <div class="mb-1 col-span-full">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="settings" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('application settings') }}
                </h1>
            </div>

            <div class="px-6 py-3 mb-3 text-base rounded-lg md:mb-0 md:text-lg text-danger bg-danger/10">
                {{ __("Don't touch anywhere, if you don't know what you are doing!") }}
            </div>
        </div>

        {{-- Left side --}}
        <aside class="col-span-full xl:col-auto">
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flow-root">
                    <h3 class="text-xl font-semibold capitalize dark:text-white">
                        {{ __('clear application cache') }}
                    </h3>

                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-4">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <p class="space-x-4 xl:mb-4 2xl:mb-0">
                                    {{ __('Clear all compiled view files') }}
                                </p>

                                <div class="inline-flex items-center w-auto xl:w-full 2xl:w-auto">
                                    <x-button size="small" wire:click.prevent="clearView">
                                        {{ __('view clear') }} </x-button>
                                </div>
                            </div>
                        </li>

                        <li class="py-4">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <p class="space-x-4 xl:mb-4 2xl:mb-0">
                                    {{ __('Remove the route cache file') }}
                                </p>

                                <div class="inline-flex items-center w-auto xl:w-full 2xl:w-auto">
                                    <x-button size="small" wire:click.prevent="clearRoute">
                                        {{ __('route clear') }} </x-button>
                                </div>
                            </div>
                        </li>

                        <li class="py-4">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <p class="space-x-4 xl:mb-4 2xl:mb-0">
                                    {{ __('Clear all cached events and listeners') }}
                                </p>

                                <div class="inline-flex items-center w-auto xl:w-full 2xl:w-auto">
                                    <x-button size="small" wire:click.prevent="clearEvent">
                                        {{ __('event clear') }}
                                    </x-button>
                                </div>
                            </div>
                        </li>

                        <li class="py-4">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <p class="space-x-4 xl:mb-4 2xl:mb-0">
                                    {{ __('Flush the application cache') }}
                                </p>

                                <div class="inline-flex items-center w-auto xl:w-full 2xl:w-auto">
                                    <x-button size="small" wire:click.prevent="clearCache">
                                        {{ __('cache clear') }} </x-button>
                                </div>
                            </div>
                        </li>

                        <li class="py-4">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <p class="space-x-4 xl:mb-4 2xl:mb-0">
                                    {{ __('Remove the configuration cache file') }}
                                </p>

                                <div class="inline-flex items-center w-auto xl:w-full 2xl:w-auto">
                                    <x-button size="small" wire:click.prevent="clearConfig">
                                        {{ __('config clear') }}
                                    </x-button>
                                </div>
                            </div>
                        </li>

                        <li class="py-4">
                            <div class="flex justify-between xl:block 2xl:flex align-center 2xl:space-x-4">
                                <p class="space-x-4 xl:mb-4 2xl:mb-0">
                                    {{ __('Clearing cached bootstrap files') }}
                                </p>

                                <div class="inline-flex items-center w-auto xl:w-full 2xl:w-auto">
                                    <x-button type="danger" size="small" wire:click.prevent="clearOptimize">
                                        {{ __('optimize clear') }} </x-button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        {{-- Right side --}}
        <aside class="col-span-2">
            <div
                class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flex flex-wrap items-center justify-between gap-5 mb-4">
                    <h3 class="text-xl font-semibold capitalize dark:text-white"> {{ __('database backup list') }}
                    </h3>

                    <x-button type="danger" size="small" wire:click="cleanBackup"
                        wire:confirm="Are you sure want to cleanup backup?">
                        <x-heroicon-o-archive-box-x-mark /> {{ __('clean backup') }}
                    </x-button>
                </div>

                <x-table>
                    <x-slot name="heading">
                        <x-table.heading> {{ __('file path') }} </x-table.heading>
                        <x-table.heading> {{ __('file name') }} </x-table.heading>
                        <x-table.heading> {{ __('file size') }} </x-table.heading>
                        <x-table.heading> {{ __('created at') }} </x-table.heading>
                        <x-table.heading> {{ __('actions') }} </x-table.heading>
                    </x-slot>

                    @forelse ($backupFiles as $key => $backupFile)
                        <x-table.row wire:key="{{ $key }}">
                            <x-table.cell> {{ $backupFile['file_path'] }} </x-table.cell>
                            <x-table.cell> {{ $backupFile['file_name'] }} </x-table.cell>
                            <x-table.cell class="font-semibold"> {{ $backupFile['file_size'] }} </x-table.cell>
                            <x-table.cell> {{ $backupFile['created_at'] }} </x-table.cell>
                            <x-table.cell class="space-x-1.5">
                                <x-button flat="primary" wire:click="downloadBackup('{{ $backupFile['file_name'] }}')">
                                    <x-heroicon-o-arrow-down-tray /> {{ __('download') }}
                                </x-button>

                                <x-button flat="danger" wire:click="deleteBackup('{{ $backupFile['file_name'] }}')"
                                    wire:confirm="Are you sure to delete?">
                                    <x-heroicon-o-trash /> {{ __('delete') }}
                                </x-button>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.data-not-found colspan="5" />
                    @endforelse

                    <x-table.row>
                        <x-table.cell colspan="2" class="font-semibold"> {{ __('total file size') }}
                        </x-table.cell>
                        <x-table.cell colspan="3" class="font-bold"> {{ $totalSizeHumanReadable }}</x-table.cell>
                    </x-table.row>
                </x-table>
            </div>
        </aside>
    </div>

    {{-- <div class="grid grid-cols-1 px-4 xl:grid-cols-2 xl:gap-4">
        <aside
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 xl:mb-0">
            <div class="flow-root">
                <h3 class="text-xl font-semibold dark:text-white">Alerts &amp; Notifications</h3>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">You can set up Themesberg to get
                    notifications</p>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Item 1 -->
                    <div class="flex items-center justify-between py-4">
                        <div class="flex flex-col flex-grow">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">Company News</div>
                            <div class="text-base font-normal text-gray-500 dark:text-gray-400">Get Themesberg news,
                                announcements, and product updates</div>
                        </div>
                        <label for="company-news" class="relative flex items-center cursor-pointer">
                            <input type="checkbox" id="company-news" class="sr-only">
                            <span
                                class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
                        </label>
                    </div>
                    <!-- Item 2 -->
                    <div class="flex items-center justify-between py-4">
                        <div class="flex flex-col flex-grow">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">Account Activity</div>
                            <div class="text-base font-normal text-gray-500 dark:text-gray-400">Get important
                                notifications about you or activity you've missed</div>
                        </div>
                        <label for="account-activity" class="relative flex items-center cursor-pointer">
                            <input type="checkbox" id="account-activity" class="sr-only" checked="">
                            <span
                                class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
                        </label>
                    </div>
                    <!-- Item 3 -->
                    <div class="flex items-center justify-between py-4">
                        <div class="flex flex-col flex-grow">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">Meetups Near You</div>
                            <div class="text-base font-normal text-gray-500 dark:text-gray-400">Get an email when a
                                Dribbble Meetup is posted close to my location</div>
                        </div>
                        <label for="meetups" class="relative flex items-center cursor-pointer">
                            <input type="checkbox" id="meetups" class="sr-only" checked="">
                            <span
                                class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
                        </label>
                    </div>
                    <!-- Item 4 -->
                    <div class="flex items-center justify-between pt-4">
                        <div class="flex flex-col flex-grow">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">New Messages</div>
                            <div class="text-base font-normal text-gray-500 dark:text-gray-400">Get Themsberg news,
                                announcements, and product updates</div>
                        </div>
                        <label for="new-messages" class="relative flex items-center cursor-pointer">
                            <input type="checkbox" id="new-messages" class="sr-only">
                            <span
                                class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
                        </label>
                    </div>
                </div>
            </div>
        </aside>

        <aside
            class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 xl:mb-0">
            <div class="flow-root">
                <h3 class="text-xl font-semibold capitalize dark:text-white">Sessions</h3>

                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li class="py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-gray-900 truncate dark:text-white">
                                    California 123.123.123.123
                                </p>
                                <p class="text-sm font-normal text-gray-500 truncate dark:text-gray-400">
                                    Chrome on macOS
                                </p>
                            </div>
                            <div class="inline-flex items-center">
                                <a href="#"
                                    class="px-3 py-2 mb-3 mr-3 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Revoke</a>
                            </div>
                        </div>
                    </li>
                    <li class="pt-4 pb-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-gray-900 truncate dark:text-white">
                                    Rome 24.456.355.98
                                </p>
                                <p class="text-sm font-normal text-gray-500 truncate dark:text-gray-400">
                                    Safari on iPhone
                                </p>
                            </div>
                            <div class="inline-flex items-center">
                                <a href="#"
                                    class="px-3 py-2 mb-3 mr-3 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Revoke</a>
                            </div>
                        </div>
                    </li>
                </ul>
                <div>
                    <button
                        class="text-primary bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">See
                        more</button>
                </div>
            </div>
        </aside>
    </div> --}}
</div>
