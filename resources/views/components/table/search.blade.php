<form class="sm:pr-3" action="#" method="GET">
    <label for="categories-search" class="sr-only">Search</label>
    <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
        <x-input wire:model.live.debounce.250ms="search" placeholder="{{ __('search') }}.." />
    </div>
</form>
