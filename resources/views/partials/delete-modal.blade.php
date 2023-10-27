<x-modal maxWidth="md" name="confirm-deletion-{{ $data->id }}">
    <div class="p-6 text-center">
        <x-heroicon-o-exclamation-circle class="mx-auto mb-4 text-gray-400 dark:text-gray-200"
            style="width: 48px; height: 48px" />

        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
            {{ __('Are you sure you want to delete this?') }}
        </h3>

        <x-danger-button wire:click.prevent="destroy({{ $data }})" x-on:click="$dispatch('close')">
            Yes, I'm sure
        </x-danger-button>

        <x-secondary-button x-on:click="$dispatch('close')" class="ml-3">
            No, cancel
        </x-secondary-button>
    </div>
</x-modal>
