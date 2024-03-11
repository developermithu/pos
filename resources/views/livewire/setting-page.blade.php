<div>
    <div class="p-4 block bg-white border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
        <div class="w-full mb-1">
            <div class="flex flex-col mb-4 md:flex-row md:items-center md:justify-between">
                <x-breadcrumb>
                    <x-breadcrumb.item label="dashboard" :href="route('admin.dashboard')" />
                </x-breadcrumb>

                <h1 class="text-xl font-semibold text-gray-900 capitalize sm:text-2xl dark:text-white">
                    {{ __('Settings') }}
                </h1>
            </div>

            @if (auth()->check() && auth()->user()->email === 'developermithu@gmail.com')
                <div class="flex flex-wrap gap-6">
                    <x-button size="small" wire:click.prevent="clearCache" title="Flush the application cache">
                        {{ __('cache clear') }} </x-button>

                    <x-button size="small" wire:click.prevent="clearView" title="Clear all compiled view files">
                        {{ __('view clear') }} </x-button>

                    <x-button size="small" wire:click.prevent="clearRoute" title="Remove the route cache file">
                        {{ __('route clear') }} </x-button>

                    <x-button size="small" wire:click.prevent="clearConfig"
                        title="Remove the configuration cache file">
                        {{ __('config clear') }}
                    </x-button>

                    <x-button size="small" wire:click.prevent="clearEvent"
                        title="Clear all cached events and listeners">
                        {{ __('event clear') }}
                    </x-button>

                    <x-button type="danger" size="small" wire:click.prevent="clearOptimize"
                        title="Clearing cached bootstrap files">
                        {{ __('optimize clear') }} </x-button>
                </div>
            @endif
        </div>
    </div>
</div>
